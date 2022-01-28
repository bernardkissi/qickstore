<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('sku_id')->unsigned()->index()->constrained('skus');
            $table->foreignId('order_id')->unsigned()->index()->constrained('orders');
            $table->foreignId('plan_id')->unsigned()->index()->constrained('product_plans');

            $table->string('subscription_code')->nullable();
            $table->string('plan_code');
            $table->string('auth_code');
            $table->string('email_token')->nullable();
            $table->string('channel')->nullable();
            $table->string('card_type')->nullable();
            $table->integer('invoice_limit')->nullable();
            $table->integer('subscription_id')->nullable();

            $table->string('customer_code');
            $table->string('customer_email')->nullable();

            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->dateTime('next_billing_date')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->integer('payment_count')->default(0);

            $table->boolean('open_invoice')->nullable();
            $table->json('invoice_history')->nullable();

            $table->string('cron_expression')->nullable();
            $table->string('state')->nullable();

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
        Schema::dropIfExists('product_subscriptions');
    }
}
