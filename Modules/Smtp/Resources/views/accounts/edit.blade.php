@extends('admin.layouts.app')
@section('content')


<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Update SMTP</li>
      </ul>
   </div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Accounts</h3>
            </div>
            <div class="card-body">
              <form method="post" action="{{url('smtp/update/'.$account->id)}}" id="smtp-edit">
              	@csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $account->title}}"class="form-control">
                    {!!$errors->first("title", "<span class='text-danger'>:message</span>")!!}
                  </div>
                  <div class="form-group col-md-6">
                    <label>Encryption Type</label>
                    <select name="encryption_type" class="form-control">
                     <option value="{{$account->encryption_type}}">{{$account-> getEncryption()}}</option>
                     <option value="0">None</option>
                     <option value="1">TLS</option>
                     <option value="2">SSL</option>
                   </select>
                    {!!$errors->first("Encryption_type", "<span class='text-danger'>:message</span>")!!}
                  </div>
                
                </div>
                
                
                <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" name="email" value="{{ $account->email }}"class="form-control" >
                   {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                </div>
                 <div class="form-group col-md-6">
                  <label>Server	</label>
                  <input type="text" value="{{ $account->server }}" name="server" class="form-control" >
                   {!!$errors->first("server", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
                <div class="form-row">
              
               
              </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                 <label>Type</label>
                    <select name="encryption_type" class="form-control">
                     <option value="{{$account->type}}">{{$account-> getType()}}</option>
                     <option value="0">None</option>
                   </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Port</label>
                  <input type="text" value="{{ $account->port }}" name="port" class="form-control" >
                </div>
              </div>
                
                <input type="submit" class="btn btn-bg" name="update" value="Update">
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
	jQuery( document ).ready(function( $ ) 	
{
 jQuery('#smtp-edit').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: 
      {
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
      title: 
          {
            required: "The title is required."
          }, 
      encryption_type: 
          {
            required: "The encryption type is required."
          },
      type: 
          {
            required: "The type is required."
          },
      email: 
          {
            required: "The email is required."
          }, 
      server: 
          {
            required: "The server is required."
          },
      password: 
          {
            required: "The password is required."
          },
      port: 
          {
            required: "The port is required."
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