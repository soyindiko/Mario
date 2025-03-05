import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map, mergeMap, shareReplay } from 'rxjs/operators';
import { Pelicula } from '../../models/pelicula';

@Injectable({
  providedIn: 'root'
})
export class PeliculaService {

  private readonly apiUrl = 'http://localhost:8888/api/peliculas';
  
  constructor(private http: HttpClient) {}

  getPeliculas(): Observable<any[]> {
    return this.http.get<any>(this.apiUrl).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );
  }
}
