<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParroquiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parroquias', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('gid0')->comment('pais');
            $table->string('gid1')->comment('provincia');
            $table->string('gid2')->comment('canton');
            $table->string('gid3')->comment('parroquia');
            $table->string('parroquia');
            $table->string('nombre_corto');
            $table->string('slug')->unique()->nullable();
            $table->string('tipo');
            $table->string('slogan')->nullable();
            $table->string('engtype');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('icono')->nullable();
            $table->string('bandera_url')->nullable();
            $table->string('escudo_url')->nullable();
            $table->string('zipcode')->nullable();
            
            $table->double('lat')->nullable()->comment('latitud de punto central para mapa');
            $table->double('lng')->nullable()->comment('longitud de punto central para mapa');
            $table->double('zoom')->default(13)->comment('Zoom que cubre todo el canton');
            $table->double('pitch')->default(60)->comment('Orientacion para mapbox que cubre todo la parroquia');
            $table->double('bearing')->default(-60)->comment('Orientacion para mapbox que cubre todo la parroquia');
            
            $table->double('minx')->nullable()->comment('right bottom para extent');
            $table->double('miny')->nullable()->comment('right bottom para extent');
            $table->double('maxx')->nullable()->comment('left top para extent');
            $table->double('maxy')->nullable()->comment('left top para extent');

            $table->integer('orden')->default(0);
            $table->boolean('estado')->default(true);

               //Nuevos
             $table->integer('n_items')->default(0)->nullable();

            $table->integer('id_0')->unsigned();
            $table->foreign('id_0')->references('id')->on('paises')->onDelete('cascade'); 

             $table->integer('id_1')->unsigned();
             $table->foreign('id_1')->references('id')->on('provincias')->onDelete('cascade'); 
             
             $table->integer('id_2')->unsigned();
             $table->foreign('id_2')->references('id')->on('cantones')->onDelete('cascade'); 
 


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
        Schema::dropIfExists('parroquias');
    }
}
