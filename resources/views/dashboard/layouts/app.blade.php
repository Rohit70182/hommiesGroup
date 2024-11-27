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

  <!-- <script src="{{ asset('js/app.js') }}" defer></script>-->

  <!-- bootstrap JS -->
  <script src="{{ asset('public/dashboard-assets/js/jquery.slim.min.js') }}"></script>
  <script src="{{ asset('public/dashboard-assets/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Animation -->
  <link rel="stylesheet" href="{{ asset('public/dashboard-assets/plugins/animation/animate.min.css') }}" />
  <script src="{{ asset('public/dashboard-assets/plugins/animation/wow.min.js') }}"></script>


  <script src="{{asset('public/assets/js/jquery-3.6.0.js')}}"></script>

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
    @include('dashboard.layouts.sidebar')
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
        <h6 class="font_600 font-20 d-none d-sm-block ThemeColor">Dashboard</h6>
        <div class="NotiSearchProfile">

          <div class="NotiDrop">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="nav-notification-header d-flex flex-wrap  align-items-center">
                <h4 class="mr-auto pr-15 mb-0">Notification</h4>
                <a href="javascript:void(0);">Clear</a>
              </div>
              <ul class="ant-list-items">
                <li class="ant-list-item list-clickable">
                  <div class="d-flex flex-row align-items-center ">
                    <div class="pr-3">
                      <span class="ant-avatar ant-avatar-circle ant-avatar-image">
                        <img src="{{ asset('public/dashboard-assets/images/default-image.jpg') }}"></span>
                    </div>
                    <div class="mr-3">
                      <span class="font_600 text-dark">Erin Gonzales </span>
                      <span class="text-gray-light">has comment on your board</span>
                    </div>
                    <small class="ml-auto">7:57PM</small>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="SearchDrop d-lg-none">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="far fa-search"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <form class="HeaderSeach">
                <div class="form-group">
                  <i class="far fa-search"></i>
                  <input type="text" class="form-control">
                </div>
              </form>
            </div>
          </div>

          <div class="ProfileDrop">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{get_current_pic()}}" alt="">
              @if(Auth::check())
              <span>{{ Auth::User()->name}}</span>
              @endif
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              @if( Auth::check() && Auth::user()->role == 0)
              <a class="dropdown-item" href="{{ url('dashboard/myprofile') }}">
                @else
                <a class="dropdown-item" href="{{ url('dashboard/myprofile') }}">

                  @endif
                  <i class="far fa-user"></i>
                  <span>My Profile</span>
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="far fa-sign-out"></i> <span>{{ __('Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="content-main">
        @yield('content')
      </div>
      @include('dashboard.layouts.footer')
    </div>
    <!-- Page Content -->
  </main>
  <script src="{{ asset('public/dashboard-assets/js/common.js') }}"></script>
  <script src="{{ asset('public/assets/toastr.min.js') }}"></script>
  <script>
    window.Livewire.on('filechoosen', () => {
      let inputField = document.getElementById('uploadDP')
      let file = inputField.files[0]
      let render = new FileReader();
      render.onloadend = () => {
        window.livewire.emit('fileupload', render.result)
      }
      render.readAsDataURL(file);
    })
  </script>
  @stack('scripts')
</body>

</html>