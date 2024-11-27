<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Comment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $comments = Comment::paginate(5);
        return view('comment::index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('comment::create');
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
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $comment = new Comment();
            $comment->model_id = $request->input('model_id');
            $comment->model_type = $request->input('model_type');
            $comment->title = $request->input('title');
            $comment->created_by_id = Auth::id();
            if ($comment->save()) {
                return redirect('/comment')->with('success', 'Comment saved succesfully');
            } else {
                return redirect('/comment')->with('error', 'Comment not save');
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
            $comment = Comment::where('id', $id)->first();
            if (!empty($comment)) {
                return view('comment::show', compact('comment'));
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
        return view('comment::edit');
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
    public function destroy($id)
    {
        try {
            $comment = Comment::where('id', $id)->first();
            if (!empty($comment)) {

                $comment->delete();
            }
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
