<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('buyOrder');
            $table->string('status');
            $table->text('items');
            $table->string('cantidad');
            $table->string('total');
            $table->text('nombre');
            $table->text('telefono');
            $table->string('email');
            $table->text('direccion');
            $table->string('region');
            $table->string('comuna');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
