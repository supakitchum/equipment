<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class TaskCalSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1;$i < 10;$i++){
            $equipment_id = $faker->randomNumber(2);
            $task = \App\TaskCalEquipment::create([
                'task_name' => 'ซ่อมหน่อย',
                'equipment_id' => $equipment_id,
                'user_id' => 24,
                'due_date' => $faker->dateTime,
                'description' => $faker->text(),
                'state' => 1
            ]);
            \App\TaskCalLog::create([
                'task_id' => $task->id,
                'assign_date' => $faker->dateTime,
                'complete_date' => $faker->dateTime
            ]);
        }

        for ($i = 1;$i < 10;$i++){
            $equipment_id = $faker->randomNumber(2);
            \App\Equipment::find($equipment_id)->update([
                'equipment_state' => '2'
            ]);
            $task = \App\TaskCalEquipment::create([
                'task_name' => 'ซ่อมหน่อย',
                'equipment_id' => $equipment_id,
                'user_id' => 24,
                'due_date' => $faker->dateTime,
                'description' => $faker->text,
                'state' => 0
            ]);
            \App\TaskCalLog::create([
                'task_id' => $task->id,
                'assign_date' => \Carbon\Carbon::now(),
                'complete_date' => null
            ]);
        }
    }
}
