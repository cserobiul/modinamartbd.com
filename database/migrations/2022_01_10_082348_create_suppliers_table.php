<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->double('purchase_amount')->nullable();
            $table->double('get_payment')->nullable();
            $table->double('current_due')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
