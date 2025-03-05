import { Component } from '@angular/core';
import { RegistroService } from '../../services/registro/registro.service';
import { InicioSesionService } from '../../services/inicio-sesion/inicio-sesion.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registro',
  standalone: false,
  
  templateUrl: './registro.component.html',
  styleUrl: './registro.component.css'
})
export class RegistroComponent {
  nombre: string = '';
  apellidos: string = '';
  nombreUsuario: string = '';
  correo: string = '';
  contrasena: string = '';
  errorMessage: string = '';

  constructor(private registroService: RegistroService, private authService: InicioSesionService, private route: Router) {}

  registrar() {
    if (!this.nombre || !this.apellidos || !this.correo || !this.contrasena) {
      this.errorMessage = 'Por favor, rellena todos los campos.';
      return;
    }

    // Primero, registrar al usuario
    const nuevoUsuario = {
      correo: this.correo,
      contrasena: this.contrasena,
      rol: "cliente"
    };

    this.registroService.registrarUsuario(nuevoUsuario).subscribe(
      (usuarioResponse) => {
        // Después de registrar al usuario, registrar los detalles del cliente
        const nuevoCliente = {
          nombre: this.nombre,
          apellidos: this.apellidos,
          id_usuario: usuarioResponse.id
        };

        this.registroService.registrarCliente(nuevoCliente).subscribe(
          (clienteResponse) => {
            console.log('Cliente registrado con éxito:', clienteResponse);
            // Redirigir o realizar otras acciones
            this.authService.login(this.correo, this.contrasena);
            this.route.navigate(['/']);
          },
          (error) => {
            this.errorMessage = 'Hubo un error al registrar el cliente.';
          }
        );
      },
      (error) => {
        this.errorMessage = 'Hubo un error al registrar el usuario.';
      }
    );
  }
}
