<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('payout_id');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('fullname');
            $table->string('currency')->default('GHS');
            $table->integer('amount_requested');
            $table->integer('transaction_fee');
            $table->string('status');
            $table->string('reference');
            $table->string('narration')->nullable();
            $table->boolean('requires_approval')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->string('error')->nullable();
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
        Schema::dropIfExists('payouts');
    }
}
