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
        Schema::create('emprendimiento', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->unsignedBigInteger('id_cat'); 
            $table->string('nombre', 255);
            $table->string('marca', 255)->nullable(); 
            $table->text('descripcion')->nullable(); 
            $table->char('estado', 2)->default('A'); 
            $table->unsignedBigInteger('id_usuario'); 
            $table->timestamp('fecha_inscripcion')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Claves foráneas sin cascada
            $table->foreign('id_cat')->references('id_cat')->on('categoria_emprendimiento');
            $table->foreign('id_usuario')->references('id')->on('usuario');
        });

        DB::statement("ALTER TABLE emprendimiento ADD CONSTRAINT chk_estado CHECK (estado IN ('A', 'IN'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento');
    }
};
