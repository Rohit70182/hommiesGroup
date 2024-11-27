<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouriteItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourite_item', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('model_id');
            $table->string('model_type');
            $table->integer('state_id')->default(1);
            $table->integer('type_id')->default(1);
            $table->integer('created_by_id');
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
        Schema::dropIfExists('favourite_item');
    }
}
