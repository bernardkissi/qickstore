<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->morphs('orderable');
            $table->integer('items_count')->default(0);
            $table->foreignId('shipping_id')->unsigned()->index()->constrained('shipping_providers');
            $table->foreignId('address_id')->unsigned()->index()->constrained('addresses');
            $table->string('shipping_service')->default('custom');
            $table->string('payment_gateway')->nullable();
            $table->integer('total')->unsigned();
            $table->string('estimate_id')->nullable();
            $table->json('delivery_details')->nullable();
            $table->text('instructions')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
