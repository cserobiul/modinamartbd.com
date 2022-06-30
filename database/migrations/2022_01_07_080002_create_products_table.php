<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->double('point')->nullable()->default(100);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->double('sale_price')->nullable();
            $table->double('wholesale_price')->nullable();
            $table->string('discount_type',32)->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->text('photo')->nullable();
            $table->integer('has_stock')->nullable();
            $table->string('view_section')->nullable()->default('NEW_ARRIVAL');
            $table->text('excerpts')->nullable();
            $table->longText('details')->nullable();
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
        Schema::dropIfExists('products');
    }
}
