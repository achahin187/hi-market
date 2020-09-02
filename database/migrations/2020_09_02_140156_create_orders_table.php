<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->unsignedFloat('rate')->nullable();
            $table->string('mobile_delivery');
            $table->text('comment');
            $table->unsignedFloat('order_price')->nullable();
            $table->unsignedInteger('status');
            $table->bigInteger('client_id')->unsigned();
            $table->unsignedInteger('request');
            $table->dateTime('approved_at');
            $table->dateTime('prepared_at');
            $table->dateTime('shipping_at');
            $table->dateTime('shipped_at');
            $table->dateTime('cancelled_at');
            $table->unsignedInteger('admin_cancellation');
            $table->bigInteger('reason_id')->unsigned();
            $table->text('notes');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('no action')->onDelete('no action');
            $table->foreign('reason_id')->references('id')->on('reasons')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
