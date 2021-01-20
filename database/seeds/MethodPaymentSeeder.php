<?php

use Illuminate\Database\Seeder;

class MethodPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MethodPayment::create([
            'name' => 'كاش'
        ]);
        \App\Models\MethodPayment::create([
            'name' => 'بنك'
        ]);
    }
}
