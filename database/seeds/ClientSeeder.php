<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinet1 = \App\Models\Client::create([
            'name' => 'عامر',
            'phone' => '0111',
            'email' => 'amer.khalil9094@gmail.com',
            'address'    => 'qus',
        ]);
        $clinet2 = \App\Models\Client::create([
            'name' => 'لولو',
            'phone' => '0111',
            'email' => 'mahmoud@gmail.com',
            'address'    => 'qus',
        ]);
        $clinet3 = \App\Models\Client::create([
            'name' => 'محمد',
            'phone' => '0111',
            'email' => 'mohamed@gmail.com',
            'address'    => 'qus',
        ]);

    }
}
