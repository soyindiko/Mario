import { Component, ViewChild } from '@angular/core';
import { Venta } from '../../models/venta';
import { VentasService } from '../../services/ventas/ventas.service';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';

@Component({
  selector: 'app-ventas-admin',
  standalone: false,
  
  templateUrl: './ventas-admin.component.html',
  styleUrl: './ventas-admin.component.css'
})
export class VentasAdminComponent {
  displayedColumns: string[] = ['id', 'fecha', 'id_sesion', 'importe'];
  dataSource = new MatTableDataSource<any>();

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(private ventasService: VentasService) {}

  ngOnInit(): void {
    this.cargarVentas();
  }

  cargarVentas(): void {
    this.ventasService.getVentas().subscribe({
      next: (ventas) => {

        this.ventasService.getVentasSesiones().subscribe({
          next: (ventasSesiones) => {
            const ventasConSesion = ventas.map((venta: { id: any; }) => {
              const sesion = ventasSesiones.find((s: { id_venta: any; }) => s.id_venta == venta.id);
              return { ...venta, id_sesion: sesion ? sesion.id_sesion : null };
            });
            this.dataSource.data = ventasConSesion;
            this.dataSource.paginator = this.paginator;
            this.dataSource.sort = this.sort;
          },
          error: (error: any) => console.error('Error al obtener ventas_sesiones:', error)
        });
      },
      error: (error) => console.error('Error al obtener ventas:', error)
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }
}
