<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BookService\Entities\Booking;
use Modules\ServiceProvider\Entities\BookServiceProvider;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\Services\Entities\CustomReq;
use App\Models\Event;

class EventsController extends Controller
{
    /**
     * @OA\Post(
     *      path="/event/event-add",
     *      operationId="addEvent",
     *      tags={"event"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *      
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"title","description","services","price"},
     *              @OA\Property(property="title", type="string", format="string", example="Marriage"),
     *              @OA\Property(property="description", type="string", format="string", example="Marriage"),
     *              @OA\Property(property="price", type="number", format="number", example="45"),
     *              @OA\Property(property="services", type="string", format="comma seperated", example="1,2"),
     *           ),
     *       ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Event Added Successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Not Found Error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    
    
    
    public function add(Request $request)
    {
        $validator = validator($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'services' => 'required'
            
        ]);
        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        $events = new Event();
        $events->user_id = Auth::id();
        $events->type_id = Booking::TYPE_EVENT;
        $events->title = $request->title;
        $events->description = $request->description;
        $events->price = $request->price;
        $events->services = $request->services;
        
        if ($events->save())
        {
            return response([
                'message' => 'Success, Your Event has been added',
                'detail'=>$events
            ], 200);
        }
        else
        {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    
    public function addOld(Request $request)
    {
        $validator = validator($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'time_start' => 'required|date_format:H:i',
            'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'lattitude' => 'required|numeric|gt:0',
            'longitude' => 'required|numeric|gt:0',
            'mobile' => 'required|numeric|digits:10',
            'promo_id' => 'nullable'
            
        ]);
        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        $events = new Booking();
        $events->user_id = Auth::id();
        $events->type_id = Booking::TYPE_EVENT;
        $events->state_id = Booking::STATE_ACTIVE;
        $events->date = $request->date.' '.$request->time_start;
        $events->time_start = $request->date.' '.$request->time_start;
        $events->address = $request->address;
        $events->latitude = $request->lattitude;
        $events->longitude = $request->longitude;
        $events->mobile = $request->mobile;
        $events->coupon_id = $request->promo_id;
        
        if ($events->save())
        {
            return response([
                'message' => 'Success, Your Event has been added',
                'detail'=>$events
            ], 200);
        }
        else
        {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    /**
     * @OA\Post(
     *      path="/event/event-update",
     *      operationId="updateEvent",
     *      tags={"event"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="event_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="date", type="string", format="date", example="2022-10-10"),
     *              @OA\Property(property="time_start", type="string", format="number", example="10:10"),
     *              @OA\Property(property="address", type="string", format="number", example="24 address"),
     *              @OA\Property(property="lattitude", type="string", format="number", example="124.34"),
     *              @OA\Property(property="longitude", type="string", format="number", example="124.34"),
     *              @OA\Property(property="mobile", type="string", format="number", example="9187678965"),
     *              @OA\Property(property="promo_id", type="string", format="number", example="promoCode"),
     *           ),
     *       ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Event Added Successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Event  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function update(Request $request)
    {
        if($events = Booking::find($request->event_id))
        {
            $validator = validator($request->all(), [
                'date' => 'nullable|date_format:Y-m-d',
                'time_start' => 'nullable|date_format:H:i',
                'address' => 'nullable|regex:/([- ,\/0-9a-zA-Z]+)/',
                'lattitude' => 'nullable|numeric|gt:0',
                'longitude' => 'nullable|numeric|gt:0',
                'mobile' => 'nullable|numeric|digits:10',
                'promo_id' => 'nullable'
                
            ]);
            if ($validator->fails()) {
                return response([
                    "status" => 422,
                    'message' => $validator->errors()
                ]);
            }
            $events->date = $request->date.' '.$request->time_start;
            $events->time_start = $request->date.' '.$request->time_start;
            $events->address = $request->address;
            $events->latitude = $request->lattitude;
            $events->longitude = $request->longitude;
            $events->mobile = $request->mobile;
            $events->coupon_id = $request->promo_id;
            
            if ($events->update())
            {
                return response([
                    'message' => 'Success, Your Event has been Updated',
                    'detail'=>$events
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'unexpected error occurred'
                ], 404);
            }
        }
        else 
        {
            return response([
                'message' => 'Event Id does not exist'
            ], 200);
        }
       
        
    }
    /**
     * @OA\Post(
     *      path="/event/event-delete",
     *      operationId="deleteEvent",
     *      tags={"event"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="event_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Event Deleted Successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Event Not Found"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function delete(Request $request)
    {
        if( $event = Booking::find($request->event_id))
        {
            if ($event->delete())
            {
                return response([
                    'message' => 'Success, Your Event has been Deleted',
                    'details' => $event
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'unexpected error occurred'
                ], 404);
            }
        }
        else
        {
            return response([
                'message' => 'Event Id does not exist'
            ], 200);
        }

    }
    
    
    
    
    
    
    
    
}