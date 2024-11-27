<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id');
            $table->integer('category_id')->default(0);
            $table->integer('subcategory_id')->default(0);
            $table->integer('addOn_id')->nullable();
            $table->dateTime('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('address');
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
        Schema::dropIfExists('bookings');
    }
}
