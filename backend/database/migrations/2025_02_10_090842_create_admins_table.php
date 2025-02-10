<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2');
            $table->string('dni')->unique();
            $table->date('fecha_nacimiento');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
