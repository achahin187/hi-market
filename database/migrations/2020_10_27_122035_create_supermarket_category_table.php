<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupermarketCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supermarket_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supermarket_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->unsignedInteger('flag')->nullable();
            $table->timestamps();


            $table->foreign('supermarket_id')->references('id')->on('supermarkets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supermarket_category');
    }
}
