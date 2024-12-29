<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/css/pages-css/autn.css')); ?>" />
<link rel="icon" href="<?php echo e(asset('public/assets/images/Favicon.png')); ?>">


<div class="landing">
  <section class="landing-wrap">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-lg-6 col-md-12 breadcrumb-inner banner">
          <div class="banner-inner">
            <h1 class="HeroTitle">Your Ultimate Property Marketplace</h1>
            <h2 class="HeroSubtitle">Find Your Perfect Room to Rent or Buy with Just a Tap!</h2>
            </h2>
            <div class="btn-wrap">
              <a class="primary-btn mt-10" href="<?php echo e(url('/login')); ?>">Get Started <span class="ml-2">
                  <i class="fa fa-long-arrow-right">

                  </i>
                </span></a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 banner-wrap">

          <div class="banner-con1">
            <div class="banner-con2">
              <div class="banner-con3"><img
                  src=""
                  alt="cover">
                <div class="banner-con4"></div>
                <div class="banner-con5"></div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/welcome.blade.php ENDPATH**/ ?>