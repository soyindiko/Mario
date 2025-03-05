import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable, shareReplay } from 'rxjs';
import { Venta } from '../../interfaces/venta'
import { VentaAlimento } from '../../interfaces/venta-alimento';
import { VentaSesion } from '../../interfaces/venta-sesion';

@Injectable({
  providedIn: 'root'
})
export class VentasService {

  private apiVentasUrl = 'http://localhost:8888/api/ventas';
  private apiVentasSesionesUrl = 'http://localhost:8888/api/sesiones_ventas';
  private apiVentasAlimentosUrl = 'http://localhost:8888/api/alimentos_ventas';

  constructor(private http: HttpClient) {}

  getVentas(): Observable<any[]> {
    return this.http.get<any>(this.apiVentasUrl).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );
  }

  getVentasSesiones(): Observable<any> {
    return this.http.get<any>(this.apiVentasSesionesUrl).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );;
  }

  getVentasAlimentos(): Observable<any> {
    return this.http.get<any>(this.apiVentasAlimentosUrl).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );;
  }

  registrarVenta(venta: Venta): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    return this.http.post<any>(this.apiVentasUrl, venta, { headers }).pipe(
      map(response => response.result),
      shareReplay(1)
    );;
  }

  registrarVentasSesion(ventaSesion: VentaSesion): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    return this.http.post<any>(this.apiVentasSesionesUrl, ventaSesion, { headers }).pipe(
      map(response => response.result),
      shareReplay(1)
    );;
  }

  registrarVentasAlimento(ventaAlimento: VentaAlimento): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    return this.http.post<any>(this.apiVentasAlimentosUrl, ventaAlimento, { headers }).pipe(
      map(response => response.result),
      shareReplay(1)
    );;
  }
}
