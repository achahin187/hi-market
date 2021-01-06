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
            $table->string('num');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->unsignedFloat('rate')->nullable();
            $table->dateTime('delivery_date');

            $table->bigInteger('delivery_rate')->nullable();
            $table->bigInteger('seller_rate')->nullable();
            $table->bigInteger('pickup_rate')->nullable();
            $table->bigInteger('time_rate')->nullable();


            $table->text('client_review')->nullable();

            $table->string('promocode')->nullable();
            $table->string('point_redeem')->nullable();
            $table->string('total_before')->nullable();

            $table->string('review_status')->nullable();

            $table->string('shipping_fee')->nullable();
            $table->string('shipping_before')->nullable();
            $table->string('total_money')->nullable();
            
            $table->unsignedFloat('order_price')->nullable();
            $table->unsignedInteger('status');
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
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
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            // $table->foreign('client_id')->references('id')->on('clients')->onUpdate('set null')->onDelete('set null');
            // $table->foreign('reason_id')->references('id')->on('reasons')->onUpdate('set null')->onDelete('set null');

            // $table->foreign('company_id')->references('id')->on('reasons')->onUpdate('set null')->onDelete('set null');
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
