<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForSomeColumnsDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 18, 4)->unsigned()->default(0)->change();
            $table->boolean('manage_stock')->default(0)->change();
            $table->boolean('in_stock')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 18, 4)->unsigned()->change();
            $table->boolean('manage_stock')->change();
            $table->boolean('in_stock')->change();
        });
    }
}
