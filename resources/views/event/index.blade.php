@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Add Event</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
         <div class="page-head-text">
                     <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Events</h3>
                        <a class="btn btn-bg" href="{{url('/event/add')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="page-index">
                Index
                </div>

            <div class="card">

                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Show Events</h3>

                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project">
                        <thead>
                        	<th>Id</th>
                            <th>Title</th>
                            <th>State</th>
                            <th>Services</th>
                            <th>Price</th>
                           <th>Actions</th>
                        </thead>
                        <tbody>
							@foreach($event as $events)
							<tr>
                            <td>{{$events->id}}</td>
                            <td>{{$events->title}}</td>
                            <td>{{$events->getStateAttribute()}}</td>
                            <td>{{$events->getService()}}</td>
                            <td>{{$events->price}}</td>
                            <td> 
                             	<a href="{{url('show/'.$events->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
              					<a href="{{url('edit/'.$events->id)}}" title="edit " class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
              					<a href="{{url('softDelete/'.$events->id)}}" onclick="return confirm('Are you sure to change its state?')" title="change state" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                           </td>
                            @endforeach
                           </tr>
                       </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('styles')
<!-- Data Table CSS -->
<link rel="stylesheet" href="{{asset('public/dataTables/dataTables.min.css')}}">
@endpush
@push('scripts')
<!-- Data Table Script -->
<script src="{{asset('public/dataTables/dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            order: [
                [0, 'DESC']
            ],
        });
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    })

</script>

@endpush