<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\SubCategory;
use Modules\Services\Entities\Service;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
       
        $category = Category::orderBy('id', 'desc')->get();
        return view('services::category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('services::category.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|unique:service_categories,name',
            'desc' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $category = new Category();
        $name = $request->input('name');
        $category->name = $request->input('name');
        $category->desc =$request->input('desc');
        $category->state_id = Category::STATE_ACTIVE;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $category->image = $filename;
        }
        if($category->save()){
            return redirect('services/category')->with('success', 'Category saved succesfully');
        } else {
            return redirect('services/category')->with('error', 'Category not saved');
        }       
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $category = Category::where('id',$id)->first();
        return view('services::category.view',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('services::category.edit',compact('category'));
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
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $category = Category::where('id',$id)->first();
        $category->name = $request->input('name');
        $category->desc = $request->input('desc');
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $category->image = $filename;
        }
        if($category->update()){
            return redirect('services/category')->with('success', 'Category Updated Successfully');
        } else {
            return redirect('services/category')->with('error', 'Category not save');
        }

    }
    
    public function softDelete($id)
    {
        try
        {
            $user = Category::where('id', $id)->first();
            
            if($user->state_id == Category::STATE_INACTIVE)
            {
                $user->state_id = Category::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = Category::STATE_INACTIVE;
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $category = Category::where('id',$id)->first();
        $service = Service::where('category_id' , $id)->first();
        if(!empty($service))
        {
            return redirect('services/category')->with('error',"Category can't be deleted as it is being used in services");
            
        }
        else{
            
            $category->delete();
            $subCategory = SubCategory::where('category_id', $id)->delete();
            return redirect('services/category')->with('success', 'Category deleted successfully.');
        }
    }
    
    
    
    
}
