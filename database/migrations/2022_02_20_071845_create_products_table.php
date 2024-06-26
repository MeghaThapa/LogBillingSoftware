<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->enum('product_type',['SALES','SERVICE']);
            $table->enum('status',['ACTIVE','INACTIVE']);
            $table->string('remark')->nullable();
             // softdelete,timestamp and userstamp
             $table->unsignedBigInteger('created_by')->nullable();
             $table->foreign('created_by')->references('id')->on('users');
             $table->unsignedBigInteger('updated_by')->nullable();
             $table->foreign('updated_by')->references('id')->on('users');
             $table->unsignedBigInteger('deleted_by')->nullable();
             $table->foreign('deleted_by')->references('id')->on('users');
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
        Schema::table('products', function (Blueprint $table){
            $table->dropSoftDeletes();
        });  
    }
}
