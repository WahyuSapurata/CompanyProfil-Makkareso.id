<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("image");
            $table->string("title");
            $table->text('description');
            $table->enum('categori', ['web', 'mobile', "logo", 'sosmed', 'illustration']);
            $table->dateTime('date');
            $table->double('price', 8, 2, true)->unsigned();
            $table->dateTime('duration');
            $table->string("client");
            $table->string("designer");

            $table->dateTime('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
