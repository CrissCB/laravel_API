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
        Schema::create('interaccion', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->unsignedBigInteger('id_cliente'); 
            $table->unsignedBigInteger('id_publicacion'); 
            $table->timestamp('fecha_interaccion')->useCurrent(); 
            $table->text('comentarios')->nullable(); 
            $table->integer('calificacion'); 

            // Claves foráneas
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->foreign('id_publicacion')->references('id')->on('publicaciones');
        });

        // Agregar restricción CHECK para calificación
        DB::statement("ALTER TABLE interaccion ADD CONSTRAINT chk_calificacion CHECK (calificacion >= 0 AND calificacion <= 5)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaccion');
    }
};
