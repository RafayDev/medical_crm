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
        Schema::table('invoices', function (Blueprint $table) {
                
                $table->string('status')->default('pending');
                $table->string('sales_tax')->nullable();
                $table->string('freight_charges')->nullable();
                $table->string('payment_proof')->nullable();
                $table->dropColumn('tracking_no');
                $table->dropColumn('courier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
                
                    $table->dropColumn('status');
                    $table->string('tracking_no');
                    $table->string('courier');
        });
    }
};
