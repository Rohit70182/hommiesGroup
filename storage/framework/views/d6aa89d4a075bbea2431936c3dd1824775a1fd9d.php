<?php $__env->startSection('template_title'); ?>
Faq
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
         <li class="active">Faqs</li>
      </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            <?php echo e(__('Faqs')); ?>

                        </span>

                        <div class="float-right">
                            <a href="<?php echo e(route('add_faq')); ?>" class="btn btn-bg btn-sm float-right" data-placement="left">
                                <?php echo e(__('Create New')); ?>

                            </a>
                        </div>
                    </div>
                </div>

                <div class="page-index">Index</div>
            <div class="card">
               
<!--                 <?php if($message = Session::get('success')): ?> -->
<!--                 <div class="alert alert-success"> -->
<!--                     <p><?php echo e($message); ?></p> -->
<!--                 </div> -->
<!--                 <?php endif; ?> -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="datatable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Question</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($faq->question); ?></td>
                                    <td class="actions">
                                        <form action="<?php echo e(route('faq.destroy')); ?>" method="POST" onsubmit='return confirm("are you sure to delete this ?")'>
                                            <a class="btn-success btn" href="<?php echo e(route('faq.show',$faq->id)); ?>" title="view"><i class="fa fa-fw fa-eye"></i></a>
                                            <a class="btn btn-bg " href="<?php echo e(route('faq.edit',$faq->id)); ?>"  title="edit"><i class="fa fa-fw fa-edit"></i> </a>
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <input type="hidden" name="id" value="<?php echo e($faq->id); ?>" >
                                            <button type="submit" class="btn-danger btn btn-sm" title="delete"><i class="fa fa-fw fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<!-- Data Table CSS -->
<link rel="stylesheet" href="<?php echo e(asset('public/dataTables/dataTables.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<!-- Data Table Script -->
<script src="<?php echo e(asset('public/dataTables/dataTables.min.js')); ?>"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            order: [
                [0, 'DESC']
            ],
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Faq\Resources/views/index.blade.php ENDPATH**/ ?>