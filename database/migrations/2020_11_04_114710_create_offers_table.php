<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('arab_name');
            $table->string('eng_name');
            $table->text('eng_description')->nullable();
            $table->text('arab_description')->nullable();
            $table->string('promocode')->nullable();
            $table->string('value_type');
            $table->string('offer_type');
            $table->unsignedBigInteger('supermarket_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->text('image')->nullable();
            $table->string('status')->default('active');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->foreign('supermarket_id')->references('id')->on('supermarkets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
