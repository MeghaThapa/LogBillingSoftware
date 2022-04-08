<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('batch_number');
            $table->unsignedBigInteger('quantity');
            $table->string('rate');
            $table->string('amount');
            $table->string('discount_amount')->default('0');
            $table->string('profit_per_item')->default('0');
            $table->string('profit_total')->default('0');
            $table->foreignId('sales_id')->nullable()->constrained();
            $table->foreignId('sales_return_id')->nullable()->constrained();
            $table->foreignId('stock_id')->nullable()->constrained();
            $table->foreignId('product_id')->constrained();
            $table->enum('sales_order_type',['SALES','RETURN']);
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
        Schema::dropIfExists('sales_items');
    }
}
