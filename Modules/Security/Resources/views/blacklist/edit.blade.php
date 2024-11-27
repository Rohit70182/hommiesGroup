@extends('admin.layouts.app')
@section('content')
<?php

use Modules\Security\Entities\Blacklist;
?>
<h2>Edit</h2><br>
<form action="{{url('security/blacklist/update/'.$blacklist->id)}}" method="post">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Ip</label>
            <input type="text" value="{{$blacklist->ip}}" name="ip" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label>State</label>
            <select name="state_id" class="form-control" required>
                <option value="">Choose...</option>
                <option value="{{Blacklist::STATE_INACTIVE}}" {{$blacklist->state_id == Blacklist::STATE_INACTIVE ? 'selected' : ''}}>Disabled</option>
                <option value="{{Blacklist::STATE_ACTIVE}}" {{$blacklist->state_id == Blacklist::STATE_ACTIVE ? 'selected' : ''}}>Enabled</option>
                <option value="{{Blacklist::STATE_DELETED}}" {{$blacklist->state_id == Blacklist::STATE_DELETED ? 'selected' : ''}}>Deleted</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Reason Why</label>
            <input type="text" name="reason" value="{{$blacklist->reason}}" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label>Type</label>
            <select name="type_id" class="form-control" required>
                <option value="">Choose...</option>
                <option value="{{Blacklist::TYPE_DENY}}" {{$blacklist->type_id == Blacklist::TYPE_DENY ? 'selected' : ''}}>Deny</option>
                <option value="{{Blacklist::TYPE_ALLOW}}" {{$blacklist->type_id == Blacklist::TYPE_ALLOW ? 'selected' : ''}}>Allow</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-bg">Update</button>
</form>
@endsection