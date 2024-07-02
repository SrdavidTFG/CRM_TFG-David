import { Component,Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';
import { ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-detalle-clientify',
  standalone: true,
  imports: [FormsModule,CommonModule,ReactiveFormsModule],
  templateUrl: './detalle-clientify.component.html',
  styleUrl: './detalle-clientify.component.css'
})
export class DetalleClientifyComponent {
  constructor(
    private formBuilder: FormBuilder,
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<DetalleClientifyComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ){}

  Cerrar():void{
    this.dialogRef.close(); location.reload(); location.reload();
  }
}
