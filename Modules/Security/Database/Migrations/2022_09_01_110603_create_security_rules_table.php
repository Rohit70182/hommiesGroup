<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_rules', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->nullable();
            $table->string('access_time')->nullable();
            $table->string('route')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('state_id')->dafault(0);
            $table->integer('type_id')->default(0);
            $table->integer('created_by_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_rules');
    }
}
