<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Security\Entities\Blacklist;
use Modules\Security\Entities\Whitelist;
use App\Models\User;


class WhitelistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $whitelist = Whitelist::paginate(10);
        return view('security::whitelist.index', compact('whitelist'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $typeAttribute = Whitelist::getTypeAttribute();
        $stateAttribute = Whitelist::getStateAttribute();
        return view('security::whitelist.add', compact('typeAttribute', 'stateAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $whitelist = new Whitelist();
            $whitelist->ip = $request->input('ip');
            $whitelist->user_id = $request->input('user_id');
            $whitelist->state_id = $request->input('state_id');
            $whitelist->type_id = $request->input('type_id');
            if ($whitelist->save()) {
                return redirect('security/whitelist')->with('success', "List has been added successfully");
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
        if (!empty($whitelist = Whitelist::find($id))) {
            return view('security::whitelist.view', compact('whitelist'));
        } else {
            return redirect()->back()->with('error', "Data couldn't be found");
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user_data = User::orderBy('id','DESC')->get();
        $whitelist = Whitelist::find($id);
        if (!empty($whitelist && ($user_data))) {
            return view('security::whitelist.edit', compact('whitelist', 'user_data'));
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
            $whitelist = Whitelist::find($id);
            $whitelist->ip = $request->input('ip');
            $whitelist->state_id = $request->state_id;
            $whitelist->type_id = $request->input('type_id');
            $whitelist->user_id = $request->input('user_id');
            $whitelist->update();
            if ($whitelist) {
                return redirect('/security/whitelist')->with('success', "List updated");
            } else {
                return redirect('/security/whitelist')->with('error', "couldn't be updated");
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
        if (!empty($whitelist = Whitelist::find($id))) {
            $whitelist->delete();
            return redirect('/security/whitelist/')->with('success', "Data has been deleted");
        } else {
            return redirect('/security/whitelist')->with('error', "Data couldn't be found");
        }
    }
}
