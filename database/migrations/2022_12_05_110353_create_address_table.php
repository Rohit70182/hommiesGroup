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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('address');
            $table->string('address_two')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->integer('postal_code');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('address_type');
            $table->integer('type_id')->default(0);
            $table->integer('state_id')->default(0);
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
        Schema::dropIfExists('address');
    }
}
