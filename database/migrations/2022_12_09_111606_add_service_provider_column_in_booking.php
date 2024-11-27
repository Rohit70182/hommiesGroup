<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderColumnInBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('bookings',['service_provider'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('service_provider')->after('time_end')->nullable();
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
        if (Schema::hasColumns('bookings',['service_provider'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('service_provider');
            });
        }
    }
}
