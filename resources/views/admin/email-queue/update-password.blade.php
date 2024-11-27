<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset password</title>
  <link rel="shortcut icon" href="{{ asset('public/frontend/assets/images/fav.png')}}" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/backend/dist/css/custom.css') }}">
  <link href="{{ asset('public/toastr.min.css') }}" rel="stylesheet" />
  <style type="text/css">
    .error {
    color: #e31612;
}
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}">
    <img src="{{ asset('public/backend/dist/img/logo1.png') }}" alt="Admin Logo" class="nav-logo2" >
  </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="text-center">
      <p class="login-box-msg pb-2">Reset password</p>
      <p class="mb-4">Please fill out your email. A link to reset password will be sent there.</p>
</div>
      <form method="POST" action="" class="formtheme">
      @csrf
    	<div class="panel panel-default">
		<div class="panel-body">
		<div class="form-group">
          <input type="password" name="password" value="{{ old('password') }}" placeholder="Password" class="form-control">
            	<span class="font-weight-bold text-danger">
                	@if($errors->has('password'))
                		{{ $errors->first('password') }}
                	@endif
                </span>
         </div>
        <div class="form-group">
         <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"placeholder="Confirm Password" class="form-control">
			<span class="font-weight-bold text-danger">
				@if($errors->has('confirm_password'))
            		{{ $errors->first('confirm_password') }}
            	@endif                	               		
             </span>      
        </div>
            <div class="form-group">
               <button type="submit" name="submit" class="btn btn-primary btn-block mt-3" >Update</button>       
            </div>
		</div>
	</div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script src="{{ asset('public/jquery.min.js') }}"></script>
<script src="{{ asset('public/toastr.min.js') }}"></script>
@include('flash-message')
<!-- jQuery -->
<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/backend/dist/js/adminlte.min.js') }}"></script>
</body>
</html>