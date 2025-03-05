import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/internal/BehaviorSubject';

@Injectable({
  providedIn: 'root'
})
export class CarritoCompraService {

  private readonly carritoKey = 'carritoCompra';

  private carrito: any[] = JSON.parse(localStorage.getItem(this.carritoKey) || '[]');
  private carritoSubject = new BehaviorSubject<any[]>(this.carrito);

  carrito$ = this.carritoSubject.asObservable(); // Observable para escuchar cambios

  agregarAlCarrito(item: any) {
    this.carrito.push(item);
    this.actualizarLocalStorage();
  }

  eliminarDelCarrito(index: number) {
    this.carrito.splice(index, 1);
    this.actualizarLocalStorage();
  }

  private actualizarLocalStorage() {
    localStorage.setItem(this.carritoKey, JSON.stringify(this.carrito));
    this.carritoSubject.next(this.carrito); // Notificar a los suscriptores
  }

  limpiarCarrito() {
    this.carrito = []
    localStorage.removeItem(this.carritoKey);
    this.carritoSubject.next(this.carrito);
  }
}
