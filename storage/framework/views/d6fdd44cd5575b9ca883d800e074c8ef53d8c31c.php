<?php $__env->startSection('content'); ?>
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">My Profile</li>
    </ul>
</div>

<div class="dash-home-cards">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="ProfileHader d-flex flex-wrap align-items-center">
						<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">My Profile</h3>
						<h5><a class=" btn btn-bg" href="<?php echo e(url('dashboard/myprofile/edit/'.$userinfo->id)); ?>"><i class="fa fa-fw fa-edit"></i></a></h5>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
<!-- 					<a class=" btn btn-bg" href="<?php echo e(url('dashboard/myprofile/edit/'.$userinfo->id)); ?>"><i class="fa fa-fw fa-edit"></i></a> -->
						<div class="col-md-2 col-12">
							<?php if($userinfo->image): ?>
							<img src="<?php echo e(url('public/uploads/'.$userinfo->image)); ?>" class="profile">
							<?php else: ?>
							<img src="<?php echo e(asset('public/assets/images/user.jpg')); ?>" class="profile">
							<?php endif; ?>
						</div>
						<div class="col-md-10 col-12"> 
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<th>Id</th>
										<td><?php echo e($userinfo->id); ?></td>
										<th>Name</th>
										<td><?php echo e($userinfo->name); ?></td>
									</tr>
									
									<tr>
										<th>Email</th>
										<td class="text-primary"><?php echo e($userinfo->email); ?></td>
										<th>Mobile</th>
										<td><?php echo e($userinfo->phone); ?></td>
<!-- 										<th>DOB</th> -->
<!-- 										<td><?php echo e($userinfo->dob); ?></td> -->
									</tr>
									<tr>
<!-- 										<th>Address</th> -->
<!-- 										<td><?php echo e($userinfo->address); ?></td> -->
<!-- 										<th>Mobile</th> -->
<!-- 										<td><?php echo e($userinfo->phone); ?></td> -->
									</tr>
									<tr>
										<th>Updated On</th>
										<td><?php echo e(DateFormat($userinfo->updated_at)); ?></td>
										<th>Created On</th>
										<td><?php echo e(DateFormat($userinfo->created_at)); ?></td>

									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\resources\views/dashboard/myprofile/personaldetails.blade.php ENDPATH**/ ?>