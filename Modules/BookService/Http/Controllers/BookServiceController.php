<?php

namespace Modules\BookService\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\BookService\Entities\Booking;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\AddOnService;
use Modules\ServiceProvider\Entities\ServiceProvider;

use Modules\Notification\Services\UserNotificationService;
use Modules\Notification\Entities\Notification;

class BookServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bookings = Booking::query();

        $bookings = $bookings->orderBy('id','DESC')->paginate(10);
        

        return view('bookservice::index',compact('bookings'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bookings = Booking::where('id',$id)->first();
        $serviceProviders = ServiceProvider::orderBy('id','DESC')->get();
        return view('bookservice::view',compact('bookings','serviceProviders'));
    }
    
    /**
     * Assign the booking Provider
     * @return Renderable
     */
    public function assign(Request $request, $uid) 
    {
        $validator = validator($request->all(), [
            'service_provider' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $bookingId = $request->booking_id;
        $serviceProvider = $request->service_provider;
        
        $user_id = Auth::id();
        
//         if($bookings->type_id == Booking::TYPE_SERVICE)
//         {
//             $title ="Your service is booked";
//         }
//         elseif($bookings->type_id == Booking::TYPE_EVENT)
//         {
//             $title ="Your event is booked";
//         }
//         $body="Your booking is successfully booked";
        
        
//         $title ="Booking is assigned to you";
        $body="Booking Description here";      
        
        $bookingData = Booking::query();
        $bookingData = $bookingData->where('id',$bookingId)->first();
        $bookingData = $bookingData->update([
            'service_provider'=>$serviceProvider,
            'state_id'=>Booking::STATE_CONFIRMED
        ]);
        
        
        
        if($bookingData) 
        {
            $notification = new UserNotificationService();
            
            if($serviceProvider)
            {
                $title ="Service has been allotted to you";
                $notification->createNotification($serviceProvider, $title, $body, $user_id, null, Booking::class, $bookingId); 
            }
            if($uid)
            {
                $title ="Service provider has been allotted for you";
                $notification->createNotification($uid, $title, $body, $user_id, null, Booking::class, $bookingId); 
            }
//             $notification->createNotification($serviceProvider, $title, $body, $user_id, null, Booking::class, $bookingId);       
//             $notification->createNotification($uid, $title, $body, $user_id, null, Booking::class, $bookingId); 
            
            return redirect()->back()->with('success','Service Provider assigned successfully');
        }
        
    }
}
