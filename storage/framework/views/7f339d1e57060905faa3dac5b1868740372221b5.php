<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
    <li class="active">Add Category</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Category</h3>
    </div>
  </div>
  <div class="card">
    <form method="post" action="<?php echo e(url('/services/category/store')); ?>" enctype="multipart/form-data" id="category-edit-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e(isset($analytics) ? $analytics->id : ''); ?>">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mt-3">
                    <label>Category Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" >
                    <?php echo $errors->first("name", "<span class='text-danger'>:message </span>"); ?>

                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group  mt-3">
                    <label>Description</label>
                    <textarea class="form-control" name="desc" rows="1"><?php echo e(old('desc')); ?></textarea>
                    <?php echo $errors->first("desc", "<span class='text-danger'>Enter category description</span>"); ?>

                </div>
                </div>
                <div class="col-lg-6">
                 <div class="form-group">
                    <label>Image:</label>
                    <input type="file" class="form-control" name="image" >
                    <?php echo $errors->first("image", "<span class='text-danger'>:message</span>"); ?>

                </div>
        </div>
      </div>

      <div class="form-group">
        <input type="submit" class="btn btn-bg" name="submit" value="Submit">
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
	
    jQuery('#category-edit-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
        },
        desc: {
          required: true,
        },
        image: {
          required: true,
          extension: "jpeg|jpg|png"
        },
      },
      messages: {
        name: {
          required: "The name is required."
        },
        desc: {
          required: "The description is required."
        },
        image: {
          required: "The image is required.",
          extension: 'jpg, jpeg, png format allowed only'
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/category/form.blade.php ENDPATH**/ ?>