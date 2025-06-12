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
        Schema::table('resenas', function (Blueprint $table) {
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
        Schema::table('resenas', function (Blueprint $table) {
            $table->dropUnique(['usuario_id', 'produccion_id']);
        });
    }
};
