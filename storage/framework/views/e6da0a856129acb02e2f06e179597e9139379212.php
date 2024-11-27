<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title><?php echo e(get_seo() ? get_seo()->title : 'demo-service'); ?></title>
  <!-- Metas -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="<?php echo e(get_seo() ? get_seo()->description : 'project Description'); ?>">
  <meta name="keywords" content="<?php echo e(get_seo() ? get_seo()->keywords : 'project keywords'); ?>">
  <meta name="author" content="@ozvidtech">
  <!-- Title  -->
  <link rel="shortcut icon" href="<?php echo e(asset('public/assets/images/Favicon.png')); ?>" />
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/css/bootstrap.min.css')); ?>">
  <!-- Plugins -->
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/css/helpers-plugin.css')); ?>" />
  <!-- Style Css -->
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/css/theme-style.css')); ?>" />
  <!-- fontawesome Css -->
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/fonts/fontawesome/css/all.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/toastr.min.css')); ?>" />
  <script src="<?php echo e(asset('public/assets/js/jquery.slim.min.js')); ?>"></script>
  <script src="<?php echo e(asset('public/assets/js/bootstrap.bundle.min.js')); ?>"></script>
  <!-- Animation -->
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/plugins/animation/animate.min.css')); ?>" />
  <script src="<?php echo e(asset('public/assets/plugins/animation/wow.min.js')); ?>"></script>
  
  
</head>

<body class="">
  <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Start Page Wrapper -->
  <main class="page-wrapper">
    <?php echo $__env->yieldContent('content'); ?>
  </main>
  <!-- Footer -->
  <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Footer -->
  <div class="copyright-area">
    <div class="container">
      <div class="copyright-menu text-center">
        <ul>
          <li>
            <p>©Copyright <a href="/remak-yii2-1644/">demo-service</a> | All Rights Reserved</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- common -->
  <script src="<?php echo e(asset('public/assets/plugins/animation/wow.min.js')); ?>"></script>
  <script src="<?php echo e(asset('public/js/jquery.js')); ?>"></script>
  <script src="<?php echo e(asset('public/assets/js/common.js')); ?>"></script>
  <script src="<?php echo e(asset('public/assets/toastr.min.js')); ?>"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-<?php echo e(get_analytics() ? get_analytics()->account : ''); ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-<?php echo e(get_analytics() ? get_analytics()->account : ""); ?>');
  </script>
      <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>