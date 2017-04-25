<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLugarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lugares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('direccion');
            $table->string('vecinity');
            $table->string('imagen')->nullable();
            $table->string('telefono')->nullable();
            $table->string('web')->nullable();
            $table->string('google_id')->unique();
            $table->double('lat');
            $table->double('lng');
            $table->boolean('loaded')->defaut(false);
            $table->timestamps();
        });

        Schema::create('categoria_lugar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria_id');
            $table->foreign('categoria_id')->references('categoria')->on('categorias')->onDelete('cascade');
            $table->integer('lugar_id')->unsigned();
            $table->foreign('lugar_id')->references('id')->on('lugares')->onDelete('cascade');
            $table->unique(['categoria_id','lugar_id']);
        });

        Schema::create('lugar_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('lugar_id')->unsigned();
            $table->foreign('lugar_id')->references('id')->on('lugares')->onDelete('cascade');
            $table->unique(['user_id','lugar_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categoria_lugar');
        Schema::drop('lugar_user');
        Schema::drop('lugares');
    }
}
