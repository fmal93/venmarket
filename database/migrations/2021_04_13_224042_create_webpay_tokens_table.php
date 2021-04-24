<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebpayTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpay_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('buyOrder');
            $table->text('tokenWs');
            $table->text('authorizationCode');
            $table->text('responseCode');
            $table->text('amount');
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
        Schema::dropIfExists('webpay_tokens');
    }
}
