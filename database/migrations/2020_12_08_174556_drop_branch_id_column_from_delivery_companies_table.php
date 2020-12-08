<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBranchIdColumnFromDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_companies', function (Blueprint $table) {
            $table->dropForeign("delivery_companies_branch_id_foreign");
            $table->dropColumn("branch_id");
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
            $table->integer("branch_id");
        });
    }
}
