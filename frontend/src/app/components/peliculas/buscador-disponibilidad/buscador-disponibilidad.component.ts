import { Component, Input } from '@angular/core';
import { CinesService } from '../../../services/cines/cines.service';
import { Cine } from '../../../models/cine';
import { SesionesService } from '../../../services/sesiones/sesiones.service';
import { CarritoCompraService } from '../../../services/carrito-compra/carrito-compra.service';
import { Pelicula } from '../../../models/pelicula';

@Component({
  selector: 'app-buscador-disponibilidad',
  standalone: false,
  
  templateUrl: './buscador-disponibilidad.component.html',
  styleUrl: './buscador-disponibilidad.component.css'
})
export class BuscadorDisponibilidadComponent {
  
  @Input() pelicula!: Pelicula;

  provincias: string[] = ['Madrid'];

  cines!: Cine[];
  cinesFiltrados!: Cine[];
  sesiones: any = {};
  sesionSeleccionada: any | null = null;
  cantidadEntradas: number = 0;

  filtroProvincia: string = '';
  filtroCine: string = '';
  fechaSeleccionada: string = '';

  constructor(private cineService: CinesService, private sesionPeliculaService: SesionesService, private carritoService: CarritoCompraService) {}

  ngOnInit() {
    this.obtenerCines();

    this.setFechaActual()
  }

  obtenerCines() {
    this.cineService.getCines().subscribe((data: any[]) => {
      this.cines = data;
      this.cinesFiltrados = data;
    });
  }

  setFechaActual() {
    const hoy = new Date();
    this.fechaSeleccionada = hoy.toISOString().split('T')[0];
  }

  onFiltrarProvincia(event: any) {
    if (this.filtroProvincia) {
      this.cinesFiltrados = this.cines.filter(cine =>
        cine.direccion.includes(this.filtroProvincia)
      );
    } else {
      this.cinesFiltrados = [...this.cines];
    }
  }

  formularioValido(): boolean {
    return this.filtroProvincia !== '' && this.filtroCine !== '' && this.fechaSeleccionada !== '';
  }

  buscarSesiones() {
    if (this.formularioValido()) {
      this.sesionPeliculaService.obtenerSesiones(this.filtroCine, this.pelicula.id.toString(), this.fechaSeleccionada)
        .subscribe((horarios) => {
          this.sesiones = horarios;
        });
    }
  }

  seleccionarSesion(sesion: any) {
    this.sesionSeleccionada = sesion;
    this.cantidadEntradas = 0;
  }

  cambiarCantidad(valor: number) {
    if (this.cantidadEntradas + valor >= 0) {
      this.cantidadEntradas += valor;
    }
  }

  agregarAlCarrito() {
    if (!this.sesionSeleccionada || this.cantidadEntradas <= 0) {
      alert('Selecciona un horario y una cantidad válida.');
      return;
    }

    const entrada = {
      pelicula_id: this.pelicula.id,
      nombre: this.pelicula.titulo,
      cine_id: this.filtroCine,
      horario: this.sesionSeleccionada.hora,
      cantidad: this.cantidadEntradas,
      precio: this.sesionSeleccionada.precio * this.cantidadEntradas,
      id_sesion: this.sesionSeleccionada.id_sesion,
      tipo: "entrada",
    };

    this.carritoService.agregarAlCarrito(entrada);
  }
}
