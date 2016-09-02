<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattleCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battle_character', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('battle_id')->unsigned()->index();
            $table->foreign('battle_id')->references('id')->on('battles')->onDelete('cascade');

            $table->integer('character_id')->unsigned()->index();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');

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
        Schema::drop('battle_character');
    }
}
