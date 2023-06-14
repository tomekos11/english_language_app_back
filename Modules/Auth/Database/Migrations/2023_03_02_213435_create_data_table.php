<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth__data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');

            $table->string('name');
            $table->string('surname');
            $table->string('photo_url')->default(Storage::url('users/avatars/default.svg'));
            $table->date('birth_date');
            $table->timestamps();

            //indexy
            $table->index('user_id');

            //relacja data-user
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
        Schema::dropIfExists('auth__data');
    }
};
