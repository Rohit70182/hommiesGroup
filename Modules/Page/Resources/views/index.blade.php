@extends('admin.layouts.app')

@section('template_title')
Page
@endsection

@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Pages</li>
  </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            {{ __('Pages') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('add_page') }}" class="btn btn-bg btn-sm float-right" data-placement="left">
                                {{ __('Create New') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="page-index">
                    Index
                </div>
            <div class="card">
               
                

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="datatable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>State</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $key=>$page)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $page->title }}</td>
                                 
                                    <td>{{ $page->getType() }}</td>
                                    <td>{{ $page->getState() }}</td>
                                    <td class="actions">
                                            <a class="btn-success btn" href="{{ route('page.show',$page->id) }}"  title="view"><i class="fa fa-fw fa-eye"></i> </a>
                                            <a class="btn btn-bg" href="{{ route('page.edit',$page->id) }}" title="edit"><i class="fa fa-fw fa-edit"></i> </a>
                                            <input type="hidden" name="id" value="{{$page->id}}">
                                            <a class="btn-danger btn btn-sm" href="{{ route('page.destroy',$page->id) }}" title="delete" onclick="return confirm('Are you sure to delete it ?')" ><i class="fa fa-fw fa-trash"></i> </a>
                                            
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