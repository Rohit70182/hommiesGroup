@extends('admin.layouts.app')
@section('content')
<?php

use App\Models\User;
?>
<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/pages-css/index.css') }}" />
<!-- Style Css -->
@if( Session::has('orig_user') )
<div class=" p-3 mb-2 bg-primary text-white">

   <span>You are now logged in as <strong>{{Auth()->user()->name }}</strong> Click
      <a href="{{url('/shadow/return')}}">here</a>
      to return back
   </span>
</div><br>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   <strong>{{ $message }}</strong>
</div>
@endif
<div class="mb-1 mt-2">
   <ul class="breadcrumb">
      <li><a href="{{url('/dashboard')}}">Home</a></li>
      <li class="active">Dashboard</li>
   </ul>
</div>
<div class="dash-home-cards">

   <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-md-2 row-cols-1 top-cards">
      <div class="col-md-6 col-lg-4 col-xl-3">
         <div class="card">
            <a class="card-body" href="{{url('logActivity')}}">
               <p class="cart-title">Login History</p>
               <div class="card-results">
                  <h5 class="main-results">{{\App\Models\LogActivity::count()}}</h5>
               </div>
               <div class="widget-icon">
                  <span><i class="fa fa-user" aria-hidden="true"></i></span>
               </div>
            </a>
            <a href="{{url('logActivity')}}">
               <div id="chart">
                  <div class="pt-1" style="min-height: 30px;">
                     <div id="apexchartsecncwpf3" class="apexcharts-canvas apexchartsecncwpf3 apexcharts-theme-light" style="width: 393px; height: 30px;">
                        <svg id="SvgjsSvg2493" width="393" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                           <g id="SvgjsG2495" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
                              <defs id="SvgjsDefs2494">
                                 <clipPath id="gridRectMaskecncwpf3">
                                    <rect id="SvgjsRect2500" width="399" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <clipPath id="forecastMaskecncwpf3"></clipPath>
                                 <clipPath id="nonForecastMaskecncwpf3"></clipPath>
                                 <clipPath id="gridRectMarkerMaskecncwpf3">
                                    <rect id="SvgjsRect2501" width="397" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <linearGradient id="SvgjsLinearGradient2506" x1="0" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop2507" stop-opacity="0.65" stop-color="rgba(220,230,236,0.65)" offset="0"></stop>
                                    <stop id="SvgjsStop2508" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                    <stop id="SvgjsStop2509" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                 </linearGradient>
                              </defs>
                              <line id="SvgjsLine2499" x1="0" y1="0" x2="0" y2="30" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                              <g id="SvgjsG2529" class="apexcharts-xaxis" transform="translate(0, 0)">
                                 <g id="SvgjsG2530" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                              </g>
                              <g id="SvgjsG2512" class="apexcharts-grid">
                                 <g id="SvgjsG2513" class="apexcharts-gridlines-horizontal" style="display: none;">
                                    <line id="SvgjsLine2517" x1="0" y1="3" x2="393" y2="3" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2518" x1="0" y1="6" x2="393" y2="6" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2519" x1="0" y1="9" x2="393" y2="9" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2520" x1="0" y1="12" x2="393" y2="12" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2521" x1="0" y1="15" x2="393" y2="15" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2522" x1="0" y1="18" x2="393" y2="18" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2523" x1="0" y1="21" x2="393" y2="21" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2524" x1="0" y1="24" x2="393" y2="24" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2525" x1="0" y1="27" x2="393" y2="27" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 </g>
                                 <g id="SvgjsG2514" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                 <line id="SvgjsLine2528" x1="0" y1="30" x2="393" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                 <line id="SvgjsLine2527" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                              </g>
                              <g id="SvgjsG2502" class="apexcharts-area-series apexcharts-plot-series">
                                 <g id="SvgjsG2503" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                    <path id="SvgjsPath2510" d="M 0 30 L 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004 L 393 30M 393 10.000000000000004z" fill="url(#SvgjsLinearGradient2506)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskecncwpf3)" pathTo="M 0 30 L 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004 L 393 30M 393 10.000000000000004z" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30"></path>
                                    <path id="SvgjsPath2511" d="M 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004" fill="none" fill-opacity="1" stroke="#dce6ec" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskecncwpf3)" pathTo="M 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30" fill-rule="evenodd"></path>
                                    <g id="SvgjsG2504" class="apexcharts-series-markers-wrap" data:realIndex="0"></g>
                                 </g>
                                 <g id="SvgjsG2505" class="apexcharts-datalabels" data:realIndex="0"></g>
                              </g>
                              <g id="SvgjsG2515" class="apexcharts-grid-borders" style="display: none;">
                                 <line id="SvgjsLine2516" x1="0" y1="0" x2="393" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 <line id="SvgjsLine2526" x1="0" y1="30" x2="393" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                              </g>
                              <g id="SvgjsG2554" class="apexcharts-yaxis-annotations"></g>
                              <g id="SvgjsG2555" class="apexcharts-xaxis-annotations"></g>
                              <g id="SvgjsG2556" class="apexcharts-point-annotations"></g>
                           </g>
                           <rect id="SvgjsRect2498" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                           <g id="SvgjsG2551" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                           <g id="SvgjsG2496" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend" style="max-height: 15px;"></div>
                     </div>
                  </div>
               </div>
            </a>

         </div>
      </div>
      <div class="col-md-6 col-lg-4 col-xl-3">
         <div class="card">
            <a class="card-body" href="{{url('dashboard/users')}}">
               <p class="cart-title">Users</p>
               <div class="card-results">
                  <h5 class="main-results">{{ \App\Models\User::where('role', User::ROLE_USER)->count() }}</h5>
               </div>
               <div class="widget-icon">
                  <span><i class="fa fa-users" aria-hidden="true"></i></span>
               </div>
            </a>
            <a href="{{url('dashboard/users')}}">
               <div id="chart">
                  <div class="pt-1" style="min-height: 30px;">
                     <div id="apexchartsajesxk9i" class="apexcharts-canvas apexchartsajesxk9i apexcharts-theme-light" style="width: 393px; height: 30px;"><svg id="SvgjsSvg2557" width="393" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                           <g id="SvgjsG2559" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
                              <defs id="SvgjsDefs2558">
                                 <clipPath id="gridRectMaskajesxk9i">
                                    <rect id="SvgjsRect2564" width="399" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <clipPath id="forecastMaskajesxk9i"></clipPath>
                                 <clipPath id="nonForecastMaskajesxk9i"></clipPath>
                                 <clipPath id="gridRectMarkerMaskajesxk9i">
                                    <rect id="SvgjsRect2565" width="397" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <linearGradient id="SvgjsLinearGradient2570" x1="0" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop2571" stop-opacity="0.65" stop-color="rgba(220,230,236,0.65)" offset="0"></stop>
                                    <stop id="SvgjsStop2572" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                    <stop id="SvgjsStop2573" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                 </linearGradient>
                              </defs>
                              <line id="SvgjsLine2563" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                              <g id="SvgjsG2593" class="apexcharts-xaxis" transform="translate(0, 0)">
                                 <g id="SvgjsG2594" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                              </g>
                              <g id="SvgjsG2576" class="apexcharts-grid">
                                 <g id="SvgjsG2577" class="apexcharts-gridlines-horizontal" style="display: none;">
                                    <line id="SvgjsLine2581" x1="0" y1="3" x2="393" y2="3" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2582" x1="0" y1="6" x2="393" y2="6" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2583" x1="0" y1="9" x2="393" y2="9" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2584" x1="0" y1="12" x2="393" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2585" x1="0" y1="15" x2="393" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2586" x1="0" y1="18" x2="393" y2="18" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2587" x1="0" y1="21" x2="393" y2="21" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2588" x1="0" y1="24" x2="393" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2589" x1="0" y1="27" x2="393" y2="27" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 </g>
                                 <g id="SvgjsG2578" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                 <line id="SvgjsLine2592" x1="0" y1="30" x2="393" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                 <line id="SvgjsLine2591" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                              </g>
                              <g id="SvgjsG2566" class="apexcharts-area-series apexcharts-plot-series">
                                 <g id="SvgjsG2567" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                    <path id="SvgjsPath2574" d="M 0 30 L 0 24.375C 7.239473684210525 24.375 13.444736842105263 26.25 20.684210526315788 26.25C 27.92368421052631 26.25 34.12894736842105 22.5 41.368421052631575 22.5C 48.6078947368421 22.5 54.81315789473684 18.75 62.05263157894736 18.75C 69.2921052631579 18.75 75.49736842105263 7.5 82.73684210526315 7.5C 89.97631578947367 7.5 96.18157894736842 3.75 103.42105263157895 3.75C 110.66052631578947 3.75 116.8657894736842 15 124.10526315789473 15C 131.34473684210525 15 137.54999999999998 16.875 144.78947368421052 16.875C 152.02894736842103 16.875 158.2342105263158 3.75 165.4736842105263 3.75C 172.71315789473684 3.75 178.91842105263157 0 186.1578947368421 0C 193.39736842105262 0 199.60263157894738 7.5 206.8421052631579 7.5C 214.0815789473684 7.5 220.28684210526316 16.875 227.52631578947367 16.875C 234.76578947368418 16.875 240.97105263157894 15 248.21052631578945 15C 255.45 15 261.65526315789475 22.5 268.89473684210526 22.5C 276.13421052631577 22.5 282.33947368421053 24.375 289.57894736842104 24.375C 296.81842105263155 24.375 303.0236842105263 26.25 310.2631578947368 26.25C 317.50263157894733 26.25 323.7078947368421 26.25 330.9473684210526 26.25C 338.1868421052631 26.25 344.3921052631579 20.625 351.6315789473684 20.625C 358.87105263157895 20.625 365.07631578947365 18.75 372.3157894736842 18.75C 379.55526315789473 18.75 385.7605263157895 16.875 393 16.875C 393 16.875 393 16.875 393 30M 393 16.875z" fill="url(#SvgjsLinearGradient2570)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskajesxk9i)" pathTo="M 0 30 L 0 24.375C 7.239473684210525 24.375 13.444736842105263 26.25 20.684210526315788 26.25C 27.92368421052631 26.25 34.12894736842105 22.5 41.368421052631575 22.5C 48.6078947368421 22.5 54.81315789473684 18.75 62.05263157894736 18.75C 69.2921052631579 18.75 75.49736842105263 7.5 82.73684210526315 7.5C 89.97631578947367 7.5 96.18157894736842 3.75 103.42105263157895 3.75C 110.66052631578947 3.75 116.8657894736842 15 124.10526315789473 15C 131.34473684210525 15 137.54999999999998 16.875 144.78947368421052 16.875C 152.02894736842103 16.875 158.2342105263158 3.75 165.4736842105263 3.75C 172.71315789473684 3.75 178.91842105263157 0 186.1578947368421 0C 193.39736842105262 0 199.60263157894738 7.5 206.8421052631579 7.5C 214.0815789473684 7.5 220.28684210526316 16.875 227.52631578947367 16.875C 234.76578947368418 16.875 240.97105263157894 15 248.21052631578945 15C 255.45 15 261.65526315789475 22.5 268.89473684210526 22.5C 276.13421052631577 22.5 282.33947368421053 24.375 289.57894736842104 24.375C 296.81842105263155 24.375 303.0236842105263 26.25 310.2631578947368 26.25C 317.50263157894733 26.25 323.7078947368421 26.25 330.9473684210526 26.25C 338.1868421052631 26.25 344.3921052631579 20.625 351.6315789473684 20.625C 358.87105263157895 20.625 365.07631578947365 18.75 372.3157894736842 18.75C 379.55526315789473 18.75 385.7605263157895 16.875 393 16.875C 393 16.875 393 16.875 393 30M 393 16.875z" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30"></path>
                                    <path id="SvgjsPath2575" d="M 0 24.375C 7.239473684210525 24.375 13.444736842105263 26.25 20.684210526315788 26.25C 27.92368421052631 26.25 34.12894736842105 22.5 41.368421052631575 22.5C 48.6078947368421 22.5 54.81315789473684 18.75 62.05263157894736 18.75C 69.2921052631579 18.75 75.49736842105263 7.5 82.73684210526315 7.5C 89.97631578947367 7.5 96.18157894736842 3.75 103.42105263157895 3.75C 110.66052631578947 3.75 116.8657894736842 15 124.10526315789473 15C 131.34473684210525 15 137.54999999999998 16.875 144.78947368421052 16.875C 152.02894736842103 16.875 158.2342105263158 3.75 165.4736842105263 3.75C 172.71315789473684 3.75 178.91842105263157 0 186.1578947368421 0C 193.39736842105262 0 199.60263157894738 7.5 206.8421052631579 7.5C 214.0815789473684 7.5 220.28684210526316 16.875 227.52631578947367 16.875C 234.76578947368418 16.875 240.97105263157894 15 248.21052631578945 15C 255.45 15 261.65526315789475 22.5 268.89473684210526 22.5C 276.13421052631577 22.5 282.33947368421053 24.375 289.57894736842104 24.375C 296.81842105263155 24.375 303.0236842105263 26.25 310.2631578947368 26.25C 317.50263157894733 26.25 323.7078947368421 26.25 330.9473684210526 26.25C 338.1868421052631 26.25 344.3921052631579 20.625 351.6315789473684 20.625C 358.87105263157895 20.625 365.07631578947365 18.75 372.3157894736842 18.75C 379.55526315789473 18.75 385.7605263157895 16.875 393 16.875" fill="none" fill-opacity="1" stroke="#dce6ec" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskajesxk9i)" pathTo="M 0 24.375C 7.239473684210525 24.375 13.444736842105263 26.25 20.684210526315788 26.25C 27.92368421052631 26.25 34.12894736842105 22.5 41.368421052631575 22.5C 48.6078947368421 22.5 54.81315789473684 18.75 62.05263157894736 18.75C 69.2921052631579 18.75 75.49736842105263 7.5 82.73684210526315 7.5C 89.97631578947367 7.5 96.18157894736842 3.75 103.42105263157895 3.75C 110.66052631578947 3.75 116.8657894736842 15 124.10526315789473 15C 131.34473684210525 15 137.54999999999998 16.875 144.78947368421052 16.875C 152.02894736842103 16.875 158.2342105263158 3.75 165.4736842105263 3.75C 172.71315789473684 3.75 178.91842105263157 0 186.1578947368421 0C 193.39736842105262 0 199.60263157894738 7.5 206.8421052631579 7.5C 214.0815789473684 7.5 220.28684210526316 16.875 227.52631578947367 16.875C 234.76578947368418 16.875 240.97105263157894 15 248.21052631578945 15C 255.45 15 261.65526315789475 22.5 268.89473684210526 22.5C 276.13421052631577 22.5 282.33947368421053 24.375 289.57894736842104 24.375C 296.81842105263155 24.375 303.0236842105263 26.25 310.2631578947368 26.25C 317.50263157894733 26.25 323.7078947368421 26.25 330.9473684210526 26.25C 338.1868421052631 26.25 344.3921052631579 20.625 351.6315789473684 20.625C 358.87105263157895 20.625 365.07631578947365 18.75 372.3157894736842 18.75C 379.55526315789473 18.75 385.7605263157895 16.875 393 16.875" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30" fill-rule="evenodd"></path>
                                    <g id="SvgjsG2568" class="apexcharts-series-markers-wrap" data:realIndex="0"></g>
                                 </g>
                                 <g id="SvgjsG2569" class="apexcharts-datalabels" data:realIndex="0"></g>
                              </g>
                              <g id="SvgjsG2579" class="apexcharts-grid-borders" style="display: none;">
                                 <line id="SvgjsLine2580" x1="0" y1="0" x2="393" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 <line id="SvgjsLine2590" x1="0" y1="30" x2="393" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                              </g>
                              <g id="SvgjsG2618" class="apexcharts-yaxis-annotations"></g>
                              <g id="SvgjsG2619" class="apexcharts-xaxis-annotations"></g>
                              <g id="SvgjsG2620" class="apexcharts-point-annotations"></g>
                           </g>
                           <rect id="SvgjsRect2562" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                           <g id="SvgjsG2615" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                           <g id="SvgjsG2560" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend" style="max-height: 15px;"></div>
                     </div>
                  </div>
               </div>
            </a>
         </div>
      </div>
      <div class="col-md-6 col-lg-4 col-xl-3">
         <div class="card">
            <a class="card-body" href="{{url('/logs')}}">
               <p class="cart-title">Logs</p>

               <div class="card-results">
                  <h5 class="main-results">{{ \App\Models\Logger::count()}}</h5>
               </div>
               <div class="widget-icon">
                  <span><i class="fa fa-sign-in" aria-hidden="true"></i></span>
               </div>
            </a>
            <a href="{{url('dashboard/logs')}}">
               <div id="chart">
                  <div class="pt-1" style="min-height: 30px;">
                     <div id="apexchartsqcvkqy26j" class="apexcharts-canvas apexchartsqcvkqy26j apexcharts-theme-light" style="width: 393px; height: 30px;"><svg id="SvgjsSvg2621" width="393" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                           <g id="SvgjsG2623" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
                              <defs id="SvgjsDefs2622">
                                 <clipPath id="gridRectMaskqcvkqy26j">
                                    <rect id="SvgjsRect2628" width="399" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <clipPath id="forecastMaskqcvkqy26j"></clipPath>
                                 <clipPath id="nonForecastMaskqcvkqy26j"></clipPath>
                                 <clipPath id="gridRectMarkerMaskqcvkqy26j">
                                    <rect id="SvgjsRect2629" width="397" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <linearGradient id="SvgjsLinearGradient2634" x1="0" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop2635" stop-opacity="0.65" stop-color="rgba(220,230,236,0.65)" offset="0"></stop>
                                    <stop id="SvgjsStop2636" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                    <stop id="SvgjsStop2637" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                 </linearGradient>
                              </defs>
                              <line id="SvgjsLine2627" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                              <g id="SvgjsG2657" class="apexcharts-xaxis" transform="translate(0, 0)">
                                 <g id="SvgjsG2658" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                              </g>
                              <g id="SvgjsG2640" class="apexcharts-grid">
                                 <g id="SvgjsG2641" class="apexcharts-gridlines-horizontal" style="display: none;">
                                    <line id="SvgjsLine2645" x1="0" y1="3" x2="393" y2="3" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2646" x1="0" y1="6" x2="393" y2="6" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2647" x1="0" y1="9" x2="393" y2="9" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2648" x1="0" y1="12" x2="393" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2649" x1="0" y1="15" x2="393" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2650" x1="0" y1="18" x2="393" y2="18" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2651" x1="0" y1="21" x2="393" y2="21" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2652" x1="0" y1="24" x2="393" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine2653" x1="0" y1="27" x2="393" y2="27" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 </g>
                                 <g id="SvgjsG2642" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                 <line id="SvgjsLine2656" x1="0" y1="30" x2="393" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                 <line id="SvgjsLine2655" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                              </g>
                              <g id="SvgjsG2630" class="apexcharts-area-series apexcharts-plot-series">
                                 <g id="SvgjsG2631" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                    <path id="SvgjsPath2638" d="M 0 30 L 0 23.18181818181818 L 20.684210526315788 16.36363636363636 L 41.368421052631575 23.18181818181818 L 62.05263157894736 2.7272727272727195 L 82.73684210526315 -7.105427357601002e-15 L 103.42105263157895 13.636363636363633 L 124.10526315789473 9.54545454545454 L 144.78947368421052 5.45454545454545 L 165.4736842105263 2.7272727272727195 L 186.1578947368421 9.54545454545454 L 206.8421052631579 19.090909090909086 L 227.52631578947367 13.636363636363633 L 248.21052631578945 -7.105427357601002e-15 L 268.89473684210526 23.18181818181818 L 289.57894736842104 16.36363636363636 L 310.2631578947368 13.636363636363633 L 330.9473684210526 -7.105427357601002e-15 L 351.6315789473684 9.54545454545454 L 372.3157894736842 8.181818181818176 L 393 16.36363636363636 L 393 30M 393 16.36363636363636z" fill="url(#SvgjsLinearGradient2634)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskqcvkqy26j)" pathTo="M 0 30 L 0 23.18181818181818 L 20.684210526315788 16.36363636363636 L 41.368421052631575 23.18181818181818 L 62.05263157894736 2.7272727272727195 L 82.73684210526315 -7.105427357601002e-15 L 103.42105263157895 13.636363636363633 L 124.10526315789473 9.54545454545454 L 144.78947368421052 5.45454545454545 L 165.4736842105263 2.7272727272727195 L 186.1578947368421 9.54545454545454 L 206.8421052631579 19.090909090909086 L 227.52631578947367 13.636363636363633 L 248.21052631578945 -7.105427357601002e-15 L 268.89473684210526 23.18181818181818 L 289.57894736842104 16.36363636363636 L 310.2631578947368 13.636363636363633 L 330.9473684210526 -7.105427357601002e-15 L 351.6315789473684 9.54545454545454 L 372.3157894736842 8.181818181818176 L 393 16.36363636363636 L 393 30M 393 16.36363636363636z" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30"></path>
                                    <path id="SvgjsPath2639" d="M 0 23.18181818181818 L 20.684210526315788 16.36363636363636 L 41.368421052631575 23.18181818181818 L 62.05263157894736 2.7272727272727195 L 82.73684210526315 -7.105427357601002e-15 L 103.42105263157895 13.636363636363633 L 124.10526315789473 9.54545454545454 L 144.78947368421052 5.45454545454545 L 165.4736842105263 2.7272727272727195 L 186.1578947368421 9.54545454545454 L 206.8421052631579 19.090909090909086 L 227.52631578947367 13.636363636363633 L 248.21052631578945 -7.105427357601002e-15 L 268.89473684210526 23.18181818181818 L 289.57894736842104 16.36363636363636 L 310.2631578947368 13.636363636363633 L 330.9473684210526 -7.105427357601002e-15 L 351.6315789473684 9.54545454545454 L 372.3157894736842 8.181818181818176 L 393 16.36363636363636" fill="none" fill-opacity="1" stroke="#dce6ec" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskqcvkqy26j)" pathTo="M 0 23.18181818181818 L 20.684210526315788 16.36363636363636 L 41.368421052631575 23.18181818181818 L 62.05263157894736 2.7272727272727195 L 82.73684210526315 -7.105427357601002e-15 L 103.42105263157895 13.636363636363633 L 124.10526315789473 9.54545454545454 L 144.78947368421052 5.45454545454545 L 165.4736842105263 2.7272727272727195 L 186.1578947368421 9.54545454545454 L 206.8421052631579 19.090909090909086 L 227.52631578947367 13.636363636363633 L 248.21052631578945 -7.105427357601002e-15 L 268.89473684210526 23.18181818181818 L 289.57894736842104 16.36363636363636 L 310.2631578947368 13.636363636363633 L 330.9473684210526 -7.105427357601002e-15 L 351.6315789473684 9.54545454545454 L 372.3157894736842 8.181818181818176 L 393 16.36363636363636" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30" fill-rule="evenodd"></path>
                                    <g id="SvgjsG2632" class="apexcharts-series-markers-wrap" data:realIndex="0"></g>
                                 </g>
                                 <g id="SvgjsG2633" class="apexcharts-datalabels" data:realIndex="0"></g>
                              </g>
                              <g id="SvgjsG2643" class="apexcharts-grid-borders" style="display: none;">
                                 <line id="SvgjsLine2644" x1="0" y1="0" x2="393" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 <line id="SvgjsLine2654" x1="0" y1="30" x2="393" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                              </g>
                              <g id="SvgjsG2682" class="apexcharts-yaxis-annotations"></g>
                              <g id="SvgjsG2683" class="apexcharts-xaxis-annotations"></g>
                              <g id="SvgjsG2684" class="apexcharts-point-annotations"></g>
                           </g>
                           <rect id="SvgjsRect2626" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                           <g id="SvgjsG2679" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                           <g id="SvgjsG2624" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend" style="max-height: 15px;"></div>
                     </div>
                  </div>
               </div>
            </a>
         </div>
      </div>
      <div class="col-md-6 col-lg-4 col-xl-3 ">
         <div class="card">
            <a class="card-body" href="{{url('notifications')}}">
               <p class="cart-title">Notifications</p>
               <div class="card-results">
                  <h5 class="main-results">{{ \Modules\Notification\Entities\Notification::count() }}</h5>
               </div>
               <div class="widget-icon">
                  <span><i class="fa fa-bell" aria-hidden="true"></i></span>
               </div>
            </a>
            <a href="{{url('notifications')}}">
               <div id="chart">
                  <div class="pt-1" style="min-height: 30px;">
                     <div id="apexchartsketx41wxf" class="apexcharts-canvas apexchartsketx41wxf apexcharts-theme-light" style="width: 393px; height: 30px;"><svg id="SvgjsSvg3917" width="393" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                           <g id="SvgjsG3919" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
                              <defs id="SvgjsDefs3918">
                                 <clipPath id="gridRectMaskketx41wxf">
                                    <rect id="SvgjsRect3924" width="399" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <clipPath id="forecastMaskketx41wxf"></clipPath>
                                 <clipPath id="nonForecastMaskketx41wxf"></clipPath>
                                 <clipPath id="gridRectMarkerMaskketx41wxf">
                                    <rect id="SvgjsRect3925" width="397" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <linearGradient id="SvgjsLinearGradient3930" x1="0" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop3931" stop-opacity="0.65" stop-color="rgba(220,230,236,0.65)" offset="0"></stop>
                                    <stop id="SvgjsStop3932" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                    <stop id="SvgjsStop3933" stop-opacity="0.5" stop-color="rgba(238,243,246,0.5)" offset="1"></stop>
                                 </linearGradient>
                              </defs>
                              <line id="SvgjsLine3923" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                              <g id="SvgjsG3953" class="apexcharts-xaxis" transform="translate(0, 0)">
                                 <g id="SvgjsG3954" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                              </g>
                              <g id="SvgjsG3936" class="apexcharts-grid">
                                 <g id="SvgjsG3937" class="apexcharts-gridlines-horizontal" style="display: none;">
                                    <line id="SvgjsLine3941" x1="0" y1="3" x2="393" y2="3" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3942" x1="0" y1="6" x2="393" y2="6" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3943" x1="0" y1="9" x2="393" y2="9" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3944" x1="0" y1="12" x2="393" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3945" x1="0" y1="15" x2="393" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3946" x1="0" y1="18" x2="393" y2="18" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3947" x1="0" y1="21" x2="393" y2="21" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3948" x1="0" y1="24" x2="393" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine3949" x1="0" y1="27" x2="393" y2="27" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 </g>
                                 <g id="SvgjsG3938" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                 <line id="SvgjsLine3952" x1="0" y1="30" x2="393" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                 <line id="SvgjsLine3951" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                              </g>
                              <g id="SvgjsG3926" class="apexcharts-area-series apexcharts-plot-series">
                                 <g id="SvgjsG3927" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                    <path id="SvgjsPath3934" d="M 0 30 L 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004 L 393 30M 393 10.000000000000004z" fill="url(#SvgjsLinearGradient3930)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskketx41wxf)" pathTo="M 0 30 L 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004 L 393 30M 393 10.000000000000004z" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30"></path>
                                    <path id="SvgjsPath3935" d="M 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004" fill="none" fill-opacity="1" stroke="#dce6ec" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskketx41wxf)" pathTo="M 0 21.666666666666668 L 20.684210526315788 15.000000000000002 L 41.368421052631575 21.666666666666668 L 62.05263157894736 20 L 82.73684210526315 23.333333333333336 L 103.42105263157895 10.000000000000004 L 124.10526315789473 3.552713678800501e-15 L 144.78947368421052 6.666666666666671 L 165.4736842105263 13.333333333333336 L 186.1578947368421 5.0000000000000036 L 206.8421052631579 10.000000000000004 L 227.52631578947367 21.666666666666668 L 248.21052631578945 16.666666666666668 L 268.89473684210526 21.666666666666668 L 289.57894736842104 10.000000000000004 L 310.2631578947368 21.666666666666668 L 330.9473684210526 10.000000000000004 L 351.6315789473684 13.333333333333336 L 372.3157894736842 3.3333333333333357 L 393 10.000000000000004" pathFrom="M -1 30 L -1 30 L 20.684210526315788 30 L 41.368421052631575 30 L 62.05263157894736 30 L 82.73684210526315 30 L 103.42105263157895 30 L 124.10526315789473 30 L 144.78947368421052 30 L 165.4736842105263 30 L 186.1578947368421 30 L 206.8421052631579 30 L 227.52631578947367 30 L 248.21052631578945 30 L 268.89473684210526 30 L 289.57894736842104 30 L 310.2631578947368 30 L 330.9473684210526 30 L 351.6315789473684 30 L 372.3157894736842 30 L 393 30" fill-rule="evenodd"></path>
                                    <g id="SvgjsG3928" class="apexcharts-series-markers-wrap" data:realIndex="0"></g>
                                 </g>
                                 <g id="SvgjsG3929" class="apexcharts-datalabels" data:realIndex="0"></g>
                              </g>
                              <g id="SvgjsG3939" class="apexcharts-grid-borders" style="display: none;">
                                 <line id="SvgjsLine3940" x1="0" y1="0" x2="393" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                 <line id="SvgjsLine3950" x1="0" y1="30" x2="393" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                              </g>
                              <g id="SvgjsG3978" class="apexcharts-yaxis-annotations"></g>
                              <g id="SvgjsG3979" class="apexcharts-xaxis-annotations"></g>
                              <g id="SvgjsG3980" class="apexcharts-point-annotations"></g>
                           </g>
                           <rect id="SvgjsRect3922" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                           <g id="SvgjsG3975" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                           <g id="SvgjsG3920" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend" style="max-height: 15px;"></div>
                     </div>
                  </div>
               </div>
            </a>
         </div>
      </div>
   </div>
   <div class="col-md-12 p-lg-0">
      <div class="card">
         <div class="card-body">
            <figure class="highcharts-figure">
               <div id="container"></div>
            </figure>
         </div>
      </div>
   </div>
   <div class="row-sm row">
      <div class="col-xl-4 col-lg-12 col-md-12">
         <div class="card">
            <div class="pb-1 card-header">
               <h3 class="mb-2 card-title">Recent Customers</h3>
               <p class="tx-12 mb-0 text-muted">A customer is an individual or business that purchases the goods service has evolved to include real-time</p>
            </div>
            <div class="p-0 customers mt-1 card-body">
               <div class="list-lg-group list-group-flush list-group">
                  <div class="list-group-item-action list-group-item">
                     <div class="media mt-0">
                        <img class="avatar-lg rounded-circle my-auto mr-3" src="{{ asset('public/assets/images/chartimg1.jpg') }}" alt="Image description">
                        <div class="media-body">
                           <div class="d-sm-flex align-items-center">
                              <div class="mt-0">
                                 <h5 class="mb-1 tx-15">Samantha Melon</h5>
                                 <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-success ms-2">Paid</span></p>
                              </div>
                              <span class="ml-auto wd-45p fs-16 mt-2">
                                 <div id="chart">
                                    <div class="wd-100p" style="min-height: 30px;">
                                       <div id="apexchartsspark1" class="apexcharts-canvas apexchartsspark1 apexcharts-theme-light" style="width: 196px; height: 30px;">
                                          <svg id="SvgjsSvg2180" width="196" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                             <g id="SvgjsG2182" class="apexcharts-inner apexcharts-graphical" transform="translate(50, 10)">

                                                <clipPath id="forecastMask2vpe9ni1"></clipPath>
                                                <clipPath id="nonForecastMask2vpe9ni1"></clipPath>
                                                <clipPath id="gridRectMarkerMask2vpe9ni1">
                                                   <rect id="SvgjsRect2188" width="150" height="14" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <filter id="SvgjsFilter2194" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%">
                                                   <feFlood id="SvgjsFeFlood2195" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood2195Out" in="SourceGraphic"></feFlood>
                                                   <feComposite id="SvgjsFeComposite2196" in="SvgjsFeFlood2195Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2196Out"></feComposite>
                                                   <feOffset id="SvgjsFeOffset2197" dx="1" dy="1" result="SvgjsFeOffset2197Out" in="SvgjsFeComposite2196Out"></feOffset>
                                                   <feGaussianBlur id="SvgjsFeGaussianBlur2198" stdDeviation="1 " result="SvgjsFeGaussianBlur2198Out" in="SvgjsFeOffset2197Out"></feGaussianBlur>
                                                   <feBlend id="SvgjsFeBlend2199" in="SourceGraphic" in2="SvgjsFeGaussianBlur2198Out" mode="normal" result="SvgjsFeBlend2199Out"></feBlend>
                                                </filter>

                                                <line id="SvgjsLine2186" x1="0" y1="0" x2="0" y2="10" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="10" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG2214" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                   <g id="SvgjsG2215" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG2200" class="apexcharts-grid">
                                                   <g id="SvgjsG2201" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                      <line id="SvgjsLine2205" x1="0" y1="1.4285714285714286" x2="146" y2="1.4285714285714286" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2206" x1="0" y1="2.857142857142857" x2="146" y2="2.857142857142857" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2207" x1="0" y1="4.285714285714286" x2="146" y2="4.285714285714286" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2208" x1="0" y1="5.714285714285714" x2="146" y2="5.714285714285714" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2209" x1="0" y1="7.142857142857143" x2="146" y2="7.142857142857143" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2210" x1="0" y1="8.571428571428571" x2="146" y2="8.571428571428571" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   </g>
                                                   <g id="SvgjsG2202" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                   <line id="SvgjsLine2213" x1="0" y1="10" x2="146" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                   <line id="SvgjsLine2212" x1="0" y1="1" x2="0" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG2189" class="apexcharts-line-series apexcharts-plot-series">
                                                   <g id="SvgjsG2190" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                      <path id="SvgjsPath2193" d="M 0 6.428571428571429 L 16.22222222222222 0.5714285714285712 L 32.44444444444444 4.142857142857143 L 48.66666666666667 1.5714285714285712 L 64.88888888888889 6.428571428571429 L 81.11111111111111 3.7142857142857144 L 97.33333333333334 8.285714285714286 L 113.55555555555556 4.857142857142857 L 129.77777777777777 8.714285714285714 L 146 7" fill="none" fill-opacity="1" stroke="rgba(10,154,225,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask2vpe9ni1)" filter="url(#SvgjsFilter2194)" pathTo="M 0 6.428571428571429 L 16.22222222222222 0.5714285714285712 L 32.44444444444444 4.142857142857143 L 48.66666666666667 1.5714285714285712 L 64.88888888888889 6.428571428571429 L 81.11111111111111 3.7142857142857144 L 97.33333333333334 8.285714285714286 L 113.55555555555556 4.857142857142857 L 129.77777777777777 8.714285714285714 L 146 7" pathFrom="M -1 10 L -1 10 L 16.22222222222222 10 L 32.44444444444444 10 L 48.66666666666667 10 L 64.88888888888889 10 L 81.11111111111111 10 L 97.33333333333334 10 L 113.55555555555556 10 L 129.77777777777777 10 L 146 10" fill-rule="evenodd"></path>
                                                      <g id="SvgjsG2191" class="apexcharts-series-markers-wrap" data:realIndex="0">
                                                         <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle2232" r="0" cx="0" cy="0" class="apexcharts-marker wnu741y3s no-pointer-events" stroke="#ffffff" fill="#0a9ae1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                         </g>
                                                      </g>
                                                   </g>
                                                   <g id="SvgjsG2192" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <g id="SvgjsG2203" class="apexcharts-grid-borders" style="display: none;">
                                                   <line id="SvgjsLine2204" x1="0" y1="0" x2="146" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   <line id="SvgjsLine2211" x1="0" y1="10" x2="146" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG2229" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG2230" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG2231" class="apexcharts-point-annotations"></g>
                                             </g>
                                             <rect id="SvgjsRect2185" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                             <g id="SvgjsG2226" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                             <g id="SvgjsG2183" class="apexcharts-annotations"></g>
                                          </svg>
                                          <div class="apexcharts-legend" style="max-height: 15px;"></div>
                                          <div class="apexcharts-tooltip apexcharts-theme-light">
                                             <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                             <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                <span class="apexcharts-tooltip-marker" style="background-color: rgb(10, 154, 225);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                   <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                   <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                   <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                             <div class="apexcharts-yaxistooltip-text"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="list-group-item-action br-t-1 list-group-item">
                     <div class="media mt-0">
                        <img class="avatar-lg rounded-circle my-auto mr-3" src="{{ asset('public/assets/images/chartimg2.jpg') }}" alt="Image description">
                        <div class="media-body">
                           <div class="d-sm-flex align-items-center">
                              <div class="mt-1">
                                 <h5 class="mb-1 tx-15">Jimmy Changa</h5>
                                 <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-danger ms-2">Pending</span></p>
                              </div>
                              <span class="ml-auto wd-45p fs-16 mt-2">
                                 <div id="chart">
                                    <div class="wd-100p" style="min-height: 30px;">
                                       <div id="apexchartsspark2" class="apexcharts-canvas apexchartsspark2 apexcharts-theme-light" style="width: 196px; height: 30px;">
                                          <svg id="SvgjsSvg2234" width="196" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                             <g id="SvgjsG2236" class="apexcharts-inner apexcharts-graphical" transform="translate(50, 10)">
                                                <defs id="SvgjsDefs2235">
                                                   <clipPath id="gridRectMaskw8ucvrav">
                                                      <rect id="SvgjsRect2241" width="152" height="12" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <clipPath id="forecastMaskw8ucvrav"></clipPath>
                                                   <clipPath id="nonForecastMaskw8ucvrav"></clipPath>
                                                   <clipPath id="gridRectMarkerMaskw8ucvrav">
                                                      <rect id="SvgjsRect2242" width="150" height="14" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <filter id="SvgjsFilter2248" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%">
                                                      <feFlood id="SvgjsFeFlood2249" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood2249Out" in="SourceGraphic"></feFlood>
                                                      <feComposite id="SvgjsFeComposite2250" in="SvgjsFeFlood2249Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2250Out"></feComposite>
                                                      <feOffset id="SvgjsFeOffset2251" dx="1" dy="1" result="SvgjsFeOffset2251Out" in="SvgjsFeComposite2250Out"></feOffset>
                                                      <feGaussianBlur id="SvgjsFeGaussianBlur2252" stdDeviation="1 " result="SvgjsFeGaussianBlur2252Out" in="SvgjsFeOffset2251Out"></feGaussianBlur>
                                                      <feBlend id="SvgjsFeBlend2253" in="SourceGraphic" in2="SvgjsFeGaussianBlur2252Out" mode="normal" result="SvgjsFeBlend2253Out"></feBlend>
                                                   </filter>
                                                </defs>
                                                <line id="SvgjsLine2240" x1="0" y1="0" x2="0" y2="10" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="10" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG2265" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                   <g id="SvgjsG2266" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG2254" class="apexcharts-grid">
                                                   <g id="SvgjsG2255" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                      <line id="SvgjsLine2259" x1="0" y1="2.5" x2="146" y2="2.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2260" x1="0" y1="5" x2="146" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2261" x1="0" y1="7.5" x2="146" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   </g>
                                                   <g id="SvgjsG2256" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                   <line id="SvgjsLine2264" x1="0" y1="10" x2="146" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                   <line id="SvgjsLine2263" x1="0" y1="1" x2="0" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG2243" class="apexcharts-line-series apexcharts-plot-series">
                                                   <g id="SvgjsG2244" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                      <path id="SvgjsPath2247" d="M 0 8.5C 5.677777777777777 8.5 10.544444444444444 8.25 16.22222222222222 8.25C 21.9 8.25 26.766666666666666 9.75 32.44444444444444 9.75C 38.12222222222222 9.75 42.988888888888894 4.125 48.66666666666667 4.125C 54.34444444444445 4.125 59.21111111111111 6 64.88888888888889 6C 70.56666666666666 6 75.43333333333334 4.5 81.11111111111111 4.5C 86.78888888888889 4.5 91.65555555555557 8.25 97.33333333333334 8.25C 103.01111111111112 8.25 107.87777777777778 3.125 113.55555555555556 3.125C 119.23333333333333 3.125 124.1 4.875 129.77777777777777 4.875C 135.45555555555555 4.875 140.32222222222222 1.375 146 1.375" fill="none" fill-opacity="1" stroke="rgba(255,81,110,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskw8ucvrav)" filter="url(#SvgjsFilter2248)" pathTo="M 0 8.5C 5.677777777777777 8.5 10.544444444444444 8.25 16.22222222222222 8.25C 21.9 8.25 26.766666666666666 9.75 32.44444444444444 9.75C 38.12222222222222 9.75 42.988888888888894 4.125 48.66666666666667 4.125C 54.34444444444445 4.125 59.21111111111111 6 64.88888888888889 6C 70.56666666666666 6 75.43333333333334 4.5 81.11111111111111 4.5C 86.78888888888889 4.5 91.65555555555557 8.25 97.33333333333334 8.25C 103.01111111111112 8.25 107.87777777777778 3.125 113.55555555555556 3.125C 119.23333333333333 3.125 124.1 4.875 129.77777777777777 4.875C 135.45555555555555 4.875 140.32222222222222 1.375 146 1.375" pathFrom="M -1 10 L -1 10 L 16.22222222222222 10 L 32.44444444444444 10 L 48.66666666666667 10 L 64.88888888888889 10 L 81.11111111111111 10 L 97.33333333333334 10 L 113.55555555555556 10 L 129.77777777777777 10 L 146 10" fill-rule="evenodd"></path>
                                                      <g id="SvgjsG2245" class="apexcharts-series-markers-wrap" data:realIndex="0">
                                                         <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle2283" r="0" cx="0" cy="0" class="apexcharts-marker w3yvq9vw3 no-pointer-events" stroke="#ffffff" fill="#ff516e" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                         </g>
                                                      </g>
                                                   </g>
                                                   <g id="SvgjsG2246" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <g id="SvgjsG2257" class="apexcharts-grid-borders" style="display: none;">
                                                   <line id="SvgjsLine2258" x1="0" y1="0" x2="146" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   <line id="SvgjsLine2262" x1="0" y1="10" x2="146" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG2280" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG2281" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG2282" class="apexcharts-point-annotations"></g>
                                             </g>
                                             <rect id="SvgjsRect2239" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                             <g id="SvgjsG2277" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                             <g id="SvgjsG2237" class="apexcharts-annotations"></g>
                                          </svg>
                                          <div class="apexcharts-legend" style="max-height: 15px;"></div>
                                          <div class="apexcharts-tooltip apexcharts-theme-light">
                                             <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                             <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                <span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 81, 110);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                   <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                   <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                   <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                             <div class="apexcharts-yaxistooltip-text"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="list-group-item-action br-t-1 list-group-item">
                     <div class="media mt-0">
                        <img class="avatar-lg rounded-circle my-auto mr-3" src="{{ asset('public/assets/images/chartimg3.jpg') }}" alt="Image description">
                        <div class="media-body">
                           <div class="d-sm-flex align-items-center">
                              <div class="mt-1">
                                 <h5 class="mb-1 tx-15">Gabe Lackmen</h5>
                                 <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-danger ms-2">Pending</span></p>
                              </div>
                              <span class="ml-auto wd-45p fs-16 mt-2">
                                 <div id="chart">
                                    <div class="wd-100p" style="min-height: 30px;">
                                       <div id="apexchartsspark3" class="apexcharts-canvas apexchartsspark3 apexcharts-theme-light" style="width: 196px; height: 30px;">
                                          <svg id="SvgjsSvg2285" width="196" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                             <g id="SvgjsG2287" class="apexcharts-inner apexcharts-graphical" transform="translate(50, 10)">
                                                <defs id="SvgjsDefs2286">
                                                   <clipPath id="gridRectMaska65z74vq">
                                                      <rect id="SvgjsRect2292" width="152" height="12" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <clipPath id="forecastMaska65z74vq"></clipPath>
                                                   <clipPath id="nonForecastMaska65z74vq"></clipPath>
                                                   <clipPath id="gridRectMarkerMaska65z74vq">
                                                      <rect id="SvgjsRect2293" width="150" height="14" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <filter id="SvgjsFilter2299" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%">
                                                      <feFlood id="SvgjsFeFlood2300" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood2300Out" in="SourceGraphic"></feFlood>
                                                      <feComposite id="SvgjsFeComposite2301" in="SvgjsFeFlood2300Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2301Out"></feComposite>
                                                      <feOffset id="SvgjsFeOffset2302" dx="1" dy="1" result="SvgjsFeOffset2302Out" in="SvgjsFeComposite2301Out"></feOffset>
                                                      <feGaussianBlur id="SvgjsFeGaussianBlur2303" stdDeviation="1 " result="SvgjsFeGaussianBlur2303Out" in="SvgjsFeOffset2302Out"></feGaussianBlur>
                                                      <feBlend id="SvgjsFeBlend2304" in="SourceGraphic" in2="SvgjsFeGaussianBlur2303Out" mode="normal" result="SvgjsFeBlend2304Out"></feBlend>
                                                   </filter>
                                                </defs>
                                                <line id="SvgjsLine2291" x1="0" y1="0" x2="0" y2="10" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="10" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG2316" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                   <g id="SvgjsG2317" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG2305" class="apexcharts-grid">
                                                   <g id="SvgjsG2306" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                      <line id="SvgjsLine2310" x1="0" y1="2.5" x2="146" y2="2.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2311" x1="0" y1="5" x2="146" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2312" x1="0" y1="7.5" x2="146" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   </g>
                                                   <g id="SvgjsG2307" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                   <line id="SvgjsLine2315" x1="0" y1="10" x2="146" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                   <line id="SvgjsLine2314" x1="0" y1="1" x2="0" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG2294" class="apexcharts-line-series apexcharts-plot-series">
                                                   <g id="SvgjsG2295" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                      <path id="SvgjsPath2298" d="M 0 4.125C 5.677777777777777 4.125 10.544444444444444 4.375 16.22222222222222 4.375C 21.9 4.375 26.766666666666666 0.75 32.44444444444444 0.75C 38.12222222222222 0.75 42.988888888888894 6 48.66666666666667 6C 54.34444444444445 6 59.21111111111111 3 64.88888888888889 3C 70.56666666666666 3 75.43333333333334 6.125 81.11111111111111 6.125C 86.78888888888889 6.125 91.65555555555557 4.5 97.33333333333334 4.5C 103.01111111111112 4.5 107.87777777777778 5.875 113.55555555555556 5.875C 119.23333333333333 5.875 124.1 4.375 129.77777777777777 4.375C 135.45555555555555 4.375 140.32222222222222 7.625 146 7.625" fill="none" fill-opacity="1" stroke="rgba(40,185,138,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaska65z74vq)" filter="url(#SvgjsFilter2299)" pathTo="M 0 4.125C 5.677777777777777 4.125 10.544444444444444 4.375 16.22222222222222 4.375C 21.9 4.375 26.766666666666666 0.75 32.44444444444444 0.75C 38.12222222222222 0.75 42.988888888888894 6 48.66666666666667 6C 54.34444444444445 6 59.21111111111111 3 64.88888888888889 3C 70.56666666666666 3 75.43333333333334 6.125 81.11111111111111 6.125C 86.78888888888889 6.125 91.65555555555557 4.5 97.33333333333334 4.5C 103.01111111111112 4.5 107.87777777777778 5.875 113.55555555555556 5.875C 119.23333333333333 5.875 124.1 4.375 129.77777777777777 4.375C 135.45555555555555 4.375 140.32222222222222 7.625 146 7.625" pathFrom="M -1 10 L -1 10 L 16.22222222222222 10 L 32.44444444444444 10 L 48.66666666666667 10 L 64.88888888888889 10 L 81.11111111111111 10 L 97.33333333333334 10 L 113.55555555555556 10 L 129.77777777777777 10 L 146 10" fill-rule="evenodd"></path>
                                                      <g id="SvgjsG2296" class="apexcharts-series-markers-wrap" data:realIndex="0">
                                                         <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle2334" r="0" cx="0" cy="0" class="apexcharts-marker wcbtgswibf no-pointer-events" stroke="#ffffff" fill="#28b98a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                         </g>
                                                      </g>
                                                   </g>
                                                   <g id="SvgjsG2297" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <g id="SvgjsG2308" class="apexcharts-grid-borders" style="display: none;">
                                                   <line id="SvgjsLine2309" x1="0" y1="0" x2="146" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   <line id="SvgjsLine2313" x1="0" y1="10" x2="146" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG2331" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG2332" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG2333" class="apexcharts-point-annotations"></g>
                                             </g>
                                             <rect id="SvgjsRect2290" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                             <g id="SvgjsG2328" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                             <g id="SvgjsG2288" class="apexcharts-annotations"></g>
                                          </svg>
                                          <div class="apexcharts-legend" style="max-height: 15px;"></div>
                                          <div class="apexcharts-tooltip apexcharts-theme-light">
                                             <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                             <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                <span class="apexcharts-tooltip-marker" style="background-color: rgb(40, 185, 138);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                   <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                   <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                   <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                             <div class="apexcharts-yaxistooltip-text"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="list-group-item-action br-t-1 list-group-item">
                     <div class="media mt-0">
                        <img class="avatar-lg rounded-circle my-auto mr-3" src="{{ asset('public/assets/images/chartimg4.jpg') }}" alt="Image description">
                        <div class="media-body">
                           <div class="d-sm-flex align-items-center">
                              <div class="mt-1">
                                 <h5 class="mb-1 tx-15">Manuel Labor</h5>
                                 <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-success ms-2">Paid</span></p>
                              </div>
                              <span class="ml-auto wd-45p fs-16 mt-2">
                                 <div id="chart">
                                    <div class="wd-100p" style="min-height: 30px;">
                                       <div id="apexchartsspark4" class="apexcharts-canvas apexchartsspark4 apexcharts-theme-light" style="width: 196px; height: 30px;">
                                          <svg id="SvgjsSvg2336" width="196" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                             <g id="SvgjsG2338" class="apexcharts-inner apexcharts-graphical" transform="translate(50, 10)">
                                                <defs id="SvgjsDefs2337">
                                                   <clipPath id="gridRectMask8512l1qy">
                                                      <rect id="SvgjsRect2343" width="152" height="12" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <clipPath id="forecastMask8512l1qy"></clipPath>
                                                   <clipPath id="nonForecastMask8512l1qy"></clipPath>
                                                   <clipPath id="gridRectMarkerMask8512l1qy">
                                                      <rect id="SvgjsRect2344" width="150" height="14" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <filter id="SvgjsFilter2350" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%">
                                                      <feFlood id="SvgjsFeFlood2351" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood2351Out" in="SourceGraphic"></feFlood>
                                                      <feComposite id="SvgjsFeComposite2352" in="SvgjsFeFlood2351Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2352Out"></feComposite>
                                                      <feOffset id="SvgjsFeOffset2353" dx="1" dy="1" result="SvgjsFeOffset2353Out" in="SvgjsFeComposite2352Out"></feOffset>
                                                      <feGaussianBlur id="SvgjsFeGaussianBlur2354" stdDeviation="1 " result="SvgjsFeGaussianBlur2354Out" in="SvgjsFeOffset2353Out"></feGaussianBlur>
                                                      <feBlend id="SvgjsFeBlend2355" in="SourceGraphic" in2="SvgjsFeGaussianBlur2354Out" mode="normal" result="SvgjsFeBlend2355Out"></feBlend>
                                                   </filter>
                                                </defs>
                                                <line id="SvgjsLine2342" x1="0" y1="0" x2="0" y2="10" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="10" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG2367" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                   <g id="SvgjsG2368" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG2356" class="apexcharts-grid">
                                                   <g id="SvgjsG2357" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                      <line id="SvgjsLine2361" x1="0" y1="2.5" x2="146" y2="2.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2362" x1="0" y1="5" x2="146" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2363" x1="0" y1="7.5" x2="146" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   </g>
                                                   <g id="SvgjsG2358" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                   <line id="SvgjsLine2366" x1="0" y1="10" x2="146" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                   <line id="SvgjsLine2365" x1="0" y1="1" x2="0" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG2345" class="apexcharts-line-series apexcharts-plot-series">
                                                   <g id="SvgjsG2346" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                      <path id="SvgjsPath2349" d="M 0 8.125C 5.677777777777777 8.125 10.544444444444444 0.625 16.22222222222222 0.625C 21.9 0.625 26.766666666666666 4.125 32.44444444444444 4.125C 38.12222222222222 4.125 42.988888888888894 1.875 48.66666666666667 1.875C 54.34444444444445 1.875 59.21111111111111 8.25 64.88888888888889 8.25C 70.56666666666666 8.25 75.43333333333334 6 81.11111111111111 6C 86.78888888888889 6 91.65555555555557 7.625 97.33333333333334 7.625C 103.01111111111112 7.625 107.87777777777778 3.25 113.55555555555556 3.25C 119.23333333333333 3.25 124.1 4.5 129.77777777777777 4.5C 135.45555555555555 4.5 140.32222222222222 2.375 146 2.375" fill="none" fill-opacity="1" stroke="rgba(244,136,70,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask8512l1qy)" filter="url(#SvgjsFilter2350)" pathTo="M 0 8.125C 5.677777777777777 8.125 10.544444444444444 0.625 16.22222222222222 0.625C 21.9 0.625 26.766666666666666 4.125 32.44444444444444 4.125C 38.12222222222222 4.125 42.988888888888894 1.875 48.66666666666667 1.875C 54.34444444444445 1.875 59.21111111111111 8.25 64.88888888888889 8.25C 70.56666666666666 8.25 75.43333333333334 6 81.11111111111111 6C 86.78888888888889 6 91.65555555555557 7.625 97.33333333333334 7.625C 103.01111111111112 7.625 107.87777777777778 3.25 113.55555555555556 3.25C 119.23333333333333 3.25 124.1 4.5 129.77777777777777 4.5C 135.45555555555555 4.5 140.32222222222222 2.375 146 2.375" pathFrom="M -1 10 L -1 10 L 16.22222222222222 10 L 32.44444444444444 10 L 48.66666666666667 10 L 64.88888888888889 10 L 81.11111111111111 10 L 97.33333333333334 10 L 113.55555555555556 10 L 129.77777777777777 10 L 146 10" fill-rule="evenodd"></path>
                                                      <g id="SvgjsG2347" class="apexcharts-series-markers-wrap" data:realIndex="0">
                                                         <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle2385" r="0" cx="0" cy="0" class="apexcharts-marker wpzebefjy no-pointer-events" stroke="#ffffff" fill="#f48846" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                         </g>
                                                      </g>
                                                   </g>
                                                   <g id="SvgjsG2348" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <g id="SvgjsG2359" class="apexcharts-grid-borders" style="display: none;">
                                                   <line id="SvgjsLine2360" x1="0" y1="0" x2="146" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   <line id="SvgjsLine2364" x1="0" y1="10" x2="146" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG2382" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG2383" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG2384" class="apexcharts-point-annotations"></g>
                                             </g>
                                             <rect id="SvgjsRect2341" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                             <g id="SvgjsG2379" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                             <g id="SvgjsG2339" class="apexcharts-annotations"></g>
                                          </svg>
                                          <div class="apexcharts-legend" style="max-height: 15px;"></div>
                                          <div class="apexcharts-tooltip apexcharts-theme-light">
                                             <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                             <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                <span class="apexcharts-tooltip-marker" style="background-color: rgb(244, 136, 70);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                   <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                   <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                   <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                             <div class="apexcharts-yaxistooltip-text"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="list-group-item-action br-t-1 br-br-7 br-bl-7 list-group-item">
                     <div class="media mt-0">
                        <img class="avatar-lg rounded-circle my-auto mr-3" src="{{ asset('public/assets/images/chartimg5.jpg') }}" alt="Image description">
                        <div class="media-body">
                           <div class="d-sm-flex align-items-center">
                              <div class="mt-1">
                                 <h5 class="mb-1 tx-15">Sharon Needles</h5>
                                 <p class="b-0 tx-13 text-muted mb-0">User ID: #1234<span class="text-success ms-2">Paid</span></p>
                              </div>
                              <span class="ml-auto wd-45p fs-16 mt-2">
                                 <div id="chart">
                                    <div class="wd-100p" style="min-height: 30px;">
                                       <div id="apexchartsspark5" class="apexcharts-canvas apexchartsspark5 apexcharts-theme-light" style="width: 196px; height: 30px;">
                                          <svg id="SvgjsSvg2387" width="196" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                             <g id="SvgjsG2389" class="apexcharts-inner apexcharts-graphical" transform="translate(50, 10)">
                                                <defs id="SvgjsDefs2388">
                                                   <clipPath id="gridRectMaskkdl3pr1if">
                                                      <rect id="SvgjsRect2394" width="152" height="12" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <clipPath id="forecastMaskkdl3pr1if"></clipPath>
                                                   <clipPath id="nonForecastMaskkdl3pr1if"></clipPath>
                                                   <clipPath id="gridRectMarkerMaskkdl3pr1if">
                                                      <rect id="SvgjsRect2395" width="150" height="14" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                   </clipPath>
                                                   <filter id="SvgjsFilter2401" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%">
                                                      <feFlood id="SvgjsFeFlood2402" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood2402Out" in="SourceGraphic"></feFlood>
                                                      <feComposite id="SvgjsFeComposite2403" in="SvgjsFeFlood2402Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2403Out"></feComposite>
                                                      <feOffset id="SvgjsFeOffset2404" dx="1" dy="1" result="SvgjsFeOffset2404Out" in="SvgjsFeComposite2403Out"></feOffset>
                                                      <feGaussianBlur id="SvgjsFeGaussianBlur2405" stdDeviation="1 " result="SvgjsFeGaussianBlur2405Out" in="SvgjsFeOffset2404Out"></feGaussianBlur>
                                                      <feBlend id="SvgjsFeBlend2406" in="SourceGraphic" in2="SvgjsFeGaussianBlur2405Out" mode="normal" result="SvgjsFeBlend2406Out"></feBlend>
                                                   </filter>
                                                </defs>
                                                <line id="SvgjsLine2393" x1="0" y1="0" x2="0" y2="10" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="10" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <g id="SvgjsG2418" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                   <g id="SvgjsG2419" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                                </g>
                                                <g id="SvgjsG2407" class="apexcharts-grid">
                                                   <g id="SvgjsG2408" class="apexcharts-gridlines-horizontal" style="display: none;">
                                                      <line id="SvgjsLine2412" x1="0" y1="2.5" x2="146" y2="2.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2413" x1="0" y1="5" x2="146" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                      <line id="SvgjsLine2414" x1="0" y1="7.5" x2="146" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   </g>
                                                   <g id="SvgjsG2409" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                                   <line id="SvgjsLine2417" x1="0" y1="10" x2="146" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                   <line id="SvgjsLine2416" x1="0" y1="1" x2="0" y2="10" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG2396" class="apexcharts-line-series apexcharts-plot-series">
                                                   <g id="SvgjsG2397" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0">
                                                      <path id="SvgjsPath2400" d="M 0 8.5C 5.677777777777777 8.5 10.544444444444444 6.875 16.22222222222222 6.875C 21.9 6.875 26.766666666666666 0.5 32.44444444444444 0.5C 38.12222222222222 0.5 42.988888888888894 5.625 48.66666666666667 5.625C 54.34444444444445 5.625 59.21111111111111 7.875 64.88888888888889 7.875C 70.56666666666666 7.875 75.43333333333334 4.625 81.11111111111111 4.625C 86.78888888888889 4.625 91.65555555555557 8.75 97.33333333333334 8.75C 103.01111111111112 8.75 107.87777777777778 6.75 113.55555555555556 6.75C 119.23333333333333 6.75 124.1 1.375 129.77777777777777 1.375C 135.45555555555555 1.375 140.32222222222222 6.125 146 6.125" fill="none" fill-opacity="1" stroke="rgba(103,58,183,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskkdl3pr1if)" filter="url(#SvgjsFilter2401)" pathTo="M 0 8.5C 5.677777777777777 8.5 10.544444444444444 6.875 16.22222222222222 6.875C 21.9 6.875 26.766666666666666 0.5 32.44444444444444 0.5C 38.12222222222222 0.5 42.988888888888894 5.625 48.66666666666667 5.625C 54.34444444444445 5.625 59.21111111111111 7.875 64.88888888888889 7.875C 70.56666666666666 7.875 75.43333333333334 4.625 81.11111111111111 4.625C 86.78888888888889 4.625 91.65555555555557 8.75 97.33333333333334 8.75C 103.01111111111112 8.75 107.87777777777778 6.75 113.55555555555556 6.75C 119.23333333333333 6.75 124.1 1.375 129.77777777777777 1.375C 135.45555555555555 1.375 140.32222222222222 6.125 146 6.125" pathFrom="M -1 10 L -1 10 L 16.22222222222222 10 L 32.44444444444444 10 L 48.66666666666667 10 L 64.88888888888889 10 L 81.11111111111111 10 L 97.33333333333334 10 L 113.55555555555556 10 L 129.77777777777777 10 L 146 10" fill-rule="evenodd"></path>
                                                      <g id="SvgjsG2398" class="apexcharts-series-markers-wrap" data:realIndex="0">
                                                         <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle2436" r="0" cx="0" cy="0" class="apexcharts-marker wuzopfkah no-pointer-events" stroke="#ffffff" fill="#673ab7" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                         </g>
                                                      </g>
                                                   </g>
                                                   <g id="SvgjsG2399" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                </g>
                                                <g id="SvgjsG2410" class="apexcharts-grid-borders" style="display: none;">
                                                   <line id="SvgjsLine2411" x1="0" y1="0" x2="146" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                   <line id="SvgjsLine2415" x1="0" y1="10" x2="146" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG2433" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG2434" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG2435" class="apexcharts-point-annotations"></g>
                                             </g>
                                             <rect id="SvgjsRect2392" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                             <g id="SvgjsG2430" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                             <g id="SvgjsG2390" class="apexcharts-annotations"></g>
                                          </svg>
                                          <div class="apexcharts-legend" style="max-height: 15px;"></div>
                                          <div class="apexcharts-tooltip apexcharts-theme-light">
                                             <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                             <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                <span class="apexcharts-tooltip-marker" style="background-color: rgb(103, 58, 183);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                   <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                   <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                   <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                             <div class="apexcharts-yaxistooltip-text"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-12 col-lg-6 col-xl-4 col-lg-6 col-md-12">
         <div class="card">
            <div class="pb-1 card-header">
               <h3 class="mb-2 card-title">Sales Activity</h3>
               <p class="tx-12 mb-0 text-muted">Sales activities are the tactics that salespeople use to achieve their goals and objective</p>
            </div>
            <div class="product-timeline pt-2 mt-1 pl-0 pr-0 card-body">
               <ul class="timeline-1 mb-0">
                  <li class="mt-0 ">
                     <i class="fal fa-shopping-cart"></i><i class="fas fa-chart-pie-alt bg-primary-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Total Products</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">3 days ago</a>
                     <p class="mb-0 text-muted tx-12">1.3k New Products</p>
                  </li>
                  <li class="mt-0">
                     <i class="fal fa-shopping-cart bg-danger-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Total Sales</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">35 mins ago</a>
                     <p class="mb-0 text-muted tx-12">1k New Sales</p>
                  </li>
                  <li class="mt-0">
                     <i class="fas fa-chart-bar bg-success-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Toatal Revenue</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">50 mins ago</a>
                     <p class="mb-0 text-muted tx-12">23.5K New Revenue</p>
                  </li>
                  <li class="mt-0">
                     <i class="far fa-wallet bg-warning-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Toatal Profit</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">1 hour ago</a>
                     <p class="mb-0 text-muted tx-12">3k New profit</p>
                  </li>
                  <li class="mt-0">
                     <i class="fas fa-eye bg-purple-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Customer Visits</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">1 day ago</a>
                     <p class="mb-0 text-muted tx-12">15% increased</p>
                  </li>
                  <li class="mt-0 mb-0">
                     <i class="far fa-edit bg-primary-gradient text-white product-icon"></i> <span class="mb-4 tx-14">Customer Reviews</span> <a class="float-right tx-11 text-muted" href="/valex/preview/indexpage/">1 day ago</a>
                     <p class="mb-0 text-muted tx-12">1.5k reviews</p>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-12 col-lg-6 col-xl-4 col-lg-6 col-md-12">
         <div class="card">
            <div class="pb-0 card-header">
               <h3 class="mb-2 card-title">Recent Orders</h3>
               <p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage firm to purchase or sell</p>
            </div>
            <div class="sales-info ot-0 pb-0 pt-0 card-body">
               <div id="chart" class="recent_order">
                  <div style="min-height: 169.383px;">
                     <div id="apexchartscymyw6zq" class="apexcharts-canvas apexchartscymyw6zq apexcharts-theme-light" style="width: 491px; height: 169.383px;">
                        <svg id="SvgjsSvg2473" width="491" height="169.38333129882812" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                           <g id="SvgjsG2475" class="apexcharts-inner apexcharts-graphical" transform="translate(156, 0)">
                              <defs id="SvgjsDefs2474">
                                 <clipPath id="gridRectMaskcymyw6zq">
                                    <rect id="SvgjsRect2477" width="187" height="205" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <clipPath id="forecastMaskcymyw6zq"></clipPath>
                                 <clipPath id="nonForecastMaskcymyw6zq"></clipPath>
                                 <clipPath id="gridRectMarkerMaskcymyw6zq">
                                    <rect id="SvgjsRect2478" width="185" height="207" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                 </clipPath>
                                 <linearGradient id="SvgjsLinearGradient2483" x1="1" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop2484" stop-opacity="1" stop-color="rgba(NaN,1)" offset="0"></stop>
                                    <stop id="SvgjsStop2485" stop-opacity="1" stop-color="rgba(236,240,250,1)" offset="1"></stop>
                                    <stop id="SvgjsStop2486" stop-opacity="1" stop-color="rgba(236,240,250,1)" offset="1"></stop>
                                 </linearGradient>
                                 <linearGradient id="SvgjsLinearGradient2494" x1="1" y1="0" x2="0" y2="1">
                                    <stop id="SvgjsStop2495" stop-opacity="1" stop-color="rgba(NaN,1)" offset="0"></stop>
                                    <stop id="SvgjsStop2496" stop-opacity="1" stop-color="rgba(0,71,170,1)" offset="1"></stop>
                                    <stop id="SvgjsStop2497" stop-opacity="1" stop-color="rgba(0,71,170,1)" offset="1"></stop>
                                 </linearGradient>
                              </defs>
                              <g id="SvgjsG2479" class="apexcharts-radialbar">
                                 <g id="SvgjsG2480">
                                    <g id="SvgjsG2481" class="apexcharts-tracks">
                                       <g id="SvgjsG2482" class="apexcharts-radialbar-track apexcharts-track" rel="1">
                                          <path id="apexcharts-radialbarTrack-0" d="M 52.3636617097865 128.6363382902135 A 53.9329268292683 53.9329268292683 0 1 1 128.6363382902135 128.6363382902135" fill="none" fill-opacity="1" stroke="rgba(236,240,250,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="12.458536585365856" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 52.3636617097865 128.6363382902135 A 53.9329268292683 53.9329268292683 0 1 1 128.6363382902135 128.6363382902135"></path>
                                       </g>
                                    </g>
                                    <g id="SvgjsG2488">
                                       <g id="SvgjsG2493" class="apexcharts-series apexcharts-radial-series" seriesName="" rel="1" data:realIndex="0">
                                          <path id="SvgjsPath2498" d="M 52.3636617097865 128.6363382902135 A 53.9329268292683 53.9329268292683 0 1 1 144.4247125832822 89.55874064062334" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient2494)" stroke-opacity="1" stroke-linecap="butt" stroke-width="15.573170731707318" stroke-dasharray="4" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="224" data:value="83" index="0" j="0" data:pathOrig="M 52.3636617097865 128.6363382902135 A 53.9329268292683 53.9329268292683 0 1 1 144.4247125832822 89.55874064062334"></path>
                                       </g>
                                       <circle id="SvgjsCircle2489" r="42.703658536585365" cx="90.5" cy="90.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle>
                                       <g id="SvgjsG2490" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;">
                                          <text id="SvgjsText2491" font-family="Helvetica, Arial, sans-serif" x="90.5" y="120.5" text-anchor="middle" dominant-baseline="auto" font-size="16px" font-weight="600" fill="#0047aa" class="apexcharts-text apexcharts-datalabel-label" style="font-family: Helvetica, Arial, sans-serif;"></text>
                                          <text id="SvgjsText2492" font-family="Helvetica, Arial, sans-serif" x="90.5" y="96.5" text-anchor="middle" dominant-baseline="auto" font-size="22px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-datalabel-value" style="font-family: Helvetica, Arial, sans-serif;">83%</text>
                                       </g>
                                    </g>
                                 </g>
                              </g>
                           </g>
                           <g id="SvgjsG2476" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend"></div>
                     </div>
                  </div>
               </div>
               <div class="sales-infomation pb-0 mb-0 mx-auto wd-100p justify-content-center row">
                  <div class="col-md-6">
                     <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Delivered</p>
                     <h3 class="mb-1">5238</h3>
                     <div class="">
                        <p class="text-muted ">Last 6 months</p>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Cancelled</p>
                     <h3 class="mb-1">3467</h3>
                     <div class="">
                        <p class="text-muted">Last 6 months</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="d-flex align-items-center pb-2">
                        <p class="mb-0">Total Sales</p>
                     </div>
                     <h4 class="fw-bold mb-2">$7,590</h4>
                     <div class="progress-style progress-sm progress">
                        <div role="progressbar" class="progress-bar bg-primary" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                  </div>
                  <div class="mt-4 mt-md-0 col-md-6">
                     <div class="d-flex align-items-center pb-2">
                        <p class="mb-0">Active Users</p>
                     </div>
                     <h4 class="fw-bold mb-2">$5,460</h4>
                     <div class="progress-style progress-sm progress">
                        <div role="progressbar" class="progress-bar bg-danger" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

  var userData = {{json_encode($userdata)}}

  Highcharts.chart('container', {
    title: {
      text: 'User Growth'
    },


    xAxis: {
      categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
      ],
      
    },
    yAxis: {
      title: {
        text: 'Number of New Users'
      }
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },
    plotOptions: {
      series: {
        allowPointSelect: true
      }
    },
    series: [{
      name: 'New Users',
      data: userData
    }],
    responsive: {
      rules: [{
        condition: {
          maxWidth: 500
        },
        chartOptions: {
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
          }
        }
      }]
    }
  });
</script>
@endsection
