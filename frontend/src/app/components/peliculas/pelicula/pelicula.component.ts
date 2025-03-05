import { Component, Input } from '@angular/core';
import { Pelicula } from '../../../models/pelicula';
import { NgFor } from '@angular/common';
import { Router } from '@angular/router';
import { PeliculaTempService } from '../../../services/almacenamiento-temporal/pelicula-temp.service';

@Component({
  selector: 'app-pelicula',
  standalone: false,
  
  templateUrl: './pelicula.component.html',
  styleUrl: './pelicula.component.css'
})
export class PeliculaComponent {
  @Input() pelicula!: Pelicula;

  constructor(private peliculaTempService: PeliculaTempService, private router: Router) {}


  verDetalles(pelicula: any) {
    this.peliculaTempService.setPelicula(pelicula); // Guardamos la película
    this.router.navigate(['/detalles-pelicula', pelicula.id]); // Navegamos al detalle
  }

}
