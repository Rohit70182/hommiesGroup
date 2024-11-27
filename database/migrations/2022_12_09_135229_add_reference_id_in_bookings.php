<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceIdInBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('bookings',['reference_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('reference_id')->after('time_end');
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
        if (Schema::hasColumns('bookings',['reference_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('reference_id');
            });
        }
    }
}
