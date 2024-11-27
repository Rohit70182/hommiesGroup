@extends('layouts.app')

@section('content')

<div id="about">
    <section class="about-us sec-inner">
      <div class="container h-100">
        <div class="row">
          <div class="col-lg-12 col-md-12 justify-content-left">
            <div class="banner-inner">
              <h2 class="main-title text-center text-white">About</h2>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="about-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6 col-12 d-flex justify-content-left">
                    <div class="about-img">
                    <img src="{{asset('/public/assets/images/pexels-andrea-piacquadio-3866329.webp')}}" alt="">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-12">
                    <div class="about-text">
                        <div class="col-lg-6 col-md-6 col-12">
                    <div class="entry__article">
                    {!!$about->description!!}
                    </div>                    
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection