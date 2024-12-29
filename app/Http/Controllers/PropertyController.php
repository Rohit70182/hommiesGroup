<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyController extends Controller
{

    // to be fixed..
    
    public function index()
    {
        $event = Event::orderBy('id', 'desc')->get();
        $services = Service::get();
        return view('event.index', compact('event', 'services'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'title' => 'required',
            'service_id' => 'required',
            'price' => 'required',
            'desc' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $event = new Event();
        $event->title = $request->input('title');
        $event->price = $request->input('price');
        $event->desc = $request->input('desc');
        $event->state_id = Event::STATE_ACTIVE;
        $event->services = implode(',', $request->service_id);
        if ($event->save()) {
            return redirect('/event/list')->with('success', "Event created successfully");
        } else {
            return redirect()->back()->with('error', "Error Occurred, Event couldn't be created");
        }
    }

    public function show($id)

    {
        $events = Event::find($id);
        return view('event.show', compact('events'));
    }
    public function edit($id)
    {
        $services = Service::where('state_id', Service::STATE_ACTIVE)->get();
        $events = Event::find($id);
        return view('event.edit', compact('events', 'services'));
    }

    public function create()
    {
        $services = Service::where('state_id', Service::STATE_ACTIVE)->get();
        return view('event.add', compact('services'));
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'title' => 'required',
            'service_id' => 'required',
            'price' => 'required',
            'desc' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $event = Event::find($id);
        $event->title = $request->input('title');
        $event->price = $request->input('price');
        $event->desc = $request->input('desc');
        $event->services = implode(',', $request->service_id);

        if ($event->update()) {
            return redirect('/event/list')->with('success', "Event updated successfully");
        } else {
            return redirect()->back()->with('error', "Error Occurred, Event couldn't be updated.");
        }
    }

    public function destroy($id)
    {
        $event = Event::where('id', $id);

        if (!empty($event)) {
            $event->delete();
        }
        return redirect('/event/list')->with('success', 'Event deleted successfully.');
    }

    public function softDelete($id)
    {

        try {
            $user = Event::where('id', $id)->first();

            if ($user->state_id == Event::STATE_INACTIVE) {
                $user->state_id = Event::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            } else {
                $user->state_id = Event::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
