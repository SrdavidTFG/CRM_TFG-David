import { Component, Inject, Input } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { TablaService } from '../../Tablas/tabla.service';
import { CrearTipoMovimientoComponent } from '../../Tablas/Movimientos/crear-tipo-movimiento/crear-tipo-movimiento.component';

@Component({
  selector: 'app-anadir-ventana-movimientos',
  standalone: true,
  imports: [FormsModule,CommonModule,CrearTipoMovimientoComponent],
  templateUrl: './anadir-ventana-movimientos.component.html',
  styleUrl: './anadir-ventana-movimientos.component.css'
})
export class AnadirVentanaMovimientosComponent {
  valorNombre: string = '';
  valorEmail: string = '';
  valorUsuario: string = '';
  emailEdit : string = '';  
  tableData: any= [];
  constructor(
    private tablaService: TablaService,
    public dialog: MatDialog,
    public dialogRef: MatDialogRef<AnadirVentanaMovimientosComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {}
  ngOnInit(): void {
    this.tablaService.obtenerMovimientosUsuario(this.data.emailEdit).subscribe((data: any) => {
      this.tableData = data;
    });
  }
  anadirVentanaMovimientos(emailEdit:string,valorNombre: any ): void {
    this.dialogRef.close();
    console.log (valorNombre);
    const dialogRef = this.dialog.open(CrearTipoMovimientoComponent, {
      width: '600px',
      data : {valorNombre,emailEdit}
    });
    
    }
}
