<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeLongitudeToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            if (!Schema::hasColumns('bookings',['property_type','latitude','longitude','mobile','coupon_id'])) {
                Schema::table('bookings', function (Blueprint $table) {
                    $table->string('property_type');
                    $table->string('latitude');
                    $table->string('longitude');
                    $table->string('mobile');
                    $table->string('coupon_id')->nullable();
                    
                });
            }  
            
            if (Schema::hasColumn('bookings','time_end')) {
                Schema::table('bookings', function (Blueprint $table) {
                    $table->string('time_end')->nullable()->change();
                    
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
        if (Schema::hasColumns('bookings',['property_type','latitude','longitude','coupon_id','time_end','mobile'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('property_type');
                $table->string('latitude');
                $table->string('longitude');
                $table->string('mobile');
                $table->string('coupon_id')->nullable();
                $table->string('time_end')->nullable();
            });
        } 
        if (!Schema::hasColumn('bookings','time_end')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('time_end')->nullable();
                
            });
        } 
    }
    
}
