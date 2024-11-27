@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="card pt-4">
            <div class="card-body">
                <iframe class="message_frame" src="{{ url('admin/email-queue/show/'.$email->id) }}" width="100%" height="500"></iframe>
                 </div>
        </div>
    </div>
</div>
@endsection
           