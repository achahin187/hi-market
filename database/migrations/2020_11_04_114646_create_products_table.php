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
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('eng_description')->nullable();
            $table->text('arab_description')->nullable();
            $table->text('eng_spec')->nullable();
            $table->text('arab_spec')->nullable();
            $table->text('review')->nullable();
            $table->unsignedFloat('price')->nullable();
            $table->unsignedFloat('offer_price')->nullable();
            $table->unsignedFloat('rate')->nullable();
            $table->unsignedInteger('priority')->nullable();
            $table->text('images')->nullable();
            $table->unsignedInteger('points')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('supermarket_id')->unsigned();
            $table->bigInteger('subcategory_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('measure_id')->unsigned();
            $table->bigInteger('size_id')->unsigned();
            $table->unsignedInteger('flag');
            $table->string('status')->default('active');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('exp_date');
            $table->string('barcode');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('supermarket_id')->references('id')->on('supermarkets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('measure_id')->references('id')->on('measures')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade')->onUpdate('cascade');
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
