import { Component } from '@angular/core';
import { InicioSesionService } from '../../services/inicio-sesion/inicio-sesion.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-inicio-sesion',
  standalone: false,
  
  templateUrl: './inicio-sesion.component.html',
  styleUrl: './inicio-sesion.component.css'
})
export class InicioSesionComponent {
  username: string = '';
  password: string = '';
  errorMessage: string = '';

  constructor(private authService: InicioSesionService, private router: Router) {}

  async login() {
    if (await this.authService.login(this.username, this.password)) {
      this.router.navigate(['/']);
    } else {
      this.errorMessage = 'Usuario o contraseña incorrectos';
    }
  }

  goToRegistro() {
    this.router.navigate(['/registro']);

  }
}
