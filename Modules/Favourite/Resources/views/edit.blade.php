@extends('admin.layouts.app')

@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
         <li class="active">Update Item</li>
      </ul>
</div>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Update Item </span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update', $item->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                             @include('favourite::form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

