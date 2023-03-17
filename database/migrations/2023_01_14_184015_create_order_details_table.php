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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name');
            $table->string('scientific_name');
            $table->string('drug_description');
            $table->date('production_date');
            $table->date('expiration_date');
            $table->string('drug_dose');
            $table->string('drug_amount');
            $table->float('drug_unit_price',8,2);
            $table->float('drug_total_cost',8,2);
            $table->foreignId('order_id')->nullable()->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_id');
        });
        
        Schema::dropIfExists('order_details');
    }
};
