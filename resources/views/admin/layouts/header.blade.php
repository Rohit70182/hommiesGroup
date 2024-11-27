@if(Auth::check())
<div class="ProfileDrop">
    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{get_current_pic()}}" alt="">

        <span>{{ Auth::check() ?  \Auth::User()->name : ''}}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
<!--         <a class="dropdown-item" href="{{ url('/dashboard') }}"> -->
<!--             <i class="far fa-tachometer"></i> -->
<!--             <span>Dashboard</span> -->
<!--         </a> -->
        <a class="dropdown-item" href="{{ url('/dashboard/myprofile') }}">
            <i class="far fa-user"></i>
            <span>My Profile</span>
        </a>
        <a class="dropdown-item" href="{{ url('change-password') }}">
            <i class="far fa-lock"></i>
            <span>Change Password</span>
        </a>
        <a class="dropdown-item" href="{{url('dashboard/myprofile/edit/'.Auth::user()->id)}}">
            <i class="far fa-pencil"></i>
            <span>Profile Update</span>
        </a>

        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="far fa-sign-out"></i> <span>{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
@endif