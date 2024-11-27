@extends('admin.layouts.app')
@section('content')
<h2>Edit Add On</h2><br>
<div class="card">

    <form method="post" action="{{url('/services/add-on/update/'.$add->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>EDIT TITLE</label>
                    <input type="text" class="form-control" name="name" value="{{$add->name}}">
                    {!!$errors->first("name", "<span class='text-danger'>enter addon service name</span>")!!}
                </div>

                <div class="form-group">
                    <label>STATE ID</label>
                   
                </div>
                
                <div class="form-group">
                    <label>TYPE ID</label>
                   
                </div>
                
                <div class="form-group">
                    <label>SERVICES ID</label>
                    
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection