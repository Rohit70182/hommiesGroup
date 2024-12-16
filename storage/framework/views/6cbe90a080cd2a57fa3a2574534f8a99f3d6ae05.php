<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Change Password</li>
    </ul>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20"><?php echo e(__('Change Password')); ?></h3>
                </div>

                <form action="<?php echo e(url('dashboard/change-password')); ?>" method="POST" enctype="multipart/form-data" id="change-password" class="pb-5">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                        <?php elseif(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                        </div>
                        <?php endif; ?>
                        <div class="row align-items-center">
                            <div class="col-md-6 forget-pass-field offset-md-3">
                                <div class="mb-3">
                                <div class="form-group">
                                    <label for="newPasswordInput" class="form-label">New Password</label>
                                    <input name="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" placeholder="New Password">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <div class="eye-icon-show-hide" >
                                        <i class="fa fa-eye" id="hide_password" onclick="hidePassword('password')" style="display:none;"></i>
                                        <i class="fa fa-eye-slash" id="show_password" onclick="showPassword('password')"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6  offset-md-3">
                                <div class="mb-3">
                                <div class="form-group">
                                    <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                    <input name="password_confirmation" type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="2password" placeholder="Confirm New Password">
                                     <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="eye-icon-show-hide" >
                                        <i class="fa fa-eye" id="2hide_password" onclick="hidePassword2('password')" style="display:none;"></i>
                                        <i class="fa fa-eye-slash" id="2show_password" onclick="showPassword2('password')"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6  offset-md-3">
                                <div class="form-group text-center">
                                    <button class="btn btn-bg mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
  
  function showPassword2(id) {
    $("#2" + id).attr('type', 'text');
    $("#2hide_" + id).show();
    $("#2show_" + id).hide();
  }

  function hidePassword2(id) {
    $("#2" + id).attr('type', 'password');
    $("#2hide_" + id).hide();
    $("#2show_" + id).show();
  }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<link href="/public/assets/css/select2.min.css" rel="stylesheet" />
<script src="/public/assets/js/select2.min.js"></script>
<script type="text/javascript">
   
    
    
jQuery( document ).ready(function( $ ) 
{
 jQuery('#change-password').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: {
     password: {
        required: true, 
      }, 
     password_confirmation: {    
        required: true,
        equalTo: "#password"
      },
      
      },
    messages: {
      password: {
        required: "The Password is required."
      }, 
      password_confirmation: {
        required: "The Confirm Password is required."
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      jQuery(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      jQuery(element).removeClass('is-invalid');
    }
  });
});
</script>



<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/change-password.blade.php ENDPATH**/ ?>