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
            $table->string('mobile_delivery');
            $table->string('address');
            $table->unsignedFloat('rate')->nullable();
            $table->dateTime('delivery_date');
            $table->unsignedFloat('delivery_rate')->nullable();
            $table->text('client_review')->nullable();
            $table->string('review_status')->nullable();
            $table->unsignedFloat('order_price')->nullable();
            $table->unsignedInteger('status');
            $table->bigInteger('client_id')->unsigned();
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('request');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('prepared_at')->nullable();
            $table->dateTime('shipping_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->unsignedInteger('admin_cancellation')->default(0);
            $table->bigInteger('reason_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

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
