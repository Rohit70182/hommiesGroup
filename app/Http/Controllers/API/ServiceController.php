<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BookService\Entities\Booking;
use Modules\ServiceProvider\Entities\BookServiceProvider;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\Services\Entities\CustomReq;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\SubCategory;
use Illuminate\Support\Facades\Validator;
use Modules\Services\Entities\AddOnService;
use Modules\Services\Entities\Coupon;
use App\Models\Event;
use App\Models\ProviderServices;
use App\Models\User;
use Modules\Services\Entities\ServiceList;
use Modules\Services\Entities\ServicePriceList;
use Modules\Services\Entities\SubService;
use Modules\Services\Entities\SubServicePriceList;

class ServiceController extends Controller
{

    /**
     *
     *   @OA\Get(
     *      path="/service/category-list",
     *      operationId="category",
     *      tags={"category"},   
     *      summary="",
     *   @OA\Parameter(
     *          name="search",
     *          description="category name",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   security={{ "sanctum": {} }},
     *   @OA\Response(
     *        response=200,
     *        description="category Object",
     *        @OA\JsonContent(
     *        @OA\Property(property="id", type="integer", example="1"),
     *        @OA\Property(property="name", type="string", example="category one"),
     *        @OA\Property(property="desc", type="string", example="category description"),
     *    )
     * ),
     * @OA\Response(
     *        response=400,
     *        description="Not Found",
     *        @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     * ),
     *  @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *    ),  
     *  )
     */
    public function categoryList(Request $request)
    {
        $categories = Category::query();

        if (!empty($request->search)) {
            $categories = $categories->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $categories->where('state_id', Category::STATE_ACTIVE)->get();

        if ($categories) {
            return response([
                'list' => $categories,
                'message' => 'category list'
            ], 200);
        } else {
            return response([
                'message' => 'Not found'
            ], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/subcategory-list",
     *      operationId="subcategory",
     *      tags={"category"},
     *      summary="",
     *      @OA\Parameter(
     *          name="search",
     *          description="subcategory name",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="category",
     *          description="category id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      security={{ "sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Sub categories object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="category one"),
     *           @OA\Property(property="desc", type="string", example="category description"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *        )
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Not Found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function subCategoryList(Request $request)
    {
        $fields = $request->all();

        $subcategories = SubCategory::query();
        if (isset($request->search) && !empty($request->search)) {

            $subcategories = $subcategories->where('name', 'like', '%' . $request->search . '%');
        }
        if (isset($request->category) && !empty($request->category)) {

            $subcategories = $subcategories->where('category_id', $request->category);
        }
        $subcategories = $subcategories->where('state_id', SubCategory::STATE_ACTIVE)->get();
        if ($subcategories) {
            return response([
                'list' => $subcategories,
                'message' => 'Sub category list'
            ], 200);
        } else {
            return response([
                'message' => 'Not found'
            ], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/list",
     *      operationId="service",
     *      tags={"service"},   
     *      summary="",
     * @OA\Parameter(
     *          name="search",
     *          description="service name",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * * @OA\Parameter(
     *          name="category",
     *          description="category id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="service one"),
     *           @OA\Property(property="desc", type="string", example="service description"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="sub_category_id", type="integer", example="1"),
     *           @OA\Property(property="category", type="object", example="{'id': 1,'name': 'category one','desc': 'category description'}"),
     *           @OA\Property(property="sub_category", type="object", example="{'id': 1,'name': 'sub category one','desc': 'sub category description'}"),
     *     )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    public function serviceList(Request $request)
    {
        $service = Service::query();

        if (!empty($request->search)) {
            $service = $service->where([
                ['name', 'like', '%' . $request->search . '%'],
                ['state_id', '=', 1],
            ]);
        }

        if (!empty($request->category)) {
            $service = $service->where([
                ['category_id', '=', $request->category],
                ['state_id', '=', 1],
            ]);
        }


        $service = $service->where('state_id', 1)->get();
        if ($service) {
            return response([
                'list' => $service,
                'message' => 'service list'
            ], 200);
        } else {
            return response([
                'message' => 'Not found'
            ], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/detail",
     *      operationId="serviceDetail",
     *      tags={"service"},   
     *      summary="",
     * @OA\Parameter(
     *          name="search_id",
     *          description="service id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="service one"),
     *           @OA\Property(property="desc", type="string", example="service description"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="sub_category_id", type="integer", example="1"),
     *           @OA\Property(property="category", type="object", example="{'id': 1,'name': 'category one','desc': 'category description'}"),
     *           @OA\Property(property="sub_category", type="object", example="{'id': 1,'name': 'sub category one','desc': 'sub category description'}"),
     *     )
     * ),
     * 
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function serviceDetail(Request $request)
    {
        $service = Service::query();

        $validator = validator($request->all(), [
            'search_id' => 'required|integer',

        ]);
        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        if (!empty($request->search_id)) {

            $searchID = $request->search_id;

            $service = $service->where('id', $searchID)->with(['subServices'])->first();

            if (!empty($service)) {
                return response([
                    'message' => 'Service Detail',
                    'detail' => $service
                ], 200);
            } else {
                return response([
                    'message' => 'Not found'
                ], 400);
            }
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/add-on",
     *      operationId="AddOn",
     *      tags={"service"},   
     *      summary="",
     * @OA\Parameter(
     *          name="addon_id",
     *          description="addon id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="addon one"),
     *           @OA\Property(property="desc", type="string", example="addon description"),
     *           @OA\Property(property="price", type="string", example="addon price"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *     )
     * ),
     * 
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function addOnDetail(Request $request)
    {

        $addOns = AddOnService::query();

        $addOnId = $request->addon_id;

        $validator = validator($request->all(), [
            'addon_id' => 'integer',
        ]);

        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        if (!empty($addOnId)) {

            $addOn = $addOns->where('id', $addOnId)->first();

            if (!empty($addOn)) {
                return response([
                    'message' => 'AddOn Detail',
                    'detail'  => $addOn
                ], 200);
            } else {
                return response([
                    'message' => 'Not found'
                ], 400);
            }
        } else {

            $addOn = $addOns->get();

            if (!empty($addOn)) {
                return response([
                    'message' => 'AddOn Detail',
                    'list'    => $addOn
                ], 200);
            } else {
                return response([
                    'message' => 'Not found'
                ], 400);
            }
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/coupon-list",
     *      operationId="CouponList",
     *      tags={"service"},
     *      summary="",
     *      @OA\Parameter(
     *     name="coupon_name",
     *     in="query",
     *     @OA\Schema(
     *       type="string"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="addon one"),
     *           @OA\Property(property="desc", type="string", example="addon description"),
     *           @OA\Property(property="amount", type="string", example="addon price"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function couponList(Request $request)
    {
        $getCoupons = Coupon::query();

        if (!empty($request->coupon_name)) {
            $couponName = $request->coupon_name;
            $getCoupons = $getCoupons->where('name', 'like', '%' . $couponName . '%')->first();

            if (!empty($getCoupons)) {
                return response([
                    'message' => 'Coupons Detail',
                    'detail'    => $getCoupons
                ], 200);
            } else {
                return response([
                    'message' => 'No Coupon found'
                ], 400);
            }
        } else {
            $getCoupons = $getCoupons->get();

            if (!empty($getCoupons)) {
                return response([
                    'message' => 'Coupons Detail',
                    'list'    => $getCoupons
                ], 200);
            } else {
                return response([
                    'message' => 'No Coupon found'
                ], 400);
            }
        }
    }

    /**
     *
     *   @OA\Get(
     *      path="/service/sub-services-list",
     *      operationId="subServiceList",
     *      tags={"service"},
     *      summary="",
     *   @OA\Parameter(
     *          name="service_id",
     *          description="service id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   security={{ "sanctum": {} }},
     *   @OA\Response(
     *        response=200,
     *        description="category Object",
     *        @OA\JsonContent(
     *        @OA\Property(property="id", type="integer", example="1"),
     *        @OA\Property(property="name", type="string", example="category one"),
     *        @OA\Property(property="desc", type="string", example="category description"),
     *    )
     * ),
     * @OA\Response(
     *        response=400,
     *        description="Not Found",
     *        @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     * ),
     *  @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *    ),
     *  )
     */

    public function subServicesList(Request $request)
    {

        $validator = validator($request->all(), [
            'service_id' => 'integer|required',
        ]);

        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        $serviceId = $request->service_id;

        if (!empty($serviceId)) {
            $getSubServices = SubService::where('service_id', $serviceId)->get();

            if (count($getSubServices) > Service::EMPTY_PRICE) {
                return response([
                    'message' => 'Sub Services Detail',
                    'list'    => $getSubServices
                ], 200);
            } else {
                return response([
                    'message' => 'No Sub Service found'
                ], 400);
            }
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/event-list",
     *      operationId="EventList",
     *      tags={"service"},
     *      summary="",
     *      @OA\Parameter(
     *          name="event_id",
     *          description="event id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="addon one"),
     *           @OA\Property(property="desc", type="string", example="addon description"),
     *           @OA\Property(property="amount", type="string", example="addon price"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function eventList(Request $request)
    {

        $events = Event::query();

        $eventId = $request->event_id;

        $validator = validator($request->all(), [
            'event_id' => 'integer',
        ]);

        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        if (!empty($eventId)) {
            $event = $events->where([
                ['id', '=', $eventId],
                ['state_id', '=', 1],
            ])->first();

            if ($event) {
                return response([
                    'message' => 'Event Detail',
                    'detail'    => $event
                ], 200);
            } else {
                return response([
                    'message' => 'No Event found'
                ], 400);
            }
        } else {
            $event = $events->where('state_id', 1)->get();

            return response([
                'message' => 'Event Detail',
                'list'    => $event
            ], 200);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/provider-list",
     *      operationId="providerList",
     *      tags={"service"},
     *      summary="",
     * @OA\Parameter(
     *          name="service_id",
     *          description="service id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="provider_name",
     *          description="provider name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="provider one"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function providerList(Request $request)
    {
        $validator = validator($request->all(), [
            'sevice_id' => 'integer',
        ]);

        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        if (!empty($request->service_id) && empty($request->provider_name)) {
            $getProviders = ProviderServices::where('service_id', $request->service_id)->with('serviceProvider')->get();

            if (!empty($getProviders)) {
                return response([
                    'message' => 'Provider List',
                    'list'  => $getProviders
                ], 200);
            } else {
                return response([
                    'message' => 'No Provider found'
                ], 400);
            }
        } else if (!empty($request->provider_name) && empty($request->service_id)) {
            $getProviders = User::where('name', 'like', '%' . $request->provider_name . '%')->where('role',User::ROLE_SERVICE_PROVIDER)->get();

            if (!empty($getProviders)) {
                return response([
                    'message' => 'Provider List',
                    'list'  => $getProviders
                ], 200);
            } else {
                return response([
                    'message' => 'No Provider found'
                ], 400);
            }
        } else if (!empty($request->provider_name) && !empty($request->service_id)) {
            $providerDatas = User::where('name', 'like', '%' . $request->provider_name . '%')->where('role',User::ROLE_SERVICE_PROVIDER)->get();

            $getProviderId = [];
            foreach ($providerDatas as $providerData) {
                $getProviderId[] = $providerData->id;
            }

            $getProviders = ProviderServices::where('service_id', $request->service_id)
                ->whereIn('service_provider_id', $getProviderId)
                ->with('serviceProvider')->get();

            if (!empty($getProviders)) {
                return response([
                    'message' => 'Provider List',
                    'list'  => $getProviders
                ], 200);
            } else {
                return response([
                    'message' => 'No Provider found'
                ], 400);
            }
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/service/provider-detail",
     *      operationId="providerDetail",
     *      tags={"service"},
     *      summary="",
     * @OA\Parameter(
     *          name="provider_id",
     *          description="provider id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Provider Detail",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="provider one"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */

    public function providerDetail(Request $request)
    {
        $validator = validator($request->all(), [
            'provider_id' => 'integer',
        ]);

        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        $serviceProviderDetail = User::where('id', $request->provider_id)->where('role',User::ROLE_SERVICE_PROVIDER)->first();

        if (!empty($serviceProviderDetail)) {
            return response([
                'message' => 'Provider Detail',
                'detail'  => $serviceProviderDetail
            ], 200);
        } else {
            return response([
                'message' => 'No Service Provider found'
            ], 400);
        }
    }

    
     /**
     * @OA\Post(
     *      path="/service/add-price",
     *      operationId="serviceAddPrice",
     *      tags={"service"},
     *      security={{ "sanctum": {} }},
     *      @OA\Parameter(
     *     name="id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *
     * 
     * 
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"service_id"},
     *              @OA\Property(property="service_id", type="integer", type="input", example="",description=""),
     *              @OA\Property(property="service_price", type="string", type="input", example="",description=""),
     *              @OA\Property(property="sub_service_id", type="integer", type="input", example="",description=""),
     *              @OA\Property(property="sub_service_price", type="string", type="input", example="",description="")
     * 
     *           ),
     *       ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Price Added",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *
     *     ),
     *   ),
     * )
     */


    public function addprice(Request $request)
    {
        if(!empty($request->service_id && $request->sub_service_id)){     
            $subservice=SubServicePriceList::where([['sub_service_id', '=' ,$request->sub_service_id],['created_by_id','=', Auth::User('user')->id]])->first();

            if(!empty($subservice)){
                $subservice->sub_service_price = $request->sub_service_price;
                if ($subservice->save()) {
                    return response([
                        'message' => 'Sub Service Price Updated Successfully',
                        'detail'  => $subservice
                    ], 200);
                } else {
                    return response([
                        'message' => 'Price not Added'
                    ], 400);
                }
                }
                else{
                    $subservice = new SubServicePriceList();
                    $subservice->service_id =  $request->service_id;
                    $subservice->sub_service_id =  $request->sub_service_id;
                    $subservice->sub_service_price = $request->sub_service_price;
                    $subservice->created_by_id = Auth::User('user')->id;
                    if ( $subservice->save()) {
                        return response([
                            'message' => 'Sub Service Price Added Successfully',
                            'detail'  => $subservice
                        ], 200);
                    } else {
                        return response([
                            'message' => 'Price not Added'
                        ], 400);
                    }
                }

            }
            else
            {
                $service=ServicePriceList::where([['service_id', '=' ,$request->service_id],['created_by_id','=', Auth::User('user')->id]])->first();
                if(!empty($service)){
                $service->service_price = $request->service_price;
                if ($service->save()) {
                    return response([
                        'message' => 'Service Price Updated Successfully',
                        'detail'  => $service
                    ], 200);
                } else {
                    return response([
                        'message' => 'Price not Added'
                    ], 400);
                }
                }
                
                else{
                $service = new ServicePriceList();
                $service->service_id = $request->service_id;
                $service->service_price = $request->service_price;
                $service->created_by_id = Auth::User('user')->id;
                if ( $service->save()) {
                    return response([
                        'message' => 'Service Price Added Successfully',
                        'detail'  => $service
                    ], 200);
                } else {
                    return response([
                        'message' => 'Price not Added'
                    ], 400);
                }
            }
       }
    }


     /**
     * @OA\Get(
     *      path="/service/nearby-providers",
     *      operationId="nearbyServiceProvider",
     *      tags={"service"},
     *      security={{ "sanctum": {} }},
     *      @OA\Parameter(
    *       name="lat",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *       type="string"
    *     )
    *   ),
    *      @OA\Parameter(
    *       name="long",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *       type="string"
    *     )
    *   ),
    *      @OA\Parameter(
    *       name="radius",
    *       in="query",
    *       required=false,
    *       @OA\Schema(
    *       type="string"
    *     )
    *   ),
    *
    * 
    * 
    *   @OA\Response(
    *     response=200,
    *     description="Provider Found Successfully",
    *     @OA\MediaType(
    *         mediaType="application/json",
    *
    *     ),
    *   ),
    * )
    */

    public function nearByProvider(Request $request)
    {
        $validator = validator($request->all(), [
            'lat' => 'string',
            'long' => 'string',
            'radius' => 'integer',
        ]);

        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        if($request->radius){
            $radius = $request->radius;
            $user =  User::getNearbyData($request->lat,$request->long ,$radius);
        }else
        {
            $radius = ServicePriceList::FIVE;
            $user =  User::getNearbyData($request->lat,$request->long ,$radius);
        }
        if(!empty($user))
        {
            $providerDetail = $user;
        }
        if (!empty($providerDetail)) {
                return response([
                    'message' => 'Provider Detail',
                    'detail'  => $providerDetail
                ], 200);
            } else {
                return response([
                    'message' => 'No Service Provider found'
                ], 400);
            }

        
    }
}
