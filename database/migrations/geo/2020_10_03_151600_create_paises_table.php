<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->increments('id');      
            $table->string('gid0')->comment('pais');
            $table->string('pais');
            $table->string('slug')->unique()->nullable();
            $table->string('codigo')->nullable();
            $table->integer('orden')->default(0)->nullable();
            
            $table->double('lat')->nullable()->comment('latitud de punto central para mapa');
            $table->double('lng')->nullable()->comment('longitud de punto central para mapa');
            $table->double('zoom')->default(13)->comment('Zoom que cubre todo el canton');
            $table->double('pitch')->default(60)->comment('Orientacion para mapbox que cubre todo el canton')->nullable();
            $table->double('bearing')->default(-60)->comment('Orientacion para mapbox que cubre todo el canton')->nullable();
            
            $table->double('minx')->nullable()->comment('right bottom para extent');
            $table->double('miny')->nullable()->comment('right bottom para extent');
            $table->double('maxx')->nullable()->comment('left top para extent');
            $table->double('maxy')->nullable()->comment('left top para extent');
            $table->boolean('estado')->default(true)->nullable();
            
            //Nuevos
            $table->string('short_name')->nullable();
            $table->string('continente')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('bandera_url')->nullable();
            $table->string('escudo_url')->nullable();
            $table->string('zipcode')->nullable();
            $table->integer('n_items')->default(0)->nullable();
            //

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
        Schema::dropIfExists('paises');
    }
}
