<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LogActivity;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\CancelReason;
use App\Models\OrderDetail;

class DashboardController extends Controller
{
    /**
     * dashboard page.
     *
     */
    public function dashboard()
    {
        $users = User::select(DB::raw("COUNT(*) as count"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = User::select(DB::raw("month(created_at) as month"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');
        $data = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $data[$month] = $users[$index];
        }
        $userdata = (array_slice($data, 1));

        return view('dashboard.dashboard', compact('userdata'));
    }

    public function changePassword(Request $request)
    {
        $user = Auth::User();

        $validator = validator($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->password == $request->password_confirmation) {
            $user->password = Hash::make($request['password']);

            if ($user->save()) {
                Auth::logout();
                return redirect('/login');
            } else {
                return redirect()->back()->with('error', "Password Couldn't be Updated.");
            }
        } else {
            return redirect()->back()->with('error', "Password and confirmation do not match.");
        }
    }


    //Logout
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }


    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();

        return view('dashboard.activity.logActivity', compact('logs'));
    }


    //Files section
    public function Showfiles()
    {
        return view('dashboard.files.files');
    }
    //fetch Notification
    public function Notification()
    {
        $notify = Notification::all();
        return view('dashboard.notification.notifications', compact('notify'));
    }

    //Delete notification
    public function deletenotification($id)
    {
        try {
            $notification = Notification::where('id', $id)->first();
            if (!empty($notification)) {
                $notification->delete();
                return redirect('notifications');
            } else {
                return redirect()->back()->with('data not found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }


    // cancel reasons crud

    // index of cancel reasons

    public function createcancelReasons()
    {

        return view('dashboard.cancel-reasons.create');
    }

    public function storecancelReasons(Request $request)
    {
        $validator = validator($request->all(), [
            'reason' => 'required',
        ]);
        if ($validator->fails()) {

            return Redirect()->back()->withInput()->withErrors($validator);
        }
        $savereason = new CancelReason();
        $savereason->messages = $request->reason;
        if ($savereason->save()) {
            return redirect()->route('cancelReasons')->with('success', 'Reason Added Successfully');
        }
    }

    public function cancelReasons()
    {
        $cancelReasons = CancelReason::all();

        return view('dashboard.cancel-reasons.index', compact('cancelReasons'));
    }

    public function showcancelReasons($id)
    {

        $cancelreasons = CancelReason::find($id);
        return view('dashboard.cancel-reasons.show', compact('cancelreasons'));
    }

    public function editcancelReasons($id)
    {

        $cancelreasons = CancelReason::find($id);
        return view('dashboard.cancel-reasons.edit', compact('cancelreasons'));
    }

    public function updatecancelReasons(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'reason' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect()->back()->withInput()->withErrors($validator);
        }
        $cancelreasons =  CancelReason::where('id', $id)->update(['messages' => $request->reason]);

        return redirect()->route('cancelReasons')->with('success', 'Reason Updated Successfully');
    }

    public function deletecancelReasons($id)
    {

        $reasonfordelete = CancelReason::find($id);

        $reasonfordelete->delete();
        return redirect()->back()->with('success', 'Reason Deleted Successfully');
    }

    // index of orders 

    public function orders()
    {

        $orders = OrderDetail::all();
        return view('dashboard.orders.index', compact('orders'));
    }

    public  function showOrders($id)
    {

        $order = OrderDetail::Where('id', $id)->first();

        return view('dashboard.orders.view', compact('order'));
    }
}
