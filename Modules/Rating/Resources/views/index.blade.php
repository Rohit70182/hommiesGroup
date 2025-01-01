@extends('admin.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Ratings </h3>
            <a class="btn btn-bg" href="{{ url('/rating/add-rating') }}">
              <i class="fa fa-plus"></i>Add Rating
            </a>
          </div>

        </div>
      <div class="card-body">
        <div class="table-responsive grid-wrapper">
          <table class="table table-bordered table-hover">
            <thead class="">
              <tr class="filter-header">
                <th>S No</th>
                <th>ID</th>
                <th>Model</th>
                <th>Model Type</th>
                <th>Rating</th>
                <th>State</th>
                <th>Created On</th>
                <th>Created By</th>
                <th>Actions</th>
              </tr>
              <!-- <tr>
                <th></th>
                <th>
                  <input type="text" name="id" class="form-control" placeholder="filter by id">
                </th>
                <th>
                  <input type="text" name="model_id" class="form-control" placeholder="filter by model_id">
                </th>
                <th>
                  <input type="text" name="model_type" class="form-control" placeholder="filter by model_type">
                </th>
                <th>
                  <input type="text" name="rating" class="form-control" placeholder="filter by rating">
                </th>
                <th>
                    <select class="form-control" name="state">
                        <option value="">filter by state</option>
                        <option value="0">New</option>
                        <option value="1">Active</option>
                        <option value="2">Deleted</option>
                    </select>
                </th>
                <th>
                  <input type="text" name="created_on" class="form-control" placeholder="filter by created_on">
                </th>
                <th>
                  <input type="text" name="created_by" class="form-control" placeholder="filter by created_by">
                </th>
                <th class="">
                </th>
              </tr> -->
            </thead>
            <tbody>
                @foreach($ratings as $k=>$rating)
                  <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $rating->id }}</td>
                    <td>{{ $rating->model_id }}</td>
                    <td>{{ $rating->model_type }}</td>
                    <td>{{ $rating->rating }}</td>
                    <td>{{ $rating->getState() }}</td>
                    <td>{{ $rating->created_at }}</td>
                    <td>{{ $rating->getUser->name }}</td>
                    <td class="actions">
                        <form action="{{ route('rating.destroy') }}" method="POST" onsubmit='return confirm("are you sure ?")'>
                            <a class="btn-success btn" href="{{ route('rating.show',$rating->id) }}"><i class="fa fa-fw fa-eye"></i> </a>
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name ="id" value="{{$rating->id}}">
                            <button type="submit" class=" btn-danger btn btn-sm"><i class="fa fa-fw fa-trash"></i> </button>
                        </form>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {!! $ratings->links() !!}
  </div>
</div>
@endsection
