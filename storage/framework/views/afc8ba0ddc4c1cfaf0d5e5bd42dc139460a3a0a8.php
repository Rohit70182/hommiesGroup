<?php $__env->startSection('content'); ?>


<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Services</li>
        <li class="active">Categories</li>
    </ul>
</div>

<div class="col-md-12">

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        <div class="page-head-text">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Categories</h3>
                        <a class="btn btn-bg" href="<?php echo e(url('/services/category/add')); ?>">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>

                </div>
                 <div class="page-index">Index</div>
            <div class="card">
               
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project">
                        <thead>
                            <th>Id</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>State</th>
                            <th>Actions</th>

                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($category->id); ?></td>
                                <td><?php echo e($category->name); ?></td>
                                <td><?php echo e($category->desc); ?></td>
                                <td><?php echo e($category->getState()); ?></td>
                                <td>
                                    <a href="<?php echo e(url('/services/category/show/'.$category->id)); ?>" title="view" class="btn-success btn " data-method="View" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo e(url('/services/category/edit/'.$category->id)); ?>" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="<?php echo e(url('/services/category/softDelete/'.$category->id)); ?>" onclick="return confirm('Are you sure to change its state ?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/category/index.blade.php ENDPATH**/ ?>