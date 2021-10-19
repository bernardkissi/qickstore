<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->morphs('skuable');
            $table->uuid('uuid')->unique();
            $table->integer('price');
            $table->integer('compare_price')->nullable();
            $table->integer('discount_percentage')->nullable();

            $table->integer('min_stock')->default(0);
            $table->boolean('unlimited')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}
