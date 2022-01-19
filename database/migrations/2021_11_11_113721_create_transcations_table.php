<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->unsigned()->index()->constrained('orders');
            $table->foreignId('subscription_id')->nullable()->unsigned()->index()->constrained('product_subscriptions');

            $table->string('tx_ref');
            $table->string('status');
            $table->string('amount');

            $table->string('auth_code')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('card_type')->nullable();
            $table->string('subaccount')->nullable();
            $table->string('provider_reference')->nullable();
            $table->string('plan')->nullable();
            $table->json('history')->nullable();
            $table->string('provider')->nullable();
            $table->string('channel')->nullable();
            $table->string('access_code')->nullable();
            $table->string('pay_url')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->boolean('has_subscription')->nullable();
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
        Schema::dropIfExists('transcations');
    }
}
