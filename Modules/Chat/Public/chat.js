var message_html_send_from = `
<div class="chat-message-right pb-4">
    <div class="flex-shrink-1">
        <div class="font-weight-bold mb-1 message-text">
                 replace_message_send_from
        </div>
        <div class="date_time_format">
         	replace_message_time
         </div>
    </div>
</div>
`;


$('#send').on('click', function() {
	
	message = $('#message').val();
	if ($('#message').val() == "") {
		alert('Please write message first');
	} else {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			type: "POST",
			url: SITEURL + '/chat/send/' + to_id,
			data: {
				message: message,
			},
			success: function(data) {
				
				if (data.message) {



					result = message_html_send_from.replace('replace_message_send_from', data.message);
					result = result.replace('replace_message_time', data.time);
					$('#chat-messages').append(result);
					$('.chat-messages').animate({ scrollBottom: 0 }, 1);
					$('#chat-messages').animate({
						scrollTop: $('#chat-messages')[0].scrollHeight
					}, 1000);
				}
				else {
					result = message_html_send_file;
					$('#chat-messages').append(result);

				}
			}
		});
		document.getElementById("frmSub").reset();
	}
});

var message_html_send_file = `
<div class="chat-message-right pb-4">
    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">                                   
		<div class="font-weight-bold mb-1 msg-chat-wrapper">
		      <a><img  src="replace_image _send"  width="100px" height="100px"></a>
		      <a class="img-download" href="replace_image _send_url" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a>
		      <div class="date_time_format">
	         	replace_message_time
	         </div>
		</div>                                                                   
   </div>
</div>  
`;

 $('#OpenImgUploads').on('click', function() { 
	$('#file').trigger('click');
	
	$('input[type="file"]').change(function(e) {
		
		var files = $(this)[0].files;
		
		if (files.length > 0) {
			var fd = new FormData();
			fd.append('file', files[0]);
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			// AJAX request 
			$.ajax({
				url: SITEURL + '/chat/send/' + to_id,
				type: "POST",
				data: fd,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(data) {
					
					result = message_html_send_file.replace('replace_image _send', data.file);
					result = result.replace('replace_image _send_url', data.file);
					result = result.replace('replace_message_time', data.time);
					$('#chat-messages').append(result);
				}
	
			});
		}
		
		$(this).val('');
     });
});

var message_html = `
<div class="chat-message-left pb-4">
    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
        <div class="font-weight-bold mb-1 msg-chat-wrapper message-text">
                 replace_message_send_to
         </div>
         <div class="date_time_format">
         	replace_message_time
         </div>
    </div>
</div>
`;


function fetchdata() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	if (to_id) {
		$.ajax({
			url: SITEURL + '/chat/get-message/' + to_id,
			type: 'POST',
			data: {
				'to_id': to_id,
			},
			success: function(data) {
				if(data.time) {
					var date = data.time;
				}
				if (data.message && !data.image) {
					var scroll_height = $('.chat-messages').height();
					var scroll_height = scroll_height + 1000;
					$('.chat-messages').animate({ scrollTop: scroll_height }, 1);
	
					result = message_html.replace('replace_message_send_to', data.message);
					result = result.replace('replace_message_time', date);
					$('#chat-messages').append(result);
				} else if(!data.message && data.image) {
					var image = '<div class="chat-message-left pb-4"><div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"><div class="font-weight-bold mb-1 msg-chat-wrapper"><img src="'+data.image+'" height="100" width="100"><a class="img-download" href="'+data.image+'" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a></div><div class="date_time_format">'+date+'</div></div></div>';
					$('#chat-messages').append(image);
				} else if (data.message && data.image) {
					var imageMessage = '<div class="chat-message-left pb-4"><div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"><div class="font-weight-bold mb-1 msg-chat-wrapper"><img src="'+data.image+'" height="100" width="100"><a class="img-download" href="'+data.image+'" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i></a></div><div class="font-weight-bold mb-1 msg-chat-wrapper"><p class="image_text_message message-text">'+data.message+'</p></div><div class="date_time_format">'+date+'</div></div></div>';
					$('#chat-messages').append(imageMessage);
				}
			}
	
		});
	}
}

function getList() {
	$.ajax({
		url: SITEURL + '/chat/get-user-list',
		type: 'GET',
		success: function(data) {
			$('#users-list').empty();
			var usersList = data;
			var currentUrl = location.href;
			$(usersList).each(function(index) {
				if(this.count > 0) {
					var count = '<span>'+this.count+'</span>';
				} else {
					var count = '';
				}
				var userAppend = '<a onclick="" id="fetch-data'+this.id+'" data-url="'+this.href+'" href="'+this.href+'" class="chat-person-button list-group-item list-group-item-action py-3 px-8 cursor-pointer border-0"><div class="badge bg-success float-right"></div><div class="d-flex align-items-start"><img src="'+this.image+'" class="rounded-circle mr-1" alt="" width="40" height="40"><div class="flex-grow-1 ml-3"><h4 class="chat-name">'+this.name+'</h4>'+count+'</div></div></a>';
				$('#users-list').append(userAppend);
			});
			$('.chat-person-button').each(function(index){
				var ongoing = $(this).attr('data-url');
				if(ongoing == currentUrl) {
					$(this).addClass('active');
				}
			});
		}
	});
}

$(document).ready(function() {
	setInterval(function() {
		fetchdata();
		getList();
	}, 2000);
	
	var currentUrl = location.href;
	$('.chat-person-button').each(function(index){
		var ongoing = $(this).attr('data-url');
		if(ongoing == currentUrl) {
			$(this).addClass('active');
		}
	});
	
	$('.chat-person-button').on('click',function(){
		$('.chat-person-button').removeClass('active');
		$(this).addClass('active');
	});
	
});




