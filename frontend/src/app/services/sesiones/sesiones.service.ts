import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map, shareReplay } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class SesionesService {
  private readonly apiUrl = 'http://localhost:8888/api/sesiones/peliculas/cines/search';


  constructor(private http: HttpClient) {}

  obtenerSesiones(cineId: string, peliculaId: string, fecha: string): Observable<any[]> {
    return this.http.post<any>(this.apiUrl, { id_cine: Number(cineId), id_pelicula: Number(peliculaId), fecha: fecha  }).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );
  }
}
