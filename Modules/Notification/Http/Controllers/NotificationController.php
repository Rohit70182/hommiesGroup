<?php

namespace Modules\Notification\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Kawankoding\Fcm\Fcm;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Services\UserNotificationService;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $notify = Notification::get();
        return view('notification::index', compact('notify'));
    }

    /**
     * Show the form for sending a new resource.
     * @return Renderable
     */
    public function send()
    {
        $users = User::paginate(10);
        return view('notification::send', compact('users'));
    }

    /**
     * Latest Notification.
     * @param Request $request
     * @return Renderable
     */
    public function ajax(Request $request)
    {
        $notifications = Notification::where('to_user_id', Auth::user()->id)->where('has_notify', '==', Notification::NOT_READ)->get();
        foreach ($notifications as $notification) {
            $notification->has_notify = '1';
            $notification->save();
        }
        return $notifications;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $notification = Notification::where('id', $id)->first();
            if (!empty($notification)) {
                $notification->delete();
                return redirect('notifications')->with('success', 'Notification deleted successfully');
            } else {
                return redirect()->back()->with('Data not found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Send notification to specific user.
     * @param Request $request
     * @return Renderable
     */
    public function sendNotification(Request $request)
    {
        try {
            $user = User::where('id', $request->user_id)->first();
            if (!empty($user)) {

                $from_user_id = 0;
                $to_user_id = $request->user_id;
                $to_admin = 0;
                $title = $request->title;
                $body = $request->description;
                $model_type = 'App\Models\User';
                $model_id = $request->user_id;

                /** create notification for user **/

                $notification_service = new UserNotificationService();
                $notification = $notification_service->createNotification(
                    $from_user_id,
                    $to_user_id,
                    $to_admin,
                    $title,
                    $body,
                    $model_type,
                    $model_id
                );

                /** Send notification to user device **/
                /** If don't have firebase key the optional to use **/
                /** app notification start **/

                $message = array(
                    "model_id" => $model_id,
                    "model_type" => $model_type,
                    "action" => 'accept',
                    "title" => $title,
                    "body" => $body
                );

                $app_notification_service = new UserNotificationService();
                $app_notification = $app_notification_service->sendAppNotification(
                    $to_user_id,
                    $message,
                );


                /** app notification end **/


                return redirect()->back()->with('success',  'notification send successfully')->with('message', $app_notification);
            } else {
                return redirect()->back()->with('error',  'data not found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
