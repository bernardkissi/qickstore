<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couponables', function (Blueprint $table) {
            $table->id();
            $table->morphs('couponable');
            $table->foreignId('coupon_id')->unsigned()->index()->constrained('coupons');
            $table->dateTime('redeemed_at');

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
        Schema::dropIfExists('couponables');
    }
}
