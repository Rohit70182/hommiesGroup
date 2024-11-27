<div class="card-body col-md-12">
    <form action="{{ url('/dashboard/comment/') }}" method="POST">
        @csrf
        <div class="border-dark box_general_3 write_review mt-3">
            <div class="form-group">
                <label class="font_600 font-18 font-md-16 mr-auto pr-20">Comment</label>
                <input type="hidden" name="model_id" value="{{request()->route('id')}}">
                <input type="hidden" name="model_type" value="{{Modules\Comment\Entities\Comment::getModelName()}}">
                <textarea class="border-dark form-control sentence" name="title" style="height: 180px;" placeholder="Leave comment..."></textarea>
                @if($errors->has('title'))
                <div class="error text-danger">{{ $errors->first('title') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-bg">Add</button>
        </div>
    </form>
</div>
<label class="card-head font_600 font-18 font-md-16 mr-auto pr-20 box_general_3 write_review mt-3">Comments</label>
@foreach($comments as $comment)
<div class="card-body col-md-12">
    <div class="col-md-12 d-flex flex-row comment-row">
        <div class="p-2"><span class="round"><img src="{{url('public/uploads/'.$comment->getUser->image)}}" alt="user" width="50"></span></div>
        <div class="comment-text w-100">
            <span class="font_700 font-18 font-md-20 mr-auto pr-20">{{$comment->getUser->name}}</span>
            <p class="m-b-5 m-t-10 ">{{$comment->title}}</p>
            <div class="comment-footer">
                <span class="date text-success">{{$comment->created_at->format('d/m/y')}}</span>
            </div>
        </div>
    </div>
</div>
<hr>
@endforeach