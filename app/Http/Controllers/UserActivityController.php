<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LogActivity;
use App\Models\User;

class UserActivityController extends Controller
{
    //user activity
    public function useractivity()
    {
        return view('dashboard.activity.useractivity');
    }

    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('dashboard.activity.logActivity',compact('logs'));
    }
    public function deleteAll()
    {
            $delete=LogActivity::truncate();
            return redirect()->back()->with('No Logs Found');   
    }
    //user table delete query
    public function delete($id)
    {
        $delete=LogActivity::where('id',$id)->first();
            if(!empty($delete))
            {
                $delete->delete();
                return redirect()->back()->with('success', 'Log deleted successfully.');
            } 
            else 
            {
                return redirect()->back()->with('No Logs Found');
            }   
     return redirect()->back()->with('success', 'Log deleted successfully.');
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = LogActivity::where('id', $id)->first();
            
            if($user->state_id == User::STATE_INACTIVE)
            {
                $user->state_id = User::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = User::STATE_INACTIVE;
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
    

    //Total count of user activity
    public function users() 
    {
        $count = User::where('role', '!=', User::ROLE_ADMIN)->orderBy('id', 'DESC')->get();
        return view('dashboard.user-management.users', compact('count'));
    }
    
    public function show($id)
    {
        $logs = LogActivity::where('id', $id)->first();
        return view('dashboard.activity.logShow', compact('logs'));
    }
    
    
    
}