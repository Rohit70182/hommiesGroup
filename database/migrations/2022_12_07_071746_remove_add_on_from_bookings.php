<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAddOnFromBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('bookings',['addOn_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('addOn_id');
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
        if (!Schema::hasColumns('bookings',['addOn_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('addOn_id')->after('time_end');
            });
        }
    }
}
