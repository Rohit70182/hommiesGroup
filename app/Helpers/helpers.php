<?php

use Modules\Seo\Entities\Seo;
use Modules\Seo\Entities\Analytics;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
function get_seo()
{
   
}

function get_analytics()
{

   
}


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
function get_current_pic()
{
    $user = Auth::user();
  
    if(Auth::check()){
        if($user->image){
            return url('public/uploads/'.$user->image);
        } else {
            return url('public/assets/images/user.jpg');
        }
    } else {
        return url('public/assets/images/user.jpg');
    }

  }
    
  
  /**
   * Changfe time format
   *
   * @return \Illuminate\Http\Response
   */
  function TimeFormat($time)
  {
      if(empty($time)){
          return null;
      }
      $dateObject = new DateTime($time);
      return $dateObject->format('h:i A');
  }
  
  /**
   * Change date format
   *
   * @return \Illuminate\Http\Response
   */
  function DateFormat($date)
  {
      if(empty($date)){
          return null;
      }
      $dateObject = new DateTime($date);
      return $dateObject->format('d/m/Y');
  }
  
  
