<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDisputeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispute_id')->unsigned()->index()->constrained('disputes');
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->boolean('has_attachment')->default(false);
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
        Schema::dropIfExists('dispute_actions');
    }
}
