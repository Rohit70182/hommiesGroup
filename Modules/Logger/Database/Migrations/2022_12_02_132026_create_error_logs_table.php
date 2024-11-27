<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        if (! Schema::hasTable('error_logs')) {
            Schema::create('error_logs', function (Blueprint $table) {
                $table->id();
                $table->string('instance');
                $table->string('channel');
                $table->string('level');
                $table->string('level_name');
                $table->longText('message', 255);
                $table->longText('context', 255);
                $table->longText('formatted_context', 255);
                $table->integer('remote_addr')
                    ->nullable()
                    ->unsigned();
                $table->string('user_agent')->nullable();
                $table->integer('created_by')
                    ->nullable()
                    ->index();
                $table->dateTime('created_at');
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
        Schema::dropIfExists('error_logs');
    }
}
