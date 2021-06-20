@extends('layouts.front_layout.front_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Attendance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('studentdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">View Attendance</li>
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
                        <h3 class="card-title">All Attendance</h3>
                        <!-- <a href="{{url('admin/add-edit-coupon')}}"><button type="button" class="btn btn-warning btn-sm float-right"> <i class="far fa-plus-square"></i> Add coupon</button></a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="attendance" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Attendance ID</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentDetails as $attendance)
                                <tr>
                                    <td>{{$attendance['id']}}</td>
                                    <td>{{$attendance['student_id']}}</td>
                                    <td>{{$attendance['student_name']}}</td>
                                    <td>{{$attendance['status']}}</td>
                                    <td><span class="badge badge-success">{{date('j F, Y', strtotime($attendance['created_at']))}}</span></td>
                                    <td><span class="badge badge-success">{{date('(g:i a)', strtotime($attendance['created_at']))}}</span></td>
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