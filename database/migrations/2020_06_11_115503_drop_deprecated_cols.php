<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDeprecatedCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function($table) {
            $table->dropColumn('unit_price_cny');
            $table->dropColumn('purchase_price_aud');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function(Blueprint $table)
        {
            $table->decimal('unit_price_cny');
            $table->decimal('purchase_pric_aud');
        });
    }
}
