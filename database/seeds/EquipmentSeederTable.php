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
        for ($i = 0;$i < 100;$i++){
            \App\Equipment::create([
                'code' => $faker->ean13,
                'name' => $faker->word,
                'category' => $faker->word,
                'type' => $faker->word,
                'maintenance_date' => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
                'maintenance_type' =>$faker->randomElement(['วัน','เดือน','ปี']),
                'description' => $faker->text('100'),
                'equipment_state' => $faker->randomElement(['0','1','2','3'])
            ]);
        }
    }
}
