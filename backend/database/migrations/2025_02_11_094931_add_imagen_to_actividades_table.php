<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('actividades', function (Blueprint $table) {
            $table->string('imagen')->nullable()->after('fecha'); // Agrega la columna después de 'fecha'
        });
    }

    public function down() {
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }
};
