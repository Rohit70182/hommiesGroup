<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>{{get_seo() ? get_seo()->title : 'demo-service'}}</title>
  <!-- Metas -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="{{get_seo() ? get_seo()->description : 'project Description'}}">
  <meta name="keywords" content="{{get_seo() ? get_seo()->keywords : 'project keywords'}}">
  <meta name="author" content="@ozvidtech">
  <!-- Title  -->
  <link rel="shortcut icon" href="{{ asset('public/assets/images/Favicon.png') }}" />
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/helpers-plugin.css') }}" />
  <!-- Style Css -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/theme-style.css') }}" />


</head>

<body class="">

<link rel="stylesheet" href="{{ asset('public/assets/css/pages-css/autn.css') }}" />
<link rel="stylesheet" href="{{ 'resources/css/app.css'}}" />

<!-- Style Css -->

<section class="autn-form sec-ptb error">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-xl-6">
          <h2 class="error-title">404</h2>   
          <h3 class="error-title">Page Not Found</h3>   
      </div>
    </div>
  </div>
</section>

</html>




