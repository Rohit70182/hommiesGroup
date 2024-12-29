<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    /**
     * @OA\Get(
     *      path="/amanity/amenities",
     *      operationId="getAmenities",
     *      tags={"amenities"},
     *      security={{ "sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Amenity List",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="WiFi"),
     *              @OA\Property(property="image", type="string", example="wifi.png"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No amenities found.")
     *          )
     *      )
     * )
     */
    public function getAmenities()
    {
        $amenities = Amenity::all();
        if ($amenities->isNotEmpty()) {
            return response()->json([
                'amenities' => $amenities,
                'message' => 'Amenities list fetched successfully.'
            ], 200);
        } else {
            return response()->json(['message' => 'No amenities found.'], 404);
        }
    }
}
