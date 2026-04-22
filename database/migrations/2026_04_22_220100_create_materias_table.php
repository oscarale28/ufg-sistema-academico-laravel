<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_materia')->unique();
            $table->timestamps();
        });

        DB::table('materias')->insert([
            ['nombre_materia' => 'Matematica I', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_materia' => 'Programacion I', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_materia' => 'Base de Datos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_materia' => 'Arquitectura de Software', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_materia' => 'Redes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
