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
        Schema::create('system__achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('event_type');
            $table->integer('value');
            $table->text('description')->default('');
            $table->integer('money');
            $table->string('photo_url')->default('');
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
        Schema::dropIfExists('system__achievements');
    }
};
