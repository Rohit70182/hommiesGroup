<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
         <li class="active">Manage</li>
         <li class="active">Login History</li>
      </ul>
</div>
<div class="dash-home-cards">
	<div class="row">
		<div class="col-12">
		<div class="page-head-text">
					<div class="ProfileHader d-flex flex-wrap align-items-center">
						<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Login History</h3>
						 <a href="<?php echo e(url('deleteLogs')); ?>" onclick="return confirm('Are you sure to delete all logs ?')"  class="btn btn-bg" >
                            <i class="fa fa-danger">Delete All Logs</i>
                        </a>
					</div>
				</div>
				<div class="page-index">
					Index
				</div>
			<div class="card">
			
				<div class="card-body table-responsive">
					<table class="table table-bordered" id="datatable">
						<thead>
							<th>serial</th>
							<th>URL</th>
							<th>Method</th>
							<th>User Ip</th>
							<th width="300px">User Agent</th>
							<th>User Id</th>
							<th>Time</th>
<!-- 							 <th>State</th> -->
							<th>Actions</th>
						</thead>
						<?php if($logs->count()): ?>
						<tbody>
							<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($log->id); ?></td>
								<td class="text-primary"><?php echo e($log->url); ?></td>
								<td><label class="label label-info"><?php echo e($log->method); ?></label></td>
								<td class="text-warning"><?php echo e($log->ip); ?></td>
								<td class="text-danger"><?php echo e($log->agent); ?></td>
								<td><?php echo e($log->user_id); ?></td>
								<td><?php echo e($log->created_at); ?></td>
<!-- 								<td><?php echo e($log->state_id); ?></td> -->
								<td> 
								<a href="<?php echo e(url('/logActivity/logShow/'.$log->id)); ?>" title="view log activity" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
								<a href="<?php echo e(url('/logActivity/delete/'.$log->id)); ?>" onclick="return confirm('Are you sure you want to delete?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>

								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
						<?php endif; ?>
					</table>
					<?php echo $logs->links(); ?>

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
        order: [[0, 'DESC']],
"bPaginate": false
    });
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/dashboard/activity/logActivity.blade.php ENDPATH**/ ?>