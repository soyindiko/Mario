import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ComunesModule } from './comunes/comunes.module';
import { PeliculasModule } from './peliculas/peliculas.module';
import { SafeUrlPipe } from '../pipes/safe-url.pipe';
import { NgxPaginationModule } from 'ngx-pagination';
import { FormsModule } from '@angular/forms';


@NgModule({
  imports: [
    CommonModule,
    ComunesModule,
    PeliculasModule,
    SafeUrlPipe,
    NgxPaginationModule,
    FormsModule,
  ],
  exports: [
    ComunesModule
  ]
})
export class ComponentsModule { }
