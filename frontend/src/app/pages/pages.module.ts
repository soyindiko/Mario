import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { InicioComponent } from './inicio/inicio.component';
import { PeliculasPageComponent } from './peliculas-page/peliculas-page.component';
import { RegistroComponent } from './registro/registro.component';
import { InicioSesionComponent } from './inicio-sesion/inicio-sesion.component';
import { AppRoutingModule } from '../app-routing.module';
import { ComunesModule } from '../components/comunes/comunes.module'; 
import { PeliculasModule } from '../components/peliculas/peliculas.module';
import { FilterByPipe } from '../pipes/filter-by.pipe';
import { PeliculaDetailsComponent } from './pelicula-details/pelicula-details.component';
import { RouterLink, RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { SafeUrlPipe } from '../pipes/safe-url.pipe';
import { NgxPaginationModule } from 'ngx-pagination';
import { DetallesPedidoComponent } from './detalles-pedido/detalles-pedido.component';
import { InicioAdminComponent } from './inicio-admin/inicio-admin.component';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatTooltipModule } from '@angular/material/tooltip';
import { BaseChartDirective } from 'ng2-charts';
import { VentasAdminComponent } from './ventas-admin/ventas-admin.component';
import { MatTableModule } from '@angular/material/table';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatSortModule } from '@angular/material/sort';
import { StockAdminComponent } from './stock-admin/stock-admin.component';
import { MatSelect, MatSelectModule } from '@angular/material/select';
import { BrowserModule } from '@angular/platform-browser';


@NgModule({
  declarations: [
    InicioComponent,
    PeliculasPageComponent,
    RegistroComponent,
    InicioSesionComponent,
    PeliculaDetailsComponent,
    DetallesPedidoComponent,
    InicioAdminComponent,
    VentasAdminComponent,
    StockAdminComponent,
  ],
  imports: [
    ComunesModule,
    PeliculasModule,
    CommonModule,
    AppRoutingModule,
    FilterByPipe,
    SafeUrlPipe,
    RouterModule,
    RouterLink,
    FormsModule,
    NgxPaginationModule,
    MatCardModule,
    MatIconModule,
    MatTooltipModule,
    BaseChartDirective,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelect,
    BrowserModule,
    MatSelectModule,
    MatButtonModule,
  ]
})
export class PagesModule { }
