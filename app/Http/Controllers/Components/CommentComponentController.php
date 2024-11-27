<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use Modules\Comment\Entities\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class CommentComponentController extends Controller
{
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
                return redirect()->back();
            } else {
                return redirect()->back()->with('error', "Comment couldn't be saved");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
