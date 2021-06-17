<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('front.front_dashboard');
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
}
