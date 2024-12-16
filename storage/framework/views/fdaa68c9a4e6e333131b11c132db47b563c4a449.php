<?php $__env->startSection('content'); ?>

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
            <div class="col-lg-5 col-12">
            <h3>Quick Contact</h3> 
                <div class="contact-left"> 
                    <ul>
                        <li>Phone: <a href="tel:+971 58 534 3058">+971 58 534 3058</a></li>
                        <li>Email: <a href="mailto:info@varianuae.com">info@varianuae.com</a></li>
                        <li>Address: Dubai, UAE</li>
                    </ul>
                </div>
            </div>
                <div class="col-lg-7 col-12">
                <h3>Get In Touch</h3>  
                      <div class="contact-right">
                        <div class="contact-form fix">
                            <form id="contact-form" action="<?php echo e(url('/contact')); ?>" method="get">
                              <div class="row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12">
                                    <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group col-lg-12">
                                    <label for="subject">Subject</label>
                                        <input type="text" name="text" id="sub" class="form-control" placeholder="Subject">
                                    </div>
                                    <div class="form-group col-lg-12">
                                    <label for="message">Message</label>
                                        <textarea name="message" id="message" cols="30" rows="6" placeholder="Message" class="form-control"></textarea>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/contact.blade.php ENDPATH**/ ?>