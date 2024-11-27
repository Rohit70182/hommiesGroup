@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add</h2>
        </div>
        <div class="card-body">
<form action="{{url('security/rule/store')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Ip</label>
            <input type="text" name="ip" value="{{request()->ip()}}" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label>State</label>
            <select name="state_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($stateAttribute as $value => $name)
                <option value="{{$value}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($whitelist=App\Models\User::all() as $w)
                <option value="{{$w->id}}">{{$w->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Type</label>
            <select name="type_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($typeAttribute as $value => $name)
                <option value="{{$value}}">{{$name}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <button type="submit" class="btn btn-bg">Save</button>
</form>
</div>
</div>
@endsection