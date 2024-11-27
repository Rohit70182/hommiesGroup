<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogActivity;
use App\Models\User;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Crypt;


class RegisterController extends Controller
{

    /**
     * Register View.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        } else {
            $user = new User();
            $types = User::getRoleOptions();
            return view('auth.register', compact('user', 'types'));
        }
    }

    /**
     * Register new user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function signup(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:20',
                'last_name' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])/',
   
                ],
            ]);

            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->name = $request->input('first_name') . ' ' . $request->input('last_name');
            $user->email = $request->input('email');
            $user->role = User::ROLE_USER;
            $user->password = Hash::make($request->password);

            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('public/uploads/', $filename);
                $user->image = $filename;
            }
            if ($user->save()) {
                //$user->sendMailToAdmin();
                /*
             * if($user->email && $user->id !=null){
             * $email=$request->input('email');
             * $data = (
             * ['name','email',
             *
             * ]);
             * Mail::to($email)->send(new successmail($data));
             * }
             */

                if ($user->id != null) {
                    Notification::create([
                        'title' => $user->name . ' Added',
                        'description' => 'A new User has been added',
                        'model_id' => $user->id,
                        'model_type' => 'User',
                        'to_user_id' => User::ROLE_ADMIN,
                        'created_by_id' => $user->id
                    ]);

                    if ($user) {
                        return redirect('/login')->with('message', "Success! Registration completed ,You can login now");
                    } else {
                        return back()->with('error', "There's an issue that has occurred, please try again");
                    }
                }
            }
        } catch (Exception $e) {
            LogActivity::addToLog($e->getMessage());
            return redirect()->back();
        }
    }

    public function verifyEmail($email){
        try {
            $verify_code = Crypt::decryptString($email);
            $user = User::where('email', $verify_code)->first();
            if(empty($user)){
                $message = 'Some Thing Went Wrong';
            }
            $user->is_verified = User::IS_VERIFIED;
            if($user->save()){
                $message = 'Thanks For Verification';
            }
            return view('verified', compact('message'));
        } catch (Exception $e) {
            $message = 'Some Thing Went Wrong';
            return view('verified', compact('message'));
        }
    }
}
