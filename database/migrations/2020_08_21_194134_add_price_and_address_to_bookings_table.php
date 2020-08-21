<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceAndAddressToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->unsignedInteger('price')->after('bookable_id');
            $table->unsignedBigInteger('address_id')->index()->nullable()->after('review_key');

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn('price');
            $table->dropForeign(['address_is']);
            $table->dropColumn('address_id');
        });
    }
}
