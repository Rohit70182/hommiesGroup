@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Update Event</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <form method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label> update event TITLE</label>
                        <input type="text" class="form-control" name="name" value="">

                    </div>

                    <div class="form-group">
                        <label>update STATE_ID</label>
                        <input type="text" name="desc" class="form-control" value=""></input>

                    </div>
                    <div class="form-group">
                        <label>update TYPE_ID</label>
                        <input type="text" name="desc" class="form-control" value=""></input>

                    </div>

                    <div class="form-group">
                        <label>update SERVICES</label>
                        <input type="text" name="desc" class="form-control" value=""></input>

                    </div>


                    <div class="form-group">
                        <input type="submit" class="btn btn-bg" name="submit" value="submit">
                    </div>
                </div>


            </div>
    </div>

    </form>
</div>
</div>
@endsection