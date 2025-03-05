import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Pelicula } from '../../models/pelicula';
import { PeliculaService } from '../../services/peliculas/pelicula.service';
import { CinesService } from '../../services/cines/cines.service';
import { CinePeliculaService } from '../../services/cines_peliculas/cine-peliculas.service';
import { Cine } from '../../models/cine';

@Component({
  selector: 'app-peliculas-page',
  standalone: false,
  templateUrl: './peliculas-page.component.html',
  styleUrls: ['./peliculas-page.component.css']
})
export class PeliculasPageComponent implements OnInit {

  peliculas!: Pelicula[];
  cines!: Cine[];
  cinesPeliculas: { id_cine: number; id_pelicula: number }[] = [];
  cinesFiltrados!: Cine[];

  peliculasFiltradas: any[] = [];
  filtro: string | null = null;

  filtroBusqueda: string = '';
  filtroEstado: number = -1;
  filtroCine: string = '';
  filtroProvincia: string = '';

  provincias: string[] = ['Madrid'];


  constructor(private route: ActivatedRoute, 
              private peliculaService: PeliculaService, 
              private cineService: CinesService, 
              private cinePeliculaService: CinePeliculaService) {}

  ngOnInit(): void {
    // Obtiene el parámetro opcional de la URL
    this.route.paramMap.subscribe(params => {
      this.filtro = params.get('filtro');
      if (this.filtro != null) {
        this.filtroEstado = Number(this.filtro);
      }
      // Cargar y filtrar películas según el parámetro recibido
      this.obtenerPeliculas();
    });
    this.obtenerCines();
    this.obtenerRelacionCinePeliculas();
  }

  obtenerPeliculas() {
    this.peliculaService.getPeliculas().subscribe(
      (peliculas) => {
        this.peliculas = peliculas;
        this.peliculasFiltradas = peliculas;
      },
      (error) => {
        console.error('Error al obtener películas:', error);
      }
    );
  }

  obtenerCines() {
    this.cineService.getCines().subscribe((data: any[]) => {
      this.cines = data;
      this.cinesFiltrados = data;
    });
  }

  obtenerRelacionCinePeliculas() {
    this.cinePeliculaService.getCinesPeliculas().subscribe(data => {
      this.cinesPeliculas = data;
      this.aplicarFiltros();
    });
  }

  // Método para filtrar cines por provincia
  onFiltrarProvincia(event: any) {
    this.filtroProvincia = event.target.value;
    if (this.filtroProvincia) {
      this.cinesFiltrados = this.cines.filter(cine =>
        cine.direccion.includes(this.filtroProvincia)
      );
    } else {
      this.cinesFiltrados = [...this.cines];
    }
    this.aplicarFiltros();
  }

  onBuscar(event: any) {
    this.filtroBusqueda = event.target.value.toLowerCase();
    this.aplicarFiltros();
  }

  onFiltrarEstado(event: any) {
    this.filtroEstado = event.target.value;
    this.aplicarFiltros();
  }

  onFiltrarCine(event: any) {
    this.filtroCine = event.target.value;
    this.aplicarFiltros();
  }

  onResetearFiltros() {
    this.filtroBusqueda = '';
    this.filtroEstado = -1;
    this.filtroCine = '';
    this.filtroProvincia = '';
    this.cinesFiltrados = [...this.cines];
    this.aplicarFiltros();
  }

  aplicarFiltros() {
    this.peliculasFiltradas = this.peliculas.filter(pelicula => {
      const coincideTitulo = this.filtroBusqueda === '' || pelicula.titulo.toLowerCase().includes(this.filtroBusqueda);
      const coincideEstado = this.filtroEstado == -1 || pelicula.estrenada == this.filtroEstado;
      const coincideCine = this.filtroCine === '' || this.cinesPeliculas.some(rel => rel.id_pelicula == pelicula.id && rel.id_cine == Number(this.filtroCine));

      return coincideTitulo && coincideEstado && coincideCine;
    });
  }
}