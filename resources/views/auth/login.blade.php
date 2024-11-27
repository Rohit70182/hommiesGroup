@extends('layouts.app')

@section('content')
<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('public/assets/css/pages-css/autn.css') }}" />
<link rel="stylesheet" href="{{ 'resources/css/app.css'}}" />

<!-- Style Css -->

<section class="autn-form sec-ptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="site-logo">
          <a class="navbar-brand" href="{{url('/')}}">
            <h1>demo-service</h1>
          </a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-xl-6">
        <div class="user-form-card">
          <h2 class="text-center">Log In To Continue</h2><br>
          <form method="POST" action="{{url('/sign-in')}}">
            @csrf
            @if(session('message'))
            <p class="alert alert-success">
              {{ session('message') }}
            </p>
            @endif
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required autocomplete="email" autofocus>
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="custom-password-field">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" required autocomplete="current-password">
                   @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
                <div class="eye-icons"><i class="fas fa-eye-slash" id="show_password" onclick="showPassword('password')"></i><i class="fas fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none"></i></div>
              
              </div>
<!--               <div class="form-group mt-3"> -->
<!--               	<span class="float-left"> -->
<!--               		<input type="checkbox" value="lsRememberMe" id="rememberMe"> -->
<!--                   <label for="rememberMe">Remember me</label> -->
<!--               	</span> -->
<!--               	<span class="float-right"><a href="{{url('/login')}}">Forgot Password?</a></span> -->
<!--               </div> -->

            </div>
            @if($errors->any())
            <div class="invalid-feedback">{{ $errors->first() }}</div>
            @endif
            <div class="row form-group">

              <div class="col-sm-6 text-sm-right mt-sm-0 mt-10">
                @if (Route::has('password.request'))
                <a class="" href="{{ route('password.request') }}">
                  {{ __('Forgot Your Password?') }}
                </a>
                @endif
              </div>
            </div>
            <div class="form-button">
              <button type="submit" class="secondary-btn btn btn-bg  btn-lg w-100 mt-3">
                {{ __('Log In') }}
              </button>
            </div>
            <div class="form-scoial-hd">
              <h2>
                Or Log In With
              </h2>
            </div>
            <div class="form-social-media">
              <ul class="social-link">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" ><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="#" ><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </form>
          <div class="user-form-remind text-center">
<!--             <p class="mb-0">Don't have any account? <a href="#">SignUp </a> here</p> -->

          </div>
          <div class="login-copyright-menu text-center">
            <ul>
              <li><a class="text-dark" style="color: #6759ff !important;" href="{{url('/terms')}}">Terms &amp; Conditions</a></li>
              <li>|</li>
              <li><a class="text-dark" style="color: #6759ff !important;" href="{{url('/privacy')}}">Privacy Policy</a></li><br>
              <li>
                <p>©Copyright <a href="/remak-yii2-1644/">demo-service</a>  All Rights Reserved<a href="/remak-yii2-1644/"></a></p>
			<li><br>
			 <li>
				<p><a target="_blank" class="resrved-btn" href="/remak-yii2-1644/"> Powered By demo-service</a></p>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  function showPassword(id) {
    $("#" + id).attr('type', 'text');
    $("#hide_" + id).show();
    $("#show_" + id).hide();
  }

  function hidePassword(id) {
    $("#" + id).attr('type', 'password');
    $("#hide_" + id).hide();
    $("#show_" + id).show();
  }
</script>
@endsection
