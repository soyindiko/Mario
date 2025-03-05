import { Component } from '@angular/core';
import { RouterModule, RouterLink, RouterLinkActive, Router, ActivatedRoute, NavigationEnd } from '@angular/router';
import { CarritoCompraService } from '../../../services/carrito-compra/carrito-compra.service';
import { InicioSesionService } from '../../../services/inicio-sesion/inicio-sesion.service';

@Component({
  selector: 'app-nav-bar',
  standalone: false,
  templateUrl: './nav-bar.component.html',
  styleUrl: './nav-bar.component.css'
})
export class NavBarComponent {

  carrito: any[] = [];
  mostrarCarrito = false;

  isLoggedIn: boolean = false;
  usuarioActual: any;

  areaPrivadaSeleccionada: boolean=false;
  rutaActual: string = '';


  constructor(private carritoService: CarritoCompraService, private router: Router, private inicioSesionService: InicioSesionService) {}

  ngOnInit() {
    this.carritoService.carrito$.subscribe(data => {
      this.carrito = data;
    });

    this.checkLoginStatus();

    this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd) {
        this.rutaActual = event.url;
        if (this.rutaActual.includes('admin')) {
          this.areaPrivadaSeleccionada=true;
        }
      }
    });
  }

  checkLoginStatus() {

    this.inicioSesionService.usuarioActual$.subscribe(data => {
      if (data.length != 0) {
        this.usuarioActual = data;
        this.isLoggedIn = true;
      }
    });
  }

  toggleCarrito() {
    this.mostrarCarrito = !this.mostrarCarrito;
  }

  eliminarEntrada(index: number) {
    this.carrito.splice(index, 1);
    localStorage.setItem('carritoCompra', JSON.stringify(this.carrito));
  }

  continuarPedido() {
    this.mostrarCarrito = false;
    this.router.navigate(['/detalles-pedido']);
  }

  logout() {
    this.inicioSesionService.logout();  
    this.isLoggedIn = false; 
    this.usuarioActual = null;
    this.areaPrivadaSeleccionada = false;
  }

  onClickAreaPrivada() {
    this.areaPrivadaSeleccionada=true;
    this.router.navigate(['/inicio-admin'])
  }
}
