<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use App\Models\Admin;
use Image;
use Session; 

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        return view('admin.dashboard');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data= $request->all(); 
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30',  
            ];

            $customMessages = [
                'email.required' => "Email is required", 
                'email.email' => 'Valid Email is required', 
                'password.required' => 'Password is required'
            ];

            $this->validate($request, $rules, $customMessages);

            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with("error_message", "Invalid Email or Password!");
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout(); 
        return redirect('admin/login');
    }

    public function updatePassword(Request $request){
        Session::put('page', 'update-password');
        if($request->isMethod('post')){
            $data = $request->all(); 
            // Check if Current Password is correct 
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                // Check if new password and confirm password are matching 
                if($data['new_pwd'] == $data['confirm_pwd']){
                    // Update New Password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated successfully!'); 
                }else{
                    return redirect()->back()->with('error_message', 'New Password and Retype Password does not match'); 
                }
            }else{  
                return redirect()->back()->with('error_message', 'Your Current Password is Incorrect'); 
            }
        }
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request){
        $data = $request->all(); 
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateDetails(Request $request){
        Session::put('page', 'update-details');
        if($request->isMethod('post')){
            $data= $request->all(); 
            // echo "<pre>"; print_r($data); die;
            // dd(Auth::guard('admin')->user()->email); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile' => 'required|numeric|digits:10',  
                // 'admin_image' => 'image',  
            ];

            // Validation the Admins
            $customMessages = [
                'admin_name.required' => "Name is required", 
                'admin_name.regex' => "Valid Name is required", 
                'admin_name.max' => 'Valid Name is required', 
                'admin_mobile.required' => 'Mobile is required', 
                'admin_mobile.numeric' => 'Valid Mobile is required', 
                'admin_mobile.digits' => 'Valid Mobile is required', 
                'admin_image.image' => 'Valid Image is required', 
                
            ];

            $this->validate($request, $rules, $customMessages);
            // Upload Admin Image 
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image'); 
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension(); 
                    // Generate New Image 
                    $imageName = rand(111,99999).'.'.$extension; 
                    $image_path = 'admin/images/photos/'.$imageName;
                    Image::make($image_tmp)->save($image_path); 
                }
            }else if(!empty($data['current_image'])){
                $imageName = $data['current_image'];
            }else{
                $imageName = "";
            }

            // Update Admin Details 
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            return redirect()->back()->with('success_message', 'Admin Details has been updated successfully!'); 
        }
        return view('admin.update_details');
    }
}
