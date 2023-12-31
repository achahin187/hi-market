<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityIdToDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_companies', function (Blueprint $table) {
            // $table->bigInteger("city_id")->unsigned();
            // $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_companies', function (Blueprint $table) {
            $table->dropColumn("city_id");
        });
    }
}
