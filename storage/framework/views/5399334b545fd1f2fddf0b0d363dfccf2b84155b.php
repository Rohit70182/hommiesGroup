<?php $__env->startSection('content'); ?>
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Update Profile</li>
    </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
            <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20  pr-20">Update Profile</h3> <span class="badge badge-success">Active</span>
          </div>
        </div>
        <div class="page-index">
            Update Profile
        </div>
      <div class="card pt-3">

        <div class="card-body">

          <form action="<?php echo e(url('dashboard/myprofile/update/'.$GetUser->id)); ?>" method="POST" enctype="multipart/form-data" id="personaldetails-add">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Name</label>
                  <input type="text" name="name" value="<?php echo e(old( 'name', $GetUser->name)); ?>" required class="form-control">
                  <?php $__errorArgs = ['name'];
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
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Phone</label>
                  <input type="number" name="phone" required value="<?php echo e($GetUser->phone); ?>" class="form-control">
                  <?php $__errorArgs = ['phone'];
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
              </div>
              
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Email</label>
                  <input type="text" name="email" value="<?php echo e(old( 'email', $GetUser->email)); ?>" required class="form-control" disabled>
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
              </div>
              
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label>Profile File:</label>
                  <input type="file" class="form-control" name="image">
					<?php $__errorArgs = ['image'];
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
              </div>
            </div>

            <div class="form-group text-right">
               <input type="submit" class="btn btn-bg" name="submit" value="Update">
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    $.validator.addMethod("alpha", function(value, element) 
    {
    	return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	},'Enter letters only');
    
    jQuery('#personaldetails-add').validate({
    

      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
          alpha	:true
        },
        phone: {
          required: true,
           minlength: 10,
           maxlength: 15
        },
      },
      messages: {
        name: {
          required: "The name is required.",
        },
        phone: {
          required: "The phone is required.",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        jQuery(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        jQuery(element).removeClass('is-invalid');
      }
    });
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/dashboard/myprofile/personaldetailsupdate.blade.php ENDPATH**/ ?>