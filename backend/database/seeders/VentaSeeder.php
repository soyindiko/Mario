<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('ventas')->insert([
            [
                'importe' => 40.0,
                'fecha' => '2025-02-28',
                'hora' => '11:37:02',
                'id_cliente' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'importe' => 83.6,
                'fecha' => '2025-02-28',
                'hora' => '23:51:11',
                'id_cliente' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'importe' => 60.6,
                'fecha' => '2025-03-01',
                'hora' => '10:27:32',
                'id_cliente' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'importe' => 19.0,
                'fecha' => '2025-02-27',
                'hora' => '18:26:10',
                'id_cliente' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
