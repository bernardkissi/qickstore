<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unsigned()->index()->constrained('products')->onDelete('cascade');
            $table->string('plan_name');
            $table->string('plan_code')->nullable();
            $table->text('plan_description');
            $table->string('type');

            $table->integer('price');
            $table->string('interval')->default('monthly');
            $table->string('currency')->default('GHS');
            $table->integer('duration')->default(24);

            $table->boolean('send_sms')->default(0);
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
        Schema::dropIfExists('product_plans');
    }
}
