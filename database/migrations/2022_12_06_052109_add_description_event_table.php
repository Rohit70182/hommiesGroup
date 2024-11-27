<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Exists;

class AddDescriptionEventTable extends Migration
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
                if(!Schema::hasColumn('event', 'desc')) {
                $table->text('desc')->after('title');
                }
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
     
            if (Schema::hasColumn('event','desc'))
            {
                Schema::table('event', function (Blueprint $table)
                {
                    $table->dropColumn('desc');
                    
                });
            }
    }
}
