<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sku_id')->unsigned()->index()->constrained('skus');
            $table->foreignId('bundle_id')->unsigned()->index()->constrained('bundles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_product');
    }
}
