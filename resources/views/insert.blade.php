@extends('admin.layouts.app')
@section('content')
<h2>AddOn Services</h2><br>
<div class="card">
    <form method="post" action="{{url('/sanjeev/event/')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>ENTER TITLE</label>
                    <input type="text" class="form-control" name="name" required>
                    {!!$errors->first("account", "<span class='text-danger'>message</span>")!!}
                </div>

                <div class="form-group">
                    <label>STATE ID</label>
                    <input type="text" class="form-control" name="desc" value="{{ isset($redirect) ? $redirect->new_url : '' }}" required>
                    {!!$errors->first("domain_name", "<span class='text-danger'>message</span>")!!}
                </div>
                
                <div class="form-group">
                    <label>TYPE ID</label>
                   
                </div>
                
                <div class="form-group">
                    <label>SERVICES</label>
                   
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection