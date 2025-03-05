import { Component, EventEmitter, Input, Output } from '@angular/core';
import { Pelicula } from '../../../models/pelicula';
import { OpinionesPeliculasService } from '../../../services/opiniones-peliculas/opiniones-peliculas.service';
import { Opinion } from '../../../models/opinion';
import { InicioSesionService } from '../../../services/inicio-sesion/inicio-sesion.service';

@Component({
  selector: 'app-resenas',
  standalone: false,
  
  templateUrl: './resenas.component.html',
  styleUrl: './resenas.component.css'
})
export class ResenasComponent {
  @Input() pelicula!: Pelicula;
  @Output() puntuacionPelicula = new EventEmitter<number>();

  puntuacion: number = 0;

  resenas!: Opinion[];

  nuevaResena: string = '';
  puntuacionSeleccionada: number = 0;

  mostrarInputResena: boolean = false;

  public paginaActual: number = 1;

  usuario: any;

  constructor(private opinionPeliculaService: OpinionesPeliculasService,  private authService:InicioSesionService) {}
  
    ngOnInit() {
    
    
    this.opinionPeliculaService.getOpiniones(this.pelicula.id).subscribe((data: any[]) => {
      this.resenas = data;

      if (data.length > 0) {
        // Calcular la media de la puntuación
        const totalPuntuacion = data.reduce((acc, opinion) => acc + opinion.puntuacion, 0);
        this.puntuacion = parseFloat((totalPuntuacion / data.length).toFixed(2));

        this.puntuacionPelicula.emit(this.puntuacion);
      } else {
        this.puntuacionPelicula.emit(0);
      }
    });

    this.usuario = this.authService.getUsuarioActual()
  }

  // Alternar input para escribir reseña
  toggleEscribirResena() {

    if (!this.authService.isLoggedIn()) {
      alert("Debes iniciar sesión para escribir una reseña.");
    } else {
      this.mostrarInputResena = !this.mostrarInputResena;
    }
  }

  seleccionarPuntuacion(puntuacion: number) {
    this.puntuacionSeleccionada = puntuacion;
  }

  // Enviar reseña
  enviarResena() {
    if (this.nuevaResena.trim() !== '' && this.puntuacionSeleccionada > 0) {
      const nuevaResenaObj = {
        puntuacion: this.puntuacionSeleccionada,
        texto: this.nuevaResena,
        id_cliente: this.usuario.id,
        id_pelicula: this.pelicula.id
      };

      // Llamar al servicio para guardar la reseña
      this.opinionPeliculaService.putOpinion(nuevaResenaObj).subscribe(
        (respuesta) => {
          console.log('Reseña guardada:', respuesta);
          this.resenas.unshift(nuevaResenaObj); // Agregar la reseña localmente para actualizar la UI
          this.nuevaResena = '';
          this.puntuacionSeleccionada = 0;
          this.mostrarInputResena = false;
        },
        (error) => {
          console.error('Error al guardar la reseña', error);
        }
      );
    }
  }

  cambiarPagina(event: any) {
    this.paginaActual = event;
  }

}
