@extends('layouts.front_layout.front_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Leave Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('studentdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Leave</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Leave Request</h3>
                        <a href="{{url('request-leave')}}"><button type="button" class="btn btn-warning btn-sm float-right"> <i class="far fa-plus-square"></i> Request </button></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="attendance" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Request Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($request as $requests)
                                <tr>
                                    <td>{{$requests['id']}}</td>
                                    <td>{{$requests['student_id']}}</td>
                                    <td>{{$requests['student_name']}}</td>
                                    <td>{{$requests['purpose']}}</td>
                                    <td>
                                        @if($requests['status'] == 'Pending')
                                        <span class="badge badge-warning">{{$requests['status']}}</span>
                                        @else
                                        <span class="badge badge-success">{{$requests['status']}}</span>
                                        @endif
                                    </td>
                                    <td>{{$requests['from']}}</td>
                                    <td>{{$requests['to']}}</td>
                                    <td>{{date('j F, Y', strtotime($requests['created_at']))}}</td>
                                </tr>
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
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection