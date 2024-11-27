@extends('admin.layouts.app')

@section('content')
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
 
          </div>
          @endif
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Comments</h3>
            <a class="btn btn-bg" href="{{ url('/comment/add-comment') }}">
              <i class="fa fa-plus"></i>
            </a>
          </div>

        </div>
        <div class="card-body table-responsive">
          <table id="ThemeTable" class="table table-bordered projects">
            <thead>
              <th>S No</th>
              <th>ID</th>
              <th>Model</th>
              <th>Model Type</th>
              <th>Comment</th>
              <th>State</th>
              <th>Created On</th>
              <th>Created By</th>
              <th width="150px">Actions</th>
            </thead>
            <tbody>
              @foreach($comments as $k=>$comment)
              <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->model_id }}</td>
                <td>{{ $comment->model_type }}</td>
                <td>{{ $comment->title }}</td>
                <td>{{ $comment->getState() }}</td>
                <td>{{ $comment->created_at }}</td>
                <td>{{ $comment->getUser->name }}</td>
                <td>  <a href="{{ route('comment.show',$comment->id) }}" title="view category" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('/comment/delete/'.$comment->id) }}" onclick="return confirm('Are you sure?')" title="delete comment" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                 
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {!! $comments->links() !!}
</div>
</div>
@endsection