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
        Schema::create('word__words', function (Blueprint $table) {
            $table->id();

            //relacja z kategorią
            $table->foreignId('category_id');

            //podstawowe pola
            $table->string('word_en');
            $table->string('word_pl');
            $table->string('difficulty');
            $table->string('photo_url')->default('');

            $table->timestamps();

            //indexy
            $table->index('category_id');

            //relacja z kategorią

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
        Schema::dropIfExists('word__words');
    }
};
