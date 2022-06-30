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
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title',100)->nullable();
            $table->string('phone',20)->nullable();
            $table->longText('details')->nullable();
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
        Schema::dropIfExists('notebooks');
    }
};
