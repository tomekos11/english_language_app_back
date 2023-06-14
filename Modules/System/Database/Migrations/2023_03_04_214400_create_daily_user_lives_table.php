<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system__daily_user_lives', function (Blueprint $table) {
            //pola
            $table->id();
            $table->foreignId('user_id');
            $table->integer('life_count');
            $table->integer('total_collect_heart');
            $table->integer('next_heart_unix_time');
            $table->timestamps();

            //index
            $table->index('user_id');

            //relacje
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
        Schema::dropIfExists('system__daily_user_lives');
    }
};
