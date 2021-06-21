@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Online Students</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Students</li>
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
                        <h3 class="card-title">All Students</h3>

                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="attendance" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>#Student ID</th>
                                    <th>Student Name</th>
                                    <th>Student Email</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalUser as $online)
                                <tr>
                                    <td>{{$online->id}}</td>
                                    <td>{{$online->name}}</td>
                                    <td>{{$online->email}}</td>
                                    <td>
                                        @if($online->isUserOnline())
                                        <span class="badge badge-success">Online</span>
                                        @else
                                        <span class="badge badge-warning">Offline</span>
                                        @endif
                                    </td>
                                    <td><a href="{{url('admin/student-detail/'.$online->id)}}"><i class="fas fa-eye"></i></a></td>
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