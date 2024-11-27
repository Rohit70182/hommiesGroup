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
          <h2 class="text-center">Reset password</h2><br>
          <form method="POST" action="{{url('password-reset')}}/{{$token}}">
            @csrf
            @if(session('message'))
            <p class="alert alert-success">
              {{ session('message') }}
</p>
            @endif
            <div class="form-group">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Confirm Password</label>
              <div class="custom-password-field">
                <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" required>
                @error('confirm_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="eye-icons"><i class="fas fa-eye-slash" id="show_password" onclick="showPassword('password')"></i><i class="fas fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none"></i></div>

              </div>

            </div>
            <div class="form-button">
              <button type="submit" class="secondary-btn btn btn-bg  btn-lg w-100 mt-3">
                Reset
              </button>
            </div>
            <div class="form-scoial-hd">
              <h2>
                Or Login With
              </h2>
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
              <p>©Copyright <a href="/remak-yii2-1644/">demo-service</a> | All Rights Reserved<a href="/remak-yii2-1644/"></a></p>
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