@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-list text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">จำนวนงานทั้งหมด</p>
                                    <p class="card-title" id="quick1">{{ $counts[0] }}<br>รายการ<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-warning text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">จำนวนงานที่ยังไม่เสร็จ</p>
                                    <p class="card-title" id="quick2">{{ $counts[1] }}<br>รายการ<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-check-circle text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">จำนวนงานที่เสร็จแล้ว</p>
                                    <p class="card-title" id="quick3">{{ $counts[2] }}<br>รายการ<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
               <div class="card">
                   <div class="card-header">
                       <h3>งานที่ได้รับล่าสุด</h3>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table" id="dataTable">
                               <thead>
                               <th>ลำดับ</th>
                               <th>ชื่องาน</th>
                               <th>ชื่อครุภัณฑ์</th>
                               <th>เลขครุภัณฑ์</th>
                               <th>รหัสครุภัณฑ์</th>
                               <th>วันที่กำหนด</th>
                               <th>ได้รับมอบหมายเมื่อ</th>
                               <th>รายละเอียด</th>
                               <th></th>
                               <th></th>
                               </thead>
                               <tbody>
                               @foreach($works as $index => $result)
                                   @if($index < 5)
                                       <tr>
                                           <td>{{ $index + 1 }}</td>
                                           <td>{{ $result->task_name }}</td>
                                           <td>{{ $result->equipment_name }}</td>
                                           <td>{{ $result->code }}</td>
                                           <td>{{ $result->serial }}</td>
                                           <td>{{ $result->due_date }}</td>
                                           <td>{{ $result->created_at }}</td>
                                           <td>{{ $result->description }}</td>
                                           <td>
                                               <a href="{{ route('engineer.tasks.show',['id' => $result->id]) }}" class="btn btn-info w-100">
                                                   <i class="fa fa-eye"></i>
                                               </a>
                                           </td>
                                           <td>
                                               <form id="submit-{{ $result->id }}"
                                                     action="{{ route('engineer.tasks.update',['id' => $result->id]) }}"
                                                     method="post">
                                                   @csrf
                                                   @method('put')
                                               </form>
                                               <button class="btn btn-success w-100"
                                                       onclick="confirmForm('{{ $result->id }}')">
                                                   <i class="fa fa-check-circle"></i>
                                               </button>
                                           </td>
                                       </tr>
                                   @endif
                               @endforeach
                               </tbody>
                           </table>
                           <a href="{{ route('engineer.tasks.index') }}" class="btn btn-info w-100"><i class="fa fa-list"></i> ดูงานทั้งหมด ({{sizeof($works) }})</a>
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable']))
<script>
    function confirmForm(id) {
        Swal.fire({
            title: 'ยืนยันสถานะ',
            text: "คุณซ่อมอุปกรณ์ชิ้นนี้เสร็จแล้ว ใช่หรือไม่?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#28d06b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ ฉันซ่อมเสร็จแล้ว',
            cancelButtonText: 'ไม่'
        }).then((result) => {
            if (result.value) {
                document.getElementById('submit-' + id).submit();
            }
        })
    }
</script>
@endsection
