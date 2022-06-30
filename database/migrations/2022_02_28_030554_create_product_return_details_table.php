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
        Schema::create('product_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_return_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('quantity')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('amount')->nullable();
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
        Schema::dropIfExists('product_return_details');
    }
};
