<?php

    use Modules\Services\Entities\CustomReq;

?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Services</li>
        <li class="active">Custom Requests</li>
    </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
    
    <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Custom Requests</h3>
             <?php if(Auth::user() && Auth::user()->role == App\Models\User::ROLE_USER): ?>
            <a class="btn btn-bg" href="<?php echo e(url('/services/custom-req/add')); ?>">
              <i class="fa fa-plus mr-1"></i>Add Custom Service
            </a>
            <?php endif; ?>
          </div>
     </div>
    
     <div class="page-index">
          Index
     </div>
    
      <div class="card">
        
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Title</th>
              <th>Desc</th>
              <th>User-Name</th>
              <th>Status</th>
<!--               <th>Profile file</th> -->
<!--               <th>State</th> -->
              <th>Action</th>
            </thead>
            <tbody>
             <?php $__currentLoopData = $custom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $custom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($custom->id); ?></td>
                <td><?php echo e($custom->name); ?></td>
                <td><?php echo e($custom->desc); ?></td>
                <td><?php echo e($custom->user->name); ?></td>
				<td>
					<?php switch($custom->state_id):
						case (CustomReq::STATE_ACCEPTED): ?>
							Accepted
						<?php break; ?>;
						<?php case (CustomReq::STATE_REJECTED): ?>
							Rejected
						<?php break; ?>;
						<?php default: ?>
							Pending
					<?php endswitch; ?>
				</td>

                <td>
                  <a href="<?php echo e(url('/services/custom-req/show/'.$custom->id)); ?>" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
<!--                   <a href="<?php echo e(url('/services/custom-req/edit/'.$custom->id)); ?>" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a> -->
            	  <a href="<?php echo e(url('/services/custom-req/remove/'.$custom->id)); ?>" onclick="return confirm('Are you sure to delete this custom request ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Services\Resources/views/custom/index.blade.php ENDPATH**/ ?>