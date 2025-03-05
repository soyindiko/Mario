import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InicioComponent } from './pages/inicio/inicio.component';
import { PeliculasPageComponent } from './pages/peliculas-page/peliculas-page.component';
import { InicioSesionComponent } from './pages/inicio-sesion/inicio-sesion.component';
import { RegistroComponent } from './pages/registro/registro.component';
import { PeliculaDetailsComponent } from './pages/pelicula-details/pelicula-details.component';
import { authGuard } from './guards/auth.guard';
import { DetallesPedidoComponent } from './pages/detalles-pedido/detalles-pedido.component';
import { InicioAdminComponent } from './pages/inicio-admin/inicio-admin.component';
import { VentasAdminComponent } from './pages/ventas-admin/ventas-admin.component';
import { StockAdminComponent } from './pages/stock-admin/stock-admin.component';

const routes: Routes = [
  {path: '', component: InicioComponent},
  {path: 'inicio', component: InicioComponent},
  {path: 'peliculas', component: PeliculasPageComponent},
  {path: 'peliculas/:filtro', component: PeliculasPageComponent},
  {path: 'detalles-pelicula/:id_pelicula', component: PeliculaDetailsComponent},
  {path: 'inicio-sesion', component: InicioSesionComponent},
  {path: 'registro', component: RegistroComponent},
  {path: 'detalles-pedido', component: DetallesPedidoComponent, canActivate: [authGuard], data: { rol: 'cliente' }},
  {path: 'inicio-admin', component: InicioAdminComponent, canActivate: [authGuard], data: { rol: 'administrador' }},
  {path: 'ventas-admin', component: VentasAdminComponent, canActivate: [authGuard], data: { rol: 'administrador' }},
  {path: 'stock-admin', component: StockAdminComponent, canActivate: [authGuard], data: { rol: 'administrador' }},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
