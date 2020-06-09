<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class EquipmentSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $code_start = "ABC20200";
        for ($i = 0;$i < 100;$i++){
            \App\Equipment::create([
                'code' => $code_start. (600 + $i),
                'serial' => $faker->randomNumber('6'),
                'name' => $faker->word,
                'category' => 'Medical Equipment',
                'type' => $faker->randomElement(['Infusion Pump','Accessory']),
                'maintenance_date' => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
                'maintenance_type' =>$faker->randomElement(['วัน','เดือน','ปี']),
                'description' => 'เครื่องให้สารละลายทางหลอดเลือดดำ B.BRAUN'
            ]);
        }
    }
}
