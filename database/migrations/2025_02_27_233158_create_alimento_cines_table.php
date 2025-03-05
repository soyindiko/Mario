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
        Schema::create('alimentos_cines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alimento');
                $table->foreign('id_alimento')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_cine');
                $table->foreign('id_cine')->references('id')->on('cines')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('unidades');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos_cines');
    }
};
