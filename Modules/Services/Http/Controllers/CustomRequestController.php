<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\CustomReq;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomReqFiles;

use Modules\Notification\Services\UserNotificationService;
use Modules\Notification\Entities\Notification;

class CustomRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    { 
        $custom = CustomReq::paginate(10); 
        return view('services::custom.index',compact('custom'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('services::custom.add');
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
            'desc' => 'required',
            'image' => 'required',
            
        ]);
        if($validator->fails()){
            return  Redirect::back()->withInput()->withErrors($validator);
        }
            $custom = new CustomReq();
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
            return redirect('/services/custom-req')->with('success', 'Custom Booking Created succesfully');        
           }
            
        else {
            return redirect('/services/custom-req')->with('error', 'Custom Booking not Created');
        }
    }
     /**
     * Apporve the Custom Service Request.
     * @param int $id
     * @return Renderable
     */
    public function updateStatus($id,$sid)
    {

        if(!empty($sid) && !empty($id)) 
        {
            $custom = CustomReq::where('id',$id)->first();
            
            $notification = new UserNotificationService();
            $body="Desc message here";
            
            if(!empty($custom)) 
            {
                
                if($sid == CustomReq::STATE_ACCEPTED) 
                {
                    $custom->state_id = CustomReq::STATE_ACCEPTED;
                    
                    $title ="Your custom request has been accepted.";
                    $notification->createNotification($custom->user_id, $title, $body , 0 , null, CustomReq::class, $custom->id);
                       
                } 
                else if($sid == CustomReq::STATE_REJECTED) 
                {
                    $custom->state_id = CustomReq::STATE_REJECTED;
                    
                    $title ="Your custom request has been rejected.";
                    $notification->createNotification($custom->user_id, $title, $body, 0 , null, CustomReq::class, $custom->id); 
                    
                } 
                else 
                {
                    return redirect('/services/custom-req')->with('error', 'This Process is not allowed');
                }
                
                if($custom->update())
                {
                    return redirect('/services/custom-req')->with('success', 'Custom booking updated succesfully');
                }
                else
                { 
                    return redirect('/services/custom-req')->with('error', 'Something went wrong');
                }
            } 
            else 
            {
                return redirect('/services/custom-req')->with('error', 'Something went wrong');
            }
        } 
        else 
        {
            return redirect('/services/custom-req')->with('error', 'Something went wrong');
        }
 
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $custom = CustomReq::where('id',$id)->first();
        
        $images = CustomReqFiles::where('custom_req_id',$id)->get();
        
        $reqImages = [];
        
        foreach($images as $image) {
            $reqImages[] = url('public/uploads/'.$image->image);
        }
        
        if($custom)
        {
            return view('services::custom.show',compact('custom','reqImages'));
        }
        else {
            return redirect('/services/custom-req')->with('error', 'Custom request not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $custom = CustomReq::where('id',$id)->first();
       
        return view('services::custom.edit',compact('custom'));
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

            $custom = CustomReq::where('id',$id)->first();
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
            return redirect('/services/custom-req')->with('success', 'Custom Booking Updated succesfully');        
           }
            
        else {
            return redirect('/services/custom-req')->with('error', 'Custom Booking not Updated');
        }
    
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $custom = CustomReq::Where('id',$id)->first();
        if(!empty($custom)){
            if($custom->delete()) {
                $files = CustomReqFiles::where('custom_req_id',$id)->delete();
            }
           return redirect('/services/custom-req')->with('success', 'Custom request deleted successfully');
        }
        else {
            return redirect('/services/custom-req')->with('error', 'Custom request not found');
        }
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = CustomReq::where('id', $id)->first();
            
            if($user->state_id == CustomReq::STATE_INACTIVE)
            {
                $user->state_id = CustomReq::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = CustomReq::STATE_INACTIVE;
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
