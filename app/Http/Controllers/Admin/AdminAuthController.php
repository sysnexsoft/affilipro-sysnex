<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login(){
        if (Auth::user()){
            return redirect()->route('admin.dashboard');
        }
        else{
            return view('backEnd.auth.login');
        }

    }
    // Login Submit
    public function loginConfirm(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'remember' => 'nullable' // checkbox optional
            ]);

            // Credentials
            $credentials = $request->only('email', 'password');

            // remember checkbox checked হলে 1, না হলে 0
            $remember = $request->has('remember') ? true : false;

            // Try Login
            if (Auth::guard('web')->attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully');
            }
            return back()->with('error', 'Invalid email or password');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','Logged out successfully');
    }
    public function resetPasswordIndex(){
        return view('backEnd.auth.resetPassword');
    }
    public function resetPasswordUpdate(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'old_password'=> 'required',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);
        if ($validate->fails()){
            return back()->with('error',$validate->messages());
        }

        $admin = auth()->guard('web')->user();
        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('error', 'Old password does not match!');
        }

        if (Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'New password cannot be the same as old password.');
        }

        // Update password
        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function profile(){
        return view('backEnd.auth.profile');
    }
    public function profileUpdate(Request $request){
        $profile = User::find(auth()->user()->id);
        $input = $request->all();

        if ($request->file('avatar')){
            if (isset($profile->avatar)){
                unlink($profile->avatar);
            }
            $profileImage = $request->file('avatar');
            $profileImageName = rand().'.'.$profileImage->extension();
            $dir = 'uploads/profile/';
            $profileImage->move($dir,$profileImageName);
            $input['avatar'] =  $dir.$profileImageName;
        }
        $profile->update($input);
        return back()->with('success', 'Profile Update Successfully.');
    }
}
