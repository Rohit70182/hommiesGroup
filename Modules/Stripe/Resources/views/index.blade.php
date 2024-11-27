@extends('admin.layouts.app')

@section('content')

<div class="dash-home-cards">
    <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-md-2 row-cols-1 top-cards">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
            <div class="card">
                <a class="card-body" href="{{url('/stripe/cards')}}">
                    <p class="cart-title">Cards</p>
                    <div class="card-results">
                        <h5 class="main-results"></h5>
                        <p class="perstant-result text-success"><i class=""></i> </p>
                    </div>
                </a>
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
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
            <div class="card">
                <a class="card-body" href="{{url('/stripe/payments')}}">
                    <p class="cart-title">Payments</p>
                    <div class="card-results">

                        <h5 class="main-results"></h5>

                        <p class="perstant-result text-success"><i class=""></i> </p>
                    </div>
                </a>
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
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/pages-css/index.css') }}" />
@endpush
@push('scripts')
@endpush