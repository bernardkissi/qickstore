<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_dispute_id')->unsigned()->index()->constrained('disputes');
            $table->string('transcation_reference');
            $table->string('refund_reason');
            $table->string('refund_id')->nullable();
            $table->integer('refund_amount')->nullable();
            $table->dateTime('refund_at')->nullable();
            $table->dateTime('expected_at')->nullable();
            $table->enum('status', ['pending', 'refunded'])->default('pending');
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
        Schema::dropIfExists('refunds');
    }
}
