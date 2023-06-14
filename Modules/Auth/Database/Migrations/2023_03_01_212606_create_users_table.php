<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Auth\Enums\RoleEnum;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth__users', function (Blueprint $table) {
            $table->id();

            //pola
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('money')->default(0);
            $table->string('role')->default(RoleEnum::USER->value);
            $table->integer('favourite_counter')->default(0);
            $table->integer('review_counter')->default(0);
            $table->integer('lvl')->default(1);
            $table->integer('xp')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('auth__users');
    }
};
