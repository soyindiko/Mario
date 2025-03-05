<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('usuarios')->insert([
            [
                'correo' => 'tomas.fernand@gmail.com',
                'contrasena' => 'g67iw3t4fhncf3olr29o8fdh!%kjrw67sdvhgcfe56',
                'rol' => 'cliente',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'correo' => 'dr.luis@gmail.com',
                'contrasena' => '8o3tq4gfngup8942nblg98p4fvwgre89uy24%&klnwr98',
                'rol' => 'cliente',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'correo' => 'ahorasontres@gmail.com',
                'contrasena' => 'iuh93q2gywhff92p7hg4803p62t08g2486t223g35h1',
                'rol' => 'cliente',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'correo' => 'comentosegundo@gmail.com',
                'contrasena' => 'awf2qhyo4gfnhbolwp02qhb4nvqg78g24fnbv29872fbu',
                'rol' => 'cliente',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'correo' => 'juan.torres@cines.es',
                'contrasena' => 'bvciuwqa98yh2fhibuhewf2798o24g0jmn2g4rv9724gh24',
                'rol' => 'administrador',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'correo' => 'ana.sanchez@cines.es',
                'contrasena' => 'hdaoliwg8972wnjfcv32po9jmvcf9812qhnf098fnq2wf09o',
                'rol' => 'administrador',
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
