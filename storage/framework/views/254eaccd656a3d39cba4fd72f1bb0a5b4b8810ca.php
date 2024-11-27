<?php $__env->startSection('content'); ?>
<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
         <li class="active">Service Providers</li>
      </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
    <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Service Providers</h3>
            <a class="btn btn-bg" href="<?php echo e(url('/serviceProvider/create')); ?>">
              <i class="fa fa-plus mr-1"></i>Add Service Provider
            </a>
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
              <th>Name</th>
              <th>DOB</th>
              <th>Gender</th>
              <th>Address</th>
              <th>Working Hours</th>
              <th>Contact</th>	
              <th>State</th>	
              <th>Actions</th>
            </thead>
            <tbody>
             <?php $__currentLoopData = $provider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($user->id); ?></td>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->date_of_birth); ?></td>
                <td><?php echo e($user->getGender()); ?></td>
                <td><?php echo e($user->address); ?></td>
                <td><?php echo e(TimeFormat($user->start_time)); ?> -- <?php echo e(TimeFormat($user->end_time)); ?></td>
                <td><?php echo e($user->contact); ?></td>
                <td><?php echo e($user->getState()); ?></td>
                <td>
                  <a href="<?php echo e(url('/serviceProvider/show/'.$user->id)); ?>" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo e(url('/serviceProvider/edit/'.$user->id)); ?>" title="edit " class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                  <a href="<?php echo e(url('/serviceProvider/softDelete/'.$user->id)); ?>" onclick="return confirm('Are you sure to change its state ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                
                  </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
          <?php echo e($provider->links()); ?>

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
                [0, 'asc']
            ],
        });
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/ServiceProvider\Resources/views/index.blade.php ENDPATH**/ ?>