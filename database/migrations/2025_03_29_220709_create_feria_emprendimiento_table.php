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
        Schema::create('feria_emprendimiento', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->unsignedBigInteger('id_feria'); // INT NOT NULL
            $table->unsignedBigInteger('id_emprendimiento'); // INT NOT NULL
            
            // Claves foráneas
            $table->foreign('id_feria')->references('id')->on('feria');
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimiento');

            // Restricción de unicidad
            $table->unique(['id_feria', 'id_emprendimiento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feria_emprendimiento');
    }
};
