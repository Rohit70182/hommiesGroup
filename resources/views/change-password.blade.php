@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Change Password</li>
    </ul>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">{{ __('Change Password') }}</h3>
                </div>

                <form action="{{ url('dashboard/change-password') }}" method="POST" enctype="multipart/form-data" id="change-password" class="pb-5">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col-md-6 forget-pass-field offset-md-3">
                                <div class="mb-3">
                                <div class="form-group">
                                    <label for="newPasswordInput" class="form-label">New Password</label>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="eye-icon-show-hide" >
                                        <i class="fa fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none;"></i>
                                        <i class="fa fa-eye-slash" id="show_password" onclick="showPassword('password')"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6  offset-md-3">
                                <div class="mb-3">
                                <div class="form-group">
                                    <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                    <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="2password" placeholder="Confirm New Password">
                                     @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="eye-icon-show-hide" >
                                        <i class="fa fa-eye" id="2hide_password" onclick="hidePassword2('password')" style="display:none;"></i>
                                        <i class="fa fa-eye-slash" id="2show_password" onclick="showPassword2('password')"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6  offset-md-3">
                                <div class="form-group text-center">
                                    <button class="btn btn-bg mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
  
  function showPassword2(id) {
    $("#2" + id).attr('type', 'text');
    $("#2hide_" + id).show();
    $("#2show_" + id).hide();
  }

  function hidePassword2(id) {
    $("#2" + id).attr('type', 'password');
    $("#2hide_" + id).hide();
    $("#2show_" + id).show();
  }
</script>
@endsection

@push('scripts')
<link href="/public/assets/css/select2.min.css" rel="stylesheet" />
<script src="/public/assets/js/select2.min.js"></script>
<script type="text/javascript">
   
    
    
jQuery( document ).ready(function( $ ) 
{
 jQuery('#change-password').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: {
     password: {
        required: true, 
      }, 
     password_confirmation: {    
        required: true,
        equalTo: "#password"
      },
      
      },
    messages: {
      password: {
        required: "The Password is required."
      }, 
      password_confirmation: {
        required: "The Confirm Password is required."
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      jQuery(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      jQuery(element).removeClass('is-invalid');
    }
  });
});
</script>



@endpush