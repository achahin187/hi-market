<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('udids', function (Blueprint $table) {
            $table->id();
            $table->string("body");
            $table->bigInteger("client_id")->unsigned()->nullable();
            $table->string("lat")->nullable();
            $table->string("lon")->nullable();
            $table->foreign("client_id")->references("id")->on("clients")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('udids');
    }
}
