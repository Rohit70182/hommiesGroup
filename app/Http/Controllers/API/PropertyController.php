<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Amenity; // If you need to validate or manipulate amenities
use App\Models\PropertyAmenity;
use App\Models\PropertyHistory;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Modules\Chat\Entities\Chat;
use Modules\Favourite\Entities\Item;

class PropertyController extends Controller
{
    /**
     * @OA\Get(
     *      path="/property/list",
     *      operationId="properties",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          required=false,
     *          description="Search properties by title or description",
     *          @OA\Schema(
     *              type="string",
     *              example="Property One"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="min_price",
     *          in="query",
     *          required=false,
     *          description="Minimum price of property",
     *          @OA\Schema(
     *              type="integer",
     *              example=100
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="max_price",
     *          in="query",
     *          required=false,
     *          description="Maximum price of property",
     *          @OA\Schema(
     *              type="integer",
     *              example=500
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="property_type",
     *          in="query",
     *          required=false,
     *          description="Property type",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="no_of_rooms",
     *          in="query",
     *          required=false,
     *          description="Number of Rooms",
     *          @OA\Schema(
     *              type="integer",
     *              example=3
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="bathroom",
     *          in="query",
     *          required=false,
     *          description="Number of bathrooms",
     *          @OA\Schema(
     *              type="integer",
     *              example=2
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="beds",
     *          in="query",
     *          required=false,
     *          description="Number of beds",
     *          @OA\Schema(
     *              type="integer",
     *              example=4
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="adults",
     *          in="query",
     *          required=false,
     *          description="Number of adults",
     *          @OA\Schema(
     *              type="integer",
     *              example=2
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="children",
     *          in="query",
     *          required=false,
     *          description="Number of children",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="infants",
     *          in="query",
     *          required=false,
     *          description="Number of infants",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="property_amenity",
     *          in="query",
     *          required=false,
     *          description="Property amenities (comma-separated values)",
     *          @OA\Schema(
     *              type="string",
     *              example="1,2"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property List",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Property One"),
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
    public function List(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'User is not authenticated.'], 401);
        }

        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);
        $propertyType = $request->get('property_type', null);
        $bedroom = $request->get('no_of_rooms', null);
        $bathroom = $request->get('bathroom', null);
        $beds = $request->get('beds', null);
        $adults = $request->get('adults', null);
        $children = $request->get('children', null);
        $infants = $request->get('infants', null);
        $propertyAmenity = $request->get('property_amenity', null);

        $propertiesQuery = Property::query();

        if (auth()->user()->role == User::ROLE_USER && auth()->id() != $propertiesQuery->sold_to) {
            $propertiesQuery->where('state_id', Property::STATE_PENDING);
        }

        if (auth()->user()->role == User::ROLE_USER && auth()->id() == $propertiesQuery->sold_to) {
            $propertiesQuery->where('sold_to', $propertiesQuery->sold_to);
        }

        if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
            $propertiesQuery->where('created_by_id', auth()->id());
        }

        if (!empty($search)) {
            $propertiesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('about', 'like', '%' . $search . '%')
                    ->orWhere('town', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%')
                    ->orWhere('zipcode', 'like', '%' . $search . '%');
            });
        }

        if (!is_null($minPrice)) {
            $propertiesQuery->where('price', '>=', $minPrice);
        }

        if (!is_null($maxPrice)) {
            $propertiesQuery->where('price', '<=', $maxPrice);
        }

        if (!is_null($propertyType)) {
            $propertiesQuery->where('property_type', $propertyType);
        }

        if (!is_null($bedroom)) {
            $propertiesQuery->where('no_of_rooms', '>=', $bedroom);
        }

        if (!is_null($bathroom)) {
            $propertiesQuery->where('bathrooms', '>=', $bathroom);
        }

        if (!is_null($beds)) {
            $propertiesQuery->where('no_of_beds', '>=', $beds);
        }

        if (!is_null($adults)) {
            $propertiesQuery->where('adult', '>=', $adults);
        }

        if (!is_null($children)) {
            $propertiesQuery->where('children', '>=', $children);
        }

        if (!is_null($infants)) {
            $propertiesQuery->where('infants', '>=', $infants);
        }

        if (!empty($propertyAmenity)) {
            $amenities = explode(',', $propertyAmenity);
            $propertiesQuery->whereHas('propertyAmenities', function ($query) use ($amenities) {
                $query->whereIn('id', $amenities);
            });
        }

        $properties = $propertiesQuery->paginate(10, ['*'], 'page', $page);
        $totalProperties = $properties->total();

        $properties->getCollection()->each(function ($property) {
            $item = Item::where([
                'model_type' => get_class($property),
                'model_id' => $property->id,
                'created_by_id' => auth()->id(),
                'state_id' => Item::STATE_ACTIVE,
            ])->first();
            $property->is_favorite = $item ? true : false;
        });

        $meta_count = [
            'total_count' => $totalProperties,
            'current_page' => $properties->currentPage(),
            'total_pages' => $properties->lastPage(),
        ];

        if ($properties->isNotEmpty()) {
            return response()->json([
                'property' => $properties->items(),
                'meta_count' => $meta_count,
                'message' => 'Property list fetched successfully.'
            ], 200);
        } else {
            return response()->json(['message' => 'No properties found.'], 400);
        }
    }

    /**
     * @OA\Get(
     *      path="/property/listByRating",
     *      operationId="listByRating",
     *      tags={"property"},
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
    public function listByRating(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'User is not authenticated.'], 401);
        }

        $page = $request->get('page', 1);
        $propertiesQuery = Property::query()->where('state_id', Property::STATE_PENDING);
        if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
            $propertiesQuery->where('created_by_id', auth()->id());
        }

        $propertiesQuery->orderBy('rating', 'desc');

        $properties = $propertiesQuery->paginate(10, ['*'], 'page', $page);
        $totalProperties = $properties->total();

        $properties->getCollection()->each(function ($property) {
            $item = Item::where([
                'model_type' => get_class($property),
                'model_id' => $property->id,
                'created_by_id' => auth()->id(),
                'state_id' => Item::STATE_ACTIVE,
            ])->first();
            $property->is_favorite = $item ? true : false;
        });

        $meta_count = [
            'total_count' => $totalProperties,
            'current_page' => $properties->currentPage(),
            'total_pages' => $properties->lastPage(),
        ];

        if ($properties->isNotEmpty()) {
            return response()->json([
                'property' => $properties->items(),
                'meta_count' => $meta_count,
                'message' => 'Property list sorted by rating fetched successfully.'
            ], 200);
        } else {
            return response()->json(['message' => 'No properties found.'], 400);
        }
    }



    /**
     * @OA\Get(
     *      path="/property/nearby",
     *      operationId="nearbyProperties",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      @OA\Parameter(
     *          name="latitude",
     *          in="query",
     *          required=false,
     *          description="Latitude of the user's location",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              example=30.7046
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="longitude",
     *          in="query",
     *          required=false,
     *          description="Longitude of the user's location",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              example=-76.7179
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Page number for pagination (default is 1)",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Nearby Property List",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Property One"),
     *              @OA\Property(property="distance", type="string", example="2.5 miles"),
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
    public function nearbyProperties(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'User is not authenticated.'], 401);
        }

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $page = $request->get('page', 1);

        if (!$latitude || !$longitude) {
            $propertiesQuery = Property::query()->where('state_id', Property::STATE_PENDING);

            if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
                $propertiesQuery->where('created_by_id', auth()->id());
            }

            $properties = $propertiesQuery->paginate(10, ['*'], 'page', $page);
            $totalProperties = $properties->total();

            $properties->getCollection()->each(function ($property) {
                $item = Item::where([
                    'model_type' => get_class($property),
                    'model_id' => $property->id,
                    'created_by_id' => auth()->id(),
                    'state_id' => Item::STATE_ACTIVE,
                ])->first();

                $property->is_favorite = $item ? true : false;
            });

            return response()->json([
                'property' => $properties->items(),
                'meta_count' => [
                    'total_count' => $totalProperties,
                    'current_page' => $properties->currentPage(),
                    'total_pages' => $properties->lastPage(),
                ],
                'message' => 'Full property list fetched successfully.',
            ], 200);
        }

        $propertiesQuery = Property::query()->where('state_id', Property::STATE_PENDING);

        if (auth()->user()->role == User::ROLE_SERVICE_PROVIDER) {
            $propertiesQuery->where('created_by_id', auth()->id());
        }

        $propertiesQuery->selectRaw(
            "*, 
        (3959 * acos(
            cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(latitude))
        )) AS distance_in_miles,
        (6371000 * acos(
            cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(latitude))
        )) AS distance_in_meters",
            [$latitude, $longitude, $latitude, $latitude, $longitude, $latitude]
        );

        $properties = $propertiesQuery->orderBy('distance_in_miles', 'asc')->paginate(10, ['*'], 'page', $page);
        $totalProperties = $properties->total();

        $properties->getCollection()->each(function ($property) {
            $item = Item::where([
                'model_type' => get_class($property),
                'model_id' => $property->id,
                'created_by_id' => auth()->id(),
                'state_id' => Item::STATE_ACTIVE,
            ])->first();

            $property->is_favorite = $item ? true : false;
        });

        return response()->json([
            'property' => $properties->items(),
            'meta_count' => [
                'total_count' => $totalProperties,
                'current_page' => $properties->currentPage(),
                'total_pages' => $properties->lastPage(),
            ],
            'message' => 'Nearby property list fetched successfully.',
        ], 200);
    }



    /**
     * @OA\Post(
     *      path="/property/properties",
     *      operationId="addProperty",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Add a new property",
     *      description="Register a new property with additional details",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={
     *                      "name", "no_of_rooms", "no_of_beds", "price", "price_type", 
     *                      "address", "latitude", "longitude", "bathrooms", 
     *                      "property_type", "adult", "children", "infants", 
     *                      "property_id_proof_1", "property_id_proof_2"
     *                  },
     *                  @OA\Property(property="name", type="string", example="Beautiful House"),
     *                  @OA\Property(property="no_of_rooms", type="integer", example=3),
     *                  @OA\Property(property="no_of_beds", type="integer", example=2),
     *                  @OA\Property(property="about", type="string", example="A cozy place for vacation."),
     *                  @OA\Property(property="price", type="number", format="float", example=150.75),
     *                  @OA\Property(property="price_type", type="integer", example=1),
     *                  @OA\Property(property="town", type="string", example= "canada"),
     *                  @OA\Property(property="zipcode", type="integer", example=178526),
     *                  @OA\Property(property="country", type="string", example="Canada"),
     *                  @OA\Property(property="address", type="string", example="123 Main St, Springfield"),
     *                  @OA\Property(property="latitude", type="number", format="float", example=40.7128),
     *                  @OA\Property(property="longitude", type="number", format="float", example=-74.0060),
     *                  @OA\Property(property="bathrooms", type="integer", example=2),
     *                  @OA\Property(property="property_type", type="string", example="1"),
     *                  @OA\Property(property="adult", type="integer", example=2),
     *                  @OA\Property(property="area", type="string", example="873"),
     *                  @OA\Property(property="children", type="integer", example=1),
     *                  @OA\Property(property="infants", type="integer", example=1),
     *                  @OA\Property(property="amenities_ids", type="array", @OA\Items(type="integer"), example={1, 2, 3}),
     *                  
     *                  @OA\Property(property="property_id_proof_1", type="file", description="First property ID proof document"),
     *                  @OA\Property(property="property_id_proof_2", type="file", description="Second property ID proof document"),
     *                  
     *                  @OA\Property(property="images[]", type="array", @OA\Items(type="file"), description="Multiple images to upload")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Property created successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property created successfully."),
     *              @OA\Property(property="property", type="object", example={"id": 1, "name": "Beautiful House", "no_of_rooms": 3, "no_of_beds": 2, "price": 150.75, "address": "123 Main St, Springfield"})
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error.")
     *          )
     *      )
     * )
     */

