<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(UserSeederTable::class);
         $this->call(EquipmentSeederTable::class);
         $this->call(MessageSeederTable::class);
         $this->call(TaskCalSeederTable::class);
    }
}
