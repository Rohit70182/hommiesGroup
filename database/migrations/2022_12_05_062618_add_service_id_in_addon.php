<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdInAddon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('add_on_services',['service_id','price'])) {
            Schema::table('add_on_services', function (Blueprint $table) {
                $table->integer('service_id')->after('desc');
                $table->integer('price')->after('desc');
                $table->text('desc')->change()->nullable();
            });
        }
        
        if (Schema::hasColumns('add_on_services',['desc'])) {
            Schema::table('add_on_services', function (Blueprint $table) {
                $table->text('desc')->change()->nullable();
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
        
        if (Schema::hasColumns('add_on_services',['service_id','price'.'desc'])) {
            Schema::table('add_on_services', function (Blueprint $table) {
                $table->dropColumn('service_id');
                $table->dropColumn('price');
                $table->string('desc')->change()->nullable();
            });
        }
    }
}
