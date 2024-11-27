@extends('admin.layouts.app')
@section('content')
<?php
use Modules\Security\Entities\Rule;
?>
<h2>Edit</h2><br>
<form action="{{url('security/rule/update/'.$rule->id)}}" method="post">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Ip</label>
            <input type="text" value="{{$rule->ip}}" name="ip" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label>State</label>
            <select name="state_id" class="form-control" required>
                <option value="">Choose...</option>
                <option value="{{Rule::STATE_INACTIVE}}" {{$rule->state_id == Rule::STATE_INACTIVE ? 'selected' : ''}}>Disabled</option>
                <option value="{{Rule::STATE_ACTIVE}}" {{$rule->state_id == Rule::STATE_ACTIVE ? 'selected' : '' }}>Enabled</option>
                <option value="{{Rule::STATE_DELETED}}" {{$rule->state_id == Rule::STATE_DELETED ? 'selected' : '' }}>Deleted</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>User</label>
            <select name="user_id" class="form-control" required>
            <option value="">Choose...</option>
                @foreach($user_data as $user)
                <option value="{{$user->id}}" {{$rule->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Type</label>
            <select name="type_id" class="form-control" required>
                <option value="">Choose...</option>
                <option value="{{Rule::TYPE_DENY}}" {{$rule->type_id == Rule::TYPE_DENY ? 'selected' : ''}}>Deny</option>
                <option value="{{Rule::TYPE_ALLOW}}" {{$rule->type_id == Rule::TYPE_ALLOW ? 'selected' : ''}}>Allow</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-bg">Update</button>
</form>
@endsection