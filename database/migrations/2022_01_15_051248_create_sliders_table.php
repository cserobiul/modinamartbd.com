<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('photo')->nullable();
            $table->integer('order')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
