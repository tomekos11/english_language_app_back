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
        Schema::create('system__money_logs', function (Blueprint $table) {
            $table->id();

            //pola relacyjne
            $table->foreignId('user_id');

            //pola
            $table->string('event');
            $table->integer('value');
            $table->integer('old_budget');
            $table->integer('new_budget');
            $table->timestamps();

            //indexy
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
        Schema::dropIfExists('system__money_logs');
    }
};
