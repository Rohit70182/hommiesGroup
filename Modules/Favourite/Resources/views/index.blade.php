@extends('admin.layouts.app')

@section('template_title')
Item
@endsection

@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Favourites</li>
      </ul>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
                        <div class="page-head-text">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="font_600 font-18 font-md-20 mr-auto pr-20">
                            {{ __('Item') }}
                        </span>

                    </div>
                </div>
                
                <div class="page-index">Index</div>
            <div class="card">

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Model Id</th>
                                    <th>Model Class</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->model_id }}</td>
                                    <td>{{ $item->model_type }}</td>
                                    <td class="actions">
                                        <form action="{{ route('item.destroy') }}" method="POST" onsubmit='return confirm("are you sure ?")'>
                                            <a class="btn-success btn " href="{{ route('item.show',$item->id) }}"><i class="fa fa-fw fa-eye"></i> </a>
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{$item->id}}">
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
            {!! $items->links() !!}
        </div>
    </div>
</div>
@endsection