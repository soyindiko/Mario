import { Component, OnInit } from '@angular/core';
import { ChartDataset, ChartOptions, ChartType, Chart } from 'chart.js';
import { VentasService } from '../../services/ventas/ventas.service';
import { LineController, LineElement, PointElement, LinearScale, CategoryScale, Title, Tooltip, Legend } from 'chart.js';
import { Venta } from '../../models/venta';

Chart.register(LineController, LineElement, PointElement, LinearScale, CategoryScale, Title, Tooltip, Legend);

@Component({
  selector: 'app-inicio-admin',
  standalone: false,
  
  templateUrl: './inicio-admin.component.html',
  styleUrl: './inicio-admin.component.css'
})
export class InicioAdminComponent {
  
  // Datos para los gráficos
  public ventasData: ChartDataset[] = [];
  public ventasSesionesData: ChartDataset[] = [];
  public ventasAlimentosData: ChartDataset[] = [];

  public chartType: ChartType = 'line';
 
   // Configuración de los gráficos
  public chartOptions: ChartOptions = {
    responsive: true,
    scales: {
      x: {
        title: {
          display: true,
          text: 'Fecha'
        }
      },
      y: {
        title: {
          display: true,
          text: 'Cantidad'
        }
      }
    }
  };

  public chartLabels: string[] = []; // Cambiado a string[]

  constructor(private ventasService: VentasService) {}

  ngOnInit(): void {
    this.obtenerDatos();
  }

  obtenerDatos(): void {
    const fechaActual = new Date();
    const fechasUltimaSemana = this.obtenerFechasUltimaSemana(fechaActual);
  
    // Inicializar estructura de datos vacía
    const ventasPorFecha: { [fecha: string]: number } = {};
    const sesionesPorFecha: { [fecha: string]: number } = {};
    const alimentosPorFecha: { [fecha: string]: number } = {};
  
    fechasUltimaSemana.forEach(fecha => {
      ventasPorFecha[fecha] = 0;
      sesionesPorFecha[fecha] = 0;
      alimentosPorFecha[fecha] = 0;
    });
  
    // Obtener datos de ventas
    this.ventasService.getVentas().subscribe((ventas) => {
      ventas.forEach((venta: { fecha: any; importe: number; }) => {
        const fecha = venta.fecha; // Formato "dd/MM/yyyy"
  
        if (ventasPorFecha[fecha] !== undefined) {
          ventasPorFecha[fecha] += venta.importe;
        }
      });
  
      // Actualizar gráfico de ventas
      this.chartLabels = fechasUltimaSemana;
      this.ventasData = [{
        data: fechasUltimaSemana.map(fecha => ventasPorFecha[fecha]),
        label: 'Ventas Totales'
      }];
  
      // Obtener datos de ventas_sesiones y asociar fecha
      this.ventasService.getVentasSesiones().subscribe((ventasSesiones) => {
        ventasSesiones.forEach((sesion: { id_venta: any; num_entradas: number; }) => {
          const venta = ventas.find((v: { id: any; }) => v.id == sesion.id_venta);
          console.log(venta);

          if (venta) {
            const fecha = venta.fecha;
            if (sesionesPorFecha[fecha] !== undefined) {
              sesionesPorFecha[fecha] += sesion.num_entradas;
            }
          }
        });
  
        this.ventasSesionesData = [{
          data: fechasUltimaSemana.map(fecha => sesionesPorFecha[fecha]),
          label: 'Ventas por Sesión'
        }];
      });
  
      // Obtener datos de ventas_alimentos y asociar fecha
      this.ventasService.getVentasAlimentos().subscribe((ventasAlimentos) => {
        ventasAlimentos.forEach((alimento: { id_venta: any; unidades: number; }) => {
          const venta = ventas.find((v: { id: any; }) => v.id == alimento.id_venta); // Buscar la venta por ID
          if (venta) {
            const fecha = venta.fecha;
            if (alimentosPorFecha[fecha] !== undefined) {
              alimentosPorFecha[fecha] += alimento.unidades;
            }
          }
        });
  
        this.ventasAlimentosData = [{
          data: fechasUltimaSemana.map(fecha => alimentosPorFecha[fecha]),
          label: 'Ventas de Alimentos'
        }];
      });
  
    });
  }
  
  

  private obtenerFechasUltimaSemana(fechaActual: Date): string[] {
    const fechas: string[] = [];

    for (let i = 6; i >= 0; i--) {
      const fecha = new Date(fechaActual);
      fecha.setDate(fechaActual.getDate() - i);
      fechas.push(fecha.toISOString().split('T')[0]); // Formato YYYY-MM-DD
    }
    return fechas;
  }

  // Función para obtener las fechas
  obtenerFechas(ventas: any[]): string[] { // Cambiado a string[]
    return ventas.map(venta => venta.fecha);
  }

  // Función para obtener los importes totales por fecha
  obtenerImportes(ventas: any[]): number[] {
    const importesPorFecha: { [key: string]: number } = {};

    ventas.forEach(venta => {
      if (!importesPorFecha[venta.fecha]) {
        importesPorFecha[venta.fecha] = 0;
      }
      importesPorFecha[venta.fecha] += venta.importe;
    });

    return this.chartLabels.map(fecha => importesPorFecha[fecha] || 0);
  }

  // Función para obtener las ventas por sesión
  obtenerVentasPorSesion(ventasSesiones: any[]): number[] {
    const ventasPorSesion: { [key: string]: number } = {};

    ventasSesiones.forEach(ventaSesion => {
      const fecha = this.obtenerFechaSesion(ventaSesion.id_venta);
      if (!ventasPorSesion[fecha]) {
        ventasPorSesion[fecha] = 0;
      }
      ventasPorSesion[fecha] += ventaSesion.num_entradas;
    });

    return this.chartLabels.map(fecha => ventasPorSesion[fecha] || 0);
  }

  // Función para obtener las ventas de alimentos por fecha
  obtenerVentasAlimentos(ventasAlimentos: any[]): number[] {
    const ventasAlimentosPorFecha: { [key: string]: number } = {};

    ventasAlimentos.forEach(ventaAlimento => {
      const fecha = this.obtenerFechaSesion(ventaAlimento.id_venta);
      if (!ventasAlimentosPorFecha[fecha]) {
        ventasAlimentosPorFecha[fecha] = 0;
      }
      ventasAlimentosPorFecha[fecha] += ventaAlimento.unidades;
    });

    return this.chartLabels.map(fecha => ventasAlimentosPorFecha[fecha] || 0);
  }

  // Función para obtener la fecha de una venta (suponiendo que las fechas son iguales)
  obtenerFechaSesion(idVenta: string): string {
    // Esto es solo un ejemplo, deberías personalizarlo según tu lógica
    return '28/2/2025'; // Aquí se debería recuperar la fecha real
  }
}
