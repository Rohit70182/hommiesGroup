<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceToNullableInServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('services'))
        {
            if(Schema::hasColumn('services', 'price'))
            Schema::table('services', function (Blueprint $table) {
                $table->string('price')->nullable()->change();
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
        if (Schema::hasTable('services')){
            if(Schema::hasColumn('services', 'price'))
                Schema::table('services', function (Blueprint $table) {
                    $table->string('price')->change();
                });
        }
    }
}
