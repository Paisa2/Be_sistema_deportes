<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nom_categoria');
            $table->string('edad_categoria')->nulable();
            $table->date('fecha_inscription')->nullable();

             //Relacion de table de uno a muchos
            $table->unsignedBigInteger('disiplina_id');
            $table->foreign('disiplina_id')
                    ->references('id')->on('disiplinas')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            //Relacion de table de uno a muchos
            $table->unsignedBigInteger('entrenador_id');
            $table->foreign('entrenador_id')
                    ->references('id')->on('entrenadores')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('categorias');
    }
}
