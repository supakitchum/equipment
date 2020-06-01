@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="card-title">รายชื่อสมาชิก</h2>
                                <small>(แก้ไขล่าสุดเมื่อ {{ $user->updated_at }})</small>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.members.index') }}" class="btn btn-primary w-100"><i class="fa fa-list"></i> รายการ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.members.update',['id' => $user->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="email">อีเมล <span class="text-danger">(*)</span></label>
                                <input
                                    required
                                    disabled
                                    type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email"
                                    name="email"
                                    placeholder="กรุณาใส่อีเมล"
                                    value="{{ $user->email }}"
                                >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">ชื่อ <span class="text-danger">(*)</span></label>
                                <input
                                    required
                                    type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name"
                                    name="name"
                                    placeholder="กรุณาใส่ชื่อ"
                                    value="{{ $user->name }}"
                                >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน <span class="text-danger">(*)</span></label>
                                <input
                                    required
                                    type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password"
                                    id="password"
                                    placeholder="กรุณาใส่รหัสผ่าน"
                                >
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="role">ระดับ</label>
                                <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" style="height: 40px !important;" id="role" name="role">
                                    <option value="">กรุณาเลือก</option>
                                    <option {{ $user->role == "admin" ? "selected" : "" }} value="admin">ผู้ดูแลศูนย์อุปกรณ์</option>
                                    <option {{ $user->role == "technician" ? "selected" : "" }} value="technician">ช่าง</option>
                                    <option {{ $user->role == "user" ? "selected" : "" }} value="user">หัวหน้าวอร์ด</option>
                                </select>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">คำอธิบาย</label>
                                <textarea
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    id="description"
                                    name="description"
                                >{{ $user->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success float-right w-100">ยืนยัน</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
