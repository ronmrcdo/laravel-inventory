<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_sku_id');
            $table->unsignedBigInteger('product_attribute_id');
            $table->unsignedBigInteger('product_attribute_value_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('product_sku_id')
                ->references('id')
                ->on('product_skus')
                ->onDelete('cascade');

            $table->foreign('product_attribute_id')
                ->references('id')
                ->on('product_attributes')
                ->onDelete('cascade');
            
            $table->foreign('product_attribute_value_id')
                ->references('id')
                ->on('product_attribute_values')
                ->onDelete('cascade');

            $table->unique(['product_id', 'product_attribute_id', 'product_sku_id'], 'product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
