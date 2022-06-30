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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->dateTime('sale_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->foreignId('buyer_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->double('total_price')->nullable()->default(0);
            $table->double('total_point')->nullable()->default(0);
            $table->double('total_discount')->nullable()->default(0);
            $table->double('special_discount')->nullable()->default(0);
            $table->double('paid')->nullable()->default(0);
            $table->double('due')->nullable()->default(0);
            $table->unsignedBigInteger('payment_method_id')->nullable()->default(1);
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
        Schema::dropIfExists('sales');
    }
};
