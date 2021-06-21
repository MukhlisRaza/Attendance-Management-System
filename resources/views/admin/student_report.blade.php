@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('studentdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('leave')}}">Generate Report</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid col-md-12">
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
            <form action="{{url('admin/studentReport')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Generate Report</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">From</label>
                                    <input type="date" class="form-control" name="from-date" id="from-date" value="{{old('from-date')}}" required>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">To</label>
                                    <input type="date" class="form-control" name="to-date" id="to-date" value="{{old('to-date')}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Student ID</label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Enter Student ID" value="{{old('student_id')}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Students</h3>

                        </div>


                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="attendance" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Student ID #</th>
                                        <th>Student Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($attendanceDetails))
                                    @foreach($attendanceDetails as $student)
                                    <tr>
                                        <td>{{$student['id']}}</td>
                                        <td>{{$student['student_id']}}</td>
                                        <td>{{$student['student_name']}}</td>
                                        <td>{{date('d-m-Y',strtotime($student['created_at']))}}</td>
                                        <td>
                                            @if($student['status'] == "Present")
                                            <span class="badge badge-success">{{$student['status']}}</span>
                                            @elseif($student['status'] == "Absent")
                                            <span class="badge badge-danger">{{$student['status']}}</span>
                                            @else
                                            <span class="badge badge-warning">{{$student['status']}}</span>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection