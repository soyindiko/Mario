export class Producto {
    public id_cine: number;
    public unidades: number;
    public id_alimento: number;
    public nombre: string;
    public precio: number;
    public url_imagen: string;

    constructor(id_cine: number, unidades: number, id_alimento: number, nombre: string, precio: number, url_imagen: string) {
        this.id_cine = id_cine;
        this.unidades = unidades;
        this.id_alimento = id_alimento;
        this.nombre = nombre;
        this.precio = precio;
        this.url_imagen = url_imagen;
    }
}
