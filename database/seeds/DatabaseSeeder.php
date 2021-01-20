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
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(BellSaleSeeder::class);
        $this->call(BellPurchaseSeeder::class);
        $this->call(SellingPriceSeeder::class);
        $this->call(MethodPaymentSeeder::class);
        $this->call(SupplierSeeder::class);

    }
}
