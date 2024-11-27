@extends('admin.layouts.app')

@section('template_title')
Faq
@endsection

@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Faqs</li>
      </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            {{ __('Faqs') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('add_faq') }}" class="btn btn-bg btn-sm float-right" data-placement="left">
                                {{ __('Create New') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="page-index">Index</div>
            <div class="card">
               
<!--                 @if ($message = Session::get('success')) -->
<!--                 <div class="alert alert-success"> -->
<!--                     <p>{{ $message }}</p> -->
<!--                 </div> -->
<!--                 @endif -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="datatable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Question</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $key=>$faq)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td class="actions">
                                        <form action="{{ route('faq.destroy') }}" method="POST" onsubmit='return confirm("are you sure to delete this ?")'>
                                            <a class="btn-success btn" href="{{ route('faq.show',$faq->id) }}" title="view"><i class="fa fa-fw fa-eye"></i></a>
                                            <a class="btn btn-bg " href="{{ route('faq.edit',$faq->id) }}"  title="edit"><i class="fa fa-fw fa-edit"></i> </a>
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{$faq->id}}" >
                                            <button type="submit" class="btn-danger btn btn-sm" title="delete"><i class="fa fa-fw fa-trash"></i> </button>
                                        </form>
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
        $('#datatable').DataTable({
            order: [
                [0, 'DESC']
            ],
        });
    });
</script>
@endpush