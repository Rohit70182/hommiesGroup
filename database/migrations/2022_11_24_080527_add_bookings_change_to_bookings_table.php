<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingsChangeToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('bookings',['service_id','units','property_type','subcategory_id','category_id'])) 
        {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('service_id')->nullable()->change();
                $table->string('units')->nullable()->change();
                $table->string('property_type')->nullable()->change();
                $table->integer('subcategory_id')->nullable()->change();
                $table->integer('category_id')->nullable()->change();
                
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
        if (Schema::hasColumns('bookings',['service_id','units','property_type','subcategory_id','category_id'])) 
        {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('service_id')->nullable(false)->change();
                $table->string('units')->nullable(false)->change();
                $table->string('property_type')->nullable(false)->change();
                $table->integer('subcategory_id')->nullable(false)->change();
                $table->integer('category_id')->nullable(false)->change();
            });
        } 
    }
}
