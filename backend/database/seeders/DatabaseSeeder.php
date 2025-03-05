<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CineSeeder::class,
            SalaSeeder::class,
            PeliculaSeeder::class,
            CinePeliculaSeeder::class,
            SesionSeeder::class,
            AlimentoSeeder::class,
            AlimentoCineSeeder::class,
            UsuarioSeeder::class,
            AdministradorSeeder::class,
            ClienteSeeder::class,
            OpinionSeeder::class,
            VentaSeeder::class,
            SesionVentaSeeder::class,
            AlimentoVentaSeeder::class
        ]);
    }
}
