<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_agency', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('price_lists_id');
            $table->unsignedBigInteger('agency_id');
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('price_lists_id')->references('id')->on('price_lists');
            $table->foreign('agency_id')->references('id')->on('agencies');
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
        Schema::dropIfExists('products_agency');
    }
}
