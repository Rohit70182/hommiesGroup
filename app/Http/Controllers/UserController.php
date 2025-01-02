<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function users()
    {
        $count = User::where('role', '=', User::ROLE_USER)->paginate(8);
        return view('dashboard.user-management.users', compact('count'));
    }

    public function serviceProviders()
    {
        $count = User::where('role', '=', User::ROLE_SERVICE_PROVIDER)->paginate(8);
        return view('dashboard.service-provider.users', compact('count'));
    }

    public function show($id)
    {
        $show = User::where('id', $id)->first();

        return view('dashboard.user-management.show', compact('show'));
    }

    public function serviceShow($id)
    {
        $show = User::where('id', $id)->first();

        return view('dashboard.service-provider.show', compact('show'));
    }

    /*
     * Delete
     */
    public function delete($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (! empty($user)) {
                $user->delete();
                return redirect('/dashboard/users')->with('success', 'User deleted successfully.');
            } else {
                return redirect()->back()->with('error', "Account not found");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    public function serviceDelete($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (! empty($user)) {
                $user->delete();
                return redirect('/dashboard/service')->with('success', 'Service Provider deleted successfully.');
            } else {
                return redirect()->back()->with('error', "Account not found");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    public function softDelete($id)
    {
        try {
            $user = User::where('id', $id)->first();

            if ($user->state_id == User::STATE_INACTIVE) {
                $user->state_id = User::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
            } else {
                $user->state_id = User::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    // Service provider soft delete 
    public function serviceSoftDelete($id)
    {
        try {
            $user = User::where('id', $id)->first();

            if ($user->state_id == User::STATE_INACTIVE) {
                $user->state_id = User::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
            } else {
                $user->state_id = User::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    /*
     * Store Data
     */
    public function addUser(Request $req)
    {
        $validator = validator($req->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'role' => 'required|integer',
            'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->role = $req->input('role');
        $user->password = Hash::make($req->password);

        if ($req->hasfile('image')) {
            $file = $req->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $user->image = $filename;
        }

        if ($user->save()) {
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
                    return redirect('/dashboard/users')->with('success', "Account Saved successfully");
                } else {
                    return redirect()->back()->with('error', "Something went wrong");
                }
            }
        } else {

            return redirect()->back()->with('error', "Something went wrong");
        }
    }

    /*
     * Edit
     */
    public function edit($id)
    {
        $GetData = User::find($id);
        return view('dashboard.user-management.update', compact('GetData'));
    }
    
    public function serviceEdit($id)
    {
        $GetData = User::find($id);
        return view('dashboard.service-provider.update', compact('GetData'));
    }

    /*
     * Update
     */
    public function update(Request $request, $id)
    {
        $validator = validator(
            $request->all(),
            [
                'name' => 'required|string',
                'dob' => 'before:today',    // Doesn't accept today date
                'address' => 'required|string',
                'phone' =>  'required|min:10|max:15',
                //             'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048'

            ]
        );
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->dob = $request->input('dob');
            $user->address = $request->input('address');
            $user->phone = $request->input('phone');
            $user->image = $request->input('image');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('public/uploads', $filename);
                $user->image = $filename;
            }

            if ($user->save()) {

                return redirect('/dashboard/users')->with('success', "Account Updated Successfully");
            } else {

                return redirect()->back()->with('error', "Something went wrong");
            }
        } catch (\Exception $e) {
            //             dd($e->getMessage());
            return redirect()->back()->with($e->getMessage());
        }
    }
    public function resetPassword($token)
    {
        $user = User::where('password_reset_token', $token)->first();
        if ($user) {
            return view('auth.update-password', compact('token'));
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function updateUserPassword(Request $request, $token)
    {
        $rules = array(
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user = User::where('password_reset_token', $token)->first();
            if (! empty($user)) {
                // $user->password = Hash::make($request->input('password'));
                // $user->password_reset_token = '';
                if ($user->save()) {
                    return Redirect('login')->with('message', 'Password updated succesfully!');
                } else {
                    return Redirect()->back()->with('message', 'Some error occured. Please try again later');
                }
            } else {
                return Redirect::back()->with('error', 'This URL is expired');
            }
        }
    }
}
