<?php

namespace Modules\Seo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Entities\Redirect;
use Illuminate\Support\Facades\Auth;


class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $redirect = Redirect::all();
        return view('seo::redirect.index', compact('redirect'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('seo::redirect.form');
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
                'old_url' => 'required',
                'new_url' => 'required',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            
            if ($request->id) {
                $redirect = Redirect::where('id', $request->id)->first();
            } else {
                $redirect = new Redirect();
            }
            $redirect->old_url = $request->old_url;
            $redirect->new_url = $request->new_url;
            $redirect->created_by_id = Auth::user()->id;
            if ($redirect->save()) {
                return redirect('/seo/redirect')->with('success', 'Record has been saved succesfully');
            } else {
                return redirect()->back()->with('error', 'Record could not be saved');
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
        $redirect = Redirect::find($id);
        if (!empty($redirect)) {
            return view('seo::redirect.view', compact('redirect'));
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
        $redirect = Redirect::find($id);
        if (!empty($redirect)) {
            return view('seo::redirect.form', compact('redirect'));
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
        $redirect = Redirect::where('id', $id)->first();
        if (!empty($redirect)) {
            $redirect->delete();
            return redirect()->back()->with('success', 'Record deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Data not found');
        }
    }
}
