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
     *                  required={"sleep_schedule", "prperty_id","lifestyle_habits", "social_preferences", "pet_friendly", "study_habits", "cooking_kitchen_usage"},
     *                  @OA\Property(property="prperty_id", type="integer", example=1),
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
        if (auth()->user()->role != User::ROLE_USER) {
            return response()->json(['message' => 'Unauthorized. Only service providers can get user list.'], 403);
        }
        try {
            $validator = Validator::make($request->all(), [
                'sleep_schedule' => 'required|integer',
                'lifestyle_habits' => 'required|string|regex:/^(\d+(,\d+)*)$/',
                'social_preferences' => 'required|string|regex:/^(\d+(,\d+)*)$/',
                'pet_friendly' => 'required|in:0,1',
                'study_habits' => 'required|integer',
                'property_id' => 'integer',
                'cooking_kitchen_usage' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $propertyId = $request->input('property_id');

            $property = Property::where('id', $propertyId)->first();
            $propertyIsSoldToUser = Property::where('id', $propertyId)
                ->where('sold_to', auth()->id())
                ->first();
            if (empty($property)) {
                return response()->json(['message' => 'Property Not Found'], 400);
            }
            if (empty($propertyIsSoldToUser)) {
                return response()->json(['message' => 'You are not allowed to make ad for roommate, Because property is sold to this user'], 400);
            }
            $roommatePreferences = new RoommatePreference();
            $roommatePreferences->property_id = $request->input('property_id');
            $roommatePreferences->sleep_schedule = $request->input('sleep_schedule');
            $roommatePreferences->lifestyle_habits = $request->input('lifestyle_habits');
            $roommatePreferences->social_preferences = $request->input('social_preferences');
            $roommatePreferences->pet_friendly = $request->input('pet_friendly');
            $roommatePreferences->study_habits = $request->input('study_habits');
            $roommatePreferences->cooking_kitchen_usage = $request->input('cooking_kitchen_usage');
            $roommatePreferences->save();

            return response()->json([
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
            $roommatePreferences = RoommatePreference::all();
            if ($roommatePreferences->isEmpty()) {
                return response()->json([
                    'message' => 'No properties found.'
                ], 400);
            }
            $propertyIds = $roommatePreferences->pluck('property_id')->unique();
            $properties = Property::whereIn('id', $propertyIds)->get();
            if ($properties->isEmpty()) {
                return response()->json([
                    'message' => 'No properties found.'
                ], 400);
            }
            return response()->json([
                'message' => 'Properties found successfully.',
                'data' => $properties
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
