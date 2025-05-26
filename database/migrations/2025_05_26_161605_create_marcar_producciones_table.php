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
        Schema::create('marcar_producciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('produccion_id')->constrained('producciones');
            $table->tinyInteger('marca')->default(0); // 0: no marcado, 1: visto, 2: quiero ver
            $table->tinyInteger('favorita')->default(0); 
            $table->timestamps();
            $table->unique(['usuario_id', 'produccion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcar_producciones');
    }
};
