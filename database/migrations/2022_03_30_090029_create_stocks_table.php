<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number');
            $table->unsignedBigInteger('quantity');
            $table->string('cp');
            $table->string('sp');
            $table->foreignId('product_id')->constrained();

            $table->foreignId('purchase_items_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('order_items_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('status',['ACTIVE','INACTIVE']);
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
        Schema::dropIfExists('stocks');
    }
}
