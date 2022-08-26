<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotifyUsers', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->string('username');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamp('expiry_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spotifyUsers');
    }
};
