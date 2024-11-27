<?php $__env->startSection('template_title'); ?>
    Create Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Create Page</li>
    </ul>
</div>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <?php if ($__env->exists('partials.errors')) echo $__env->make('partials.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-head-text">
                      <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Create Page</span>
                </div>
                   
                <div class="card card-default">
                    
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(url('/page/save-page')); ?>"  role="form" enctype="multipart/form-data" id="create-page">
                            <?php echo csrf_field(); ?>

                            <div class="box box-info padding-1">
                                <div class="box-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>">
                                          <?php echo $errors->first('title', '<div class="invalid-feedback">:message</div>'); ?>

                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Type</label>
                                          <select class="form-control" name="type_id" id="type_id">
                                              <option value="">Select type</option>
                                              <?php $__currentLoopData = @$types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e(@$key); ?>" <?php if(old('type_id') == $key): ?> selected='selected' <?php endif; ?> ><?php echo e(@$type); ?></option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </select>
                                          <?php echo $errors->first('type_id', '<div class="invalid-feedback">:message</div>'); ?>

                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label>Description</label>
                                          <textarea name="editor1"><?php echo e(old('description')); ?></textarea>
                                            <?php echo $errors->first('editor1', '<div class="invalid-feedback">The Description field is required.</div>'); ?>

                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="box-footer mt20">
                                    <button type="submit" class="btn btn-bg">Submit</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
jQuery.noConflict();
jQuery( document ).ready(function( $ ) 
{
 jQuery('#create-page').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: 
      {
         title: {
            required: true, 
          }, 
        editor1: {    
            required: true,
          },
         type_id: {     
            required: true,
          },
     },
    messages: {
      title: 
          {
            required: "The title is required."
          }, 
       editor1: 
          {
            required: "The description is required."
          },
      type_id: 
          {
            required: "The type is required."
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


 <script>
CKEDITOR.replace( 'editor1' );
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Page\Resources/views/create.blade.php ENDPATH**/ ?>