<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_vendor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('CASCADE');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');
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
        Schema::dropIfExists('category_vendor');
    }
}
