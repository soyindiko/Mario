import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Opinion } from '../../models/opinion';
import { map, shareReplay } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class OpinionesPeliculasService {

  private apiUrl = 'http://localhost:8888/api/opiniones/search';
  
  constructor(private http: HttpClient) {}

  getOpiniones(idPelicula: number): Observable<any[]> {
    return this.http.post<any>(this.apiUrl, { id_pelicula: idPelicula }).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );
  }

  putOpinion(opinion: Opinion): Observable<any> {
    return this.http.post<any>('http://localhost:8888/api/opiniones', opinion).pipe(
      map(response => response.result),
      shareReplay(1)
    );
  }
}
