<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('arab_name');
            $table->string('eng_name');
            $table->string('image')->nullable();
            // $table->bigInteger('category_id')->unsigned();
            //$table->bigInteger('subcategory_id')->unsigned();
            $table->unsignedInteger('sponsor');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('no action')->onDelete('no action');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
