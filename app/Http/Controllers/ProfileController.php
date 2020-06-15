<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function changePassword(Request $request)
    {
        $validator = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:7|string',
        ]);

        $user = User::find(auth()->user()->id);
        if (Hash::check($validator['old_password'], $user->password)) {
            if ($validator['old_password'] === $validator['password']){
                return redirect(route('profile.index'))->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'รหัสผ่านใหม่ไม่สามารถเหมือนรหัสผ่านเก่าได้'
                    ]
                ]);
            }else{
                $user->password = bcrypt($validator['password']);
                $user->save();
                Auth::logout();
                return redirect(route('login'))->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'แก้ไขรหัสผ่านสำเร็จ'
                    ]
                ]);
            }
        }else{
            return redirect(route('profile.index'))->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'รหัสผ่านเก่าไม่ถูกต้อง'
                ]
            ]);
        }
    }

    public function changeProfile(Request $request)
    {
        $validator = $request->validate([
            'name' => 'string|required'
        ]);

        $user = User::find(auth()->user()->id);
        if ($user->name !== $validator['name']){
            $user->update([
                'name' => $validator['name']
            ]);
            return redirect(route('profile.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'บันทึกข้อมูลเรียบร้อย'
                ]
            ]);
        }
        return redirect(route('profile.index'))->with([
            'status' => [
                'class' => 'warning',
                'message' => 'ไม่พบข้อมูลเปลี่ยนแปลง'
            ]
        ]);
    }
}
