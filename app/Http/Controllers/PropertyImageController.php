<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    public function index()
    {
        $propertyImages = PropertyImage::all();
        return response()->json($propertyImages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'image_path' => 'required|string',
        ]);

        $propertyImage = PropertyImage::create($request->all());
        return response()->json($propertyImage, 201);
    }

    public function show($id)
    {
        $propertyImage = PropertyImage::findOrFail($id);
        return response()->json($propertyImage);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'sometimes|exists:properties,id',
            'image_path' => 'sometimes|string',
        ]);

        $propertyImage = PropertyImage::findOrFail($id);
        $propertyImage->update($request->all());
        return response()->json($propertyImage);
    }

    public function destroy($id)
    {
        $propertyImage = PropertyImage::findOrFail($id);
        $propertyImage->delete();
        return response()->json(null, 204);
    }
}
