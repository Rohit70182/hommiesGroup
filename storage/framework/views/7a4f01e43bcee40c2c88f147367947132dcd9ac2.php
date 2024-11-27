<?php $__env->startSection('content'); ?>
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">

			<div class="mb-1 mt-2">
				<ul class="breadcrumb">
					<li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
					<li class="active">Seo Manager</li>
					<li class="active">Meta</li>
					<li class="active">Managers</li>
				</ul>
			</div>
			
			 <div class="page-head-text">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Managers</h3>
                        <a class="btn btn-bg" href="<?php echo e(url('/seo/manager/add')); ?>">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
              </div>
			<div class="page-index">
                    Index
                </div>
				
			<div class="card">
<!--                 <div class="card-header"> -->
<!--                     <div class="ProfileHader d-flex flex-wrap align-items-center"> -->
<!--                         <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Managers</h3> -->
<!--                         <a class="btn btn-bg" href="<?php echo e(url('/seo/manager/add')); ?>"> -->
<!--                             <i class="fa fa-plus"></i> -->
<!--                         </a> -->
<!--                     </div> -->

                    <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Route</th>
                            <th>Title</th>
                            <th>keyword</th>
                            <th>data</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $seo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($single->id); ?></td>
                                <td><?php echo e($single->route); ?></td>
                                <td><?php echo e($single->title); ?></td>
                                <td><?php echo e($single->keywords); ?></td>
                                <td><?php echo e($single->data); ?></td>
                                <td><?php echo e($single->state); ?></td>
                                <td> <a href="<?php echo e(url('/seo/manager/view')); ?>/<?php echo e($single->id); ?>" title="view" class="btn-success btn" data-method="view"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo e(url('/seo/manager/edit')); ?>/<?php echo e($single->id); ?>" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="<?php echo e(url('/seo/manager/remove')); ?>/<?php echo e($single->id); ?>" onclick="return confirm('Are you sure to delete this record ?')" title="delete" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
<!--             </div> -->
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Seo\Resources/views/manager/index.blade.php ENDPATH**/ ?>