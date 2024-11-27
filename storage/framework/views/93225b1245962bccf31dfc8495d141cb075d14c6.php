<?php $__env->startSection('content'); ?>
<link href="<?php echo e(asset('public/assets/css/chat.css')); ?>" rel="stylesheet">

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>">Home</a></li>
        <li class="active">Chats</li>
    </ul>
</div>

<div class="container-fluid">
<main class="content">
    <div class="p-0">
		<div class="page-head-text">
			<div class="ProfileHader d-flex flex-wrap align-items-center">
				<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Chats</h3>
			</div>
		</div>
		<div class="page-index">Index</div>

		<div class="card chat">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 w-full min-w-0 lg:min-w-100 lg:max-w-100 border-right pr-0">
					
                    <div class="user-list" id='users-list'>
                        <?php echo $__env->make('chat::users-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>
                <?php if($message = Session::get('error')): ?>
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo e($message); ?></strong>
                </div>
                <?php endif; ?>
                <?php if(request()->route('id')): ?>
                <div class="col-12 col-lg-7 col-xl-9 pl-0">
                    <div class="py-3 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1">
                            <div class="position-relative">
                       
                            <?php if(App\Models\User::find(request()->route('id'))->image): ?>
                            <img src="<?php echo e(url('public/uploads/'.App\Models\User::find(request()->route('id'))->image)); ?>" class="rounded-circle mr-3" alt="" width="40" height="40">
                            <?php else: ?>
								<img alt="img"  title="certificate" src="<?php echo e(asset('public/assets/images/user.jpg')); ?>" class="rounded-circle mr-3" alt="" width="40" height="40" >
							<?php endif; ?>
                            </div>
                            <span class="font-weight-bold mb-1"><?php echo e(App\Models\User::find(request()->route('id'))->name); ?></span>
                            <div class="flex-grow-1 pl-3">
                                <strong></strong>
                                <div class="text-muted small"><em></em></div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(request()->route('id')): ?>
                    <div class="position-relative">
                        <div class="chat-messages p-4" id="chat-messages">
                        <?php $__currentLoopData = $formatedMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date=>$messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        	<div class='message-dates'>
                        		<span class='message-date'><?php echo e($date); ?></span>
                        	</div>
                          <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                          	<?php if($chats->to_id == request()->route('id') && !empty($chats->message) && !empty($chats->file) ): ?>
								<div class="chat-message-right pb-4 message-text">                                     
										<?php echo e($chats->message); ?>

								 </div>
                                 <div class="chat-message-right pb-4 ">  
                                      <a><img src="<?php echo e(url('public/uploads/'.$chats->file)); ?>"  width="100px" height="100px"></a>
                                      <a class="img-download" href="<?php echo e(url('public/uploads/'.$chats->file)); ?>" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a>  
                                 </div>
                                 <div class='date_time_format'>
                                	<?php
                                	    $dateTime = new DateTime($chats->created_at);
                                        
                                        echo $dateTime->format('h:i a');
                                	?>
                                </div> 

                             
                          	<?php elseif($chats->to_id == request()->route('id') && !empty($chats->file) && empty($chats->message)): ?>
                                 <div class="chat-message-right pb-4 ">                                     

                                        
                                            <div class="font-weight-bold mb-1 msg-chat-wrapper" >
                                                  <a><img src="<?php echo e(url('public/uploads/'.$chats->file)); ?>"  width="100px" height="100px"></a>  
                                                  <a class="img-download" href="<?php echo e(url('public/uploads/'.$chats->file)); ?>" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a>
                                            </div>                  
                                            <div class='date_time_format'>
                                            	<?php
                                            	    $dateTime = new DateTime($chats->created_at);
                                                    
                                                    echo $dateTime->format('h:i a');
                                            	?>
                                            </div> 
                                                  

                                    </div>
                                    
                          	<?php elseif($chats->to_id == request()->route('id') && !empty($chats->message) && empty($chats->file)): ?>
                            
                             <div class="chat-message-right pb-4 ">                                     

                                        <div class="font-weight-bold mb-1 msg-chat-wrapper message-text" >
                                               <?php echo e($chats->message); ?>

                                        </div>                  
                                        <div class='date_time_format'>
                                        	<?php
                                        	    $dateTime = new DateTime($chats->created_at);
                                                
                                                echo $dateTime->format('h:i a');
                                        	?>
                                        </div> 
                                              

                             </div>
                            
                         <?php endif; ?>
                            
                         <?php if($chats->from_id == request()->route('id') && !empty($chats->message) && empty($chats->file)): ?>
                            <div class="chat-message-left pb-4 ">

                                    <div class="font-weight-bold mb-1 msg-chat-wrapper message-text" >                                 
                                           <?php echo e($chats->message); ?>

                                    </div>
                                    <div class='date_time_format'>
                                    	<?php
                                    	    $dateTime = new DateTime($chats->created_at);
                                            
                                            echo $dateTime->format('h:i a');
                                    	?>
                                    </div> 

                            </div>
                         <?php elseif($chats->from_id == request()->route('id') && !empty($chats->file) && empty($chats->message)): ?> 
                             <div class="chat-message-left pb-4 ">                                     

                                        <div class="font-weight-bold mb-1 msg-chat-wrapper" >
                                              <a><img src="<?php echo e(url('public/uploads/'.$chats->file)); ?>" width="100px" height="100px"></a>  
                                              <a class="img-download" href="<?php echo e(url('public/uploads/'.$chats->file)); ?>" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a>
                                        </div>
                                        <div class='date_time_format'>
                                        	<?php
                                        	    $dateTime = new DateTime($chats->created_at);
                                                
                                                echo $dateTime->format('h:i a');
                                        	?>
                                        </div>                            

                                </div>
                         <?php elseif($chats->from_id == request()->route('id') && !empty($chats->message) && !empty($chats->file)): ?> 
                         	<div class="chat-message-left pb-4 ">                                         
                                <div class="font-weight-bold mb-1 msg-chat-wrapper message-text" >
                                	<?php echo e($chats->message); ?>

                                </div> 
                                <div class="font-weight-bold mb-1 msg-chat-wrapper" >
                                	<a><img src="<?php echo e(url('public/uploads/'.$chats->file)); ?>"  width="100px" height="100px"></a>
                                	<a class="img-download" href="<?php echo e(url('public/uploads/'.$chats->file)); ?>" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a>  
                                </div>
                                <div class='date_time_format'>
                                	<?php
                                	    $dateTime = new DateTime($chats->created_at);
                                        
                                        echo $dateTime->format('h:i a');
                                	?>
                                </div>                    
                             </div>
                         
                         <?php endif; ?> 
                          	
                      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                
                        </div>
                        
                    </div>
                   
                    <div class="flex-grow-0 py-3 px-4 border-top">
                        <div class="input-group">
                            <form class="input-group" id="frmSub" >
                                <input id="message" type="text" name="message" class="form-control ml-1" placeholder="Type your message">
                                <button id="send" type="button" class="btn btn-primary rounded-circle ml-1">
                                      <i class="fa fa-paper-plane" aria-hidden="true"> </i>
                                </button>

                                <input type="file" name="file" id="file" style="display:none"/>
                                <?php echo $errors->first("file", "<span class='text-danger'>message</span>"); ?>

                                 <button class="btn btn-warning ml-1 rounded-circle text-white"  name="file" id="OpenImgUploads"  type="button">
                                  <?php echo $errors->first("file", "<span class='text-danger'>message</span>"); ?>

											<i class="fa fa-paperclip"></i>
								</button>                 

                            </form>       
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
<script>
	var SITEURL = "<?php echo e(url('/')); ?>";
	var to_id = "<?php echo e(request()->route('id')); ?>";
</script>

<script src="<?php echo e(url('/public/assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('/Modules/Chat/Public/chat.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    jQuery('#frmSub').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        file: {
          required: true,
          extension: "jpeg|jpg|png"
        },
        OpenImgUpload: {
          required: true,
          extension: "jpeg|jpg|png"
        },
      },
      messages: {
        file: {
          required: "The image is required.",
          extension: 'jpg, jpeg, png format allowed only'
        },
        OpenImgUpload: {
          required: "The image is required.",
          extension: 'jpg, jpeg, png format allowed only'
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        jQuery(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        jQuery(element).removeClass('is-invalid');
      }
    });
  });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\whizzer-yii2-1836-master\Modules/Chat\Resources/views/chat.blade.php ENDPATH**/ ?>