<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstNameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('users',['first_name','last_name'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('first_name')->after('name')->nullable();
                $table->string('last_name')->after('first_name')->nullable();                
            });
        }
        
        if (!Schema::hasColumns('users',['is_complete'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_complete')->default(0);
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
        if (Schema::hasColumns('users',['first_name','last_name','is_complete'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('first_name');
                $table->dropColumn('last_name');
                $table->dropColumn('is_complete');
            });
        }
    }
}
