@extends('admin.layouts.app')

@section('content')
<form action="{{ url('/comment/store-comment') }}" method="POST" >
    @csrf
    <div class="box_general_3 write_review mt-3">
        <div class="form-group">
            <label>Your Comment</label>
            <input type="hidden" name="model_id" value="1">
            <input type="hidden" name="model_type" value="Comment">
            <textarea class="form-control sentancee" name="title" style="height: 180px;"
                placeholder="Write your comment here ..."></textarea>
                @if($errors->has('title'))
                    <div class="error text-danger">{{ $errors->first('title') }}</div>
                @endif
        </div>
        <button type="submit" class="btn btn-bg">Submit Comment</button>
    </div>
</form>

@endsection
