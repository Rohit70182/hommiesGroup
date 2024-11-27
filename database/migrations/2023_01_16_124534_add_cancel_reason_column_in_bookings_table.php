<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelReasonColumnInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('bookings', ['cancel_id','cancel_message'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('cancel_id')->after('coupon_id')->nullable();
                $table->longText('cancel_message')->after('coupon_id')->nullable();
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
        if(Schema::hasColumns('bookings', ['cancel_id','cancel_message'])) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('cancel_id');
                $table->dropColumn('cancel_message');
            });
        }
    }
}
