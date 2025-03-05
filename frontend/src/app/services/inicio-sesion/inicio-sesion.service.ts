import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject } from 'rxjs/internal/BehaviorSubject';

@Injectable({
  providedIn: 'root'
})
export class InicioSesionService {

  private apiUrl = 'http://localhost:8888/api/usuarios/authentication';

  private usuarioKey = 'usuarioActual'; // Clave para localStorage

  constructor(private http: HttpClient, private router: Router) {}

  private usuario: any = JSON.parse(localStorage.getItem(this.usuarioKey) || '[]');

  private usuarioSubject = new BehaviorSubject<any>(this.usuario);
  
  usuarioActual$ = this.usuarioSubject.asObservable();

  // Método para iniciar sesión
  login(correo: string, contrasena: string): Promise<boolean> {

    return new Promise((resolve, reject) => {
      this.http.post<any>(this.apiUrl, { correo: correo.toString(), contrasena: contrasena.toString() })
        .subscribe(response => {
          const usuario = response.result;
  
          if (usuario) {
            localStorage.setItem(this.usuarioKey, JSON.stringify(usuario));
            this.usuarioSubject.next(usuario);
          }
  
          if (response.statusCode === 200) {
            resolve(true);
          } else {
            resolve(false);
          }
        }, error => {
          reject(false);
        });
    });
              
  }

  // Obtener usuario actual
  getUsuarioActual() {
    const usuario = localStorage.getItem(this.usuarioKey);
    return usuario ? JSON.parse(usuario) : null;
  }

  // Verifica si el usuario tiene un rol específico
  tieneRol(rol: string): boolean {
    const usuario = this.getUsuarioActual();
    return usuario ? usuario.rol === rol : false;
  }

  // Verificar si hay sesión iniciada
  isLoggedIn(): boolean {
    return this.getUsuarioActual() !== null;
  }

  logout() {
    localStorage.removeItem(this.usuarioKey);
    this.router.navigate(['/inicio-sesion']);
    this.usuario = []
    this.usuarioSubject.next(this.usuario);
  }
}
