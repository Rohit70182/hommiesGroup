<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageTypeInChats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('chats', 'message_type')) {
            Schema::table('chats', function (Blueprint $table) {
                $table->string('message_type')->after('is_read')->nullable(false);
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
        if(Schema::hasColumn('chats', 'message_type')) {
            Schema::table('chats', function (Blueprint $table) {
                $table->dropColumn('message_type');
            });
        }
    }
}
