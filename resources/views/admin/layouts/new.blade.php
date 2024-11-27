<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <!-- Metas -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="@ozvidtech">
  <!-- Title  -->
  <title>{{ config('app.name', 'Laravel Base') }}</title>
  <!-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> -->
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('public/assets/images/fav.ico') }}" />
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/bootstrap.min.css') }}">
  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/helpers-plugin.css') }}" />
  <!-- Style Css -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/theme-style.css') }}" />
  <!-- fontawesome Css -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/fonts/fontawesome/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/assets/toastr.min.css') }}" />
  <!-- Scripts -->
  <meta name="app_url" content="{{url('')}}" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <style type="text/css">
    .invalid-feedback {
      display: block;
    }
  </style>
  @stack('styles')


</head>

<body class="">
  <!-- Start Page Wrapper -->
  <main class="page-wrapper">

    <!-- Sidebar Content -->
    @include('admin.layouts.sidebar')
    <!-- Sidebar Content -->
    <!-- Page Content -->
    <div id="content-wrapper">
      <div class="page-header">
        <button id="nav-icon2" class="navbar-toggler mr-20 d-xl-none" type="button" data-toggle="collapse" data-target="#sidebar-nav" aria-controls="sidebar-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span></span><span></span><span></span><span></span><span></span><span></span>
        </button>
        <a class="SideBarToggler btn btn-link mr-20 d-none d-xl-block" href="javascript:void(0);">
          <span></span><span></span><span></span><span></span><span></span><span></span>
        </a>
        <h6 class="font_600 font-20 d-none d-sm-block ThemeColor">@yield('template_title')</h6>
        <div class="NotiSearchProfile">
          @include('admin.layouts.header')

        </div>
      </div>
      <div class="content-main">
       
        
    
        @yield('content')
      </div>
      @include('admin.layouts.footer')
    </div>
    <!-- Page Content -->
  </main>
  <script src="{{ asset('public/js/jquery.js') }}"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="{{ asset('public/dashboard-assets/js/common.js') }}"></script>
  <script src="{{ asset('public/assets/toastr.min.js') }}"></script>
  <!-- bootstrap JS -->
  <script src="{{ asset('public/dashboard-assets/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Animation -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/plugins/animation/animate.min.css') }}" />
  <script src="{{ asset('public/dashboard-assets/plugins/animation/wow.min.js') }}"></script>
<!--   <script type="text/javascript" src="{{ asset('Modules/Notification/Resources/views/ajax.js') }}"></script> -->
  @stack('scripts')
  @if (session('success'))

        <script>
        	toastr.success(' ', "{{ session('success') }}")
        </script>
        
        @endif
</body>

</html>