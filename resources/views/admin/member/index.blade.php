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
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.members.create') }}" class="btn btn-success w-100"><i
                                        class="fa fa-plus"></i> เพิ่ม</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>อีเมล</th>
                                <th>ระดับ</th>
                                {{--                                <th>ข้อมูลเพิ่มเติม</th>--}}
                                <th>สร้างเมื่อ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($users as $index=>$user)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        {{--                                        <td>{{ $user->description }}</td>--}}
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="{{ route('admin.members.edit',['id' => $user->id]) }}" class="btn btn-primary w-100"><i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <form
                                                        action="{{ route('admin.members.destroy',['id' => $user->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger w-100"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable']))
@endsection
