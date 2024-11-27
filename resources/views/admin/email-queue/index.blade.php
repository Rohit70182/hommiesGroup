<?php 
use App\Models\User;
?>
@extends('admin.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Email Queue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Email Queue</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of all Email In Queue	</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>From Email</th>
                    <th>To Email</th>
                    <th>Subject</th>
                    <th>Date Sent</th>
                    <th>State</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 1;
                    ?>
                @foreach(@$emails as $key=>$value)
                  <tr>
                    <td>{{ @$count }}</td>
                    <td>{{ $value->from_email }}</td>
                    <td>{{ $value->to_email }}</td>
                    <td>{{ $value->subject }}</td>
                    <td>{{ $value->date_sent}}</td>
                    <td>{{ $value->getState() }}</td>
                    <td>
                      <a class="btn btn-info btn-sm" href = "{{url('/admin/email-queue/'.encrypt($value->id))}}" >
                        <i class="fas fa-eye"></i>View
                      </a>
                      <a class="btn pl-0 btn-sm">
                        <form action="{{ url('admin/email-queue/delete/'. encrypt(@$value->id)) }}" method="post">
                          @csrf
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item? ');">
                            <i class="fas fa-trash"></i> Delete
                            <input type="hidden" name="id" value="{{ encrypt(@$value->id) }}">
                          </button>
                        </form>
                      </a>
                    </td>
                  </tr>
                  <?php
                  $count++;
                  ?>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
