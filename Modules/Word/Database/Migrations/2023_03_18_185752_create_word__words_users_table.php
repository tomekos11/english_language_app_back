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
        Schema::create('word__words_users', function (Blueprint $table) {
            $table->id();

            //relacje
            $table->foreignId('word_id');
            $table->foreignId('user_id');

            //pola
            $table->boolean('review')->default(false);
            $table->boolean('review_done')->default(false);
            $table->boolean('is_favourite')->default(false);
            $table->text('notes')->default('');
            $table->timestamps();

            //indexy
            $table->index('word_id');
            $table->index('user_id');

            //relacja ze slowem
            $table->foreign('word_id')
                ->references('id')
                ->on('word__words')
                ->onDelete('cascade');

            //relacja z testem
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
        Schema::dropIfExists('word__words_users');
    }
};
