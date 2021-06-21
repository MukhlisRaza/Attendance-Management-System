@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Grading</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('studentdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Grading</li>
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
        </div>
        <form action="{{url('admin/studentGrade')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Generate Grade</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Enter Student ID</label>
                                <input type="text" class="form-control" name="student_id" id="from-student_id" placeholder="Enter Student ID" required>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Students Grading</h3>

                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="attendance" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>Student ID #</th>
                                    <th>Student Name</th>
                                    <th>Total Present</th>
                                    <th>Total Absent</th>
                                    <th>Total Leave</th>
                                    <th>Percentage</th>
                                    <th>Grade (UpTo)</th>
                                </tr>
                            </thead>
                            @if(isset($student_detail))
                            @foreach($student_detail as $student)
                            <tbody>
                                <tr>
                                    <td>{{$student['id']}}</td>
                                    <td>{{$student['name']}}</td>
                                    <td>{{$present}}</td>
                                    <td>{{$absent}}</td>
                                    <td>{{$leave}}</td>
                                    <td>{{$totalPercentage}}%</td>
                                    <td>
                                        <span class="badge badge-light">{{$grade}}</span>
                                    </td>
                                </tr>
                            </tbody>

                            @endforeach
                            @endif
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