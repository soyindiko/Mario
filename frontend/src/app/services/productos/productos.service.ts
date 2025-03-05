import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map, shareReplay } from 'rxjs';
import { Producto } from '../../models/producto';

@Injectable({
  providedIn: 'root'
})
export class ProductosService {
  

  private apiUrl = 'http://localhost:8888/api/alimentos/alimentos_cines';
    
  constructor(private http: HttpClient) {}

  getProductos(idCine: number): Observable<any[]> {
    return this.http.post<any>(this.apiUrl, { id_cine: Number(idCine) }).pipe(
      map(response => response.result.data),
      shareReplay(1)
    );
  }

  putProducto(producto: Producto): Observable<any> {
    return this.http.post<any>(this.apiUrl, producto);
  }

  actualizarStock(id:number, id_cine:number, id_alimento: number, unidades: number): Observable<any> {      
    return this.http.put(`http://localhost:8888/api/alimentos_cines/${id}`, { id_cine:Number(id_cine), id_alimento:Number(id_alimento), unidades:Number(unidades)  });
  }
}
