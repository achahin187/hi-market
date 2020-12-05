<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
         $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('status')->default('inactive');
            $table->unsignedFloat('commission');
            
            $table->bigInteger('supermarket_id')->unsigned();
            $table->unsignedInteger('priority');
            $table->string('image')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();


            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->string('state')->default('open');
            $table->string('start_time');
            $table->string('end_time');
            
            $table->string('rating');

            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('country_id');

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('supermarket_id')->references('id')->on('supermarkets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
