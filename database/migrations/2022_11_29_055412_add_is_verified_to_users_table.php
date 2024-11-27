<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVerifiedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users','is_verified')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_verified')->after('role')->default(0);
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
        if (Schema::hasColumn('users','is_verified')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_verified');
            });
        }
    }
}
