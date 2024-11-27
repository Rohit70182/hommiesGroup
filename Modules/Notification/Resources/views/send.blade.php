@extends('admin.layouts.app')
@section('content')
<h2>Send Notification To User</h2><br>
<div class="card">

    <form method="post" action="{{url('/notifications/send')}}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title">
                    {!!$errors->first("title", "<span class='text-danger'>message</span>")!!}
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="description" >
                    {!!$errors->first("description", "<span class='text-danger'>message</span>")!!}
                </div>

                <div class="form-group">
                    <label>Users</label>
                    <select name="user_id" class="form-control" >
                        <option>Select</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    {!!$errors->first("user_id", "<span class='text-danger'>message</span>")!!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection