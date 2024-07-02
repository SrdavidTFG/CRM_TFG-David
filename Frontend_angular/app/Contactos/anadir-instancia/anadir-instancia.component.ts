import { Component, Inject, Input } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormsModule } from '@angular/forms';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';
import { ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-anadir-instancia',
  standalone: true,
  imports: [FormsModule,CommonModule,ReactiveFormsModule],
  templateUrl: './anadir-instancia.component.html',
  styleUrl: './anadir-instancia.component.css'
})
export class AnadirInstanciaComponent {
  valorfecha: string = '';
  lista: any;
  email: any;
  miFormulario!: FormGroup; 
  constructor(
    private formBuilder: FormBuilder,
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<AnadirInstanciaComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    
  ) {
    this.miFormulario = this.formBuilder.group({
      campo: ['', [Validators.required, Validators.pattern(/^\d{4}-\d{2}-\d{2}$/)]]
    });
  }
  anadirInstanciaMovimiento(valorfecha: any, lista:any, email:string): void {
    this.dialogRef.close(); location.reload();
      console.log(email);
      console.log(lista);
      console.log(valorfecha);
      this.tablaService.anadirInstanciasMovimientos(valorfecha,lista, email, [3,1]).subscribe();
    
    }
}
  