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
            $table->integer('type');
            $table->integer('mode');
            $table->string('promocode');
            $table->string('promocode_type');
            $table->string('value');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status');
            $table->timestamps();
            $table->dateTime('created_by')->nullable();
            $table->dateTime('updated_by')->nullable();
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
