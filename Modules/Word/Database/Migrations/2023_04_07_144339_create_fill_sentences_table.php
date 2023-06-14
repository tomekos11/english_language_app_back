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
        Schema::create('word__fill_sentences', function (Blueprint $table) {
            $table->id();
            $table->json('sentence');
            $table->string('correct_answer');
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
        Schema::dropIfExists('word__fill_sentences');
    }
};
