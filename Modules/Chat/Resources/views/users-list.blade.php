@foreach($nuserlist as $chats)
<a onclick="" id="fetch-data<?php echo $chats->id; ?>" data-url="{{url('chat/show/'.$chats->id)}}" href="{{url('chat/show/'.$chats->id)}}" class="chat-person-button chat-person-button list-group-item list-group-item-action py-3 px-8 cursor-pointer border-0">
	<div class="badge bg-success float-right"></div>
	<div class="d-flex align-items-start">
        @if(!empty($chats->image))
        	<img src="{{url('public/uploads/'.$chats->image)}}" class="rounded-circle mr-1" alt="" width="40" height="40">
        @else
        	<img src="{{url('public/assets/images/user.png')}}" class="rounded-circle mr-1" alt="" width="40" height="40">
    @endif
    <div class="flex-grow-1 ml-3">
        <h4 class="chat-name">
            {{$chats->name}}     
	
        </h4>
        	@if($chats->unread_count > 0)
        		<span>{{$chats->unread_count}} </span>
        	@endif
        </div>
    </div>
</a>
@endforeach