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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo', length: 15);
            $table->float('precio');
            $table->integer('aforo_restante');
            $table->unsignedBigInteger('id_sala');
                $table->foreign('id_sala')->references('id')->on('salas')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('id_pelicula');
                $table->foreign('id_pelicula')->references('id')->on('peliculas')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
