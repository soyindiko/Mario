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
        Schema::create('opiniones', function (Blueprint $table) {
            $table->id();
            $table->integer('puntuacion');
            $table->string('texto', length: 1000)->nullable();
            $table->unsignedBigInteger('id_cliente');
                $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_pelicula');
                $table->foreign('id_pelicula')->references('id')->on('peliculas')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opiniones');
    }
};
