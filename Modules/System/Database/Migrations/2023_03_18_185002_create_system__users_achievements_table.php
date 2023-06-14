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
        Schema::create('system__users_achievements', function (Blueprint $table) {
            //pola
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('achievement_id');

            $table->timestamps();

            //indexy
            $table->index('user_id');
            $table->index('achievement_id');

            //relacja z userem
            $table->foreign('user_id')
                ->references('id')
                ->on('auth__users')
                ->onDelete('cascade');

            //relacja z achievement
            $table->foreign('achievement_id')
                ->references('id')
                ->on('system__achievements')
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
        Schema::dropIfExists('system__users_achievements');
    }
};
