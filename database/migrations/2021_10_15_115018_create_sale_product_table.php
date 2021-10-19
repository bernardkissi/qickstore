<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sku_id')->unsigned()->index()->constrained('skus');
            $table->foreignId('sale_id')->unsigned()->index()->constrained('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_product');
    }
}
