<?php if(Auth::check()): ?>
<div class="ProfileDrop">
    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="<?php echo e(get_current_pic()); ?>" alt="">

        <span><?php echo e(Auth::check() ?  \Auth::User()->name : ''); ?></span>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
<!--         <a class="dropdown-item" href="<?php echo e(url('/dashboard')); ?>"> -->
<!--             <i class="far fa-tachometer"></i> -->
<!--             <span>Dashboard</span> -->
<!--         </a> -->
        <a class="dropdown-item" href="<?php echo e(url('/dashboard/myprofile')); ?>">
            <i class="far fa-user"></i>
            <span>My Profile</span>
        </a>
        <a class="dropdown-item" href="<?php echo e(url('change-password')); ?>">
            <i class="far fa-lock"></i>
            <span>Change Password</span>
        </a>
        <a class="dropdown-item" href="<?php echo e(url('dashboard/myprofile/edit/'.Auth::user()->id)); ?>">
            <i class="far fa-pencil"></i>
            <span>Profile Update</span>
        </a>

        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="far fa-sign-out"></i> <span><?php echo e(__('Logout')); ?></span>
        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\hommiesGroup\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>