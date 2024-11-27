<?php

namespace Modules\BookService\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\BookService\Entities\Custom;
use Illuminate\Support\Facades\Auth;

class CustomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {    
        $custom = Custom::where('user_id',Auth::id())->paginate(10);
        return view('bookservice::custombooking.index',compact('custom'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        
        return view('bookservice::custombooking.add');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:20',
            'desc' => 'required',
            'image' => 'required',
            
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
            $custom = new Custom();
            $custom->name = $request->input('name');
            $custom->desc =$request->input('desc');
            $custom->user_id = Auth::id();
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('public/uploads', $filename);
                $custom->image = $filename;
            }
         
           if($custom->save()){
            return redirect('/booking/custom')->with('success', 'Custom Booking Created succesfully');        
           }
            
        else {
            return redirect('/booking/custom')->with('error', 'Custom Booking not Created');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $custom = Custom::where('id',$id)->first();
        return view('bookservice::custombooking.show',compact('custom'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $custom = Custom::where('id',$id)->first();
        return view('bookservice::custombooking.edit',compact('custom'));
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
            'name' => 'required',
            'desc' => 'required',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
            $custom = Custom::where('id',$id)->first();
            $custom->name = $request->input('name');
            $custom->desc =$request->input('desc');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('public/uploads', $filename);
                $custom->image = $filename;
            }
         
           if($custom->update()){
            return redirect('/booking/custom')->with('success', 'Custom Booking Updated succesfully');        
           }
            
        else {
            return redirect('/booking/custom')->with('error', 'Custom Booking not Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $custom = Custom::where('id',$id)->first();
        if(!empty($custom))
        {
            $custom->delete();
            return redirect()->back()->with('success','Custom service deleted successfully');
        }

    }
}