    public function addProperty(Request $request)
    {
        if (auth()->user()->role != User::ROLE_SERVICE_PROVIDER) {
            return response()->json(['message' => 'Unauthorized. Only service providers can add properties.'], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_of_rooms' => 'required|integer',
            'no_of_beds' => 'required|integer',
            'about' => 'nullable|string',
            'price' => 'required|numeric',
            'price_type' => 'required|integer',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bathrooms' => 'required|integer',
            'property_type' => 'required|string|max:255',
            'adult' => 'required|integer',
            'children' => 'required|integer',
            'infants' => 'required|integer',
            'town' => 'required|string',
            'area' => 'required|string',
            'zipcode' => 'required|integer',
            'country' => 'required|string',
            // 'amenities_ids' => 'required|array',
            // 'amenities_ids.*' => 'integer|exists:amenities,id',
            // 'images' => 'required|array',
            // 'images.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'property_id_proof_1' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'property_id_proof_2' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error.', 'errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $idProof1Name = null;
            $idProof2Name = null;

            if ($request->hasFile('property_id_proof_1')) {
                $idProof1Name = 'proof1_' . date('Ymd') . '_' . time() . '.' . $request->file('property_id_proof_1')->getClientOriginalExtension();
                $request->file('property_id_proof_1')->move(public_path('uploads/property/propertyIds/'), $idProof1Name);
            }

            if ($request->hasFile('property_id_proof_2')) {
                $idProof2Name = 'proof2_' . date('Ymd') . '_' . time() . '.' . $request->file('property_id_proof_2')->getClientOriginalExtension();
                $request->file('property_id_proof_2')->move(public_path('uploads/property/propertyIds/'), $idProof2Name);
            }

            $property = Property::create([
                'name' => $request->name,
                'no_of_rooms' => $request->no_of_rooms,
                'no_of_beds' => $request->no_of_beds,
                'about' => $request->about,
                'price' => $request->price,
                'price_type' => $request->price_type,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'bathrooms' => $request->bathrooms,
                'property_type' => $request->property_type,
                'adult' => $request->adult,
                'children' => $request->children,
                'infants' => $request->infants,
                'town' => $request->town,
                'area' => $request->area,
                'state_id' => Property::STATE_PENDING,
                'zipcode' => $request->zipcode,
                'country' => $request->country,
                'property_id_proof_1' => $idProof1Name,
                'property_id_proof_2' => $idProof2Name,
                'created_by_id' => auth()->id(),
            ]);

            $amenitiesIds = is_string($request->amenities_ids) ? explode(',', $request->amenities_ids) : $request->amenities_ids;

            foreach ($amenitiesIds as $amenityId) {
                PropertyAmenity::create([
                    'property_id' => $property->id,
                    'amenities_id' => $amenityId,
                    'created_by_id' => $property->created_by_id,
                ]);
            }

            foreach ($request->file('images') as $image) {
                $imageName = 'property_' . date('Ymd') . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/property/propertyImages/'), $imageName);

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $imageName,
                    'created_by_id' => $property->created_by_id,
                ]);
            }

            DB::commit();
            // $property->load('propertyAmenities', 'images');
            return response()->json(['message' => 'Property created successfully.', 'property' => $property], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating property.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/property/getPropertyDetail/{id}",
     *      operationId="getPropertyDetail",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Get Property Details",
     *      description="Retrieve details of a property by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the property",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property details retrieved successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Beautiful House"),
     *              @OA\Property(property="no_of_rooms", type="integer", example=3),
     *              @OA\Property(property="no_of_beds", type="integer", example=2),
     *              @OA\Property(property="about", type="string", example="A cozy place for vacation."),
     *              @OA\Property(property="price", type="number", format="float", example=150.75),
     *              @OA\Property(property="address", type="string", example="123 Main St, Springfield"),
     *              @OA\Property(property="latitude", type="number", format="float", example=40.7128),
     *              @OA\Property(property="longitude", type="number", format="float", example=-74.0060),
     *              @OA\Property(property="bathrooms", type="integer", example=2),
     *              @OA\Property(property="property_type", type="string", example="1"),
     *              @OA\Property(property="adult", type="integer", example=2),
     *              @OA\Property(property="children", type="integer", example=1),
     *              @OA\Property(property="infants", type="integer", example=1),
     *              @OA\Property(property="property_id_proof_1", type="string", example="proof1_20240807_123456.jpg"),
     *              @OA\Property(property="property_id_proof_2", type="string", example="proof2_20240807_123457.jpg"),
     *              @OA\Property(property="amenities", type="array", @OA\Items(type="string"), example={"Pool", "Wi-Fi", "Parking"}),
     *              @OA\Property(property="images", type="array", @OA\Items(type="string"), example={"image1.jpg", "image2.jpg"})
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property not found.")
     *          )
     *      )
     * )
     */
    public function getPropertyDetail($id)
    {
        try {
            $property = Property::with(['propertyAmenities.amenity', 'images', 'user'])->find($id);

            if (!$property) {
                return response()->json(['message' => 'Property not found.'], 400);
            }

            $item = Item::where([
                'model_type' => get_class($property),
                'model_id' => $property->id,
                'created_by_id' => auth()->id(),
                'state_id' => Item::STATE_ACTIVE,
            ])->first();

            $isFavorite = $item ? true : false;
            $formattedProperty = [
                'id' => $property->id,
                'name' => $property->name,
                'no_of_rooms' => $property->no_of_rooms,
                'no_of_beds' => $property->no_of_beds,
                'about' => $property->about,
                'price' => $property->price,
                'price_type' => $property->price_type,
                'address' => $property->address,
                'latitude' => $property->latitude,
                'longitude' => $property->longitude,
                'bathrooms' => $property->bathrooms,
                'property_type' => $property->property_type,
                'adult' => $property->adult,
                'children' => $property->children,
                'infants' => $property->infants,
                'town' => $property->town,
                'area' => $property->area,
                'state_id' => $property->state_id,
                'zipcode' => $property->zipcode,
                'country' => $property->country,
                'is_favorite' => $isFavorite,
                'property_id_proof_1' => $property->property_id_proof_1_url,
                'property_id_proof_2' => $property->property_id_proof_2_url,
                'property_images_url' => $property->property_images_url,
                'property_amanities_image' => $property->property_amanities_image,
                'property_amenities' => $property->propertyAmenities,
                'testimonials' => $property->testimonials,
                // 'images' => $property->images,
                'user' => $property->user,
                'testimonials' => $property->testimonials,
            ];

            return response()->json([
                'message' => 'Property details fetched successfully',
                'property' => $formattedProperty
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching property details.', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Post(
     *      path="/property/edit/{id}",
     *      operationId="updateProperty",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "no_of_rooms", "no_of_beds", "price", "price_type", "address", "latitude", "longitude", "bathrooms", "property_type", "adult", "children", "infants"},
     *                  @OA\Property(property="name", type="string", example="Updated Property"),
     *                  @OA\Property(property="no_of_rooms", type="integer", example=4),
     *                  @OA\Property(property="no_of_beds", type="integer", example=3),
     *                  @OA\Property(property="price", type="number", format="float", example=200.50),
     *                  @OA\Property(property="price_type", type="integer", example=1),
     *                  @OA\Property(property="address", type="string", example="456 New Street, City"),
     *                  @OA\Property(property="latitude", type="number", format="float", example=41.8781),
     *                  @OA\Property(property="longitude", type="number", format="float", example=-87.6298),
     *                  @OA\Property(property="bathrooms", type="integer", example=3),
     *                  @OA\Property(property="property_type", type="string", example="2"),
     *                  @OA\Property(property="adult", type="integer", example=2),
     *                  @OA\Property(property="area", type="string", example="873 m"),
     *                  @OA\Property(property="children", type="integer", example=1),
     *                  @OA\Property(property="infants", type="integer", example=1),
     *                  @OA\Property(property="town", type="string", example= "canada"),
     *                  @OA\Property(property="zipcode", type="integer", example=178526),
     *                  @OA\Property(property="country", type="string", example="Canada"),
     *                  @OA\Property(property="amenities_ids", type="array", @OA\Items(type="integer"), example={1, 2}),
     *                  @OA\Property(property="property_id_proof_1", type="file", description="Updated first property ID proof"),
     *                  @OA\Property(property="property_id_proof_2", type="file", description="Updated second property ID proof"),
     *                  @OA\Property(property="images[]", type="array", @OA\Items(type="file"), description="New images to upload or update")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property updated successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property updated successfully."),
     *              @OA\Property(property="property", type="object", example={"id": 1, "name": "Updated Property", "no_of_rooms": 4, "no_of_beds": 3, "price": 200.50, "address": "456 New Street, City"})
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property not found.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error.")
     *          )
     *      )
     * )
     */
    public function updateProperty(Request $request, $id)
    {
        $property = Property::where('id', $id)
            ->where('created_by_id', auth()->id())
            ->first();

        if (!$property) {
            return response()->json(['message' => 'Property not found.'], 400);
        }
        if (auth()->user()->role != User::ROLE_SERVICE_PROVIDER || auth()->id() != $property->created_by_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'no_of_rooms' => 'nullable|integer',
            'no_of_beds' => 'nullable|integer',
            'about' => 'nullable|string',
            'price' => 'nullable|numeric',
            'price_type' => 'nullable|integer',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'bathrooms' => 'nullable|integer',
            'property_type' => 'nullable|string|max:255',
            'adult' => 'nullable|integer',
            'children' => 'nullable|integer',
            'infants' => 'nullable|integer',
            'town' => 'required|string',
            'area' => 'required|string',
            'zipcode' => 'required|integer',
            'country' => 'required|string',
            'property_id_proof_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'property_id_proof_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error.', 'errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $property->update([
                'name' => $request->name ?? $property->name,
                'no_of_rooms' => $request->no_of_rooms ?? $property->no_of_rooms,
                'no_of_beds' => $request->no_of_beds ?? $property->no_of_beds,
                'about' => $request->about ?? $property->about,
                'price' => $request->price ?? $property->price,
                'price_type' => $request->price_type ?? $property->price_type,
                'address' => $request->address ?? $property->address,
                'latitude' => $request->latitude ?? $property->latitude,
                'longitude' => $request->longitude ?? $property->longitude,
                'bathrooms' => $request->bathrooms ?? $property->bathrooms,
                'property_type' => $request->property_type ?? $property->property_type,
                'adult' => $request->adult ?? $property->adult,
                'children' => $request->children ?? $property->children,
                'infants' => $request->infants ?? $property->infants,
                'town' => $request->town ?? $property->town,
                'area' => $request->area ?? $property->area,
                'zipcode' => $request->zipcode ?? $property->zipcode,
                'country' => $request->country ?? $property->country,
            ]);

            if ($request->hasFile('property_id_proof_1')) {
                if ($property->property_id_proof_1 && file_exists(public_path('uploads/property/propertyIds/' . $property->property_id_proof_1))) {
                    unlink(public_path('uploads/property/propertyIds/' . $property->property_id_proof_1));
                }

                $idProof1Name = 'proof1_' . date('Ymd') . '_' . time() . '.' . $request->file('property_id_proof_1')->getClientOriginalExtension();
                $request->file('property_id_proof_1')->move(public_path('uploads/property/propertyIds/'), $idProof1Name);
                $property->property_id_proof_1 = $idProof1Name;
            }

            if ($request->hasFile('property_id_proof_2')) {
                if ($property->property_id_proof_2 && file_exists(public_path('uploads/property/propertyIds/' . $property->property_id_proof_2))) {
                    unlink(public_path('uploads/property/propertyIds/' . $property->property_id_proof_2));
                }

                $idProof2Name = 'proof2_' . date('Ymd') . '_' . time() . '.' . $request->file('property_id_proof_2')->getClientOriginalExtension();
                $request->file('property_id_proof_2')->move(public_path('uploads/property/propertyIds/'), $idProof2Name);
                $property->property_id_proof_2 = $idProof2Name;
            }

            $amenitiesIds = is_string($request->amenities_ids) ? explode(',', $request->amenities_ids) : $request->amenities_ids;
            PropertyAmenity::where('property_id', $property->id)->delete();
            foreach ($amenitiesIds as $amenityId) {
                PropertyAmenity::create([
                    'property_id' => $property->id,
                    'amenities_id' => $amenityId,
                    'created_by_id' => auth()->id(),
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = 'property_' . date('Ymd') . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/property/propertyImages/'), $imageName);

                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => $imageName,
                        'created_by_id' => auth()->id(),
                    ]);
                }
            }

            DB::commit();
            // $property->load('propertyAmenities', 'images');
            return response()->json(['message' => 'Property updated successfully.', 'property' => $property], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating property.', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *      path="/property/myFavourites",
     *      operationId="myFavourites",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Get a list of favourite items for the authenticated user",
     *      description="Returns a list of active favourite items for the authenticated user.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No favourite items found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No providers are in your favourites")
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
    public function myFavourites()
    {
        try {
            $favourites = Item::where([
                'created_by_id' => auth()->id(),
                'state_id' => Item::STATE_ACTIVE,
            ])->get();

            if ($favourites->isNotEmpty()) {
                $properties = Property::whereIn('id', $favourites->pluck('model_id'))->get();
                return response()->json(['message' => 'Favorite Listed successfully.', 'property' => $properties], 200);
            } else {
                return response()->json([
                    'message' => 'No providers are in your favourites'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * @OA\Post(
     *      path="/property/markfavourite",
     *      operationId="markfavourite",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Mark Favorite property",
     *      description="Register a new property with additional details",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"property_id"},
     *                  @OA\Property(property="property_id", type="integer", example="1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Property favorite and unfavorite successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property favorite and unfavorite successfully."),
     *              @OA\Property(property="property", type="object", example={"id": 1, "name": "Beautiful House", "no_of_rooms": 3, "no_of_beds": 2, "price": 150.75, "address": "123 Main St, Springfield"})
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error.")
     *          )
     *      )
     * )
     */

    public function markfavourite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error.', 'errors' => $validator->errors()], 400);
        }
        $id = $request->property_id;
        try {
            $property = Property::where('id', $id)->first();
            if ($property) {
                $item = Item::where([
                    'model_type' => get_class($property),
                    'model_id' => $property->id,
                    'created_by_id' => auth()->id()
                ])->first();

                if ($item) {
                    if ($item->state_id == Item::STATE_ACTIVE) {
                        $item->state_id = Item::STATE_INACTIVE;
                        $item->save();
                        return response()->json([
                            'message' => 'property removed from favourites'
                        ], 200);
                    } else {
                        $item->state_id = Item::STATE_ACTIVE;
                        $item->save();
                        return response()->json([
                            'message' => 'property added to favourites'
                        ], 200);
                    }
                } else {
                    $model = new Item;
                    $model->model_type = get_class($property);
                    $model->model_id = $property->id;
                    $model->state_id = Item::STATE_ACTIVE;
                    $model->created_by_id = auth()->id();

                    if ($model->save()) {
                        return response()->json([
                            'message' => 'property added to favourites'
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'unexpected error occurred'
                        ], 401);
                    }
                }
            } else {
                return response()->json([
                    'message' => 'Property not found'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/property/deleteProperty",
     *      operationId="deleteProperty",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Delete a property",
     *      description="Delete a property with all associated data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"property_id"},
     *                  @OA\Property(property="property_id", type="integer", example="1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property deleted successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property deleted successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property not found.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized to delete property.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized to delete property.")
     *          )
     *      )
     * )
     */
    public function deleteProperty(Request $request)
    {
        $id = $request->input('property_id');
        if (auth()->user()->role != User::ROLE_SERVICE_PROVIDER) {
            return response()->json(['message' => 'Unauthorized to delete property.'], 403);
        }
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found.'], 400);
        }

        if ($property->created_by_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized to delete this property.'], 403);
        }

        DB::beginTransaction();
        try {
            PropertyAmenity::where('property_id', $property->id)->delete();
            PropertyImage::where('property_id', $property->id)->delete();

            foreach ($property->images as $image) {
                $imagePath = public_path('uploads/property/propertyImages/' . $image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $proof1Path = public_path('uploads/property/propertyIds/' . $property->property_id_proof_1);
            if (file_exists($proof1Path)) {
                unlink($proof1Path);
            }

            $proof2Path = public_path('uploads/property/propertyIds/' . $property->property_id_proof_2);
            if (file_exists($proof2Path)) {
                unlink($proof2Path);
            }
            $property->delete();

            DB::commit();
            return response()->json(['message' => 'Property deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting property.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/property/storePropertyHistory",
     *      operationId="storePropertyHistory",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Store property history for the given property and user",
     *      description="Stores a record in the property history table with the given to_user, property_id, and message.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"property_id"},
     *                  @OA\Property(property="to_user", type="integer", example=2),
     *                  @OA\Property(property="property_id", type="integer", example=101),
     *                  @OA\Property(property="message", type="string", example="Property sold to this user."),
     *                  @OA\Property(property="sold_outside", type="integer", example=0)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property history saved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property history saved successfully.")
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
    public function storePropertyHistory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'property_id' => 'required|integer',
                'to_user' => 'nullable|integer',
                'message' => 'nullable|string',
                'sold_outside' => [
                    'nullable',
                    'integer',
                    'in:0,1',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!$request->has('to_user') && !$value) {
                            return $fail('The ' . $attribute . ' field is required when to_user is not provided.');
                        }
                    }
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $property_id = $request->input('property_id');
            $property = Property::where([
                ['state_id', '=', Property::STATE_PENDING],
                ['id', '=', $property_id],
                ['created_by_id', '=', auth()->id()],
            ])->first();

            if ($property) {
                $property->state_id = Property::STATE_SOLD;
                $property->sold_to = $request->input('to_user');
                $property->save();
            } else {
                return response()->json([
                    'message' => 'Property not found.'
                ], 400);
            }

            $propertyHistory = new PropertyHistory();
            $propertyHistory->property_id = $request->input('property_id');
            $propertyHistory->to_user = $request->input('to_user');
            $propertyHistory->state_id = PropertyHistory::STATE_ACTIVE;
            $propertyHistory->message = $request->input('message');
            $propertyHistory->sold_outside = $request->input('sold_outside');
            $propertyHistory->save();

            return response()->json([
                'message' => 'Property history saved and property updated successfully.'
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
     *      path="/property/markAsUnsold",
     *      operationId="markAsUnsold",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Mark a property as unsold",
     *      description="Marks a property as unsold by updating its state_id and removing the sold_to information.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"property_id"},
     *                  @OA\Property(property="property_id", type="integer", example=101)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Property marked as unsold successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property marked as unsold successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found or is not in sold state",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Property not found or is not sold.")
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

    public function markAsUnsold(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'property_id' => 'required|integer|exists:properties,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid input data.',
                    'errors' => $validator->errors()
                ], 400);
            }

            $property_id = $request->input('property_id');

            $property = Property::where([
                ['id', '=', $property_id],
                ['state_id', '=', Property::STATE_SOLD]
            ])->first();

            if ($property) {
                $property->state_id = Property::STATE_PENDING;
                $property->sold_to = null;

                $property->save();

                return response()->json([
                    'message' => 'Property marked as unsold successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Property not found or is not sold.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get users associated with a property and filtered by role.
     *
     * @OA\Get(
     *      path="/property/user-list",
     *      operationId="getUserList",
     *      tags={"property"},
     *      security={{ "sanctum": {} }},
     *      summary="Fetch users associated with a property based on property_id",
     *      description="Fetches a list of users involved in chats associated with a given property and filtered by role.",
     *      @OA\Parameter(
     *          name="property_id",
     *          in="query",
     *          required=true,
     *          description="The ID of the property to filter users by",
     *          @OA\Schema(
     *              type="integer",
     *              example=101
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of users fetched successfully",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="John Doe"),
     *                  @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                  @OA\Property(property="phone", type="string", example="123456789"),
     *                  @OA\Property(property="created_at", type="string", example="2022-01-01T00:00:00.000000Z")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid property_id.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found or no associated users",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No users found for this property.")
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
    public function getUserList(Request $request)
    {
        // if (auth()->user()->role != User::ROLE_SERVICE_PROVIDER) {
        //     return response()->json(['message' => 'Unauthorized. Only service providers can get user list.'], 403);
        // }
        try {
            $validator = Validator::make($request->all(), [
                'property_id' => 'required|integer|exists:properties,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid property_id.',
                    'errors' => $validator->errors(),
                ], 400);
            }

            $propertyId = $request->input('property_id');
            $property = Property::where('id', $propertyId)->first();
            if (empty($property)) {
                return response()->json(['message' => 'Property Not Found'], 400);
            }
            $chats = Chat::where('property_id', $propertyId)
                ->where(function ($query) {
                    $query->where('to_id', auth()->id())
                        ->orWhere('from_id', auth()->id());
                })
                ->get();

            $userIds = $chats->flatMap(function ($chat) {
                return [$chat->to_id, $chat->from_id];
            })->unique()->toArray();

            $users = User::whereIn('id', $userIds)
                ->where('role', User::ROLE_USER)
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No users found for this property.'
                ], 400);
            }
            return response()->json([
                'user' => $users,
                'message' => 'Users found successfuly.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
