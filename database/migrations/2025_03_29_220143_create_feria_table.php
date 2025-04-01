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
        Schema::create('feria', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 255); 
            $table->text('descripcion')->nullable(); 
            $table->timestamp('fecha_inicio')->nullable(false); 
            $table->timestamp('fecha_fin')->nullable(false); 
            $table->string('modalidad', 20);
            $table->string('localidad', 255)->nullable(); 
            $table->string('estado', 20); 
        });

        // Agregar restricciones CHECK en modalidad y estado
        DB::statement("ALTER TABLE feria ADD CONSTRAINT chk_modalidad CHECK (modalidad IN ('virtual', 'presencial'));");
        DB::statement("ALTER TABLE feria ADD CONSTRAINT chk_estado CHECK (estado IN ('próxima', 'en curso', 'finalizada'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feria');
    }
};
