@extends('layouts.app')

@section('content')
<div id="privacy">
<section class="privacy-wrap sec-inner">
    <div class="container h-100">
        <div class="row">
            <div class="col-lg-12 col-md-12 justify-content-left">
                <div class="banner-inner">
                  <h2 class="main-title text-center text-white">Privacy Policy</h2>
                </div>
            </div>
        </div>
    </div>
</section>

     <section class="terms-cont">
        <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-6 col-md-6 col-12">
                    <div class="entry__article">
                    {!!$privacy->description!!}
                    </div>                    
                </div>
               </div>
                <div class="col-lg-10 ">
                    <div class="entry__article">
                    
                    
                  </div>
            </div>
        </div>
    </section>

</div>

@endsection