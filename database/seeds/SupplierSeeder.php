<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier1 = \App\Models\Supplier::create([
            'name' => 'مصطفى',
            'phone' => '0111',
            'email' => 'hamada@gmail.com',
            'address'    => 'qus',
        ]);
        $supplier2 = \App\Models\Supplier::create([
            'name' => 'على',
            'phone' => '0111',
            'email' => 'mahmoud@gmail.com',
            'address'    => 'qus',
        ]);
        $supplier3 = \App\Models\Supplier::create([
            'name' => 'عبدالله',
            'phone' => '0111',
            'email' => 'mohamed@gmail.com',
            'address'    => 'qus',
        ]);
    }
}
