@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Add Custom Service</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2>Add Custom Service</h2>
        </div>
        <div class="card-body">

            <form method="post" action="{{url('/services/custom-req/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="name" value="">
                    {!!$errors->first("name", "<span class='text-danger'></span>")!!}
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="desc" value="">
                    {!!$errors->first("desc", "<span class='text-danger'></span>")!!}
                </div>
                <div class="form-group">
                    <label>Service Image</label>
                    <input type="file" class="form-control" name="image">
                    {!!$errors->first("image", "<span class='text-danger'>upload image</span>")!!}
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="" class="form-control" name="state_id" aria-required="true" aria-invalid="false">
                        <option value=""></option>
                        <option value="0">Apply</option>
                        <option value="1">Apporve</option>
                        <option value="2">Decline</option>
                    </select>
                    @error('state_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-bg" name="submit" value="submit">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection