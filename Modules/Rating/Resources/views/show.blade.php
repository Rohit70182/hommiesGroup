@extends('admin.layouts.app')

@section('template_title')
    {{ $rating->title ?? 'Show Page' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Show Page</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-bg" href="{{ url('rating') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body"> 
                        <div class="form-group">
                            <strong>Model Id:</strong>
                            {{ $rating->model_id }}
                        </div>
                        <div class="form-group">
                            <strong>Model Type:</strong>
                            {{ $rating->model_type }}
                        </div>
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $rating->title }}
                        </div>
                        <div class="form-group">
                            <strong>Rating:</strong>
                            {{ $rating->rating }}
                        </div>
                        <div class="form-group">
                            <strong>State:</strong>
                            {{ $rating->getState() }}
                        </div>
                        <div class="form-group">
                            <strong>Created By:</strong>
                            {{ $rating->getUser->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
