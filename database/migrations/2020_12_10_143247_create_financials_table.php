<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();

            $table->string('total_order')->nullable();
            $table->string('delivertto_money')->nullable();

            $table->string('branch_money')->nullable();
            $table->string('branch_recieved')->nullable();
            $table->string('branch_remain')->nullable();

            $table->string('company_remain')->nullable();
            $table->string('company_remain')->nullable();
            $table->string('company_remain')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financials');
    }
}
