<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //direct admin home page
    public function index(){
        $id = Auth::user()->id;
        $user = User::select('name','email','phone','address','gender')->where('id',$id)->first();
        return view('admin.profile.index',compact('user'));
    }

    //profile update
    public function updateAdminInfo(Request $request){
        $userData = $this->getUserInfo($request);
        $validator = $this->userValidationCheck($request);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        User::where('id',Auth::user()->id)->update($userData);
        return back()->with(['updateSuccess'=>'Profile Updated!']);
    }

    //change password page
    public function adminChangePassword(){
        return view('admin.profile.changePassword');
    }

    //change password
    public function PasswordChange(Request $request){
        $validator = $this->passwordValidationCheck($request);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $dbData = User::where('id',Auth::user()->id)->first();
        $dbPassword = $dbData->password;
        $hashUserPassword = Hash::make($request->newPassword);

        $updateData = [
            'password' => $hashUserPassword,
        ];

        if (Hash::check($request->oldPassword,$dbPassword)) {
            User::where('id',Auth::user()->id)->update($updateData);
            return redirect()->route('dashboard');
        }else{
            return back()->with(['fail'=>'Old Password do not match!']);
        }
    }

    //user validation check
    private function userValidationCheck($request){
        return Validator::make($request->all(), [
            'adminName' => 'required',
            'adminEmail' => 'required',
        ],[
            'adminName.required' => 'name is required!!',
            'adminEmail.required' => 'email is required!!'
        ]);
    }

    //get user info
    private function getUserInfo($request){
        return [
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'address' => $request->adminAddress,
            'gender' => $request->adminGender,
            'updated_at' => Carbon::now(),
        ];
    }

    //passwordValidationCheck
    private function passwordValidationCheck($request){
        return Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|max:15',
            'confirmPassword' => 'required|same:newPassword|min:8|max:15',
        ],[
            'oldPassword.required' => 'Old Password is required!!',
            'newPassword.required' => 'New Password is required!!',
            'confirmPassword.required' => 'Confirm Password is required!!',
            'confirmPassword.same' => 'New Password & Confirm Password must be same!'
        ]);
    }
}
