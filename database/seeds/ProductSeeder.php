<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product1 = \App\Models\Product::create([
            'name' => 'سماعة أذن',
            'description'  => 'سماعة أذن',
        ]);
        $product2 = \App\Models\Product::create([
            'name' => 'كمبيوتر',
            'description'  => 'كمبيوتر',
        ]);
        $product3 = \App\Models\Product::create([
            'name' => 'ساعة حائط',
            'description'  => 'ساعة حائط',
        ]);
        $product4 = \App\Models\Product::create([
            'name' => 'طابعة',
            'description'  => 'طابعة',
        ]);
        $product5 = \App\Models\Product::create([
            'name' => 'سكنر',
            'description'  => 'سكنر',
        ]);
    }
}
