<?php

namespace Modules\Notification\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Entities\UserDeviceToken;
use App\Models\User;
use Carbon\Carbon;
use Kawankoding\Fcm\Fcm;
use App\Models\DeviceDetail;

class UserNotificationService
{
    /**
     * This function will create new notification in database.
     * 
     */
    public function createNotification(
        $to_user_id,
        $title,
        $body,
        $to_admin = 0,
        $from_user_id = 0,
        $model_type,
        $model_id 
    )
    
    {
        $create = new Notification();
        $create->from_user_id = Auth::user()->id;
        $create->to_user_id = $to_user_id;
        $create->to_admin = $to_admin;
        $create->title = $title;
        $create->description = $body;
        $create->model_type = $model_type;
        $create->model_id = $model_id;
        $create->created_by_id = Auth::user()->id;
        if ($create->save()) {
            return $create;
        } else {
            return null;
        }
    }

    /**
     * This function will send FCM notification to user device.
     * 
     */
    public function sendAppNotification(
        $to_user_id,
        $message
    ) {

        /** get device token **/

        $data = DeviceDetail::where('created_by_id', $to_user_id)->first();
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
        if (!empty($data)) {

            $notifyData = $message;

            // Creating the notification array.
            $notification = array(
                'title' => $message['title'],
                'body' => $message['body'],
                'sound' => 'default',
                'badge' => '1'
            );
            $arrayToSend = array(
                'to' => $data->device_token,
                'data' => $notifyData,
                'notification' => $notification,
                'priority' => 'high',
                'sound' => 'default',
                'mutable_content' => true,
                'category' => "ImagePush"
            );

            $dataString = json_encode($arrayToSend);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];



            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            curl_close($ch);

            //return message
            if (json_decode($response)->success) {
                $response = 'app notification send successfully';
            }

            // return error
            if ($response === FALSE) {
                return redirect()->back()->with('error', curl_error($ch));
            }


            return $response;
        }

        return null;
    }
}
