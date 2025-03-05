import { ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot } from '@angular/router';
import { inject } from '@angular/core';
import { InicioSesionService } from '../services/inicio-sesion/inicio-sesion.service';

export const authGuard: CanActivateFn = (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
  const authService = inject(InicioSesionService);
  const router = inject(Router);

  const usuario = authService.getUsuarioActual();

  if (!usuario) {
    router.navigate(['/inicio-sesion']);
    return false;
  }

  const rolRequerido = route.data['rol'];
  if (rolRequerido && usuario.rol !== rolRequerido) {
    router.navigate(['/']);
    return false;
  }

  return true;
};
