<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyHistory;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Modules\Chat\Entities\Chat;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('id', 'desc')->get();
        return view('property.property.property', compact('properties'));
    }

    public function show($id)
    {
        $property = Property::find($id);
        return view('property.property.show', compact('property'));
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
        $event = Property::where('id', $id);

        if (!empty($event)) {
            PropertyHistory::where('property_id', $id)->delete();
            PropertyImage::where('property_id', $id)->delete();
            PropertyAmenity::where('property_id', $id)->delete();
            // Chat::where('property_id', $id)->delete();
            $event->delete();
        }

        return redirect('/dashboard/property')->with('success', 'Property deleted successfully.');
    }

    public function softDelete($id)
    {
        try {
            $property = Property::where('id', $id)->first();
            if ($property->state_id == Property::STATE_SOLD) {
                return redirect()->back()->with('error', 'This property is sold and cannot be modified.');
            }
            if ($property->state_id == Property::STATE_DELETED) {
                $property->state_id = Property::STATE_PENDING;
                $property->save();
                return redirect()->back();
            } else {
                $property->state_id = Property::STATE_DELETED;
                $property->save();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
