<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_stock_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stock_id');
            $table->integer('before')->default(0);
            $table->integer('after')->default(0);
            $table->decimal('cost', 8, 2)->default(0)->nullable();
            $table->string('reason')->nullable();

            
            $table->timestamps();

            $table->foreign('stock_id')
                ->references('id')
                ->on('inventory_stocks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_stock_movements');
    }
}
