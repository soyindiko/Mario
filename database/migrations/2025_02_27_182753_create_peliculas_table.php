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
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', length: 200);
            $table->string('generos', length: 200)->nullable();
            $table->string('director', length: 100)->nullable();
            $table->string('actores', length: 500)->nullable();
            $table->string('sinopsis', length: 10000)->nullable();
            $table->string('url_portada', length: 500)->nullable();
            $table->string('url_trailer', length: 500)->nullable();
            $table->date('fecha_estreno')->nullable();
            $table->boolean('estrenada');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};
