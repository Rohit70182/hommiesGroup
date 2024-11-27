<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Security\Entities\Blacklist;

class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $blacklist = Blacklist::paginate(10);
        return view('security::blacklist.index', compact('blacklist'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $typeAttribute = Blacklist::getTypeAttribute();
        $stateAttribute = Blacklist::getStateAttribute();
        return view('security::blacklist.add', compact('stateAttribute', 'typeAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $blacklist = new Blacklist();
            $blacklist->ip = $request->input('ip');
            $blacklist->state_id = $request->input('state_id');
            $blacklist->reason = $request->input('reason');
            $blacklist->type_id = $request->input('type_id');
            if ($blacklist->save()) {
                return redirect('security/blacklist')->with('success', "List has been saved successfully");
            } else {
                return redirect()->back()->with('error', "Unexpected error occurred");
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
    public function show($id)
    {
        if (!empty($blacklist = Blacklist::find($id))) {
            return view('security::blacklist.view', compact('blacklist'));
        } else {
            return redirect()->back()->with('error', "Data Couldn't be found");
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (!empty($blacklist = Blacklist::find($id))) {
            return view('security::blacklist.edit', compact('blacklist'));
        } else {
            return redirect()->back()->with('error', "Data Couldn't be found");
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            $blacklist = Blacklist::find($id);
            $blacklist->ip = $request->input('ip');
            $blacklist->state_id = $request->input('state_id');
            $blacklist->reason = $request->input('reason');
            $blacklist->type_id = $request->input('type_id');
            $blacklist->update();
            if ($blacklist) {
                return redirect('/security/blacklist/')->with('success', "Data updated");
            } else {
                return redirect('/security/blacklist/')->with('error', "couldn't be updated");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (!empty($blacklist = Blacklist::find($id))) {
            $blacklist->delete();
            return redirect('/security/blacklist/')->with('success', "Data has been deleted");
        } else {
            return redirect('/security/blacklist')->with('error', "Data couldn't be found");
        }
    }
}
