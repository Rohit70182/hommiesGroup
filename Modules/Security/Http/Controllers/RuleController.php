<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Security\Entities\Rule;
use App\Models\User;


class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $rule = Rule::paginate(10);
        return view('security::rule.index', compact('rule'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $typeAttribute = Rule::getTypeAttribute();
        $stateAttribute = Rule::getStateAttribute();
        return view('security::rule.add', compact('stateAttribute', 'typeAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $rule = new Rule;
            $rule->ip = $request->input('ip');
            $rule->state_id = $request->state_id;
            $rule->user_id = $request->input('user_id');
            $rule->type_id = $request->input('type_id');
            if ($rule->save()) {
                return redirect('/security/rule/')->with('success', "Rule has been saved");
            } else {
                return redirect()->with('error', "Unexpected error occurred");
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
        if(!empty($rule = Rule::find($id)))
        {
        return view('security::rule.view', compact('rule'));
    }else{
        return redirect()->back()->with('error',"Data Couldn't be found");
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
        $rule = Rule::find($id);
        if(!empty($rule && ($user_data))) {
            return view('security::rule.edit', compact('rule', 'user_data'));
        } else {
            return redirect()->back()->with('error', "Data couldn't be found");
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
            $rule = Rule::find($id);
            $rule->ip = $request->input('ip');
            $rule->state_id = $request->input('state_id');
            $rule->type_id = $request->input('type_id');
            $rule->user_id = $request->input('user_id');
            $rule->update();
            if ($rule) {
                return redirect('/security/rule/')->with('success', "Rule updated");
            } else {
                return redirect('/security/rule/')->with('error', "couldn't be updated");
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
        if (!empty($rule = Rule::find($id))) {
            $rule->delete();
            return redirect('/security/rule/')->with('success', "Rule has been deleted");
        } else {
            return redirect('/security/rule')->with('error', "Data couldn't be found");
        }

    }
}
