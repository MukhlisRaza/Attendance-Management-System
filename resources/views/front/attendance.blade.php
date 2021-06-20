@extends('layouts.front_layout.front_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ url('/admin/profile')}}">
                        <h1>Profile</h1>
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('studentdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">

                                <img class="profile-user-img img-fluid img-circle" src="{{url('images/front_images/'.Auth::user()->image)}}">

                            </div>

                            <h3 class="profile-username text-center">

                            </h3>

                            <p class="text-muted text-center">
                                {{$studentDetails['name']}}
                            </p>
                            <!-- Button trigger modal -->
                            <h5 class="mb-2">Attendance Management</h5>
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">
                                        <form action="{{url('mark-attendance')}}" class="col-md-4 col-sm-12 col-12" method="post">
                                            @csrf
                                            <button type="submit" name="present" id="present" value="Present" class="info-box-icon bg-info mark-attendance"><i class="far fa-calendar-check"></i></button>
                                        </form>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Mark Attendance</span>
                                            <span>Click here to mark your attendance</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">
                                        <a href="{{url('view-attendance')}}">
                                            <button name="view-attendance" id="view-attendance" class="info-box-icon bg-success mark-attendance"><i class="fas fa-eye"></i></button>
                                        </a>
                                        <div class="info-box-content">
                                            <span class="info-box-number">View Attendance</span>
                                            <span>Click here to view your attendance &nbsp;&nbsp;</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">

                                        <a href="{{url('leave')}}">
                                            <button name="leave" id="leave" class="info-box-icon bg-warning mark-attendance"><i class="fas fa-sign-out-alt"></i></button>
                                        </a>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Request For Leave</span>
                                            <span>Click here to request for leave to teacher</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if (Session::has('error_message'))
                            <div class="alert alert-danger " role="alert">
                                {{Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if (Session::has('success_message'))
                            <div class="alert alert-success " role="alert">
                                {{Session::get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>


            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection