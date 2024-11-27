<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event', function (Blueprint $table) {
            Schema::table('event', function (Blueprint $table) {
                $table->integer('price')->after('title');
                $table->text('desc')->after('title')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function (Blueprint $table) {
            Schema::table('event', function (Blueprint $table) {
                $table->dropColumn('price');
                $table->dropColumn('desc');
            });
        });
    }
}
