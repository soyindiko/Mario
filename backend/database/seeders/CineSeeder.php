<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class CineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('cines')->insert([
            [
                'nombre' => 'Las Rosas',
                'direccion' => 'Avenida de Guadalajara 17, San Blas-Canillejas, Madrid',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Méndez Álvaro',
                'direccion' => 'Calle Acanto 9, Arganzuela, Madrid',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Retiro',
                'direccion' => 'Calle de Narváez 25, Retiro, Madrid',
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
