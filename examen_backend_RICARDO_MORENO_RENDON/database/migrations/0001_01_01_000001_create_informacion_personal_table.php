<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informacion_personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Foreign key
            $table->string('Direccion');
            $table->string('Telefono');
            $table->date('FechaNacimiento');
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_personal');
    }
};
