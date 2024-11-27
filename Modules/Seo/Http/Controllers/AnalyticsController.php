<?php

namespace Modules\Seo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Entities\Analytics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $analytics = Analytics::all();
        return view('seo::analytics.index', compact('analytics'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('seo::analytics.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'account' => 'required',
                'domain_name' => 'required',
                'type_id' => 'required',
            ]);
            if ($validator->fails())
            {
                return  Redirect::back()->withInput()->withErrors($validator);
            }
            
            if ($request->id) {
                $analytics = Analytics::where('id', $request->id)->first();
            } else {
                $analytics = new Analytics();
            }
            $analytics->account = $request->account;
            $analytics->domain_name = $request->domain_name;
            $analytics->type_id = $request->type_id;
            $analytics->created_by_id = Auth::user()->id;
            if ($analytics->save()) {
                return redirect('/seo/analytics')->with('success', 'Analytics has been saved succesfully');
            } else {
                return redirect()->back()->with('error', 'analytics could not be saved');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function view($id)
    {
        $analytics = Analytics::find($id);
        if (!empty($analytics)) {
            return view('seo::analytics.view', compact('analytics'));
        } else {
            return redirect()->back()->with('error', 'Data not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $analytics = Analytics::find($id);
        if (!empty($analytics)) {
            return view('seo::analytics.form', compact('analytics'));
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
        $analytics = Analytics::where('id', $id)->first();
        if (!empty($analytics)) {
            $analytics->delete();
            return redirect()->back()->with('success', 'Record deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Data not found');
        }
    }
}
