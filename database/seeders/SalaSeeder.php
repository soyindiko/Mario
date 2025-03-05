<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('salas')->insert([
            [
                'nombre' => 'Sala 01',
                'aforo' => 140,
                'id_cine' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Sala 02',
                'aforo' => 160,
                'id_cine' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Sala 01',
                'aforo' => 320,
                'id_cine' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Sala 02',
                'aforo' => 200,
                'id_cine' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Sala 03',
                'aforo' => 210,
                'id_cine' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Sala 01',
                'aforo' => 295,
                'id_cine' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
