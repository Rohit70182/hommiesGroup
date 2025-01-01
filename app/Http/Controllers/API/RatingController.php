<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Modules\Rating\Entities\Rating;

class RatingController extends Controller
{
    /**
     * Store a new rating.
     *
     * @OA\Post(
     *      path="/rating/storeRating",
     *      operationId="storeRating",
     *      tags={"rating"},
     *      security={{ "sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={"property_id", "rating"},
     *                  @OA\Property(property="property_id", type="integer", example=1),
     *                  @OA\Property(property="rating", type="integer", example=4),
     *                  @OA\Property(property="title", type="string", example="Great Property!")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Rating stored successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Rating saved successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Validation error.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Something went wrong.")
     *          )
     *      )
     * )
     */
    public function storeRating(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'property_id' => 'required|numeric',
                'rating' => 'required|numeric|between:1,5',
                'title' => 'string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->first()
                ], 400);
            }

            $property = Property::find($request->input('property_id'));

            if (!$property) {
                return response()->json([
                    'error' => 'Property not found.'
                ], 404);
            }

            $is_exist = Rating::where('model_id', $request->input('property_id'))
                ->where('model_type', get_class($property))
                ->where('created_by_id', Auth::id())
                ->first();

            if ($is_exist) {
                $rating = $is_exist;
            } else {
                $rating = new Rating();
            }

            $rating->model_id = $request->input('property_id');
            $rating->model_type = get_class($property);
            $rating->title = $request->input('title');
            $rating->rating = $request->input('rating');
            $rating->created_by_id = Auth::id();

            if ($rating->save()) {
                $this->updatePropertyRating($request->input('property_id'), $property);

                return response()->json([
                    'message' => 'Rating saved successfully.',
                    'property' => $property
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Failed to save rating.'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the rating for a property based on its ratings.
     *
     * @param int $propertyId
     * @return void
     */
    private function updatePropertyRating(int $propertyId, $propertyC)
    {
        $averageRating = Rating::where('model_id', $propertyId)
            ->where('model_type', get_class($propertyC))
            ->avg('rating');

        $property = Property::find($propertyId);
        if ($property) {
            $property->rating = round($averageRating, 2);
            $property->save();
        }
    }
}
