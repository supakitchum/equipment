@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="card-title">สร้างคำร้อง</h2>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('user.reserving.index') }}" class="btn btn-primary w-100"><i
                                        class="fa fa-list"></i> รายการ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('widget.form',[
                        'action' => route('user.reserving.store'),
                        'method' => 'post',
                        'grid' => true,
                        'elements' => [
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'name',
                                'id' => 'name',
                                'label' => 'ชื่ออุปกรณ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'required' => true,
                                'readonly' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'textarea',
                                'name' => 'description',
                                'id' => 'description',
                                'label' => 'รายละเอียดคำร้อง',
                                'required' => true
                            ],
                        ],
                        ])
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">รายการครุภัณฑ์</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>สถานะ</th>
                                <th>ชื่อ</th>
                                <th>หมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>รายละเอียด</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td>{!! equipmentState($result->equipment_state) !!}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->category }}</td>
                                        <td>{{ $result->type }}</td>
                                        <td>{{ $result->description }}</td>
                                        <td>
                                            <button class="btn btn-primary w-100" onclick="choose('{{ $result->name }}')"><i class="fa fa-check-circle"></i></button>
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
    <script>
        function choose(name) {
            $('#name').val(name)
        }
    </script>
@endsection
