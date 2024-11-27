<header class="laundry-header-transparent">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                 <img src="<?php echo e(asset('public/assets/images/logoleft.png')); ?>" alt="laundry" width="80%">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-lg-auto align-items-center mr-lg-20 order-2 order-lg-1">
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(asset('public/assets/images/logoleft.png')); ?>" alt="laundry" width="80%">
                        </a>
                    </li>
                    <?php if(auth()->guard()->guest()): ?>
<!--                     <li class="nav-item  "> -->
<!--                         <a class="nav-link btn btn-bg log_buttn" href="<?php echo e(url('/register')); ?>">Sign-up</a> -->
<!--                     </li> -->
                    <li class="nav-item ">
                        <a class="nav-link btn btn-bg log_buttn" href="<?php echo e(url('/login')); ?>">Log In</a>
                    </li>
                    <?php endif; ?>
                    <?php if(Auth::check()): ?>
                    <li class="nav-item dropdown ProfileDrop">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><?php echo e(Auth::User()->name); ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo e(url('/dashboard')); ?>">
                                <i class="far fa-tachometer"></i>
                                <span>Dashboard</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(url('/dashboard/myprofile')); ?>">
                                <i class="far fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <!-- here goes logout-->
                            <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="far fa-sign-out"></i> <span><?php echo e(__('Logout')); ?></span>
                            </a>
                            <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH C:\xampp\htdocs\service-provider\resources\views/layouts/header.blade.php ENDPATH**/ ?>