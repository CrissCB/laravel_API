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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->string('titulo', 255); // VARCHAR(255) NOT NULL
            $table->text('descripcion')->nullable(); // TEXT (puede ser NULL)
            $table->string('imagen_url', 255)->nullable(); // VARCHAR(255) (puede ser NULL)
            $table->unsignedBigInteger('id_emprendimiento')->nullable(); // INT (puede ser NULL)
            $table->unsignedBigInteger('id_feria')->nullable(); // INT (puede ser NULL)
            $table->timestamp('fecha_publicacion')->useCurrent(); // TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            $table->char('estado', 2)->default('AC'); // CHAR(2) NOT NULL DEFAULT 'AC'

            // Claves foráneas
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimiento');
            $table->foreign('id_feria')->references('id')->on('feria');
        });

        // Agregar restricción CHECK para el campo estado
        DB::statement("ALTER TABLE publicaciones ADD CONSTRAINT chk_estado CHECK (estado IN ('AC', 'IN'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
