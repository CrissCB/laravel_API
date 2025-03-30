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
        Schema::create('categoria_emprendimiento', function (Blueprint $table) {
            $table->id('id_cat');
            $table->char('estado', 2)->default('AC');
            $table->text('descripcion')->nullable();
            $table->string('nombre', 255);
        });

        DB::statement("ALTER TABLE categoria_emprendimiento ADD CONSTRAINT chk_estado CHECK (estado IN ('AC', 'IN'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_emprendimiento');
    }
};
