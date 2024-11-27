<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeStartToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('bookings','time_start')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dateTime('time_start')->change();   

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
        if (!Schema::hasColumn('bookings','time_start')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->time('time_start');

            });
        } 
    }
}
