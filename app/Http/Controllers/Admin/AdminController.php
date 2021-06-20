<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\Models\User;
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
        return view('admin.admin_dashboard');
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
        if ($this->auth->check() && $this->auth->user()->last_activity < Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) {
            $user = $this->auth->user();
            $user->last_activity = new \DateTime;
            $user->timestamps = false;
            $user->save();
        }
        return view('admin.view_students');
    }
}
