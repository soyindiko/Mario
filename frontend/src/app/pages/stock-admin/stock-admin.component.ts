import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { CinesService } from '../../services/cines/cines.service';
import { ProductosService } from '../../services/productos/productos.service';

@Component({
  selector: 'app-stock-admin',
  standalone: false,
  
  templateUrl: './stock-admin.component.html',
  styleUrl: './stock-admin.component.css'
})
export class StockAdminComponent {
  cines: any[] = [];
  cinesFiltrados: any[] = [];
  alimentosFiltrados: any[] = [];
  provincias: string[] = ['Madrid'];
  filtroProvincia: string = '';
  filtroCine: number | null = null;

  displayedColumns: string[] = ['nombre', 'stock', 'acciones'];

  constructor(
    private cineService: CinesService,
    private productosService: ProductosService,
    public dialog: MatDialog
  ) {}

  ngOnInit(): void {
    this.obtenerCines();
  }

  // Obtener lista de cines
  obtenerCines(): void {
    this.cineService.getCines().subscribe((data: any[]) => {
      this.cines = data;
      this.cinesFiltrados = data;
    });
  }

  // Filtrar por provincia
  onFiltrarProvincia(event: any): void {
    if (this.filtroProvincia) {
      this.cinesFiltrados = this.cines.filter(cine =>
        cine.direccion.includes(this.filtroProvincia)
      );
    } else {
      this.cinesFiltrados = [...this.cines];
    }
    this.obtenerAlimentos();
  }

  // Filtrar por cine
  onFiltrarCine(event: any): void {
    this.obtenerAlimentos();
  }

  // Obtener alimentos según los filtros
  obtenerAlimentos(): void {
    if (this.filtroCine) {
      this.productosService.getProductos(this.filtroCine).subscribe((data: any[]) => {
        this.alimentosFiltrados = data;
      });
    }
  }

  // Agregar stock
  agregarStock(alimento: any): void {
    alimento.unidades += 1;
  }

  // Quitar stock
  quitarStock(alimento: any): void {
    if (alimento.unidades > 0) {
      alimento.unidades -= 1;
    }
  }

  // Guardar cambios en la base de datos
  actualizarStock(id: number, idAlimento: number, unidades: number): void {
    this.productosService.actualizarStock(id, this.filtroCine!, idAlimento, unidades).subscribe(
      (response: any) => {
        alert('Cambios guardados correctamente');
      },
      (error: any) => {
        console.error('Error al guardar cambios:', error);
        alert('Hubo un error al guardar los cambios');
      }
    );
  }
}
