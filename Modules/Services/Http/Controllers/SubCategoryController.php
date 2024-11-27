<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\SubCategory;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\Service;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subcate = SubCategory::orderBy('id', 'desc')->get();
        return view('services::sub-category.index',compact('subcate'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $category = Category::where('state_id', Category::STATE_ACTIVE)->get();
        return view('services::sub-category.form',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|unique:sub_categories,name',
            'desc' => 'required',
            'category_id' => 'required|integer',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $subcate = new SubCategory();
       
        $name = $request->input('name');
        $n= SubCategory:: where('name',$name)->get();
        $count = $n->count();
        if($count == 0)
        {
            $subcate->name = $request->input('name');
            $subcate->desc =$request->input('desc');
            $subcate->state_id = SubCategory::STATE_ACTIVE;
            $subcate->category_id = $request->input('category_id');
            
            if ($request->hasfile('image')) 
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('public/uploads', $filename);
                $subcate->image = $filename;
            }
        if($subcate->save())
        {
            return redirect('services/sub-category')->with('success', 'Sub-Category saved succesfully');
        }
         else 
         {
            return redirect('services/sub-category')->with('error', 'Sub-Category not save');
        }
       }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $subcategory = SubCategory::where('id',$id)->first();
        $category = Category::get();
        return view('services::sub-category.view',compact('subcategory','category'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $subcategory = SubCategory::where('id',$id)->first();
        $category = Category::where('state_id', Category::STATE_ACTIVE)->get();
        return view('services::sub-category.edit',compact('subcategory','category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $subcate = SubCategory::where('id', $id)->first();
        $validator = validator($request->all(), [
            'name' => 'required|unique:sub_categories,name,'.$id,
            'desc' => 'required',
            'category_id' => 'required|integer',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $subcate =  SubCategory::where('id',$id)->first();
        $subcate->name = $request->input('name');
        $subcate->desc =$request->input('desc');
        $subcate->category_id = $request->input('category_id');
        if ($request->hasfile('image')) 
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $subcate->image = $filename;
        }

        if($subcate->update()){
            return redirect('services/sub-category')->with('success', 'Sub-Category update succesfully');
        } else {
            return redirect('services/sub-category')->with('error', 'Sub-Category not save');
        }   
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $subcate = SubCategory::where('id',$id)->first();
        $service = Service::where('subcategory_id',$id)->first();
        if(!empty($service)){
            return redirect('services/sub-category')->with('error',"Sub-Category can't be deleted as it is being used in services");
        }
        if(empty($service)){
            $subcate->delete();
            return redirect('services/sub-category')->with('success','Sub-Category Successfully deleted');
        }
    }
    
    
    
    public function softDelete($id)
    {
        try
        {
            $user = SubCategory::where('id', $id)->first();
            
            if($user->state_id == SubCategory::STATE_INACTIVE)
            {
                $user->state_id = SubCategory::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = SubCategory::STATE_INACTIVE;
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
