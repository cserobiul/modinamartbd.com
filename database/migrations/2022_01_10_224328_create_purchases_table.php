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
            $table->string('purchase_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->double('purchase_amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('pay_amount')->nullable();
            $table->double('due_amount')->nullable();
            $table->foreignId('supplier_id')->constrained();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('update_by')->nullable();  // who updated this
            $table->foreign('update_by')->references('id')->on('users');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('purchases');
    }
}
