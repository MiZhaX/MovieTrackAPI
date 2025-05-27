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
        Schema::create('produccion_listas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lista_personalizada_id')->constrained('listas_personalizadas');
            $table->foreignId('produccion_id')->constrained('producciones');
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
        Schema::dropIfExists('produccion_listas');
    }
};
