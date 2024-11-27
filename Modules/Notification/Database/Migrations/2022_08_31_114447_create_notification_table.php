<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notifications');

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_user_id')->default('0');
            $table->unsignedBigInteger('to_user_id')->default('0');
            $table->tinyInteger('to_admin')->default('0');
            $table->string('title');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('is_read')->default('0');
            $table->tinyInteger('has_notify')->default('0');
            $table->integer('state_id')->default('0');
            $table->integer('type_id')->default('0');
            $table->integer('created_by_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
