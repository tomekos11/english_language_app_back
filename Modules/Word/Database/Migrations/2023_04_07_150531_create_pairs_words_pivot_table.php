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
        Schema::create('word__pairs_words_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id');
            $table->foreignId('pair_id');
            $table->timestamps();

            $table->index('word_id');
            $table->index('pair_id');

            //relacja z slowami
            $table->foreign('word_id')
                ->references('id')
                ->on('word__words')
                ->onDelete('cascade');

            //relacja z parami
            $table->foreign('pair_id')
                ->references('id')
                ->on('word__connect_pairs')
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
        Schema::dropIfExists('word__pairs_words_pivot');
    }
};
