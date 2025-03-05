<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class AlimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('alimentos')->insert([
            [
                'nombre' => 'Comida Palomitas saladas',
                'precio' => 6.2,
                'url_imagen' => 'https://carnisima.com/cdn/shop/files/palomitassaladamicroondasecocarnisima3_1024x1024.jpg?v=1686233763',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Comida Palomitas dulces',
                'precio' => 6.5,
                'url_imagen' => 'https://i.pinimg.com/736x/29/51/5c/29515c2f2a9cc4f71c976ee8599b5b3c.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Comida Bolsa de patatas (sabor jamón)',
                'precio' => 4.9,
                'url_imagen' => 'https://m.media-amazon.com/images/I/71WRUmbCjPL._AC_UF894,1000_QL80_.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Bebida Coca-cola mediana',
                'precio' => 3.0,
                'url_imagen' => 'https://tucervezaadomicilio.com/wp-content/uploads/2020/07/lata-coca-cola.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Bebida Coca-cola grande',
                'precio' => 4.5,
                'url_imagen' => 'https://distribucionesplata.com/tienda/19327-thickbox_default/coca-cola-2-l.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Bebida Nestea mediano',
                'precio' => 3.0,
                'url_imagen' => 'https://tienda.officemat.es/1442377-large_default/pack-24-latas-nestea-limon-33cl.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'nombre' => 'Bebida Nestea grande',
                'precio' => 4.5,
                'url_imagen' => 'https://coalimentlasecuita.com/947/nestea-limon-15l.jpg',
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
