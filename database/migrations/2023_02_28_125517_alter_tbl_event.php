<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTblEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('event',['user_id'])) {
            Schema::table('event', function (Blueprint $table) {
                $table->string('user_id')->nullable();
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
        if (Schema::hasColumns('event', ['user_id'])) {
            Schema::table('event', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
        
    }
}
