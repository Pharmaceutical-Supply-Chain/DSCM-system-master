<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('trade_name');
            $table->dropColumn('scientific_name');
            $table->dropColumn('drug_description');
            $table->dropColumn('drug_dose');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('trade_name');
            $table->string('scientific_name');
            $table->string('drug_description');
            $table->string('drug_dose');
        });
    }
};
