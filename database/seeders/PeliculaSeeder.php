<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;

class PeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime("now", new DateTimeZone('Europe/Madrid'))->format('Y-m-d H:i:s'); 

        DB::table('peliculas')->insert([
            [
                'titulo' => 'Titanic',
                'generos' => 'Romance, Aventura',
                'director' => 'James Cameron',
                'actores' => 'Kate Winslet, Leonardo DiCaprio',
                'url_portada' => 'https://pics.filmaffinity.com/titanic-321994924-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/1EMkCJWQIDY',
                'fecha_estreno' => '1998-01-08',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'El sexto sentido',
                'generos' => 'Terror, Misterio',
                'director' => 'M. Night Shyamalan',
                'actores' => 'Bruce Willis',
                'url_portada' => 'https://pics.filmaffinity.com/the_sixth_sense-516003703-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/zfOdk9JDzSw',
                'fecha_estreno' => '2000-01-14',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'Gran Torino',
                'generos' => 'Drama, Acción',
                'director' => 'Clint Eastwood',
                'actores' => 'Clint Eastwood',
                'url_portada' => 'https://m.media-amazon.com/images/M/MV5BYzZmMGFhMzQtNjAzMy00NWE5LWE5YTQtYTU1Y2NhMzc2MTEwXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/RMhbr2XQblk',
                'fecha_estreno' => '2009-03-06',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'Ágora',
                'generos' => 'Aventura, Acción',
                'director' => 'Alejandro Amenábar',
                'actores' => 'Rachel Weisz',
                'url_portada' => 'https://pics.filmaffinity.com/agora-344690742-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/XVSTwtmYXIw',
                'fecha_estreno' => '2009-10-09',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'Misión imposible: protocolo fantasma',
                'generos' => 'Acción, Suspense',
                'director' => 'Brad Bird',
                'actores' => 'Tom Cruise, Paula Patton',
                'url_portada' => 'https://pics.filmaffinity.com/mission_impossible_ghost_protocol-284514904-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/9MMPQ88NDWY',
                'fecha_estreno' => '2011-12-16',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'Alien: Covenant',
                'generos' => 'Ciencia ficción, Terror',
                'director' => 'Ridley Scott',
                'actores' => 'Michael Fassbender, Noomi Rapace',
                'url_portada' => 'https://pics.filmaffinity.com/alien_covenant-271063602-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/zM_8SvQXBso',
                'fecha_estreno' => '2017-05-12',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ],[
                'titulo' => 'Star Wars: Episodio IX - El ascenso de Skywalker',
                'generos' => 'Ciencia ficción, Acción',
                'director' => 'J. J. Abrams',
                'actores' => 'Carrie Fisher, Daisy Ridley',
                'url_portada' => 'https://pics.filmaffinity.com/star_wars_the_rise_of_skywalker-619389738-large.jpg',
                'url_trailer' => 'https://www.youtube.com/embed/Izme__ZsURY',
                'fecha_estreno' => '2019-12-20',
                'estrenada' => 1,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);

        DB::table('peliculas')->insert([
            [
                'titulo' => 'Transformers 12',
                'generos' => 'Acción, Ciencia ficción',
                'url_trailer' => 'https://www.youtube.com/embed/zSWdZVtXT7E',
                'fecha_estreno' => '2025-08-20',
                'estrenada' => 0,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);

        DB::table('peliculas')->insert([
            [
                'titulo' => 'Fast & Furious 18',
                'generos' => 'Acción, Suspense',
                'actores' => 'Vin Diesel',
                'url_trailer' => 'https://www.youtube.com/embed/zSWdZVtXT7E',
                'fecha_estreno' => '2032-01-01',
                'estrenada' => 0,
                'created_at' => $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
