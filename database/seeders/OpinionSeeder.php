<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('opiniones')->insert([
            [
                'puntuacion' => 5,
                'id_cliente' => 1,
                'id_pelicula' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'puntuacion' => 4,
                'id_cliente' => 1,
                'id_pelicula' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'puntuacion' => 1,
                'id_cliente' => 2,
                'id_pelicula' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);

        DB::table('opiniones')->insert([
            [
                'puntuacion' => 3,
                'texto' => 'Buena fotografía, pero un poco lenta',
                'id_cliente' => 2,
                'id_pelicula' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'puntuacion' => 1,
                'texto' => 'Me he dormido...',
                'id_cliente' => 4,
                'id_pelicula' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'puntuacion' => 3,
                'texto' => 'Las primeras eran las mejores, yo ni pagaria por esta',
                'id_cliente' => 4,
                'id_pelicula' => 7,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
