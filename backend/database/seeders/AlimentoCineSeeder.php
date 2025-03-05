<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class AlimentoCineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('alimentos_cines')->insert([
            [
                'id_alimento' => 1,
                'id_cine' => 1,
                'unidades' => 144,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 4,
                'id_cine' => 1,
                'unidades' => 56,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 1,
                'id_cine' => 2,
                'unidades' => 120,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 2,
                'id_cine' => 2,
                'unidades' => 131,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 4,
                'id_cine' => 2,
                'unidades' => 67,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 5,
                'id_cine' => 2,
                'unidades' => 50,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 6,
                'id_cine' => 2,
                'unidades' => 30,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 1,
                'id_cine' => 3,
                'unidades' => 110,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 4,
                'id_cine' => 3,
                'unidades' => 21,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 5,
                'id_cine' => 3,
                'unidades' => 23,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
