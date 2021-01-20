<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('discount',8,2)->default(0.00);
            $table->float('vat')->default(0);
            $table->decimal('value_rate',8,2)->default(0.00);
            $table->decimal('total_due',8,2)->default(0.00);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('type')->default(1);
            $table->text('notes')->nullable();
            $table->foreignId('client_id')->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();
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
        Schema::dropIfExists('invoices');
    }
}
