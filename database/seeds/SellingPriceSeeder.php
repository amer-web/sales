<?php

use Illuminate\Database\Seeder;

class SellingPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $price1 = \App\Models\SellingPrice::create([
           'product_id' => 1,
           'selling_price' => 100
        ]);
        $price2 = \App\Models\SellingPrice::create([
            'product_id' => 2,
            'selling_price' => 250
        ]);
        $price3 = \App\Models\SellingPrice::create([
            'product_id' => 3,
            'selling_price' => 150
        ]);
        $price3 = \App\Models\SellingPrice::create([
            'product_id' => 4,
            'selling_price' => 400
        ]);
        $price3 = \App\Models\SellingPrice::create([
            'product_id' => 5,
            'selling_price' => 110
        ]);
    }
}
