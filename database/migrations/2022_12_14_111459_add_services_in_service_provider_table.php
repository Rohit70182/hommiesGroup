<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServicesInServiceProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('service_providers', 'services')) {
            Schema::table('service_providers', function (Blueprint $table) {
                $table->string('services')->after('image')->nullable();
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
        if(!Schema::hasColumn('service_providers', 'services')) {
            Schema::table('service_providers', function (Blueprint $table) {
                $table->dropColumn('services');
            });
        }
    }
}
