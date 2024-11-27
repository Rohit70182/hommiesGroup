@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Managers</h3>
                        <a class="btn btn-bg" href="{{url('/stripe/settings/add')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>

                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered projects">
                        <thead>
                            <th>Id</th>
                            <th>Publishable Key</th>
                            <th>Secret Key</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($settings as $single)
                            <tr>
                                <td>{{$single->id}}</td>
                                <td style="word-break: break-all;">{{$single->publishable_key}}</td>
                                <td style="word-break: break-all;">{{$single->secret_key}}</td>
                                <td> <a href="{{url('/stripe/settings/view')}}/{{$single->id}}" title="view user" class="btn-success btn" data-method="view"><i class="fa fa-eye"></i></a>      
                                    <a href="{{url('/stripe/settings/edit')}}/{{$single->id}}" title="edit users" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/stripe/settings/remove')}}/{{$single->id}}" onclick="return confirm('Are you sure?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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
        $('#datatable').DataTable();
    });
</script>
@endpush