import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PeliculaTempService {

  private peliculaSource = new BehaviorSubject<any>(null); // Almacena la película
  peliculaActual = this.peliculaSource.asObservable(); // Observable para suscribirse

  constructor() {}

  setPelicula(pelicula: any) {
    this.peliculaSource.next(pelicula);
  }

  getPelicula() {
    return this.peliculaSource.value;
  }
}
