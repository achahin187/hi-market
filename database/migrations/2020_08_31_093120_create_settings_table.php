<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tax');
            $table->unsignedFloat('tax_value');
            $table->unsignedInteger('tax_on_product');
            $table->unsignedFloat('delivery');
            $table->unsignedInteger('cancellation');
            $table->string('splash')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
