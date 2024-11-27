<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Page\Entities\Page;

class HomeController extends Controller
{
    /**
     * Landing Page.
     * 
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Home Page.
     * 
     */
    public function home()
    {
        return view('home');
    }

    /**
     * About Page.
     * 
     */
    public function about()
    {
        $about= Page::where(['type_id' => Page::ABOUT_US])->first();
        
        return view('about',['about' => $about]);
        
    }
     /**
     * Contact Page.
     * 
     */
    public function contact()
    {
        return view('contact');
    }
     /**
     * privacy Page.
     * 
     */
    public function privacy()
    {
        $privacy= Page::where(['type_id' => Page::PRIVACY_POLICY])->first();
       
        return view('privacy',['privacy' => $privacy]);
    }
    
    public function changePassword()
    {
        return view('change-password');
    }
    
    

     /**
     * Terms Page.
     * 
     */
    public function terms()
    {
        $terms= Page::where(['type_id' => Page::TERMS_CONDITION])->first();
        return view('terms',['terms' => $terms]);
    }
}
