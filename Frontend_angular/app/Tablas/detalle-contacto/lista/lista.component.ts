import { Component, Input } from '@angular/core';
import { TablaService } from '../../tabla.service'; 
import { CommonModule } from '@angular/common';
import { OperacionesComponent } from '../../operaciones/operaciones.component';
import { Location } from '@angular/common';

@Component({
  selector: 'app-lista',
  standalone: true,
  imports: [CommonModule,OperacionesComponent],
  templateUrl: './lista.component.html',
  styleUrl: './lista.component.css'
})
export class ListaComponent {
  datos: any[] | undefined;
  listaSeleccionada: any;
  @Input() Movimientos: any;
  @Input() emailEdit: any;
  Lista : any | undefined;
  Cabecera : any | undefined;

  constructor(private tablaService: TablaService, private location:Location) { this.Lista="Si", this.Cabecera="Si"}
  
  ngOnInit(): void {
    this.tablaService.obtenerListaMovimientos(this.emailEdit).subscribe(data => {
      this.datos=data[0];
      console.log(data[0][0]);
      console.log(this.datos);
      // Por defecto, selecciona la primera lista
      this.listaSeleccionada = data[0][0];
    });

  }

  seleccionarLista(lista: any): void {
    console.log(lista);
    this.listaSeleccionada = lista;
  }
  goBack(): void {
    this.location.back();
  }

  getKeys(obj: any): string[] {
    if (obj === undefined || obj === null) {
      return [];
    }
    return Object.keys(obj);
  }
  
}
