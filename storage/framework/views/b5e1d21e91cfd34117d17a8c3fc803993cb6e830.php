<?php $__env->startSection('content'); ?>
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
                    <?php echo $privacy->description; ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/privacy.blade.php ENDPATH**/ ?>