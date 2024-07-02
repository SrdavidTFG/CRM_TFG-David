import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';

@Component({
  selector: 'app-eliminar-usuario',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './eliminar-usuario.component.html',
  styleUrl: './eliminar-usuario.component.css'
})
export class EliminarUsuarioComponent {
  valorNombre: string = '';
  valorEmail: string = '';
  valorUsuario: string = '';

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<EliminarUsuarioComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {}
  eliminarUsuario(valorEmail: string): void {
    this.dialogRef.close(); location.reload();
      this.tablaService.EliminarUsuario(valorEmail).subscribe();
    
    }
    cancelar(){
      this.dialogRef.close(); location.reload();
    }
}
