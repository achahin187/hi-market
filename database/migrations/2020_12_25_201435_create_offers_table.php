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
            $table->string('type');
            $table->bigInteger('priority');
            $table->string('source')->nullable();
            $table->string('promocode_name')->nullable();
            $table->string('promocode_type')->nullable();
            $table->string('discount_on')->nullable();
            $table->bigInteger('supermarket_id')->unsigned()->nullable();
            $table->bigInteger('value')->nullable();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('total_order_money')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->boolean('status')->default(1);
            $table->string('banner');
          
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
        Schema::dropIfExists('offers');
    }
}
