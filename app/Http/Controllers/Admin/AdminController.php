<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use DateTime;
use Session;
use Image;

class AdminController extends Controller
{
    //

    public function login(Request $request)
    {
        if ($request->isMethod("post")) {

            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);


            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {

                Session::flash('error_message', "Enter valid email or password");
                return redirect()->back();
            }
        }

        return view('admin.admin_login');
    }

    public function dashboard()
    {
        Session::put('page', 'dashboard');

        $leaveRequest = Leave::where('status', 'Pending')->count();

        return view('admin.admin_dashboard')->with(compact('leaveRequest'));
    }

    // Admin Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->flash('status', 'Successful Logout!');
        return redirect('/admin');
    }

    // Profile
    public function profile()
    {
        Session::put('page', 'profile');
        //Anather way to fectch admin details
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // echo "<pre>";
        // print_r($adminDetails);
        // die;
        return view('admin.admin_profile')->with(compact('adminDetails'));
    }

    // Update Admin Image
    public function updateAdminImage(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'admin_avatar_image' => 'image',
            ];
            $customMessage = [
                'admin_avatar_image.image' => 'Enter Valid Image',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Image
            if ($request->hasFile('admin_avatar_image') && Auth::guard('admin')->user()->type == 'admin') {
                $image_tmp = $request->file('admin_avatar_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            } else if ($request->hasFile('admin_avatar_image') && Auth::guard('admin')->user()->type == 'vendor') {
                $image_tmp = $request->file('admin_avatar_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            }
            //Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['image' => $imageName]);
            Session::flash('success_message', "Details is successfully updated");
            return redirect()->back();
        }
    }

    // View Student
    public function viewStudents()
    {
        Session::put('page', 'viewStudent');
        $totalUser = User::get();

        return view('admin.view_students')->with(compact('totalUser'));
    }

    //  Single Students Details
    public function singleStudentDetails($id)
    {
        $detail = User::with('attendance', 'leaves')->where('id', $id)->get()->toArray();
        $presentCount = Attendance::where('status', 'Present')->where('student_id', $id)->count();
        $absentCount = Attendance::where('status', 'Absent')->where('student_id', $id)->count();
        $leaveCount = Leave::where('status', 'Approved')->where('student_id', $id)->count();
        // echo "<pre>";
        // print_r($detail);
        // die;
        return view('admin.student_details')->with(compact('detail', 'presentCount', 'absentCount', 'leaveCount'));
    }

    //  Student Attendance Market
    public function studentAttendance()
    {
        Session::put('page', 'studentAttendance');
        $detail = Attendance::get()->toArray();
        $dt = new DateTime();
        $dt->format('Y-m-d');
        // echo "<pre>";
        // print_r($dt);
        // die;
        $totalStudent = User::get()->count();
        $totalPresent = Attendance::whereDate('created_at', $dt)->where('status', 'Present')->get()->count();
        $totalLeave = Attendance::whereDate('created_at', $dt)->where('status', 'Leave')->get()->count();
        $totalAbsent = Attendance::whereDate('created_at', $dt)->where('status', 'Absent')->get()->count();
        return view('admin.students-attendance')->with(compact('detail', 'totalStudent', 'totalPresent', 'totalLeave', 'totalAbsent'));
    }

    // Admin Mark Attendance
    public function adminMarkAttendance(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            Attendance::where('student_id', $data['student_id'])
                ->where('id', $data['attendanedate'])
                ->update(['status' => $data['adminMark']]);

            Session::flash('success_message', 'Attendance Mark!');
            return redirect()->back();
        }
    }

    // Student Leaves Request
    public function studentLeave()
    {
        Session::put('page', 'leave');
        $dt = new DateTime();
        $dt->format('Y-m-d');

        $totalStudent = User::get()->count();
        $totalPresent = Attendance::whereDate('created_at', $dt)->where('status', 'Present')->get()->count();
        $totalLeave = Attendance::whereDate('created_at', $dt)->where('status', 'Leave')->get()->count();
        $totalAbsent = Attendance::whereDate('created_at', $dt)->where('status', 'Absent')->get()->count();

        $leaves = Leave::get()->toArray();
        // echo "<pre>";
        // print_r($leaves);
        // die;
        return view('admin.students-leave')->with(compact('leaves', 'totalStudent', 'totalPresent', 'totalLeave', 'totalAbsent'));;
    }

    // Admin Accept or Reject Leaves
    public function adminLeaves(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $dateExist = Attendance::whereDate('created_at', $data['fromdate'])->get()->count();
            // echo "<pre>";
            // print_r($dateExist);
            // die;
            $leaveReject = "Absent";
            $leaveAccept = "Leave";
            if ($data['adminMark'] == 'Approved') {
                Leave::where('id', $data['leave_id'])
                    ->where('student_id', $data['student_id'])
                    ->update(['status' => $data['adminMark']]);

                if ($dateExist > 0) {
                    Attendance::where('student_id', $data['student_id'])
                        ->whereDate('created_at', $data['fromdate'])
                        ->update(['status' => $leaveAccept]);
                }

                Session::flash('success_message', 'Leave Approved!');
                return redirect()->back();
            } else {
                Leave::where('id', $data['leave_id'])
                    ->where('student_id', $data['student_id'])
                    ->update(['status' => $data['adminMark']]);

                if ($dateExist > 0) {
                    Attendance::where('student_id', $data['student_id'])
                        ->whereDate('created_at', $data['fromdate'])
                        ->update(['status' => $leaveReject]);
                }

                Session::flash('error_message', 'Leave Rejected!');
                return redirect()->back();
            }
        }
    }

    // Generate Single Student Report
    public function studentReport()
    {
        Session::put('page', 'singleStudentReport');

        return view('admin.student_report');
    }

    // Single Student Report Generate
    public function singleStudentReport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();


            $attendanceDetails = Attendance::where('student_id', $data['student_id'])
                ->whereDate('created_at', '>=', $data['from-date'])
                ->whereDate('created_at', '<=', $data['to-date'])
                ->get()->toArray();

            // echo "<pre>";
            // print_r($attendanceDetails);
            // die;

            return view('admin.student_report')->with(compact('attendanceDetails'));
        }
    }

    // system Report
    public function systemReport()
    {
        Session::put('page', 'systemreport');
        return view('admin.system_report');
    }

    // Total System Report
    public function allSystemReport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $attendanceDetails = Attendance::whereDate('created_at', '>=', $data['from-date'])
                ->whereDate('created_at', '<=', $data['to-date'])
                ->get()->toArray();

            return view('admin.system_report')->with(compact('attendanceDetails'));
        }
    }

    //  System Grading
    public function studentGrading()
    {
        Session::put('page', 'grading');

        $grading = User::with('attendance', 'leaves')->get()->toArray();
        // echo "<pre>";
        // print_r($grading);
        // die;


        return view('admin.student_grading')->with(compact('grading'));
    }

    //  Student Grade
    public function studentGrade(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            $student_detail = User::where('id', $data['student_id'])->select('id', 'name')->get()->toArray();
            // echo "<pre>";
            // print_r($student_detail);
            // die;
            $present = Attendance::where('status', 'Present')->where('student_id', $data['student_id'])->count();
            $absent = Attendance::where('status', 'Absent')->where('student_id',  $data['student_id'])->count();
            $leave = Leave::where('status', 'Leave')->where('student_id',  $data['student_id'])->count();

            $totalPresent = $present * 1;
            $totalLeave = $leave * 0.5;
            $sum = $totalPresent + $totalLeave;
            $totalPercentage = round($sum * 100 / 30);
            $grade = '';

            if ($totalPresent >= 26) {
                $grade = "A Grade";
            } elseif ($totalPresent >= 20) {
                $grade = "B Grade";
            } elseif ($totalPresent >= 15) {
                $grade = "C Grade";
            } else {
                $grade = "D Grade";
            }

            // echo "<pre>";
            // print_r($totalLeave);
            // die;

            return view('admin.student_grading')->with(compact('student_detail', 'present', 'absent', 'leave', 'totalPercentage', 'grade'));
        }
    }
}
