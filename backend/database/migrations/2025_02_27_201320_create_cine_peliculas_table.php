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
        Schema::create('cines_peliculas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cine');
                $table->foreign('id_cine')->references('id')->on('cines')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cines_peliculas');
    }
};
