<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unsigned()->index()->constrained('orders');
            $table->string('tx_ref');
            $table->string('auth_code')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('card_type')->nullable();
            $table->string('subaccount')->nullable();
            $table->string('provider_reference')->nullable();
            $table->string('status');
            $table->string('amount');
            $table->string('provider');
            $table->string('channel');
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
        Schema::dropIfExists('payments');
    }
}
