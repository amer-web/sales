<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = \App\Models\User::create([
            'firstname' => 'عامر',
            'lastname' => 'الخريصى',
            'email' => 'amer@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $user2 = \App\Models\User::create([
            'firstname' => 'لولو',
            'lastname' => 'سيد',
            'email' => 'lolo@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $user3 = \App\Models\User::create([
            'firstname' => 'مصطفى',
            'lastname' => 'سيد',
            'email' => 'moustafa@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
