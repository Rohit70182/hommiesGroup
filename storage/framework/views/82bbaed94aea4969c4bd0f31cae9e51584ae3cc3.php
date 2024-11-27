<?php use App\Models\CancelReason; ?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Cancel Reasons</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="page-head-text">
                     <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Cancel Reasons</h3>
                        <a class="btn btn-bg" href="<?php echo e(route('createreason')); ?>">
                            <i class="fa fa-plus"></i>
                        </a>

                    </div>
                </div>
                <div class="page-index">
                Index
                </div>
        
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Cancel Reasons</h3>
                    </div>

                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project">
                        <thead>
                            <th>Id</th>
                            <th>Reason</th>
                            <th>State</th>
                            <th>Actions</th>  
                        </thead>
                        <tbody>
                     		<?php $__currentLoopData = $cancelReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cancelReason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     			<tr>
                     				<td><?php echo e($cancelReason->id); ?></td>
                     				<td><?php echo e($cancelReason->messages); ?></td>
                     				<?php if($cancelReason->state_id == CancelReason::STATE_ACTIVE): ?>
                     					<td>Active</td>
                     				<?php endif; ?>
                     				<td>
                     					<a href="<?php echo e(route('showreason' ,$cancelReason->id)); ?>" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    	<a href="<?php echo e(url('cancel-reasons/edit/' . $cancelReason->id)); ?>" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    	<a href="<?php echo e(route('deletereason' , $cancelReason->id)); ?>" onclick="return confirm('Are you sure you want to delete it ?')" title="change state"" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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
        $('#datatable').DataTable();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/dashboard/cancel-reasons/index.blade.php ENDPATH**/ ?>