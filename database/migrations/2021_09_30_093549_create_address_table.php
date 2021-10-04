<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->uuid('identifer')->unique()->nullable();
            $table->string('full_address');
            $table->string('city');
            $table->string('digital_address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();

            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('email');
            $table->boolean('is_default')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
