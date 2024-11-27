<?php $__env->startSection('template_title'); ?>
Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
    <li class="active">Pages</li>
  </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            <?php echo e(__('Pages')); ?>

                        </span>

                        <div class="float-right">
                            <a href="<?php echo e(route('add_page')); ?>" class="btn btn-bg btn-sm float-right" data-placement="left">
                                <?php echo e(__('Create New')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="page-index">
                    Index
                </div>
            <div class="card">
               
                

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="datatable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>State</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($page->title); ?></td>
                                 
                                    <td><?php echo e($page->getType()); ?></td>
                                    <td><?php echo e($page->getState()); ?></td>
                                    <td class="actions">
                                            <a class="btn-success btn" href="<?php echo e(route('page.show',$page->id)); ?>"  title="view"><i class="fa fa-fw fa-eye"></i> </a>
                                            <a class="btn btn-bg" href="<?php echo e(route('page.edit',$page->id)); ?>" title="edit"><i class="fa fa-fw fa-edit"></i> </a>
                                            <input type="hidden" name="id" value="<?php echo e($page->id); ?>">
                                            <a class="btn-danger btn btn-sm" href="<?php echo e(route('page.destroy',$page->id)); ?>" title="delete" onclick="return confirm('Are you sure to delete it ?')" ><i class="fa fa-fw fa-trash"></i> </a>
                                            
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
        $('#datatable').DataTable();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Page\Resources/views/index.blade.php ENDPATH**/ ?>