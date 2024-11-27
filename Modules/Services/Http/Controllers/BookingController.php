<?php

namespace Modules\Services\Http\Controllers;

use App\Jobs\SendOrderMail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\BookService\Entities\Booking;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\AddOnService;
use Modules\Smtp\Entities\EmailQueue;
use App\Models\User;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bookings = Booking::orderBy('id', 'desc')->get();
        return view('services::bookings.index', compact('bookings',));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        $service = Service::get();
        $addOn = AddOnService::get();
        return view('services::bookings.form', compact('service', 'addOn'));
    }
    public function get_category($id)
    {
        $data = Service::join('service_categories', 'service_categories.id', '=', 'services.category_id')
            ->get(['service_categories.name']);

        return response()->json($data);
    }
    public function get_subcategory($id)
    {
        $subdata = Service::join('sub_categories', 'services.subcategory_id', '=', 'sub_categories.id')
            ->get(['sub_categories.name']);

        return response()->json($subdata);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'service_id' => 'required',
            'date' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'address' => 'required',

        ]);
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $bookings = new Booking();
        $bookings->user_id = Auth::id();
        $bookings->service_id = $request->input('service_id');
        $bookings->addOn_id = $request->input('addOn_id');
        $bookings->date = $request->input('date');
        $bookings->time_start = $request->input('time_start');
        $bookings->time_end = $request->input('time_end');
        $bookings->address = $request->input('address');
        if ($bookings->save()) {
            //$bookings->sendBookingMailToUser();
            // $details['email'] = Auth::user()->email;
            // $details['subject'] = 'Your booking has been recorded.';
            // SendOrderMail::dispatch($details);
            return redirect('/services/booking-req/')->with('success', 'Booking saved succesfully');
        } else {
            return redirect('/services/booking-req/')->with('error', 'Booking not saved');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bookings = Booking::where('id', $id)->first();
        return view('services::bookings.view', compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $bookings = Booking::find($id);
        $service = Service::get();
        $addOn = AddOnService::get();
        return view('services::bookings.edit', compact('bookings', 'service', 'addOn'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $validator = validator($request->all(), [
            'service_id' => 'required',
            'date' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'address' => 'required',

        ]);
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $bookings = Booking::where('id', $id)->get();
        $bookings->service_id = $request->input('service_id');
        $bookings->addOn_id = $request->input('addOn_id');
        $bookings->date = $request->input('date');
        $bookings->time_start = $request->input('time_start');
        $bookings->time_end = $request->input('time_end');
        $bookings->address = $request->input('address');

        if ($bookings->update()) {

            return redirect('/services/booking-req')->with('success', 'Booking updated succesfully');
        } else {
            return redirect('/services/booking-req')->with('error', 'Booking not saved');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $bookings = $bookings = Booking::where('id', $id)->first();
        if (!empty($bookings)) 
        {
            $bookings->delete();
            return redirect('/services/booking-req')->with('success', 'Booking deleted sucessfully');
        }
    }
}
