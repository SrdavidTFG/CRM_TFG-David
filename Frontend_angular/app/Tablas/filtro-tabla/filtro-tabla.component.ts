import { Component, Inject, Input } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';
import { MatDialog } from '@angular/material/dialog';
import { ComunicacionFiltradoService } from '../comunicacion-filtrado.service';
import { ThisReceiver } from '@angular/compiler';

@Component({
  selector: 'app-filtro-tabla',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './filtro-tabla.component.html',
  styleUrls: ['./filtro-tabla.component.css']
})
export class FiltroTablaComponent {
  valorfecha: string = '';
  nuevosDatos: any = [];
  lista: any;
  email: any;
  Tipo : any;
  Base : any;

  constructor(
    private tablaService: TablaService,
    private comunicacionservice: ComunicacionFiltradoService,
    public dialogRef: MatDialogRef<FiltroTablaComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    public dialog: MatDialog
  ) {}

  Buscar(Nombre: any, Tipo: any) {
    this.dialogRef.close(); location.reload();
    console.log(Tipo);
    if(Tipo == "Usuarios"){
      this.Base ="Usuarios";
    }else{
      this.Base ="CRM_CONTACTS";
    }
    this.tablaService.FiltrarPorNombre(Nombre,this.Base).subscribe(data => {
      console.log(data);
      this.nuevosDatos = data;

      // Llamar al servicio para actualizar tableData en el componente Tabla después de que nuevosDatos se haya actualizado
      this.comunicacionservice.actualizarTablaData(this.nuevosDatos);
    });
  }
}
