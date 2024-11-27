<?php

namespace Modules\Stripe\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Stripe\Entities\StripeSetting;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $settings = StripeSetting::select('*')->get();
        return view('stripe::settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('stripe::settings.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules['publishable_key'] = "required";
        $rules['secret_key'] = "required";
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->id) {
                $settings = StripeSetting::where('id', $request->id)->first();
            } else {
                $settings = new StripeSetting();
            }
            $settings->publishable_key = $request->publishable_key;
            $settings->secret_key = $request->secret_key;
            $settings->created_by_id = Auth::user()->id;
            try {
                if ($settings->save()) {
                    return redirect('/stripe/settings/')->with('success', 'Data Saved Successfully');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function view($id)
    {
        $settings = StripeSetting::find($id);
        return view('stripe::settings.view', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $settings = StripeSetting::find($id);
        if ($settings) {
            return view('stripe::settings.form', compact('settings'));
        } else {
            return redirect()->back()->with('error', 'Data not found');
        }
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $settings = StripeSetting::where('id', $id)->first();
        if (!empty($settings)) {
            $settings->delete();
            return redirect()->back()->with('success', 'Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Data not found');
        }
    }
}
