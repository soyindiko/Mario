<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class CinePeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('cines_peliculas')->insert([
            [
                'id_cine' => 1,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_cine' => 3,
                'id_pelicula' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_cine' => 2,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_cine' => 2,
                'id_pelicula' => 7,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_cine' => 3,
                'id_pelicula' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_cine' => 3,
                'id_pelicula' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
