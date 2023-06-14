<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system__time_games_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id');
        $table->string('type');
        $table->integer('result');
        $table->datetime('end_time');
        $table->timestamps();

        $table->index('user_id');

        //relacja z slowami
        $table->foreign('user_id')
            ->references('id')
            ->on('auth__users')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system__time_games_results');
    }
};
