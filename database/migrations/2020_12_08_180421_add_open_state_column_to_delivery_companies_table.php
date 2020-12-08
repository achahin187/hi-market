<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpenStateColumnToDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_companies', function (Blueprint $table) {
            $table->date("open_time")->after("name_en")->nullable();
            $table->date("close_time")->after("open_time")->nullable();
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
            $table->dropColumn("open_time","close_time");

        });
    }
}
