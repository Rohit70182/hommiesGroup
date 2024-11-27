@extends('admin.layouts.app')

@section('template_title')
{{ $page->title ?? 'Show Page' }}
@endsection

@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Show Page</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">{{ $page->title }}</h3>
                    <div class="float-right">
                        <a class="btn btn-bg" href="{{ route('page.edit',$page->id) }}"><i class="fa fa-fw fa-edit"></i> </a>
                        <a class="btn-danger btn" href="{{ route('page.destroy',$page->id) }}"  onclick="return confirm('Are you sure to delete it ?')" ><i class="fa fa-fw fa-trash"></i> </a>
                        <a class="btn btn-bg" href="{{ url('/page') }}"> Back</a>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table table-bordered table-user-show-page">
                            <thead>
                                <tr>
                                    <td><span>ID</span></td>
                                    <td>
                                        <strong>
                                            {{ $page->id }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span>Title</span></td>
                                    <td>
                                        <strong>
                                            {{ $page->title }}
                                        </strong>
                                    </td>
                                    
                                <tr>
                                    <td><span>Type</span></td>
                                    <td>
                                        <strong>
                                            {{ $page->getType() }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span>Status</span></td>
                                    <td>
                                        <strong>
                                            {{ $page->getState() }}
                                        </strong>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <div>
                            <h2> {{ $page->title }}</h2><br>
                            {!! $page->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection