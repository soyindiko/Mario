<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('administradores')->insert([
            [
                'puede_ver_ventas' => 1,
                'puede_agregar_alimentos' => 1,
                'id_usuario' => 5,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'puede_ver_ventas' => 1,
                'puede_agregar_alimentos' => 1,
                'id_usuario' => 6,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
