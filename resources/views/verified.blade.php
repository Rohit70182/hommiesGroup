@extends('layouts.app')

@section('content')
<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('public/assets/css/pages-css/autn.css') }}" />
<link rel="stylesheet" href="{{ 'resources/css/app.css'}}" />

<!-- Style Css -->

<section class="autn-form sec-ptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="site-logo">
          <a class="navbar-brand" href="{{url('/')}}">
            <h1>demo-service</h1>
          </a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-xl-6">
        <div class="user-form-card">
          <h2 class="text-center">{{$message}}</h2><br>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection