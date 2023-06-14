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
        Schema::create('word__exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id');
            $table->foreignId('external_id');
            $table->string('status');
            $table->string('type');
            $table->integer('number');
            $table->timestamps();


            //indexy
            $table->index('test_id');
            $table->index('external_id');

            //relacja z testami
            $table->foreign('test_id')
                ->references('id')
                ->on('word__tests')
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
        Schema::dropIfExists('word__exercises');
    }
};
