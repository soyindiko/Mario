<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class SesionVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('sesiones_ventas')->insert([
            [
                'id_sesion' => 5,
                'id_venta' => 1,
                'num_entradas' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_sesion' => 6,
                'id_venta' => 2,
                'num_entradas' => 4,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_sesion' => 12,
                'id_venta' => 3,
                'num_entradas' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'id_sesion' => 14,
                'id_venta' => 4,
                'num_entradas' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
