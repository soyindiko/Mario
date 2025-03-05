import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegistroService {

  private apiUrlUsuarios = 'http://localhost:8888/api/usuarios';  // Endpoint para registrar usuarios
  private apiUrlClientes = 'http://localhost:8888/api/clientes';  // Endpoint para registrar clientes

  constructor(private http: HttpClient) {}

  registrarUsuario(usuario: any): Observable<any> {
    return this.http.post<any>(this.apiUrlUsuarios, usuario).pipe(
      map(response => response.result)
    );
  }

  registrarCliente(cliente: any): Observable<any> {
    return this.http.post<any>(this.apiUrlClientes, cliente).pipe(
      map(response => response.result)
    );
  }
}
