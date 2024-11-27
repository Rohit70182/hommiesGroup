@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
    <li class="active">Add SMTP</li>
  </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add SMTP</h3>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <div class="card-body mt-1">
            <form method="post" action="{{url('smtp/store/')}}" id="smtp-add">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Title</label>
                  <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                  {!!$errors->first("title", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group col-md-3">
                  <label>Encryption Type</label>
                  <select name="encryption_type" class="form-control">
                    <option value="">Choose encryption</option>
                    <option value="0">None</option>
                    <option value="1">TLS</option>
                    <option value="2">SSL</option>
                  </select>
                  {!!$errors->first("Encryption_type", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group col-md-3">
                  <label>Type</label>
                  <select name="type" class="form-control">
                    <option value="">Choose type</option>
                    <option value="0">SMTP</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                  {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group col-md-6">
                  <label>Server </label>
                  <input type="text" value="{{ old('server') }}" name="server" class="form-control">
                  {!!$errors->first("server", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Password </label>
                  <input type="password" value="{{ old('password') }}" name="password" class="form-control">
                  {!!$errors->first("password", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group col-md-6">
                  <label>Port</label>
                  <input type="text" value="{{ old('port') }}" name="port" class="form-control">
                  {!!$errors->first("port", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>

              <div class="col-md-12 text-right">
                <input type="submit" class="btn btn-bg" name="Save" value="Submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    jQuery('#smtp-add').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        title: {
          required: true,
        },
        encryption_type: {
          required: true
        },
        type: {
          required: true,
        },
        email: {
          required: true,
        },
        server: {
          required: true
        },
        password: {
          required: true,
        },
        port: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "The title is required."
        },
        encryption_type: {
          required: "The encryption type is required."
        },
        type: {
          required: "The type is required."
        },
        email: {
          required: "The email is required."
        },
        server: {
          required: "The server is required."
        },
        password: {
          required: "The password is required."
        },
        port: {
          required: "The port is required."
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        jQuery(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        jQuery(element).removeClass('is-invalid');
      }
    });
  });
</script>
@endpush