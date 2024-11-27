<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
    <li class="active">Add Coupon</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Coupon</h3>
    </div>

  </div>
  <div class="card">
    <div class="card-header ">
    <form method="post" action="<?php echo e(url('/services/coupon/store')); ?>" enctype="multipart/form-data" id="coupon-add-form">
      <?php echo csrf_field(); ?>
      <div class="row mt-3">
        <div class="col-md-6">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name">
            <?php echo $errors->first("name", "<span class='text-danger'>:message</span>"); ?>

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control" value="<?php echo e(old('desc')); ?>" name="desc">
            <?php echo $errors->first("desc", "<span class='text-danger'>Description is required</span>"); ?>

          </div>
        </div>
        <div class="col-md-6">

          <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control" name="amount">
            <?php echo $errors->first("amount", "<span class='text-danger'>Enter a valid amount</span>"); ?>

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>State</label>
            <select name="state_id" value="<?php echo e(old('state_id')); ?>" class="form-control">
              <option disabled selected value="">Choose </option>
              <option value="0" <?php echo e(old('state_id') == 'STATE_INACTIVE' ? 'selected' : ''); ?>>Inactive</option>
              <option value="1" <?php echo e(old('state_id') == 'STATE_ACTIVE' ? 'selected' : ''); ?>>Active</option>
              
            </select>
            <?php echo $errors->first("state_id", "<span class='text-danger'>Choose a valid State</span>"); ?>

          </div>

        </div>
        <div class="col-md-12">
          <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="Submit">
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    jQuery('#coupon-add-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
        },
        desc: {
          required: true
        },
        amount: {
          required: true,
          min:1
        },
        state_id: {
          required: true
        },
      },
      messages: {
        name: {
          required: "The title is required."
        },
        desc: {
          required: "The description is required."
        },
        amount: {
          required: "The amount is required."
        },
        state_id: {
          required: "The state is required."
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/coupon/form.blade.php ENDPATH**/ ?>