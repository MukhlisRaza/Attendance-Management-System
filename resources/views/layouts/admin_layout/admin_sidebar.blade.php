  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('images/front_images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img class="profile-user-img img-fluid img-circle" src="{{url('images/admin_images/'.Auth::guard('admin')->user()->image)}}" alt="User profile picture">

        </div>
        <div class="info">

          <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if(Session::get('page')=="dashboard")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview menu-open">
            <a href="{{url('admin/dashboard')}}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>

          </li>
          @if(Session::get('page')=="profile")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="{{url('admin/profile')}}" class="nav-link {{$active}}">
              <i class="nav-icon far fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-header">STUDENT RECORDS</li>
          @if(Session::get('page')=="Attendance" || Session::get('page')=="viewStudent" || Session::get('page')=="studentAttendance" || Session::get('page')=="leave")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="viewStudent")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/view-students')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Students</p>
                </a>
              </li>
              @if(Session::get('page')=="studentAttendance")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/student-attendance')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Students Attendance</p>
                </a>
              </li>
              @if(Session::get('page')=="leave")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/student-leave')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-header">ATTENDANCE MANAGEMENT</li>
          @if(Session::get('page')=="Attendance" || Session::get('page')=="singleStudentReport" || Session::get('page')=="systemreport" || Session::get('page')=="grading")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="singleStudentReport")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/student_report')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Report</p>
                </a>
              </li>
              @if(Session::get('page')=="systemreport")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/system_report')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>System Report</p>
                </a>
              </li>
              @if(Session::get('page')=="grading")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/student_grading')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grading</p>
                </a>
              </li>

            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>