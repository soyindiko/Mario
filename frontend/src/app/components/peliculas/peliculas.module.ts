import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PeliculaComponent } from './pelicula/pelicula.component';
import { RouterModule, RouterLink } from '@angular/router';
import { TrailerModalComponent } from './trailer-modal/trailer-modal.component';
import { SafeUrlPipe } from '../../pipes/safe-url.pipe';
import { ResenasComponent } from './resenas/resenas.component';
import { BuscadorDisponibilidadComponent } from './buscador-disponibilidad/buscador-disponibilidad.component';
import { NgxPaginationModule } from 'ngx-pagination';
import { FormsModule } from '@angular/forms';



@NgModule({
  declarations: [
    PeliculaComponent,
    TrailerModalComponent,
    ResenasComponent,
    BuscadorDisponibilidadComponent,
  ],
  imports: [
    CommonModule,
    RouterModule,
    RouterLink,
    SafeUrlPipe,
    NgxPaginationModule,
    FormsModule
  ],
  exports: [
    PeliculaComponent,
    ResenasComponent,
    BuscadorDisponibilidadComponent
  ]
})
export class PeliculasModule { }
