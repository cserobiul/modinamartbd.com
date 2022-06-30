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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('oid')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->double('total_price')->nullable();
            $table->double('total_discount')->nullable();
            $table->double('special_discount')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->text('order_note')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_type')->default('free');
            $table->double('shipping_amount')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('update_by')->nullable();  // who updated this
            $table->foreign('update_by')->references('id')->on('users');

            $table->string('status')->default(\App\Models\Settings::STATUS_PENDING);
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
        Schema::dropIfExists('orders');
    }
};
