@extends('admin.layouts.app')
@section('content')
<?php
use Modules\Security\Entities\Whitelist;
?>
<h2>edit</h2><br>
<form action="{{url('security/whitelist/update/'.$whitelist->id)}}" method="post">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Ip</label>
            <input type="text" name="ip" value="{{$whitelist->ip}}" class="form-control" id="ip">
        </div>
        <div class="form-group col-md-6">
            <label>State</label>
            <select name="state_id" class="form-control">
                <option selected>Choose...</option>
                <option value="{{Whitelist::STATE_INACTIVE}}" {{$whitelist->state_id == Whitelist::STATE_INACTIVE ? 'selected' : ''}}>Disabled</option>
                <option value="{{Whitelist::STATE_ACTIVE}}" {{$whitelist->state_id == Whitelist::STATE_ACTIVE ? 'selected' : ''}}>Enabled</option>
                <option value="{{Whitelist::STATE_DELETED}}" {{$whitelist->state_id == Whitelist::STATE_DELETED ? 'seleted' : ''}}>Deleted</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>User</label>
            <select name="user_id" class="form-control"  required>
                <option value="">Choose...</option>
                @foreach($user_data as $user)
                <option value="{{$user->id}}" {{$user->id == $whitelist->user_id ? 'selected' : ''}}>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Type</label>
            <select name="type_id" class="form-control">
                <option selected>Choose...</option>
                <option value="{{Whitelist::TYPE_DENY}}" {{$whitelist->type_id == Whitelist::TYPE_DENY ? 'selected' : ''}}>Deny</option>
                <option value="{{Whitelist::TYPE_ALLOW}}" {{$whitelist->type_id == Whitelist::TYPE_ALLOW ? 'selected' : ''}}>Allow</option>
            </select>
        </div>

    </div>
    <button type="submit" class="btn btn-bg">Update</button>
</form>
@endsection