<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies', function (Blueprint $table) {
            $table->id();
            $table->string("name_ar");
            $table->string("name_en");
            $table->boolean("status")->default(0);
            $table->float("commission");
            $table->string("phone_number");
            $table->string("email");
            $table->bigInteger("city_id")->unsigned();
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");

            $table->bigInteger("manager_id")->unsigned();
            $table->foreign("manager_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('delivery_companies');
    }
}
