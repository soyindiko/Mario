import { Component } from '@angular/core';
import { CarritoCompraService } from '../../services/carrito-compra/carrito-compra.service';
import { ProductosService } from '../../services/productos/productos.service';
import { Producto } from '../../models/producto';
import { Router } from '@angular/router';
import { InicioSesionService } from '../../services/inicio-sesion/inicio-sesion.service';
import { VentasService } from '../../services/ventas/ventas.service';

@Component({
  selector: 'app-detalles-pedido',
  standalone: false,
  
  templateUrl: './detalles-pedido.component.html',
  styleUrl: './detalles-pedido.component.css'
})
export class DetallesPedidoComponent {
  bebidas!: Producto[];
  palomitas!: Producto[];
  carrito: any[] = [];

  id_cine: string = '';

  idUsuarioActual: any;


  constructor(private carritoCompraService: CarritoCompraService, private productosService: ProductosService, private router: Router, private inicioSesionService: InicioSesionService, private ventasService: VentasService) {
    this.carritoCompraService.carrito$.subscribe(data => {
      this.carrito = data;
      this.id_cine = data[0].cine_id;
    });
  }

  ngOnInit() {
    this.productosService.getProductos(Number(this.id_cine)).subscribe({
      next: (data) => { 
        this.bebidas = data.filter(p => p.nombre.includes('Bebida'));

        this.palomitas = data.filter(producto => producto.nombre.includes('Comida')); 
      },
      error: (error) => { console.error('Error:', error); },
      complete: () => { console.log('Finalizado'); }
    });    

    this.inicioSesionService.usuarioActual$.subscribe(data => {
      let usuarioActual:any = data;
      this.idUsuarioActual = usuarioActual.id;
    });
  }

  get total() {
    return this.carrito.reduce((acc, item) => acc + item.precio, 0);
  }

  agregarAlPedido(producto: any) {
    const prod = {
      id_alimento: producto.id_alimento,
      nombre: producto.nombre,
      cantidad: 1,
      precio: producto.precio,
      tipo: "comida",
    };
    this.carritoCompraService.agregarAlCarrito(producto)
  }

  pagarPedido() {
    const usuarioActual = this.inicioSesionService.getUsuarioActual();
    const id_cliente = usuarioActual.id;
    //id_usuario: this.idUsuarioActual;

    const venta = {
      importe: this.total,
      fecha: new Date().toISOString().split('T')[0],
      hora: new Date().toLocaleTimeString(),
      id_cliente: id_cliente
    };


    this.ventasService.registrarVenta(venta).subscribe({
      next: (ventaResponse) => {

        // Agrupar los productos por nombre
        const productosAgrupados: any = {};

        // Agrupar los productos en base al nombre
        this.carrito.forEach((item) => {
          if (productosAgrupados[item.nombre] && item.tipo!="entrada") {
            productosAgrupados[item.nombre].unidades += 1;
            console.log(productosAgrupados)
          } else if (item.tipo!="entrada") {
            productosAgrupados[item.nombre] = { 
              id_alimento: item.id_alimento,
              unidades: 1
            };
          }
        });

        // Enviar los productos agrupados
        Object.keys(productosAgrupados).forEach((nombre) => {
          const ventaAlimento = {
            id_venta: ventaResponse.id,
            id_alimento: productosAgrupados[nombre].id_alimento,
            unidades: productosAgrupados[nombre].unidades
          };
          
          // Registrar cada venta de alimento con su cantidad total
          this.ventasService.registrarVentasAlimento(ventaAlimento).subscribe({
            next: (response) => {
              console.log('Producto registrado en ventas_alimentos', response);
            },
            error: (error) => {
              console.error('Error al registrar venta de alimento', error);
            }
          });
        });
          
        // Filtrar los productos cuyo tipo es "entradas" para registrarlos en ventas_sesiones
        const entrada = this.carrito.filter(item => item.tipo === "entrada")[0];
        console.log(entrada)

        const ventaSesion = {
          id_venta: ventaResponse.id,
          id_sesion: entrada.id_sesion,
          num_entradas: entrada.cantidad
        };

        this.ventasService.registrarVentasSesion(ventaSesion).subscribe({
          next: (response) => {
            console.log('Entrada registrada en ventas_sesiones', response);
            this.carritoCompraService.limpiarCarrito();
            this.router.navigate(['/']);
          },
          error: (error) => {
            console.error('Error al registrar venta de sesión', error);
          }
        });
        
      }
    });
  }
}


