import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';

@Component({
  selector: 'app-eliminar-instancia',
  standalone: true,
  imports: [],
  templateUrl: './eliminar-instancia.component.html',
  styleUrl: './eliminar-instancia.component.css'
})
export class EliminarInstanciaComponent {
  nombreLista : any;
  valorEmail: string = '';
  instanciaId : bigint | undefined;

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<EliminarInstanciaComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {}
  //eliminarInstancia(email.value, data.listaSeleccionada.nombre, data.instancia.id)
  eliminarInstancia(valorEmail: string, nombreLista: any, instanciaId: bigint): void {
    this.dialogRef.close(); location.reload();
      this.tablaService.eliminarInstancia(valorEmail,nombreLista, instanciaId).subscribe();
    
    }
    cancelar(){
      this.dialogRef.close(); location.reload();
    }
}
 