import { Component, ElementRef, HostListener, ViewChild } from '@angular/core';
import { Pelicula } from '../../models/pelicula';
import { PeliculaService } from '../../services/peliculas/pelicula.service';

@Component({
  selector: 'app-inicio',
  standalone: false,
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {
  peliculas: Pelicula[] = [];

  constructor(private readonly peliculaService: PeliculaService) {}

  ngOnInit(): void {
    this.peliculaService.getPeliculas().subscribe(
      (peliculas) => {
        this.peliculas = peliculas;
      },
      (error) => {
        console.error('Error al obtener películas:', error);
      }
    );
  }


  @ViewChild('listadoPeliculas') listadoPeliculas!: ElementRef;
  @ViewChild('listadoPeliculasProximas') listadoPeliculasProximas!: ElementRef;

  private isDragging = false;
  private startX = 0;
  private scrollLeft = 0;
  private activeList!: HTMLElement | null;

  ngAfterViewInit() {
    this.addDragEvents(this.listadoPeliculas.nativeElement);
    this.addDragEvents(this.listadoPeliculasProximas.nativeElement);
  }

  private addDragEvents(list: HTMLElement) {
    list.addEventListener('mousedown', (e: MouseEvent) => this.startDragging(e, list));
    list.addEventListener('mouseleave', () => this.stopDragging());
    list.addEventListener('mouseup', () => this.stopDragging());
    list.addEventListener('mousemove', (e: MouseEvent) => this.drag(e));
  }

  private startDragging(e: MouseEvent, list: HTMLElement) {
    this.isDragging = true;
    this.activeList = list;
    this.startX = e.pageX - list.offsetLeft;
    this.scrollLeft = list.scrollLeft;
    list.classList.add('dragging');
  }

  private stopDragging() {
    this.isDragging = false;
    this.activeList?.classList.remove('dragging');
    this.activeList = null;
  }

  private drag(e: MouseEvent) {
    if (!this.isDragging || !this.activeList) return;
    e.preventDefault();
    const x = e.pageX - this.activeList.offsetLeft;
    const walk = (x - this.startX) * 1.5; // Aumenta el factor para mayor velocidad
    this.activeList.scrollLeft = this.scrollLeft - walk;
  }
}
