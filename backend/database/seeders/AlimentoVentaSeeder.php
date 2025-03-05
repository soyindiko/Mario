<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class AlimentoVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('alimentos_ventas')->insert([
            [
                'id_alimento' => 2,
                'id_venta' => 1,
                'unidades' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 4,
                'id_venta' => 1,
                'unidades' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 1,
                'id_venta' => 2,
                'unidades' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 2,
                'id_venta' => 2,
                'unidades' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 5,
                'id_venta' => 2,
                'unidades' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 6,
                'id_venta' => 2,
                'unidades' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 1,
                'id_venta' => 3,
                'unidades' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 5,
                'id_venta' => 3,
                'unidades' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 2,
                'id_venta' => 4,
                'unidades' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_alimento' => 4,
                'id_venta' => 4,
                'unidades' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
