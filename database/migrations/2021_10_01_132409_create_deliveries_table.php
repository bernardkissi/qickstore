<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('service');
            $table->foreignId('order_id')->unsigned()->index()->constrained('orders');
            $table->string('state');
            $table->json('updates')->nullable();
            $table->string('reference');
            $table->string('batch_number')->nullable();
            $table->string('tracking_code')->unique();
            $table->string('provider_code')->nullable();
            $table->string('estimate_id')->nullable();
            $table->text('instructions')->nullable();
            $table->string('download_link')->nullable();
            $table->text('error')->nullable();
            $table->json('agent_details')->nullable();
            $table->json('vehicle')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('failed_at')->nullable();
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
        Schema::dropIfExists('deliveries');
    }
}
