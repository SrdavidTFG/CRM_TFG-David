import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';

@Component({
  selector: 'app-eliminar-contacto',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './eliminar-contacto.component.html',
  styleUrl: './eliminar-contacto.component.css'
})
export class EliminarContactoComponent {
  valorNombre: string = '';
  valorEmail: string = '';
  valorUsuario: string = '';

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<EliminarContactoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {}
  eliminarContacto(valorEmail: string): void {
    this.dialogRef.close(); location.reload();
      this.tablaService.EliminarContacto(valorEmail).subscribe();
    
    }
    cancelar(){
      this.dialogRef.close(); location.reload();
    }
}
