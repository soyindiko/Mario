export class Opinion {
    puntuacion:number;
    texto: string;
    id_cliente: number;
    id_pelicula: number;

    constructor(puntuacion:number, texto: string, id_cliente: number, id_pelicula: number) {
        this.puntuacion = puntuacion;
        this.texto = texto;
        this.id_cliente = id_cliente;
        this.id_pelicula = id_pelicula;
    }
}
  