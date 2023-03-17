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
        Schema::create('stock_details', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name');
            $table->string('drug_amount');
            $table->date('drug_entry_date');
            $table->string('drug_residual');
            $table->date('production_date');
            $table->date('expiration_date');
            $table->float('drug_unit_price',8,2);
            $table->foreignId('stock_id')->nullable()->constrained('stock')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('drug_id')->nullable()->constrained('drugs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('stock_details');

        Schema::table('stock_details', function (Blueprint $table) {
            $table->dropConstrainedForeignId('stock_id');
            $table->dropConstrainedForeignId('drug_id');
        });
    }
};
