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
        Schema::create('word__tests', function (Blueprint $table) {
            //pola
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->string('status');
            $table->string('difficulty');
            $table->integer('number');
            $table->timestamps();

            //index
            $table->index('user_id');
            $table->index('category_id');

            //relacja z userem
            $table->foreign('user_id')
                ->references('id')
                ->on('auth__users')
                ->onDelete('cascade');

            //relacja z kategoria
            $table->foreign('category_id')
                ->references('id')
                ->on('word__categories')
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
        Schema::dropIfExists('word__tests');
    }
};
