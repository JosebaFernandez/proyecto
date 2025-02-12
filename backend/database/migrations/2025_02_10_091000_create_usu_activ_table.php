<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('usu_activ', function (Blueprint $table) {
            $table->unsignedBigInteger('dni');
            $table->unsignedBigInteger('id');

            $table->foreign('dni')->references('dni')->on('users')->cascadeOnDelete();
            $table->foreign('id')->references('id')->on('actividades')->cascadeOnDelete();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('usu_activ');
    }
};
