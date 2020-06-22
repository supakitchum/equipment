@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="card-title">เพิ่มครุภัณฑ์</h2>
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
                                'name' => 'code',
                                'id' => 'code',
                                'label' => 'เลขครุภัณฑ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'serial',
                                'id' => 'serial',
                                'label' => 'รหัสครุภัณฑ์',
                                'type' => 'text',
                                'placeholder' => '',
                                'required' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'select',
                                'options' => [
                                    [
                                        'value' => 1,
                                        'text' => 'Infusomat Space P'
                                    ],
                                    [
                                        'value' => 2,
                                        'text' => 'Pole Clamp'
                                    ],
                                    [
                                        'value' => 3,
                                        'text' => 'Power Supply'
                                    ]
                                ],
                                'name' => 'name',
                                'id' => 'name',
                                'label' => 'ชื่อครุภัณฑ์',
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
                                'required' => true,
                                'readonly' => true
                            ],
                            [
                                'col' => 'col-sm-12 col-lg-12',
                                'tag' => 'input',
                                'name' => 'type',
                                'id' => 'type',
                                'label' => 'ประเภท',
                                'type' => 'text',
                                'placeholder' => '',
                                'required' => true,
                                'readonly' => true
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
@section('script')
    <script>
        $('#name').change(function () {
            let name = $('#name').val();
            if (name == 1){
                $('#category').val("Medical Equipment");
                $('#type').val('Infusion Pump');
            } else if (name == 2 || name == 3){
                $('#category').val('Medical Equipment');
                $('#type').val('Accessory');
            } else{
                $('#category').val('');
                $('#type').val('');
            }
        })
    </script>
@endsection
