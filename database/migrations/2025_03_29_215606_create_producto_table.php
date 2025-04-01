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
        Schema::create('producto', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_emprendimiento'); 
            $table->string('nombre', 255); 
            $table->text('detalle')->nullable(); 
            $table->decimal('precio', 10, 2)->nullable(); 
            $table->integer('stock')->default(0); // 
            $table->date('fecha_elaboracion')->nullable(); 
            $table->date('fecha_vencimiento')->nullable(); 
            $table->string('talla', 50)->nullable(); 
            $table->string('codigo_qr', 50)->unique()->nullable(); 
            $table->string('estado', 20)->default('disponible'); 
            $table->unsignedBigInteger('id_cat');

            $table->foreign('id_cat')->references('id_cat')->on('categoria_producto');
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimiento');
        });

        DB::statement("ALTER TABLE producto ADD CONSTRAINT chk_estado CHECK (estado IN ('disponible', 'agotado', 'descontinuado'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
