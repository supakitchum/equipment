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
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.equipments.index') }}" class="btn btn-primary w-100"><i
                                        class="fa fa-list"></i> รายการ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('widget.form',[
                        'action' => route('admin.equipments.store'),
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
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'category',
                                'id' => 'category',
                                'label' => 'หมวดหมู่',
                                'type' => 'text',
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
                                'placeholder' => '',
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-6',
                                'tag' => 'input',
                                'name' => 'maintenance_date',
                                'id' => 'maintenance_date',
                                'label' => 'วันที่ปิดปรับปรุง',
                                'type' => 'text',
                                'placeholder' => '',
                                'required' => false
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-6',
                                'tag' => 'select',
                                'name' => 'maintenance_type',
                                'id' => 'maintenance_type',
                                'label' => 'ประเภทปิดปรับปรุง',
                                'options' => [
                                    [
                                        'value' => 'วัน',
                                        'text' => 'วัน'
                                    ],
                                    [
                                        'value' => 'เดือน',
                                        'text' => 'เดือน'
                                    ],
                                    [
                                        'value' => 'ปี',
                                        'text' => 'ปี'
                                    ]
                                ],
                                'required' => false
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'select',
                                'name' => 'equipment_state',
                                'id' => 'equipment_state',
                                'label' => 'สถานะ',
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
