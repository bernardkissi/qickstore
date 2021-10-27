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
            $table->foreignId('coupon_id')->nullable()->unsigned()->index()->constrained('coupons');

            $table->string('shipping_service')->nullable();
            $table->integer('shipping_cost')->nullable();

            $table->string('payment_gateway')->nullable();
            $table->integer('total')->unsigned();
            $table->integer('discount')->unsigned()->nullable();

            $table->string('estimate_id')->nullable();

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
        Schema::enableForeignKeyConstraints();
    }
}
