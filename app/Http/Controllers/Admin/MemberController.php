<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('superadmin'))
            $user = User::where('role','!=','superadmin')->where('id','!=',auth()->user()->id)->get();
        else
            $user = User::where('role','=','user')->orWhere('role','=','engineer')->where('id','!=',auth()->user()->id)->get();
        return view('admin.member.index')->with([
            'users' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|string|email|unique:users|max:255',
            'name' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'description' => 'string|nullable'
        ]);
        $create =  User::create([
            'email' => $validator['email'],
            'password' => bcrypt($validator['password']),
            'name' => $validator['name'],
            'role' => $validator['role'],
            'description' => $validator['description']
        ]);
        if ($create){
            return redirect(route('admin.members.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'สร้างบัญชีสมาชิก '. $validator['email'] .' สำเร็จ'
                ]
            ]);
        } else {
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'สร้างบัญชีสมาชิก '. $validator['email'] .' ไม่สำเร็จ กรุณาตรวจสอบข้อมูล และลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.member.edit')->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'description' => 'string|nullable'
        ]);

        $update = User::find($id)->update($validator);
        if ($update){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'แก้ไขข้อมูลสำเร็จ'
                ]
            ]);
        }else{
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'แก้ไขข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $del = $user->delete();
        if ($del){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ลบ '.$user->email.' สำเร็จ'
                ]
            ]);
        }else{
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ลบ '.$user->email.' ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }
}
