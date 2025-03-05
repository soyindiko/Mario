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
        Schema::create('alimentos_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alimento')->default(0);
                $table->foreign('id_alimento')->references('id')->on('alimentos')->onDelete('set default')->onUpdate('cascade');
            $table->unsignedBigInteger('id_venta');
                $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimentos_ventas');
    }
};
