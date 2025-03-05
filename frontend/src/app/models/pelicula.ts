
export class Pelicula {
    public id: number;
    public titulo: string;
    public generos: string;
    public director: string;
    public actores: string;
    public sinopsis: string;
    public url_portada: string;
    public url_trailer: string;
    public fecha_estreno: Date;
    public estrenada: number;

    constructor(id: number, titulo: string, generos: string, director: string, actores: string, sinopsis: string, url_portada: string, url_trailer: string, fecha_estreno: Date, estrenada: number){
        this.id = id;
        this.titulo = titulo;
        this.generos = generos;
        this.director = director;
        this.actores = actores;
        this.sinopsis = sinopsis;
        this.url_portada = url_portada;
        this.url_trailer = url_trailer;
        this.fecha_estreno = fecha_estreno;
        this.estrenada = estrenada;
    }

}