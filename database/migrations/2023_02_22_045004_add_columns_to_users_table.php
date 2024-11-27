<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumns('users',['latitude','longitude','experience','certifications','services','start_time','end_time','working_day'])) {
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->integer('experience')->nullable();
                $table->string('certifications')->nullable();
                $table->string('services')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->integer('working_day')->nullable();
          

            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumns('users',['latitude','longitude','experience','certifications','services','start_time','end_time','working_day'])) {
                    $table->dropColumn('latitude','longitude','experience','certifications','services','start_time','end_time','working_day');
            }
               
          
        });
    }
}
