<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpAccountTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('smtp_account')) {
            Schema::create('smtp_account', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('email');
                $table->string('password');
                $table->string('server');
                $table->integer('port')->default(25);
                $table->integer('encryption_type')->default(0);
                $table->integer('limit_per_email')->nullable();
                $table->integer('state_id')->default(0);
                $table->integer('type_id')->default(0);
                $table->integer('created_by_id')->nullable();
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
        Schema::dropIfExists('smtp_account');
    }
}
