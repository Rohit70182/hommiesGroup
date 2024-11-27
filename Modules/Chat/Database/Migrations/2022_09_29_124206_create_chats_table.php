<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('chats')) {
            Schema::create('chats', function (Blueprint $table) {
                $table->id();
                $table->string('message')->nullable();
                $table->string('users')->nullable();
                $table->integer('from_id');
                $table->integer('to_id')->nullable();
                $table->string('readers')->default(0);
                $table->integer('from_role')->nullable();
                $table->integer('to_role')->nullable();
                $table->integer('is_read')->default(0);
                $table->string('notified_users')->nullable();
                $table->integer('role')->nullable();
                $table->integer('state_id')->default(1);
                $table->integer('type_id')->default(0);
                $table->string('file')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('chats');
    }
}
