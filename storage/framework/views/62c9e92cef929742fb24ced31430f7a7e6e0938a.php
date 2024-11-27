<?php $__env->startSection('content'); ?>
<!-- Style Css -->
<link rel="stylesheet" href="<?php echo e(asset('public/assets/css/pages-css/autn.css')); ?>" />
<link rel="stylesheet" href="<?php echo e('resources/css/app.css'); ?>" />

<!-- Style Css -->

<section class="autn-form sec-ptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="site-logo">
          <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <h1>Whizzer</h1>
          </a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-xl-6">
        <div class="user-form-card">
          <h2 class="text-center">Log In To Continue</h2><br>
          <form method="POST" action="<?php echo e(url('/sign-in')); ?>">
            <?php echo csrf_field(); ?>
            <?php if(session('message')): ?>
            <p class="alert alert-success">
              <?php echo e(session('message')); ?>

            </p>
            <?php endif; ?>
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback" role="alert">
                <strong><?php echo e($message); ?></strong>
              </span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="custom-password-field">
                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" value="<?php echo e(old('password')); ?>" required autocomplete="current-password">
                   <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback" role="alert">
                <strong><?php echo e($message); ?></strong>
              </span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="eye-icons"><i class="fas fa-eye-slash" id="show_password" onclick="showPassword('password')"></i><i class="fas fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none"></i></div>
              
              </div>
<!--               <div class="form-group mt-3"> -->
<!--               	<span class="float-left"> -->
<!--               		<input type="checkbox" value="lsRememberMe" id="rememberMe"> -->
<!--                   <label for="rememberMe">Remember me</label> -->
<!--               	</span> -->
<!--               	<span class="float-right"><a href="<?php echo e(url('/login')); ?>">Forgot Password?</a></span> -->
<!--               </div> -->

            </div>
            <?php if($errors->any()): ?>
            <div class="invalid-feedback"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>
            <div class="row form-group">

              <div class="col-sm-6 text-sm-right mt-sm-0 mt-10">
                <?php if(Route::has('password.request')): ?>
                <a class="" href="<?php echo e(route('password.request')); ?>">
                  <?php echo e(__('Forgot Your Password?')); ?>

                </a>
                <?php endif; ?>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" class="secondary-btn btn btn-bg  btn-lg w-100 mt-3">
                <?php echo e(__('Log In')); ?>

              </button>
            </div>
            <div class="form-scoial-hd">
              <h2>
                Or Log In With
              </h2>
            </div>
            <div class="form-social-media">
              <ul class="social-link">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" ><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="#" ><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </form>
          <div class="user-form-remind text-center">
<!--             <p class="mb-0">Don't have any account? <a href="#">SignUp </a> here</p> -->

          </div>
          <div class="login-copyright-menu text-center">
            <ul>
              <li><a class="text-dark" style="color: #6759ff !important;" href="<?php echo e(url('/terms')); ?>">Terms &amp; Conditions</a></li>
              <li>|</li>
              <li><a class="text-dark" style="color: #6759ff !important;" href="<?php echo e(url('/privacy')); ?>">Privacy Policy</a></li><br>
              <li>
                <p>©Copyright <a href="/remak-yii2-1644/">Whizzer</a>  All Rights Reserved<a href="/remak-yii2-1644/"></a></p>
			<li><br>
			 <li>
				<p><a target="_blank" class="resrved-btn" href="/remak-yii2-1644/"> Powered By Whizzer</a></p>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  function showPassword(id) {
    $("#" + id).attr('type', 'text');
    $("#hide_" + id).show();
    $("#show_" + id).hide();
  }

  function hidePassword(id) {
    $("#" + id).attr('type', 'password');
    $("#hide_" + id).hide();
    $("#show_" + id).show();
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\resources\views/auth/login.blade.php ENDPATH**/ ?>