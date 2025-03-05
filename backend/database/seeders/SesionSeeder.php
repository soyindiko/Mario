<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class SesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('sesiones')->insert([
            [
                'fecha' => '2024-11-09',
                'hora' => '17:00:00',
                'tipo' => 'ordinaria',
                'precio' => 10.5,
                'aforo_restante' => 140,
                'id_sala' => 1,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-09',
                'hora' => '17:00:00',
                'tipo' => 'VOSE',
                'precio' => 9.5,
                'aforo_restante' => 295,
                'id_sala' => 6,
                'id_pelicula' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-09',
                'hora' => '20:00:00',
                'tipo' => 'VOSE',
                'precio' => 9.5,
                'aforo_restante' => 295,
                'id_sala' => 6,
                'id_pelicula' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-23',
                'hora' => '17:00:00',
                'tipo' => 'ordinaria',
                'precio' => 10.5,
                'aforo_restante' => 140,
                'id_sala' => 1,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-23',
                'hora' => '17:30:00',
                'tipo' => 'ordinaria',
                'precio' => 10.5,
                'aforo_restante' => 320,
                'id_sala' => 3,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-23',
                'hora' => '17:40:00',
                'tipo' => 'ordinaria',
                'precio' => 10.5,
                'aforo_restante' => 200,
                'id_sala' => 4,
                'id_pelicula' => 7,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-11-23',
                'hora' => '20:30:00',
                'tipo' => 'ordinaria',
                'precio' => 10.5,
                'aforo_restante' => 210,
                'id_sala' => 5,
                'id_pelicula' => 7,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-12-21',
                'hora' => '17:00:00',
                'tipo' => 'VOSE',
                'precio' => 12.5,
                'aforo_restante' => 295,
                'id_sala' => 6,
                'id_pelicula' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2024-12-21',
                'hora' => '21:00:00',
                'tipo' => 'VOSE',
                'precio' => 12.5,
                'aforo_restante' => 295,
                'id_sala' => 6,
                'id_pelicula' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '17:00:00',
                'tipo' => 'ordinaria',
                'precio' => 9.5,
                'aforo_restante' => 320,
                'id_sala' => 3,
                'id_pelicula' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '21:00:00',
                'tipo' => 'VOSE',
                'precio' => 8.5,
                'aforo_restante' => 320,
                'id_sala' => 3,
                'id_pelicula' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '20:30:00',
                'tipo' => 'ordinaria',
                'precio' => 9.5,
                'aforo_restante' => 200,
                'id_sala' => 4,
                'id_pelicula' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '18:15:00',
                'tipo' => 'VOSE',
                'precio' => 8.5,
                'aforo_restante' => 200,
                'id_sala' => 4,
                'id_pelicula' => 4,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '17:45:00',
                'tipo' => 'ordinaria',
                'precio' => 9.5,
                'aforo_restante' => 210,
                'id_sala' => 5,
                'id_pelicula' => 5,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '21:30:00',
                'tipo' => 'VOSE',
                'precio' => 8.5,
                'aforo_restante' => 210,
                'id_sala' => 5,
                'id_pelicula' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'fecha' => '2025-03-02',
                'hora' => '19:15:00',
                'tipo' => 'ordinaria',
                'precio' => 9.5,
                'aforo_restante' => 210,
                'id_sala' => 5,
                'id_pelicula' => 7,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
