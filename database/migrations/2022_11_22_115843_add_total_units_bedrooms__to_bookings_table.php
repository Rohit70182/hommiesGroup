<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalUnitsBedroomsToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('bookings',['units','bedrooms'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('units');
                $table->string('bedrooms')->nullable();
                
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('bookings',['units','bedrooms'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('units');
                $table->string('bedrooms')->nullable();
            });
        }
    }
}
