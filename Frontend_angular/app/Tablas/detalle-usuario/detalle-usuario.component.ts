import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../tabla.service';

@Component({
  selector: 'app-detalle-usuario',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './detalle-usuario.component.html',
  styleUrl: './detalle-usuario.component.css'
})

export class DetalleUsuarioComponent {
  tableData: any[] = [];
  valorNombre: string = '';
  valorEmail: string = '';
  valorUser: string = '';

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<DetalleUsuarioComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {console.log(data);}

  onNoClick(valorNombre: string, valoEmail: string, valorUser: string): void {
    this.dialogRef.close(); location.reload();
      // this.tablaService.ActualizarDatosTablaUsuarios(valorId, valorNombre, valorApellido).subscribe(data => {
      //   this.tableData = data;
      // });
      // console.log(this.tableData);//Esta operacion modifica la base de datos asiq se mostraria en la tabla
    }
}
  


