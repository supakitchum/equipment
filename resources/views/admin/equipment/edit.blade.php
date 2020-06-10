@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="card-title">รายการครุภัณฑ์</h2>
                                <small>(แก้ไขล่าสุดเมื่อ {{ $result->updated_at }})</small>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.equipments.index') }}" class="btn btn-primary w-100"><i
                                        class="fa fa-list"></i> รายการ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            {!! \QrCode::size(300)->generate($result->code) !!}
                        </div>
                        @include('widget.form',[
                        'action' => route('admin.equipments.update',['id' => $id]),
                        'method' => 'put',
                        'grid' => true,
                        'elements' => [
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'name',
                                'id' => 'name',
                                'label' => 'เลขครุภัณฑ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'value' => $result->code,
                                'disabled' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'name',
                                'id' => 'name',
                                'label' => 'รหัสครุภัณฑ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'value' => $result->serial
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'name',
                                'id' => 'name',
                                'label' => 'ชื่ออุปกรณ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'value' => $result->name,
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'category',
                                'id' => 'category',
                                'label' => 'หมวดหมู่',
                                'type' => 'text',
                                'value' => $result->category,
                                'placeholder' => '',
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'type',
                                'id' => 'type',
                                'label' => 'ประเภท',
                                'type' => 'text',
                                'value' => $result->type,
                                'placeholder' => '',
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'select',
                                'name' => 'equipment_state',
                                'id' => 'equipment_state',
                                'label' => 'สถานะ',
                                'value' => $result->equipment_state,
                                'options' => [
                                    [
                                        'value' => '0',
                                        'text' => 'Available'
                                    ],
                                    [
                                        'value' => '1',
                                        'text' => 'Reserved'
                                    ],
                                    [
                                        'value' => '2',
                                        'text' => 'Maintenance'
                                    ],
                                    [
                                        'value' => '3',
                                        'text' => 'Removed'
                                    ]
                                ],
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'textarea',
                                'name' => 'description',
                                'id' => 'description',
                                'label' => 'รายละเอียด',
                                'value' => $result->description,
                                'required' => false
                            ],
                        ],
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
