@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Add User</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2>Add</h2>
        </div>
        <div class="card-body">

            <form method="post" action="{{url('/dashboard/user/add')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option>Choose your role</option>
                                <option value="1" {{old('role') == '1' ? 'selected' : ''}}>User</option>
                                <option value="2" {{old('role') == '2' ? 'selected' : ''}}>Service Provider</option>
                            </select>
                            {!!$errors->first("role", "<span class='text-danger'>:message</span>")!!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password">
                            {!!$errors->first("password", "<span class='text-danger'>:message</span>")!!}
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-12">
                        <div class="form-group">
                            <label>Profile Photo:</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-bg" name="submit" value="submit">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection