<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('publishable_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_id')->nullable();
            $table->foreignId('customer_id')->index();
            $table->text('response');
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->text('response');
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('interval')->nullable();
            $table->text('features');
            $table->text('response');
            $table->string('image_file')->nullable();
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('product_id')->nullable();
            $table->text('response');
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('plan_id')->index();
            $table->string('subscription_id');
            $table->text('response');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
            $table->timestamps();
        });

        Schema::create('stripe_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('description')->index();
            $table->string('amount')->index();
            $table->string('currency')->index();
            $table->text('response');
            $table->string('payment_status');
            $table->integer('model_id');
            $table->string('model_type');
            $table->tinyInteger('state_id')->default('1');
            $table->tinyInteger('type_id')->default('0');
            $table->foreignId('created_by_id')->index();
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
        Schema::dropIfExists('stripe_settings');
        Schema::dropIfExists('stripe_cards');
        Schema::dropIfExists('stripe_customers');
        Schema::dropIfExists('stripe_plans');
        Schema::dropIfExists('stripe_products');
        Schema::dropIfExists('stripe_subscriptions');
        Schema::dropIfExists('stripe_transactions');
    }
}
