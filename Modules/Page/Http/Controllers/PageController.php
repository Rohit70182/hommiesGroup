<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $pages = Page::paginate(5);
        return view('page::index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        $page = new Page();
        $types = Page::getTypeOptions();
        return view('page::create', compact('page', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'title' => 'required',
            'editor1' => 'required',
            'type_id' => 'required|numeric|unique:pages,type_id',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    
        $is_exist = Page::where('type_id', $request->input('type_id'))->first();
   
        if (!empty($is_exist)) {
            return redirect('/page')->with('error', 'This page is already added');
        }
        $pages = new Page();
        $pages->title = $request->input('title');
        $pages->type_id = $request->input('type_id');
        $pages->description = $request->input('editor1');
        $pages->created_by_id = Auth::id();
     
        if ($pages->save()) {
            return redirect('/page')->with('success', 'Page saved succesfully');
        } else {
            return redirect('/page')->with('error', 'Page not save');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $page = Page::where('id', $id)->first();
     
        if (!empty($page)) {
            return view('page::show', compact('page'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $page = Page::where('id', $id)->first();
        $types = Page::getTypeOptions();
        if (!empty($page)) {
            return view('page::edit', [
                'page' => $page,
                'types' => $types
            ]);
        } else {
            abort(404);
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
        $validator = validator($request->all(), [
            'title' => 'required',
            'editor1' => 'required',
            'type_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $is_exist = Page::where('id', '!=', $id)->where('type_id', $request->input('type_id'))->first();
        if (!empty($is_exist)) {
            return redirect('/page')->with('success', 'Page already exist of this type');
        }
        $pages = Page::where('id', $id)->first();
        if (!empty($pages)) {
            $pages->title = $request->input('title');
            $pages->description = $request->input('editor1');
            $pages->type_id = $request->input('type_id');
            if ($pages->save()) {
                return redirect('/page')->with('success', 'Page updated');
            } else {
                return redirect('/page')->with('error', 'page not updated');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

    public function destroy(Request $request)
    {
        $page = Page::where('id', $request->id)->first();
        if (!empty($page)) {
            $page->delete();
        }
        return redirect('/page')->with('success', 'Page deleted successfully.');
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = Page::where('id', $id)->first();
            
            if($user->state_id == Page::STATE_INACTIVE)
            {
                $user->state_id = Page::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = Page::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with($e->getMessage());
        }
    }
    
    
}
