<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('clientes')->insert([
            [
                'nombre' => 'Tomás',
                'apellidos' => 'Fernández Castillo',
                'id_usuario' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Luis',
                'apellidos' => 'Carrascosa García',
                'id_usuario' => 2,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Juan',
                'apellidos' => 'Gómez de la Vega',
                'id_usuario' => 3,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Daniel',
                'apellidos' => 'Requena Balsa',
                'id_usuario' => 4,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
