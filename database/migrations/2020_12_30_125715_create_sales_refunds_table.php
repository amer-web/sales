<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('invoice_refund_id')->constrained('invoice_refunds')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('sale_price', 8,2);
            $table->integer('amount');
            $table->decimal('total', 8,2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_refunds');
    }
}
