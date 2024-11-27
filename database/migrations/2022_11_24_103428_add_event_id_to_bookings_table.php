<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventIdToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('bookings','event_id'))
        {
            Schema::table('bookings', function(Blueprint $table)
            {
                $table->bigInteger('event_id')->nullable();
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
        if (Schema::hasColumn('bookings','event_id'))
        {
            Schema::table('bookings', function (Blueprint $table)
            {
                $table->dropColumn('event_id')->nullable(false);
                
            });
        }
    }
}
