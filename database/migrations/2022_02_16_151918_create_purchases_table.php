<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('fiscal_year');
            $table->string('transaction_date');
            $table->string('bill_date');
            $table->string('bill_no');
            $table->string('total_amount')->default('0');
            $table->string('discount_amount')->default('0');
            $table->string('Vat_amount')->default('0');
            $table->string('extra_charges')->default('0');
            $table->string('rounding')->default('0');
            $table->string('net_amount')->default('0');
            $table->enum('purchase_type',['DIRECT','ORDER','RETURN']);
            $table->string('remark')->nullable();
            $table->foreignId('supplier_id')->constrained();
            $table->enum('status',['RUNNING','COMPLETED','CANCLED']);
            // softdelete,timestamp and userstamp
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table){
            $table->dropSoftDeletes();
        });  
    }
}
