<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnInServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('sub_services','sub_service_price')) {
            Schema::table('sub_services', function (Blueprint $table) {
                $table->integer('sub_service_price')->nullable()->change();
                
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
        if (!Schema::hasColumn('sub_services','sub_service_price')) {
            Schema::table('sub_services', function (Blueprint $table) {
                $table->string('sub_service_price')->nullable();
                
            });
        } 
    }
}
