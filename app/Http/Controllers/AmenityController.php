<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::orderBy('id', 'desc')->get();
        return view('property.property-amanity.amenity', compact('amenities'));
    }

    public function show($id)
    {
        $amenity = Amenity::find($id);
        return view('property.property-amanity.show', compact('amenity'));
    }


    public function destroy($id)
    {
        $amanity = Amenity::where('id', $id);

        if (!empty($amanity)) {
            die('here');
            $amanity->delete();
        }

        return redirect('/dashboard/amenity')->with('success', 'Amenity deleted successfully.');
    }

    public function softDelete($id)
    {
        try {
            $amenity = Amenity::where('id', $id)->first();
            if ($amenity->state_id == Amenity::STATE_DELETED) {
                $amenity->state_id = Amenity::STATE_ACTIVE;
                $amenity->save();
                return redirect()->back();
            } else {
                $amenity->state_id = Amenity::STATE_DELETED;
                $amenity->save();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
