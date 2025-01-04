<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\RoommatePreference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoommateController extends Controller
{
    /**
     * @OA\Post(
     *      path="/roommate/findRoommate",
     *      operationId="findRoommate",
     *      tags={"roommate"},
     *      security={{ "sanctum": {} }},
     *      summary="Find a roommate based on preferences",
     *      description="This API allows users to submit their preferences for finding a roommate based on various factors like sleep schedule, lifestyle habits, and more.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"sleep_schedule", "property_id","lifestyle_habits", "social_preferences", "pet_friendly", "study_habits", "cooking_kitchen_usage"},
     *                  @OA\Property(property="property_id", type="integer", example=1),
     *                  @OA\Property(property="sleep_schedule", type="integer", example=2),
     *                  @OA\Property(property="lifestyle_habits", type="string", example="1,2,3"),
     *                  @OA\Property(property="social_preferences", type="string", example="1,2"),
     *                  @OA\Property(property="pet_friendly", type="integer", example=1),
     *                  @OA\Property(property="study_habits", type="integer", example=2),
     *                  @OA\Property(property="cooking_kitchen_usage", type="integer", example=3)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Roommate preferences saved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Roommate preferences saved successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid input data.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Something went wrong")
     *          )
     *      )
     * )
     */
    public function findRoommate(Request $request)
    {
        if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
            return response()->json(['message' => 'Unauthorized. Only users can post this.'], 403);
        }
        try {
            $validator = Validator::make($request->all(), [
                'sleep_schedule' => 'required|integer',
                'lifestyle_habits' => 'required|string',
                'social_preferences' => 'required|string',
                'pet_friendly' => 'required|integer',
                'study_habits' => 'required|integer',
                'property_id' => 'required|integer',
                'cooking_kitchen_usage' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $propertyId = $request->input('property_id');
            $property = Property::find($propertyId);

            if (!$property) {
                return response()->json(['message' => 'Property Not Found'], 400);
            }

            if ($property->sold_to !== auth()->id()) {
                return response()->json(['message' => 'You are not allowed to make ad for roommate, Because property is sold to this user'], 400);
            }

            $existingRoommateAd = RoommatePreference::where('property_id', $propertyId)
                ->where('created_by_id', auth()->id())
                ->where('state_id', RoommatePreference::STATE_PENDING)
                ->first();

            if ($existingRoommateAd) {
                return response()->json(['message' => 'You have already posted a roommate ad for this property.'], 400);
            }

            $roommatePreferences = new RoommatePreference();
            $roommatePreferences->property_id = $request->input('property_id');
            $roommatePreferences->sleep_schedule = $request->input('sleep_schedule');
            $roommatePreferences->lifestyle_habits = $request->input('lifestyle_habits');
            $roommatePreferences->social_preferences = $request->input('social_preferences');
            $roommatePreferences->pet_friendly = $request->input('pet_friendly');
            $roommatePreferences->study_habits = $request->input('study_habits');
            $roommatePreferences->cooking_kitchen_usage = $request->input('cooking_kitchen_usage');
            $roommatePreferences->created_by_id = auth()->id();
            $roommatePreferences->save();

            $roommatePreferences->load('createdBy');

            return response()->json([
                'roommate' => $roommatePreferences,
                'message' => 'Roommate preferences saved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * @OA\Get(
     *      path="/roommate/roommate-list",
     *      operationId="roommateList",
     *      tags={"roommate"},
     *      security={{ "sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Property List by Rating",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Property One"),
     *              @OA\Property(property="rating", type="number", format="float", example=4.5),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Something went wrong"),
     *          )
     *      ),
     * )
     */
    public function roommateList(Request $request)
    {
        try {
            $userId = auth()->id();
            $roommatePreferencesQuery = RoommatePreference::query();
            if ($userId) {
                $roommatePreferencesQuery->where('created_by_id', $userId)
                    ->whereIn('state_id', [RoommatePreference::STATE_PENDING, RoommatePreference::STATE_BOOKED]);
            } else {
                $roommatePreferencesQuery->whereIn('state_id', [RoommatePreference::STATE_PENDING]);
            }
            $roommatePreferences = $roommatePreferencesQuery->get();
            if ($roommatePreferences->isEmpty()) {
                return response()->json([
                    'message' => 'No properties found.'
                ], 400);
            }

            $roommatePreferences->load('createdBy', 'property');
            return response()->json([
                'message' => 'Properties found successfully.',
                'roommate' => $roommatePreferences
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *      path="/roommate/updateRoommate/{id}",
     *      operationId="updateRoommate",
     *      tags={"roommate"},
     *      security={{ "sanctum": {} }},
     *      summary="Update roommate preferences",
     *      description="This API allows users to update their roommate preferences.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Roommate Preference ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"sleep_schedule", "property_id","lifestyle_habits", "social_preferences", "pet_friendly", "study_habits", "cooking_kitchen_usage"},
     *                  @OA\Property(property="property_id", type="integer", example=1),
     *                  @OA\Property(property="sleep_schedule", type="integer", example=2),
     *                  @OA\Property(property="lifestyle_habits", type="string", example="1,2,3"),
     *                  @OA\Property(property="social_preferences", type="string", example="1,2"),
     *                  @OA\Property(property="pet_friendly", type="integer", example=1),
     *                  @OA\Property(property="study_habits", type="integer", example=2),
     *                  @OA\Property(property="cooking_kitchen_usage", type="integer", example=3)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Roommate preferences updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Roommate preferences updated successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input or roommate preference not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid input data or Roommate Preference not found.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized action",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized. Only users can update this.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Something went wrong.")
     *          )
     *      )
     * )
     */
    public function updateRoommate(Request $request, $id)
    {
        if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
            return response()->json(['message' => 'Unauthorized. Only users can update this.'], 403);
        }

        try {
            $validator = Validator::make($request->all(), [
                'sleep_schedule' => 'required|integer',
                'lifestyle_habits' => 'required|string',
                'social_preferences' => 'required|string',
                'pet_friendly' => 'required|integer',
                'study_habits' => 'required|integer',
                'property_id' => 'required|integer',
                'cooking_kitchen_usage' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $roommatePreference = RoommatePreference::where('id', $id)
                ->where('created_by_id', auth()->id())
                ->first();

            if (!$roommatePreference) {
                return response()->json(['message' => 'Roommate Preference not found or unauthorized access.'], 400);
            }

            $propertyId = $request->input('property_id');
            $property = Property::find($propertyId);

            if (!$property) {
                return response()->json(['message' => 'Property Not Found'], 400);
            }

            if ($property->sold_to !== auth()->id()) {
                return response()->json(['message' => 'You are not allowed to update roommate preferences for this property.'], 400);
            }

            $roommatePreference->property_id = $request->input('property_id');
            $roommatePreference->sleep_schedule = $request->input('sleep_schedule');
            $roommatePreference->lifestyle_habits = $request->input('lifestyle_habits');
            $roommatePreference->social_preferences = $request->input('social_preferences');
            $roommatePreference->pet_friendly = $request->input('pet_friendly');
            $roommatePreference->study_habits = $request->input('study_habits');
            $roommatePreference->cooking_kitchen_usage = $request->input('cooking_kitchen_usage');
            $roommatePreference->save();

            $roommatePreference->load('createdBy', 'property');

            return response()->json([
                'roommate' => $roommatePreference,
                'message' => 'Roommate preferences updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/roommate/markAsSold",
     *      operationId="markAsSold",
     *      tags={"roommate"},
     *      security={{ "sanctum": {} }},
     *      summary="Mark roommate preference as sold",
     *      description="This API allows users to mark a roommate preference as sold based on roommate_reference_id and user_id.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"roommate_reference_id", "user_id"},
     *                  @OA\Property(property="roommate_reference_id", type="integer", example=1),
     *                  @OA\Property(property="user_id", type="integer", example=2)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Roommate preference marked as sold successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Roommate preference marked as sold successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input or data not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid input or roommate preference not found.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Something went wrong")
     *          )
     *      )
     * )
     */
    public function markAsSold(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'roommate_reference_id' => 'required|integer',
                'user_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $userId = $request->input('user_id');
            $user = User::where('id', $userId)
                ->where('role', User::ROLE_USER)
                ->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found or does not have the correct role.'
                ], 400);
            }

            $roommatePreference = RoommatePreference::where('id', $request->input('roommate_reference_id'))
                ->where('created_by_id', auth()->id())
                ->where('state_id', RoommatePreference::STATE_PENDING)
                ->first();

            if (!$roommatePreference) {
                return response()->json([
                    'message' => 'Roommate preference not found or unauthorized access.'
                ], 400);
            }

            $roommatePreference->state_id = RoommatePreference::STATE_BOOKED;
            $roommatePreference->sold_to_user = $userId;
            $roommatePreference->save();
            $roommatePreference->load('createdBy', 'property','soldToUser');
            return response()->json([
                'roommate' => $roommatePreference,
                'message' => 'Roommate preference marked as sold successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
