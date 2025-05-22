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
        Schema::create('producciones', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('titulo', 255);
            $table->enum('tipo', ['Pelicula', 'Serie']);
            $table->foreignId('genero_id')->constrained('generos');
            $table->text('sinopsis');
            $table->integer('duracion');
            $table->date('fecha_estreno');
            $table->string('poster', 255);
            $table->decimal('puntuacion_critica', 3, 1);
            $table->decimal('puntuacion_usuarios', 3, 1);
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
        Schema::dropIfExists('producciones');
    }
};
