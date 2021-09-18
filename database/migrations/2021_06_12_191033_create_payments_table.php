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
            $table->string('authorization_code')->nullable();
            $table->string('card_type')->nullable();
            $table->string('subaccount')->nullable();
            $table->string('provider_reference')->nullable();
            $table->string('status');
            $table->string('amount');
            $table->string('provider')->nullable();
            $table->string('channel')->nullable();
            $table->string('access_code')->nullable();
            $table->string('pay_url')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->boolean('has_subscription')->nullable();
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
