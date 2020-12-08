<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies_branches', function (Blueprint $table) {
            $table->id();
           $table->bigInteger("delivery_company_id")->unsigned();
           $table->bigInteger("branch_id")->unsigned();
           $table->foreign("delivery_company_id")->references("id")->on("delivery_companies")->onDelete("cascade");
           $table->foreign("branch_id")->references("id")->on("branches")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_companies_branches');
    }
}
