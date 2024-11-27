@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('public/assets/css/pages-css/autn.css') }}" />
<link rel="stylesheet" href="{{ 'resources/css/app.css'}}" />
<!-- Style Css -->
<style>
  .form-data div {
    position: absolute;
    right: 42px;
    top: 43px;
    font-size: 18px;
    color: #212529;
  }
</style>
<div>
  <section class="autn-form sec-ptb registration-form">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
          <div class="user-form-card">
            <div class="user-form-title">
            </div>
            <h2 class="text-center">SignUp Here</h2><br>
            <form method="post" action="{{url('/register/signup')}}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="form-group col-lg-6 col-md-12">
                  <label>First Name:</label>
                  <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                  {!!$errors->first("first_name", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label>Last Name:</label>
                  <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                  {!!$errors->first("last_name", "<span class='text-danger'>:message</span>")!!}
                </div>

                <div class="form-group col-lg-6 col-md-12">
                  <label>Email:</label>
                  <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                  {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                </div>

                <div class="form-group form-data col-lg-6 col-md-12">
                  <label>Password:</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                  <div class="eye-icons"><i class="fas fa-eye-slash" id="show_password" onclick="showPassword('password')"></i><i class="fas fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none"></i></div>
                  {!!$errors->first("password", "<span class='text-danger'>:message</span>")!!}
                </div>

                <div class="form-group col-lg-12">
                  <label>Profile Photo:</label>
                  <input type="file" class="form-control" name="image">
                </div>
                <button type="submit" class="secondary-btn btn btn-bg  btn-lg w-100 mt-3">
                  {{ __('Submit') }}
                </button>
                <div class="register-form-remind text-center">
                  <p class="mb-0">Already have a account <a class="nav-link btn haveacc-btn" href="{{url('/login')}}">Login </a> here.</p>
                </div>
                <div class="login-copyright-menu text-center">
                  <ul>
                    <li><a class="text-dark" href="{{url('terms')}}">Terms &amp; Conditions</a></li>
                    <li>|</li>
                    <li><a class="text-dark" href="{{url('privacy')}}">Privacy &amp; Policy</a></li>
                    <li>|</li>
                    <li>
                      <p>© 2022 <a href="/remak-yii2-1644/"></a> All Rights
                        Reserved. Powered By <a target="_blank" class="resrved-btn" href="#">Rohit</a>
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
            </form>
            @endsection
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