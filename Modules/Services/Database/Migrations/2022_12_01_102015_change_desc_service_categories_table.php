<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDescServiceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->text('desc')->change();
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->text('desc')->change();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->text('desc')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->string('desc')->change();
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('desc')->change();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->string('desc')->change();
        });
    }
}
