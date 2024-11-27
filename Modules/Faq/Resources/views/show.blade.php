@extends('admin.layouts.app')

@section('template_title')
{{ $faq->title ?? 'Show Faq' }}
@endsection

@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
         <li class="active">Show Faq</li>
      </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="page-head-text d-flex flex-wrap justify-content-between">
                    <div class="float-left">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Show Faq</span>
                    </div>
                    <div class="float-right">
                    
						<form action="{{ route('faq.destroy') }}" method="POST" onsubmit='return confirm("are you sure to delete this ?")'>
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$faq->id}}">
						<a href="{{ route('faq.edit',$faq->id) }}" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>					
                            <button type="submit" class="btn-danger btn " title="delete"><i class="fa fa-fw fa-trash"></i> </button>
                        <a class="btn btn-bg" href="{{ route('faq') }}"> Back</a>
                        </form>
                    </div>
                </div>

            <div class="card">
               

                <div class="card-body">
                <div class="table-responsive">
                    <table id="faq-detail-view" class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Question:</th>
                                <td colspan="1"> {{ $faq->question }}</td>
                            </tr>
                            <tr>
                                <th>Answer:</th>
                                <td colspan="1">  {{ $faq->answer }}</td>
                            </tr>
                                </tbody>
                                </table>
                                </div>
                                                    


                </div>
            </div>
        </div>
    </div>
</section>
@endsection