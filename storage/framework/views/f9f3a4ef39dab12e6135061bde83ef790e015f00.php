<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
		<li class="active">User</li>
	</ul>
</div>


<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text">
				<div class="ProfileHader d-flex flex-wrap align-items-center">
					<h3 class="font_600 font-18 font-md-20 mr-auto pr-20"> <?php echo e($show->name); ?></h3>
					<div class="float-right">
					</div>
					<div class="float-right">
						<a href="<?php echo e(url('dashboard/users/edit/'.$show->id)); ?>" title="edit users" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
						<a href="<?php echo e(url('dashboard/users/delete/'.$show->id)); ?>" onclick="return confirm('Are you sure to delete this user ?')" title="delete user" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
						<a class="btn btn-bg ml-1" href="<?php echo e(url('dashboard/users')); ?>"> Back</a>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header ">
					
				</div>
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<?php if($show->image): ?>
								<img alt="img" title="" class=" isTooltip" src="<?php echo e(url('public/uploads/'.$show->image)); ?>">
								<?php else: ?>
								<img alt="img" class=" isTooltip" src="<?php echo e(asset('public/assets/images/user.jpg')); ?>">
								<?php endif; ?>
							</div>
							<div class="col-md-8">
								<!-- <strong>Information</strong><br> -->
								<div class="table-responsive">
									<table class="table table-user-information table table-bordered">
										<tbody>
											<tr>
												<th>
													<span class="text-dark">Name</span>
												</th>
												<td>
													<span><?php echo e($show->name); ?></span>
												</td>

												<th>
													<span class="text-dark">Email </span>
												</th>
												<td>
													<span><?php echo e($show->email); ?></span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">DOB </span>
												</th>
												<td>
													<strong>
														<span class="text-dark"> </span>
														<?php echo e(DateFormat($show->dob)); ?>

													</strong>
												</td>
												<th>
													<span class="text-dark">Address </span>
												</th>
												<td>
													<span><?php echo e($show->address); ?></span>
												</td>

											</tr>
											<tr>
												<th>
													<span class="text-dark">Phone</span>
												</th>
												<td>
													<span><?php echo e($show->phone); ?></span>
												</td>
												<th>
													<span class="text-dark">Created On </span>
												</th>
												<td>
													<span><?php echo e($show->created_at); ?></span>
												</td>

												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Role</span>
												</th>
												<td>
													<span><?php echo e($show->getRole()); ?></span>
												</td>
												<th>

												</th>
												<td>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/dashboard/user-management/show.blade.php ENDPATH**/ ?>