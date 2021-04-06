<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritional_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_value_id');
            $table->string('portion', 30);
            $table->float('portions_per_pack');
            $table->float('calories');
            $table->float('proteins');
            $table->float('fats');
            $table->float('carbs');
            $table->float('sugar');
            $table->float('fiber');
            $table->float('sodium');
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
        Schema::dropIfExists('nutritional_infos');
    }
}
