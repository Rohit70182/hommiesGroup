<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToUersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if(!Schema::hasColumn('users','customer_id'))
        {
            Schema::table('users', function(Blueprint $table)
            {
                $table->string('customer_id');
            });
        }  
    }
    
    /**,
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        if (Schema::hasColumn('users','customer_id'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('customer_id');
                
            });
        }
    }
}
