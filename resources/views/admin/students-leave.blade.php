@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Leaves</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>

                        <li class="breadcrumb-item active">Student Leave</li>
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
        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </section>


    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Students &nbsp; &nbsp; <span class="badge badge-primary">{{$totalStudent}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ToDay Total Presents &nbsp;&nbsp; <span class="badge badge-primary">{{$totalPresent}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ToDay Total Absents &nbsp;&nbsp; <span class="badge badge-danger">{{$totalAbsent}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ToDay Total Leaves &nbsp;&nbsp; <span class="badge badge-warning">{{$totalLeave}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
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

                                    <th style="width: 10%;">Student ID</th>
                                    <th style="width: 20%;">Student Name</th>
                                    <th style="width: 30%;">Purpose</th>
                                    <th>Status</th>
                                    <th style="width: 12%;">From</th>
                                    <th style="width: 12%;">To</th>
                                    <th colspan="2" style="width: 10%;">Action</th>

                                </tr>
                                @foreach($leaves as $leave)
                                <tbody>

                                    <td>{{$leave['student_id']}}</td>
                                    <td>{{$leave['student_name']}}</td>
                                    <td>{{$leave['purpose']}}</td>
                                    <td>
                                        @if($leave['status']=="Approved")
                                        <span class="badge badge-success"> {{$leave['status']}}</span>
                                        @elseif($leave['status']=="Pending")
                                        <span class="badge badge-warning"> {{$leave['status']}}</span>
                                        @else
                                        <span class="badge badge-danger"> {{$leave['status']}}</span>
                                        @endif
                                    </td>
                                    <td>{{date('d-m-Y',strtotime($leave['from']))}}</td>
                                    <td>{{date('d-m-Y',strtotime($leave['to']))}}</td>
                                    <td>
                                        <form action="{{url('admin/markLeave')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="leave_id" id="leave_id" value="{{$leave['id']}}">
                                            <input type="hidden" name="student_id" id="student_id" value="{{$leave['student_id']}}">
                                            <input type="hidden" name="fromdate" id="fromdate" value="{{$leave['from']}}">
                                            <input type="hidden" name="todate" id="todate" value="{{$leave['to']}}">
                                            <button type="submit" class="btn btn-outline-primary" name="adminMark" value="Approved">Approved</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{url('admin/markLeave')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="leave_id" id="leave_id" value="{{$leave['id']}}">
                                            <input type="hidden" name="student_id" id="student_id" value="{{$leave['student_id']}}">
                                            <input type="hidden" name="fromdate" id="fromdate" value="{{$leave['from']}}">
                                            <input type="hidden" name="todate" id="todate" value="{{$leave['to']}}">
                                            <button type="submit" class="btn btn-outline-danger" name="adminMark" value="Rejected">Rejected</button>
                                        </form>
                                    </td>
                                </tbody>
                                @endforeach
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

</div>

@endsection