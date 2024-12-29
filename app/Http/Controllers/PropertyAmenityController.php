<?php

namespace App\Http\Controllers;

use App\Models\PropertyAmenity;
use Illuminate\Http\Request;

class PropertyAmenityController extends Controller
{
    public function index()
    {
        $propertyAmenities = PropertyAmenity::all();
        return response()->json($propertyAmenities);
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer',
            'amenities_id' => 'required|integer',
            'state_id' => 'nullable|integer',
            'created_by_id' => 'nullable|integer',
        ]);

        $propertyAmenity = PropertyAmenity::create($request->all());
        return response()->json($propertyAmenity, 201);
    }

    public function show($id)
    {
        $propertyAmenity = PropertyAmenity::findOrFail($id);
        return response()->json($propertyAmenity);
    }

    public function edit($id) {}

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required|integer',
            'amenities_id' => 'required|integer',
            'state_id' => 'nullable|integer',
            'created_by_id' => 'nullable|integer',
        ]);

        $propertyAmenity = PropertyAmenity::findOrFail($id);
        $propertyAmenity->update($request->all());
        return response()->json($propertyAmenity);
    }

    public function destroy($id)
    {
        $propertyAmenity = PropertyAmenity::findOrFail($id);
        $propertyAmenity->delete();
        return response()->json(null, 204);
    }
}
