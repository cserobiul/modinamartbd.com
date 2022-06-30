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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name',64)->nullable();
            $table->string('shop_name',48)->nullable();
            $table->string('phone')->nullable();
            $table->string('email',64)->nullable();
            $table->double('buy_amount')->nullable();
            $table->double('paid_payment')->nullable();
            $table->double('current_due')->nullable();
            $table->text('address')->nullable();
            $table->string('district')->nullable();
            $table->text('photo')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
