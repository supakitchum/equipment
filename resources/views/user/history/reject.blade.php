@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-danger text-center">
                    <h3 class="p-0 m-0"><i class="fa fa-close"></i> คำร้องขอของคุณถูกปฎิเสธ</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" class="text-center"><b>รายละเอียดการยืม</b></td>
                            </tr>
                            <tr>
                                <td><b>คำร้องขอ</b></td>
                                <td>{!! $reserving->description !!}</td>
                            </tr>
                            <tr>
                                <td><b>ร้องขอเมื่อ</b></td>
                                <td>{{ $reserving->created_at }}</td>
                            </tr>
                            <tr>
                                <td><b>อนุมัติเมื่อ</b></td>
                                <td>{{ $reserving->updated_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
