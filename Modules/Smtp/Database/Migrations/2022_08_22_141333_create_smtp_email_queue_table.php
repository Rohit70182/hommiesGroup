<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpEmailQueueTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('smtp_email_queue')) {
            Schema::create('smtp_email_queue', function (Blueprint $table) {
                $table->id();
                $table->string('from_email', 128)->nullable();
                $table->string('to_email', 128)->nullable();
                $table->text('message');
                $table->string('subject')->nullable();
                $table->dateTime('date_published')->nullable();
                $table->dateTime('last_attempt')->nullable();
                $table->dateTime('date_sent')->nullable();
                $table->integer('attempts')->default('1');
                $table->integer('state_id')->default('1');
                $table->integer('model_id')->nullable();
                $table->string('model_type', 128)->nullable();
                $table->integer('email_account_id')->nullable();
                $table->string('message_id')->nullable();
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
        Schema::dropIfExists('smtp_email_queue');
    }
}
