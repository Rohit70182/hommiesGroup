<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteExtraColumnsFromBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('bookings',['address','property_type','units','bedrooms','latitude','longitude'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('address');
                $table->dropColumn('property_type');
                $table->dropColumn('units');
                $table->dropColumn('bedrooms');
                $table->dropColumn('latitude');
                $table->dropColumn('longitude');
            });
        }
        
        if (!Schema::hasColumns('bookings',['address_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('address_id')->after('time_end');
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
        if (!Schema::hasColumns('bookings',['address','property_type','units','bedrooms','latitude','longitude'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('address')->after('time_end');
                $table->string('property_type')->after('time_end');
                $table->integer('units')->after('time_end');
                $table->integer('bedrooms')->after('time_end');
                $table->string('latitude')->after('time_end');
                $table->string('longitude')->after('time_end');
            });
        }
        
        if (Schema::hasColumns('bookings',['address_id'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('address_id');
            });
        }
    }
}
