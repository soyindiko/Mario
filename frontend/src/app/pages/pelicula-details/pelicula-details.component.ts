import { Component } from '@angular/core';
import { PeliculaTempService } from '../../services/almacenamiento-temporal/pelicula-temp.service';
import { Router } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { TrailerModalComponent } from '../../components/peliculas/trailer-modal/trailer-modal.component';
import { Pelicula } from '../../models/pelicula';

@Component({
  selector: 'app-pelicula-details',
  standalone: false,
  
  templateUrl: './pelicula-details.component.html',
  styleUrl: './pelicula-details.component.css'
})
export class PeliculaDetailsComponent {
  
  pelicula!: Pelicula;
  puntuacion: number = 0;
 
  constructor(private peliculaService: PeliculaTempService, private router: Router, private dialog: MatDialog) {}

  ngOnInit() {
    this.pelicula = this.peliculaService.getPelicula();
    
    if (!this.pelicula) {
      // Si no hay película, redirigir a la lista
      this.router.navigate(['/peliculas']);
    }

  }

  verTrailer() {
    this.dialog.open(TrailerModalComponent, {
      width: '600px',
      data: { videoUrl: this.pelicula.url_trailer }
    });
  }

  actualizarPuntuacion(nuevaPuntuacion: number) {
    this.puntuacion = nuevaPuntuacion;
  }
}
