export class Venta {    
    id: number;
    importe: number;
    fecha: string;
    hora: string;
    id_cliente: number;

    constructor(id: number, importe: number, fecha: string, hora: string, id_cliente: number) {
        this.id = id;
        this.importe=importe;
        this.fecha =fecha;
        this.hora=hora;
        this.id_cliente=id_cliente;
    }
}