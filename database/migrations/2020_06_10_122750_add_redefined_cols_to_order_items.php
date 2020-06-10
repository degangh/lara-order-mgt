<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRedefinedColsToOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('purchase_price',13,4)->default(0);
            $table->string('purchase_currency',3);
            $table->decimal('sell_price',13,4)->default(0);
            $table->string('sell_currency', 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
            $table->dropColumn('purchase_currency');
            $table->dropColumn('sell_price');
            $table->dropColumn('sell_currency');
        });
    }
}
