<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');

            $table->string('body_ar');
            $table->string('body_en');
            
            $table->string('type');//order|| offer
            $table->string('icon')->nullable();

            $table->unsignedInteger('client_id')->nullable();

            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('supermarket_id')->nullable();

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
        Schema::dropIfExists('notification_mobiles');
    }
}
