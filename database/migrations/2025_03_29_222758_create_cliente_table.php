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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->string('nombre', 100); // VARCHAR(100) NOT NULL
            $table->string('apellido', 100); // VARCHAR(100) NOT NULL
            $table->string('identificacion', 50)->unique(); // VARCHAR(50) UNIQUE NOT NULL
            $table->char('estado', 2)->default('AC'); // CHAR(2) NOT NULL DEFAULT 'A'
            $table->date('fecha_nacimiento')->nullable(); // DATE
            $table->string('sexo', 10)->nullable(); // VARCHAR(10)
            $table->text('direccion')->nullable(); // TEXT
            $table->string('telefono', 20)->nullable(); // VARCHAR(20)
            $table->string('email', 255)->unique(); // VARCHAR(255) UNIQUE NOT NULL
        });

        // Agregar restricción CHECK para el campo estado en cliente
        DB::statement("ALTER TABLE cliente ADD CONSTRAINT chk_estado CHECK (estado IN ('AC', 'IN'))");
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
