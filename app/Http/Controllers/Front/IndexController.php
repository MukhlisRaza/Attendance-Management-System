<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Image;

class IndexController extends Controller
{
    //
    public function login()
    {
        return view('front.front_login');
    }

    // Student Register
    public function register()
    {
        return view('front.register');
    }


    public function userRegister(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|max:11|min:11',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:30',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Name must be alphabet letters',
                'mobile.required' => 'Mobile number is required',
                'mobile.max' => 'Mobile number must be 11 character',
                'mobile.min' => 'Mobile number must be 11 character',
                'email.required' => 'Email is required!',
                'email.email' => 'Valid email is required',
                'email.unique' => 'This email is already taken',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be string',
                'password.regex' => 'Password must contain letters,uppercase and lowercase letters, atleast one digits, and special characters',
            ];

            $this->validate($request, $rules, $customMessages);


            //checking if user already register
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                $message = "Email Already Register";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Register new user
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                $message = "Successfully register";
                session::flash('success_message', $message);
                return redirect('/');
            }
        }
    }

    // Student Login
    public function userlogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
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

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('/studentdashboard');
            } else {

                Session::flash('error_message', "Enter valid email or password");
                return redirect()->back();
            }
        } else {
            return view('front.front_dashboard');
        }
    }

    //
    public function dashboard()
    {
        Session::put('page', 'dashboard');

        // Today Attendance
        $dt = new DateTime();
        $dt->format('Y-m-d');
        $todayAttendance = Attendance::whereDate('created_at', '=', $dt)->where('student_id', Auth::user()->id)->get()->count();

        // echo "<pre>";
        // print_r($todayAttendance);
        // die;

        $present = Attendance::where('status', 'Present')->where('student_id', Auth::user()->id)->count();
        $absent = Attendance::where('status', 'Absent')->where('student_id', Auth::user()->id)->count();
        $leave = Leave::where('status', 'Approved')->where('student_id', Auth::user()->id)->count();

        $totalPresent = $present * 1;
        $totalLeave = $leave * 0.5;
        $sum = $totalPresent + $totalLeave;
        $totalPercentage = round($sum * 100 / 30);
        // echo "<pre>";
        // print_r($totalLeave);
        // die;
        $totalAttendanceMark = Attendance::where('student_id', Auth::user()->id)->get()->count();
        $totalApprovedLeaves = Leave::where('status', 'Approved')->where('student_id', auth::user()->id)->get()->count();

        return view('front.front_dashboard')->with(compact('totalAttendanceMark', 'totalApprovedLeaves', 'totalPercentage', 'todayAttendance'));
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }

    // Profile
    public function profile()
    {
        Session::put('page', 'profile');
        //Anather way to fectch admin details
        $studentDetails = User::where('email', Auth::user()->email)->first()->toArray();
        // echo "<pre>";
        // print_r($studentDetails);
        // die;
        return view('front.front_profile')->with(compact('studentDetails'));
    }

    // Update Student Image
    public function updateStudentImage(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'user_image' => 'image',
            ];
            $customMessage = [
                'user_image.image' => 'Enter Valid Image',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Image
            if ($request->hasFile('student_avatar_image')) {
                $image_tmp = $request->file('student_avatar_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/front_images/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            }
            //Update Admin Details
            User::where('id', Auth::user()->id)->update(['image' => $imageName]);

            return redirect()->back();
        }
    }


    // Attendance
    public function attendance()
    {
        Session::put('page', 'attendance');
        //Anather way to fectch admin details
        $studentDetails = User::where('email', Auth::user()->email)->first()->toArray();
        // echo "<pre>";
        // print_r($studentDetails);
        // die;
        return view('front.attendance')->with(compact('studentDetails'));
    }

    // Student Mark Attendance
    public function markAttendance(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $dt = new DateTime();

            $dt->format('Y-m-d');
            // echo "<pre>";
            // print_r($dt);
            // die;
            $dates = Attendance::whereDate('created_at', '=', $dt)
                ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, created_at, ?)) <= 480', [$dt])
                ->where('student_id', Auth::user()->id)
                ->get()->count();

            /*
                ? is a placeholder for the $date. Those are called bindings and are 
                mostly used to get a clean query and prevent SQL injection.
                TIMESTAMPDIFF(MINUTE, ... will return the difference of the input date
                 time and the one stored in the database field in minutes. 
                If that value is smaller or equal to 120 (2 hours = 120 minutes) 
                it matches the condition.
                ABS will make the value "unsigned". -60 becomes 60
                
                */
            // echo "<pre>";
            // print_r($dates);
            // die;
            $studentDetails = User::where('email', Auth::user()->email)->first()->toArray();

            if ($dates > 0) {
                $message = "You already mark your attendance";
                Session::flash('error_message', $message);
                return view('front.attendance')->with(compact('studentDetails'));
            } else {
                $markAttendance = new Attendance;
                $markAttendance->student_id = Auth::user()->id;
                $markAttendance->student_name = Auth::user()->name;
                $markAttendance->status = $data['Present'];
                $markAttendance->save();

                $message = "Your attendance 'present' is mark";
                Session::flash('success_message', $message);
                return view('front.attendance')->with(compact('studentDetails'));
            }
        }
    }

    // View Your Attendance
    public function viewAttendance()
    {
        $studentDetails = Attendance::where('student_id', Auth::user()->id)->get()->toArray();

        // $studentDetails = DB::table('attendances')->where('attendances.student_id', Auth::user()->id)
        //     ->join('leaves', 'leaves.student_id', '=', 'attendances.student_id')->get()->toArray();
        // echo "<pre>";
        // print_r($studentDetails);
        // die;
        return view('front.view-attendance')->with(compact('studentDetails'));
    }

    // Leave
    public function leave()
    {
        $request = Leave::where('student_id', Auth::user()->id)->get()->toArray();
        // echo "<pre>";
        // print_r($request);
        // die;
        return view('front.leave')->with(compact('request'));
    }

    // Request Leave
    public function requestLeave()
    {
        return view('front.request-leave');
    }

    // Request Form
    public function requestForm(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $requestAlready = Leave::where('from', '=', $data['from-date'])
                ->where('to', '=', $data['to-date'])
                ->get()->count();

            // echo "<pre>";
            // print_r($requestAlready);
            // die;

            if ($requestAlready > 0) {
                $message = "You have already request at the same date! ";
                Session::flash('error_message', $message);
                return redirect()->back();
            } else {
                $request = new Leave;
                $request->student_id = Auth::user()->id;
                $request->student_name = Auth::user()->name;
                $request->purpose = $data['reason'];
                $request->from = $data['from-date'];
                $request->to = $data['to-date'];
                $request->status = "Pending";
                $request->save();

                $message = "Your request is submitted! ";
                Session::flash('success_message', $message);
                return redirect()->back();
            }
        }
    }
}
