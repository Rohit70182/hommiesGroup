<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use App\Models\User;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Login View.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Attempt Login.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $checkRole = User::where('email',$request->email)->first();
            if(empty($checkRole)){
                return Redirect::back()->withInput()->withErrors([
                    'password' => 'Account not register please register account first.'
                ]);
            }
            if($checkRole->role != User::ROLE_ADMIN) {
                return Redirect::back()->withInput()->withErrors([
                    'password' => 'Login with admin account details.'
                ]);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                LogActivity::addToLog('Login Attempt');
                return redirect('/dashboard');
            }

         
            return Redirect::back()->withInput()->withErrors([
                'password' => 'Email or Password is incorrect.'
            ]);
            
     
        } catch (Exception $e) {
            LogActivity::addToLog($e->getMessage());
            return redirect()->back();
        }
    }
}
