<?php

namespace Modules\BookService\Http\Controllers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\BookService\Entities\ScheduleService;
use Modules\Services\Entities\Service;
use  Modules\ServiceProvider\Entities\ServiceProvider;

class ScheduleServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         $schedule = ScheduleService::where('user_id',Auth::id())->paginate(10);
        return view('bookservice::schedule.index',compact('schedule'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $service = Service::where('state_id',Service::STATE_ENABLE)->get();
        $provider = ServiceProvider::get();
        return view('bookservice::schedule.form',compact('service','provider'));
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
            'provider_id' => 'required',
            'date' => 'required',
            'time_start' => 'required',
            'time_end' =>'required',
            'address' => 'required',

        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
            $schedule = new ScheduleService();
            $schedule->user_id = Auth::id();
            $schedule->service_id = $request->input('service_id');
            $schedule->provider_id =$request->input('provider_id');
            $schedule->date = $request->input('date');
            $schedule->start_time =$request->input('time_start');
            $schedule->end_time =$request->input('time_end');
            $schedule->address =$request->input('address');
           if($schedule->save()){
            return redirect('/booking/schedule')->with('success', 'Schedule saved succesfully');        
           }
            
        else {
            return redirect('/booking/schedule')->with('error', 'Schedule not saved');
        }
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $schedule = ScheduleService::where('id',$id)->first();
        return view('bookservice::schedule.show',compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $schedule =ScheduleService::where('id',$id)->first();
        return view('bookservice::schedule.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {    
        $validator = validator($request->all(),[
            'service_id' => 'required',
            'provider_id' => 'requird',
            'date' => 'require',
            'address' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $schedule = ScheduleService::where('id',$id)->first();
        $schedule->service_id = $request->input('service_id');
        $schedule->provider_id = $request->input('provider_id');
        $schedule->date = $request->input('date');
        $schedule->start_time =$request->input('start_time');
        $schedule->end_time = $request->input('end_time');
        $schedule->address =$request->input('address');

        if($schedule->update()){
            
            return view('/booking/schedule/')->with('success','Service has been Scheduled successfully');
        }
        else
        {
            return view('/booking/schedule/')->with('error','Service not Scheduled');
        }
    
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        
    }
}
