@extends('admin.layouts.app')

@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Notifications</li>
    </ul>
</div>
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="page-head-text">
                     <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Notifications</h3>
                    </div>
                </div>
                <div class="page-index">
                Index
                </div>
        
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notify as $notification)
                            <tr>
                                <td>{{$notification->id}}</td>
                                <td>{{$notification->title}}</td>

                                <td> <a href="{{url('/notifications/delete/'.$notification->id)}}}" title="delete" onclick="return confirm('Are you sure to delete this notification ?')" class="btn-danger btn"><i class="fa fa-trash"></i></a></td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                [0, 'desc']
            ],
        });
    });
</script>
@endpush