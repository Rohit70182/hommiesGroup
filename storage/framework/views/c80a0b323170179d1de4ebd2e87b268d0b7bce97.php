<?php $__env->startSection('template_title'); ?>
Item
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
         <li class="active">Favourites</li>
      </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
                        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            <?php echo e(__('Item')); ?>

                        </span>

                    </div>
                </div>
                
                <div class="page-index">Index</div>
            <div class="card">

                <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success">
                    <p><?php echo e($message); ?></p>
                </div>
                <?php endif; ?>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Model Id</th>
                                    <th>Model Class</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($item->model_id); ?></td>
                                    <td><?php echo e($item->model_type); ?></td>
                                    <td class="actions">
                                        <form action="<?php echo e(route('item.destroy')); ?>" method="POST" onsubmit='return confirm("are you sure ?")'>
                                            <a class="btn-success btn " href="<?php echo e(route('item.show',$item->id)); ?>"><i class="fa fa-fw fa-eye"></i> </a>
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                            <button type="submit" class=" btn-danger btn btn-sm"><i class="fa fa-fw fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo $items->links(); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\service-provider-laravel\Modules/Favourite\Resources/views/index.blade.php ENDPATH**/ ?>