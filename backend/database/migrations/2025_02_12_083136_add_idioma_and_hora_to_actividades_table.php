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
            $table->string('idioma')->nullable(); // Añade el campo 'idioma'
            $table->time('hora')->nullable(); // Añade el campo 'hora'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropColumn('idioma'); // Elimina el campo 'idioma'
            $table->dropColumn('hora'); // Elimina el campo 'hora'
        });
    }
};
