<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            // Eliminar el campo 'edad'
            $table->dropColumn('edad');

            // Añadir los nuevos campos 'edad_minima' y 'edad_maxima'
            $table->integer('edad_minima')->nullable(); // Edad mínima
            $table->integer('edad_maxima')->nullable(); // Edad máxima
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            // Revertir los cambios: eliminar los nuevos campos y restaurar 'edad'
            $table->dropColumn('edad_minima');
            $table->dropColumn('edad_maxima');
            $table->string('edad')->nullable(); // Restaurar el campo 'edad'
        });
    }
};
