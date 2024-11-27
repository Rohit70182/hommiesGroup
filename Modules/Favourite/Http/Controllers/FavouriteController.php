<?php

namespace Modules\Favourite\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Favourite\Entities\Item;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Modules\ServiceProvider\Entities\ServiceProvider;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $items = Item::paginate(5);
        return view('favourite::index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $item = new Item();
        $types = Item::getTypeOptions();
        return view('favourite::create', compact('item', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $id)
    {
        try {
            $validator = validator($request->all(), [
                'model_id' => 'required|numeric',
                'model_type' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $is_exist = Item::where('model_id', $request->input('model_id'))->where('model_type', $request->input('model_type'))->first();
            if (!empty($is_exist)) {
                return redirect('/favourite')->with('error', 'This item is already added');
            }
            $item = new Item();
            $item->model_id = $request->input('model_id');
            $item->model_type = $request->input('model_type');
            $item->created_by_id = Auth::id();
            if ($item->save()) {
                return redirect('/favourite')->with('success', 'Item saved succesfully');
            } else {
                return redirect('/favourite')->with('error', 'Item not save');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            $item = Item::where('id', $id)->first();
            if (!empty($item)) {
                return view('favourite::show', compact('item'));
            } else {
                return abort(404);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $item = Item::where('id', $id)->first();
            $types = Item::getTypeOptions();
            if (!empty($item)) {
                return view('favourite::edit', [
                    'page' => $item,
                    'types' => $types
                ]);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
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
            $validator = validator($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'type_id' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $is_exist = Item::where('id', '!=', $id)->where('model_id', $request->input('model_id'))->where('model_type', $request->input('model_type'))->first();
            if (!empty($is_exist)) {
                return redirect('/favourite')->with('success', 'Item already exist');
            }
            $pages = Item::where('id', $id)->first();
            if (!empty($pages)) {

                $pages->model_id = $request->input('model_id');
                if ($pages->save()) {
                    return redirect('/favourite')->with('success', 'Item updated');
                } else {
                    return redirect('/favourite')->with('error', 'Item not updated');
                }
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
    public function destroy(Request $request)
    {
        try {
            $item = Item::where('id', $request->id)->first();
            if (!empty($item)) {
                $item->delete();
            }
            return redirect()->back()->with('success', 'Item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
