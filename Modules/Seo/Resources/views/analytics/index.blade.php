@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="mb-1 mt-2">
				<ul class="breadcrumb">
					<li><a href="{{url('/dashboard')}}">Home</a></li>
					<li class="active">Seo Manager</li>
					<li class="active">Analytics</li>
				</ul>
			</div>
			
                <div class="page-head-text">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Analytics</h3>
                        <a class="btn btn-bg" href="{{url('/seo/analytics/add')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>

                </div>
                
                <div class="page-index">
                    Index
                </div>
                
                <div class="card">
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Account</th>
                            <th>Domain Name</th>
                            <th>Analytics Type</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($analytics as $single)
                            <tr>
                                <td>{{$single->id}}</td>
                                <td>{{$single->account}}</td>
                                <td>{{$single->domain_name}}</td>
                                <td>{{$single->type}}</td>
                                <td>{{$single->get_created_by->name}}</td>
                                <td>{{$single->state}}</td>
                                <td> <a href="{{url('/seo/analytics/view')}}/{{$single->id}}" title="view" class="btn-success btn" data-method="view"><i class="fa fa-eye"></i></a>
                                <a href="{{url('/seo/analytics/edit')}}/{{$single->id}}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="{{url('/seo/analytics/remove')}}/{{$single->id}}" onclick="return confirm('Are you sure to delete this record ?')" title="delete" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                                </td>
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