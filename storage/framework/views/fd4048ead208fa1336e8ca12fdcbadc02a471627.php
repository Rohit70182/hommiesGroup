<?php $__currentLoopData = $nuserlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<a onclick="" id="fetch-data<?php echo $chats->id; ?>" data-url="<?php echo e(url('chat/show/'.$chats->id)); ?>" href="<?php echo e(url('chat/show/'.$chats->id)); ?>" class="chat-person-button chat-person-button list-group-item list-group-item-action py-3 px-8 cursor-pointer border-0">
	<div class="badge bg-success float-right"></div>
	<div class="d-flex align-items-start">
        <?php if(!empty($chats->image)): ?>
        	<img src="<?php echo e(url('public/uploads/'.$chats->image)); ?>" class="rounded-circle mr-1" alt="" width="40" height="40">
        <?php else: ?>
        	<img src="<?php echo e(url('public/assets/images/user.png')); ?>" class="rounded-circle mr-1" alt="" width="40" height="40">
    <?php endif; ?>
    <div class="flex-grow-1 ml-3">
        <h4 class="chat-name">
            <?php echo e($chats->name); ?>     
	
        </h4>
        	<?php if($chats->unread_count > 0): ?>
        		<span><?php echo e($chats->unread_count); ?> </span>
        	<?php endif; ?>
        </div>
    </div>
</a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Chat\Resources/views/users-list.blade.php ENDPATH**/ ?>