<?php $__env->startSection('content'); ?>
<?php

use Modules\Services\Entities\Service;
?>


<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
    <li class="active">Add Service</li>
  </ul>
</div>

<div class="col-md-12">

  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Service</h3>
  	</div>
  </div>
  <div class="card">
    <form method="post" action="<?php echo e(url('/services/store')); ?>" enctype="multipart/form-data" id="add-service-form">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="id" value="">
      <div class="row mt-3">
        <div class="col-md-6">
              <div class="form-group">
                <label>Service Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>">
                <?php echo $errors->first("name", "<span class='text-danger'>Enter service name</span>"); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Description</label>
    
                <textarea class="form-control" name="desc" value="<?php echo e(old('desc')); ?>"><?php echo e(old('desc')); ?></textarea>
                <?php echo $errors->first("desc", "<span class='text-danger'>Enter description</span>"); ?>

              </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label>Select Category</label>
                <select name="category_id" id="category_id" class="form-control">
                  <option selected disabled>Choose</option>
                  <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php echo $errors->first("category_id", "<span class='text-danger'>Select category </span>"); ?>

              </div>
            </div>
            <div class="col-md-6">
            <div class="form-group" >
                <label>Select Sub Category</label>
                <select name="subCategory" id="subcategory_id" class="form-control">
                  <option selected disabled>Choose</option>
                </select>
                <?php echo $errors->first("subcat", "<span class='text-danger'>Select sub category </span>"); ?>

              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control" name="price" value="<?php echo e(old('price')); ?>">
                  <?php echo $errors->first("price", "<span class='text-danger'>:prices</span>"); ?>

              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                  <label>Image:</label>
                  <input type="file" class="form-control" name="image">
                  <?php echo $errors->first("image", "<span class='text-danger'>:message</span>"); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" >
                  <label>Type</label>
                  <select name="type" id="type" class="form-control">
                    <option selected disabled>Choose</option>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($value); ?>"><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <?php echo $errors->first("subcat", "<span class='text-danger'>Select type</span>"); ?>

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
<script src="<?php echo e(url('/Modules/Services/public/form.js')); ?>"></script>
<script src="<?php echo e(url('/Modules/Services/public/Services.js')); ?>"></script>
<script>
  var SITEURL = "<?php echo e(url('/')); ?>";
</script>

<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    jQuery('#add-service-form').validate({
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
        category_id: {
          required: true,
        },
        subCategory: {
          required: true,
        },

        price: {
          min:1
        },
        type_id: {
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
        category_id: {
          required: "The category is required."
        },
        subCategory: {
          required: "The subcategory is required."
        },
        type_id: {
          required: "The status is required."
        },
        price: {
          required: "The price is required."
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/management/form.blade.php ENDPATH**/ ?>