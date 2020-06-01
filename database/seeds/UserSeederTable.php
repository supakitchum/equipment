<?php

use Illuminate\Database\Seeder;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        \App\User::create([
            'email' => 'superadmin@email.com',
            'password' => bcrypt('letmein'),
            'name' => $faker->name,
            'role' => 'superadmin',
            'description' => $faker->text
        ]);
        \App\User::create([
            'email' => 'admin@email.com',
            'password' => bcrypt('letmein'),
            'name' => $faker->name,
            'role' => 'admin',
            'description' => $faker->text
        ]);
        for ($i = 0;$i < 10;$i++){
            \App\User::create([
                'email' => $faker->email,
                'password' => bcrypt('letmein'),
                'name' => $faker->name,
                'role' => 'admin',
                'description' => $faker->text
            ]);
        }
        \App\User::create([
            'email' => 'user@email.com',
            'password' => bcrypt('letmein'),
            'name' => $faker->name,
            'role' => 'user',
            'description' => $faker->text
        ]);

        for ($i = 0;$i < 10;$i++){
            \App\User::create([
                'email' => $faker->email,
                'password' => bcrypt('letmein'),
                'name' => $faker->name,
                'role' => 'user',
                'description' => $faker->text
            ]);
        }

        \App\User::create([
            'email' => 'engineer@email.com',
            'password' => bcrypt('letmein'),
            'name' => $faker->name,
            'role' => 'engineer',
            'description' => $faker->text
        ]);

        for ($i = 0;$i < 10;$i++){
            \App\User::create([
                'email' => $faker->email,
                'password' => bcrypt('letmein'),
                'name' => $faker->name,
                'role' => 'engineer',
                'description' => $faker->text
            ]);
        }
    }
}
