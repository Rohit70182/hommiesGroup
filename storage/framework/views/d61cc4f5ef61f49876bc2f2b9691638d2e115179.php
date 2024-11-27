


<div id="contact">

<section class="privacy-wrap sec-inner">
    <div class="container h-100">
        <div class="row">
            <div class="col-lg-12 col-md-12 justify-content-left">
                <div class="banner-inner">
                  <h2 class="main-title text-center text-white">Contact Us</h2>
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="contact-from-area">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-12">
                <h3>Get In Touch</h3>  
                      <div class="contact-right">
                        <div class="contact-form fix">
                            <form id="contact-form" action="<?php echo e(url('/test-submit')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                              <div class="row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label for="amount">Principal Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control" placeholder="amount">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12">
                                    <label for="rate-of-intreset">Rate of Intreset</label>
                                        <input type="text" name="rate-of-intreset" id="rate-of-intreset" class="form-control" placeholder="rate-of-intreset">
                                    </div>
                                    <div class="form-group col-lg-12">
                                    <label for="time">Time</label>
                                        <input type="integer" name="time" id="sub" class="form-control" placeholder="time">
                                    </div>
                                   
                                    <div class="form-group col-lg-12">
                                        <button type="submit" class="secondary-btn btn btn-bg submit-btn">SUBMIT</button>
                                    </div>
                                </div>
                            </form>
                        </div>                             
                    </div>                            
                </div>
            </div>
         </div>                     
           
    </section>
</div>
<?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/test.blade.php ENDPATH**/ ?>