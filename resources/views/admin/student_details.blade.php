@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Attendance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('admin/view-students')}}">Students</a></li>
                        <li class="breadcrumb-item active">Student Attendance</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </section>

    @foreach($detail as $userDetails)
    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Presents &nbsp; &nbsp; <span class="badge badge-primary">{{$presentCount}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Absents &nbsp;&nbsp; <span class="badge badge-primary">{{$absentCount}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Leaves &nbsp;&nbsp; <span class="badge badge-primary">{{$leaveCount}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                <tr>
                                    <td colspan="6">
                                        <strong>Attendance Details</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#ID</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                    <th>Date</th>

                                </tr>

                                <tbody>
                                    @foreach($userDetails['attendance'] as $attendance)
                                    <tr>
                                        <td>{{$attendance['id']}}</td>
                                        <td>{{$attendance['student_id']}}</td>
                                        <td>{{$attendance['student_name']}}</td>
                                        <td>
                                            <span class="badge badge-light"> {{$attendance['status']}}</span>
                                        </td>
                                        <td>{{date('d-m-Y',strtotime($attendance['created_at']))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-5">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                <tr>
                                    <td colspan="6">
                                        <strong>Leaves Details</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#ID</th>
                                    <th>Purpose</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                </tr>

                                <tbody>
                                    @foreach($userDetails['leaves'] as $leaves)
                                    <tr>
                                        <td>{{$leaves['id']}}</td>
                                        <td>{{$leaves['purpose']}}</td>
                                        <td>{{$leaves['from']}}</td>
                                        <td>{{$leaves['to']}}</td>
                                        <td>
                                            @if($leaves['status'] == "Approved")
                                            <span class="badge badge-success"> Approved</span>
                                            @else
                                            <span class="badge badge-warning"> Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <br>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @endforeach
</div>

@endsection