<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('identificacion', 50)->unique();
            $table->string('codigo_estudiantil', 50)->unique()->nullable();
            $table->string('programa', 255)->nullable();
            $table->char('estado', 2)->default('AC');
            $table->date('fecha_nacimiento')->nullable();
            $table->char('sexo', 1)->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('redes_sociales')->nullable();
            $table->string('email', 255)->unique();

        });

        DB::statement("ALTER TABLE usuario ADD CONSTRAINT chk_estado CHECK (estado IN ('AC', 'IN'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
