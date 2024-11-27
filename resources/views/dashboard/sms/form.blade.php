@extends('admin.layouts.app')
@section('content')
<h2>Send Sms</h2><br>
<div class="card">

    <form method="post" action="{{url('/sms/send')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Number</label>
                    <input type="text" class="form-control" name="number" value="" required>
                    {!!$errors->first("number", "<span class='text-danger'>message</span>")!!}
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <input type="text" class="form-control" name="message" value="" required>
                    {!!$errors->first("message", "<span class='text-danger'>message</span>")!!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection