<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\AddOnService;
use Modules\Services\Entities\Service;

class AddOnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $add = AddOnService::get();
        return view('services::add-on.index',compact('add'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $services  = Service::where('state_id', Service::STATE_ACTIVE)->get();
        return view('services::add-on.form',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'service_id' => 'required',
            'price' => 'required|integer'
        ]);
        
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        
        $add = new AddOnService();
        $add->name       = $request->input('name');
        $add->desc       = $request->input('desc');
        $add->price      = $request->input('price');
        $add->service_id = $request->input('service_id');
        $add->state_id   = AddOnService::STATE_ACTIVE;
        
        if($add->save()){
            return redirect('services/add-on')->with('success', 'Add on Service saved successfully');
        } else {
            return redirect('services/add-on')->with('error', 'Add on Service not save');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function view($id)
    {
        $add = AddOnService::where('id',$id)->first();
        return view('services::add-on.view',compact('add') );
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $add = AddOnService::where('id',$id)->first();
        
        $services  = Service::where('state_id', Service::STATE_ACTIVE)->get();

        return view('services::add-on.edit',compact('add','services'));
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
            'service_id' => 'required',
            'price' => 'required|integer'
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        
        $category = AddOnService::where('id',$id)->first();
        $category->name       = $request->input('name');
        $category->desc       = $request->input('desc');
        $category->price      = $request->input('price');
        $category->service_id = $request->input('service_id');
        if($category->update()){
            return redirect('services/add-on')->with('success', 'Add on service updated successfully');
        } else {
            return redirect('services/add-on')->with('error', 'Add on service not updated');
            
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       $add = AddOnService::where('id',$id)->first();
        if(!empty($add))
        {
            $add->delete();
            
            return redirect('/services/add-on')->with('success', 'Add on Service deleted successfully');
        }
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = AddOnService::where('id', $id)->first();
            
            if($user->state_id == AddOnService::STATE_INACTIVE)
            {
                $user->state_id = AddOnService::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = AddOnService::STATE_INACTIVE;
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
