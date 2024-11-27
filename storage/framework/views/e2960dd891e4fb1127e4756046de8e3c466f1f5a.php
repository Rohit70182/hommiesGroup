<?php $__env->startSection('content'); ?>
<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Services</li>
        <li class="active">Service Management</li>
    </ul>
</div>
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Services</h3>
                    <a class="btn btn-bg" href="<?php echo e(url('/services/add')); ?>">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

            </div>
            <div class="page-index">
                Index
            </div>
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>State</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($service->id); ?></td>
                                <td><?php echo e($service->name); ?></td>
                                <td><?php echo e($service->desc); ?></td>
                                <td><?php if($service->price): ?> <?php echo e($service->price); ?> <?php else: ?> No price added <?php endif; ?>  </td>
                                <td><?php echo e($service->getStateid()); ?></td>
                                <td><?php echo e($service->getServiceType()); ?></td>
                                <td>
                                    <a href="<?php echo e(url('/services/show/'.$service->id)); ?>" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo e(url('/services/edit/'.$service->id)); ?>" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="<?php echo e(url('/services/softDelete/'.$service->id)); ?>" onclick="return confirm('Are you sure to change its state ?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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
                [0, 'desc']
            ],
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/management/index.blade.php ENDPATH**/ ?>