<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('seo');
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('route')->nullable();
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('data')->nullable();
            $table->tinyInteger('state_id')->default('1');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
        Schema::dropIfExists('seo_analytics');
        Schema::create('seo_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('account')->nullable();
            $table->string('domain_name')->nullable();
            $table->string('additional_information')->nullable();
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->integer('created_by_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
        Schema::dropIfExists('seo_redirect');
        Schema::create('seo_redirect', function (Blueprint $table) {
            $table->id();
            $table->string('old_url')->nullable();
            $table->string('new_url')->nullable();
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->integer('created_by_id')->nullable();
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
        if (Schema::hasTable('seo')) {
            Schema::dropIfExists('seo');
        }
        if (Schema::hasTable('seo_analytics')) {
            Schema::dropIfExists('seo_analytics');
        }
        if (Schema::hasTable('seo_redirect')) {
            Schema::dropIfExists('seo_redirect');
        }
    }
}
