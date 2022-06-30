<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->string('invoice_no',32)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->foreignId('buyer_id')->constrained();
            $table->double('amount')->nullable();
            $table->string('purpose',32)->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('transaction_id',32)->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('update_by')->nullable();  // who updated this
            $table->foreign('update_by')->references('id')->on('users');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_transactions');
    }
};
