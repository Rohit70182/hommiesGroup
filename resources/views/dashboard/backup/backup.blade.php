@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Manage</li>
         <li class="active">Backup</li>
      </ul>
</div>
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
            <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Manage database backup files </h3>
            <a class="btn btn-bg" href="{{ url('/backup/create') }}">
              <i class="fa fa-plus mr-1"></i>Create Backup
            </a>
          </div>

        </div>
        <div class="page-index">
        Index
        </div>
      <div class="card">

        <div class="card-body table-responsive">
          <table class="table table-bordered projects" id="datatable">
            <thead>
              <tr>
                <th>Serial</th>
                <th>Name</th>
                <th>size</th>
                <th>extension</th>
                <th>Date & Time of Creation</th>
                <th colspan="3px">Actions</th>
              </tr>
            </thead>
            @php $serial=1 @endphp
            <tbody>
              @foreach($names as $file)
              <tr>
                <td>{{$serial++}}</td>
                <td>{{$file['filename']}}</td>
                <td>{{$file['filesize']}}</td>
                <td>{{$file['ext']}}</td>
                <td>{{date("F d Y H:i:s.", $file['time'])}}</td>

                <td><a href="{{url('backup/download/'.$file['filename'])}}" title="download" class="btn btn-bg" data-method="Download" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-download"></i></a>
                  <a href="{{url('backup/restore/'.$file['filename'])}}" onclick="return confirm('Are you sure?')" title="restore" class="btn btn-bg" data-method="restore" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fas fa-sync"></i></a>
                  <a href="{{url('backup/delete/'.$file['filename'])}}" onclick="return confirm('Are you sure?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a></td>

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
        order: [[0, 'DESC']],
"bPaginate": false
    });
    });
</script>

@endpush