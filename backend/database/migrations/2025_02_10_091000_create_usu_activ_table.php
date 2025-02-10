<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('usu_activ', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_actividad')->constrained('actividades')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usu_activ');
    }
};
