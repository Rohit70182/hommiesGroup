<?php

namespace Modules\Rating\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Rating\Entities\Rating;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $ratings = Rating::paginate(5);
            return view('rating::index', compact('ratings'));
        } catch (Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('rating::create');
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
                'model_id' => 'required|numeric',
                'model_type' => 'required',
                'rating' => 'required',
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $is_exist = Rating::where('model_id', $request->input('model_id'))->where('model_type', $request->input('model_type'))->where('created_by_id', Auth::id())->first();
            if (!empty($is_exist)) {
                $rating = Rating::where('model_id', $request->input('model_id'))->where('model_type', $request->input('model_type'))->where('created_by_id', Auth::id())->first();
            } else {
                $rating = new Rating();
            }
            $rating->model_id = $request->input('model_id');
            $rating->model_type = $request->input('model_type');
            $rating->title = $request->input('title');
            $rating->rating = key(array_slice($request->rating, -1, 1, true));
            $rating->created_by_id = Auth::id();
            if ($rating->save()) {
                return redirect('/rating')->with('success', 'Rating saved succesfully');
            } else {
                return redirect('/rating')->with('error', 'Rating not save');
            }
        } catch (Exception $e) {
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
            $rating = Rating::where('id', $id)->first();
            if (!empty($rating)) {
                return view('rating::show', compact('rating'));
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
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
        return view('rating::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        try {
            $rating = Rating::where('id', $request->id)->first();
            if (! empty($rating)) {
                $rating->delete();
            }
            return redirect()->back()->with('success', 'Rating deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
