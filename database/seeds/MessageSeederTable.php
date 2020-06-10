<?php

use Illuminate\Database\Seeder;

class MessageSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Message::create([
            'id' => 1,
            'text' => 'มีสมาชิกส่งคำร้องขอเข้ามาใหม่'
        ]);
        \App\Message::create([
            'id' => 2,
            'text' => 'ครุภัณฑ์ที่ท่านยืมอยู่ ถึงเวลาบำรุงรักษาแล้ว กรุณาส่งคืน'
        ]);
        \App\Message::create([
            'id' => 3,
            'text' => 'มีสมาชิกต้องการยืมครุภัณฑ์ที่ท่านยืมอยู่ต่อจากท่าน'
        ]);
        \App\Message::create([
            'id' => 4,
            'text' => 'คำร้องของท่านได้รับการอนุมัติแล้ว'
        ]);
        \App\Message::create([
            'id' => 5,
            'text' => 'คำร้องของท่านถูกปฎิเสธ'
        ]);
        \App\Message::create([
            'id' => 6,
            'text' => 'คุณมีครุภัณฑ์ที่ถูกเรียกคืนเพื่อซ่อมบำรุง'
        ]);
    }
}
