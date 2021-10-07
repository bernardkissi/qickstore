<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->morphs('disputable');
            $table->string('disputable_reference_id');
            $table->string('disputable_transcation_reference');
            $table->string('subject');
            $table->longtext('customer_dispute');
            $table->longText('merchant_response')->nullable();
            $table->boolean('has_attachment')->default(false);
            $table->string('customer_mobile');
            $table->string('customer_email')->nullable();
            $table->enum('status', ['open', 'declined', 'accepted', 'resolved'])->default('open');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *'
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disputes');
    }
}
