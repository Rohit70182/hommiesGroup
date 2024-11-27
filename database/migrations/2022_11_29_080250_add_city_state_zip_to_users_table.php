<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityStateZipToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('users',['address_two','state','city','zip'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('address_two')->nullable();
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->string('zip')->nullable();
                
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
        if (Schema::hasColumns('users',['address_two','state','city','zip','time_end','mobile'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('address_two');
                $table->string('state');
                $table->string('city');
                $table->string('zip');
            });
        }
    }
}
