<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Faq\Entities\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('faq::index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $faq = new Faq();
        return view('faq::create', compact('faq'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $faq = new Faq();
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');

        if ($faq->save()) {
            return redirect('/faq')->with('success', 'Faq saved succesfully');
        } else {
            return redirect('/faq')->with('error', 'Faq not save');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $faq = Faq::where('id', $id)->first();
        if (!empty($faq)) {
            return view('faq::show', compact('faq'));
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
        $faq = Faq::where('id', $id)->first();
        if (!empty($faq)) {
            return view('faq::edit', [
                'faq' => $faq,
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
            'question' => 'required',
            'answer' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $faq = Faq::where('id', $id)->first();
        if (!empty($faq)) {
            $faq->question = $request->input('question');
            $faq->answer = $request->input('answer');

            if ($faq->save()) {
                return redirect('/faq')->with('success', 'Faq updated');
            } else {
                return redirect('/faq')->with('error', 'Faq not updated');
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
        $faq = Faq::where('id', $request->id)->first();
        if (!empty($faq)) {
            $faq->delete();
        }
        return redirect('/faq')->with('success', 'Faq deleted successfully.');
    }
}
