@extends('admin.layouts.app')
@section('content')

<h2>{{ isset($settings) ? 'Update' : 'Add' }}</h2><br>

<div class="card p-5">
    <form method="post" action="{{url('/stripe/settings/store')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ isset($settings) ? $settings->id : '' }}">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label>Publishable Key</label>
                    <input type="text" class="form-control" name="publishable_key" value="{{ isset($settings) ? $settings->publishable_key : '' }}" required>
                    {!!$errors->first("publishable_key", "<span class='text-danger'>message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Secret Key</label>
                    <input type="text" class="form-control" name="secret_key" value="{{ isset($settings) ? $settings->secret_key : '' }}" required>
                    {!!$errors->first("publishable_key", "<span class='text-danger'>message</span>")!!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>
@endsection