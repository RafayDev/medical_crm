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
        Schema::table('invoice_products', function (Blueprint $table) {
            $table->string('invoice_id')->change();
            $table->string('product_id')->change();
            $table->string('quantity')->change();
            $table->string('price_per_unit')->change();
            $table->string('total_price')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_products', function (Blueprint $table) {
            $table->integer('invoice_id')->change();
            $table->integer('product_id')->change();
            $table->integer('quantity')->change();
            $table->integer('price_per_unit')->change();
            $table->integer('total_price')->change();
        });
    }
};
