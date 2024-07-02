import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';
@Component({
  selector: 'app-modificar-usuario',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './modificar-usuario.component.html',
  styleUrl: './modificar-usuario.component.css'
})
export class ModificarUsuarioComponent {
  valorNombre: string = '';
  valorEmail: string = '';
  valorUsuario: string = '';

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<ModificarUsuarioComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {console.log(data);}
ModificarUsuario(valorNombre: string, valorEmail: string, valorUsuario: string): void {
  this.dialogRef.close(); location.reload();
    this.tablaService.ModificarUsuario(valorNombre, valorEmail, valorUsuario).subscribe();
  }

}
