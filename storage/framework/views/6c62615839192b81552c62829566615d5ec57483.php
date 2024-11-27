<?php $__env->startSection('content'); ?>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="mb-1 mt-2">
				<ul class="breadcrumb">
					<li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
					<li class="active">Manage</li>
					<li class="active">Logs</li>
				</ul>
			</div>
        
            
                <div class="page-head-text">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Logs</h3>
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
                            <tr>
                            <th>Id</th>
                            <th>Instance</th>
                            <th>Level</th>
                            <th>User Agent</th>
                            <th>Message</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($log->id); ?></td>
                                <td><?php echo e($log->instance); ?></td>
                                <td><?php echo e($log->level_name); ?></td>
                                <td><?php echo e($log->user_agent); ?></td>
                                <td><?php echo e($log->message); ?></td>
                                <td> <a href="<?php echo e(url('/logs/delete/'.$log->id)); ?>}" title="delete" onclick="return confirm('Are you sure to delete this log ?')" class="btn-danger btn"><i class="fa fa-trash"></i></a></td>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Logger\Resources/views/index.blade.php ENDPATH**/ ?>