<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoAmountInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('bookings', 'promo_amount')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->float('promo_amount')->after('coupon_id')->nullable();
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
        if(Schema::hasColumn('bookings', 'promo_amount')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('promo_amount');
            });
        }
    }
}
