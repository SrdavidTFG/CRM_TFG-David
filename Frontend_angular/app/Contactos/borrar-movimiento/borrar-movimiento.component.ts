import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';

@Component({
  selector: 'app-borrar-movimiento',
  standalone: true,
  imports: [],
  templateUrl: './borrar-movimiento.component.html',
  styleUrl: './borrar-movimiento.component.css'
})
export class BorrarMovimientoComponent {
  listaSeleccionada : any;
  valorEmail: string = '';
  

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<BorrarMovimientoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {}
  eliminarMovimiento(valorEmail: string, listaSeleccionada: any): void {
    this.dialogRef.close(); location.reload();
      this.tablaService.eliminarMovimiento(valorEmail,listaSeleccionada).subscribe();
    
    }
    cancelar(){
      this.dialogRef.close(); location.reload();
    }
}

