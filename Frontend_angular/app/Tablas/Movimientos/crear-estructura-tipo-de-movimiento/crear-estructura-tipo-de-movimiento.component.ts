import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormArray,ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { TablaService } from '../../tabla.service';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
@Component({
  selector: 'app-crear-estructura-tipo-de-movimiento',
  standalone: true,
  imports: [CommonModule,ReactiveFormsModule],
  templateUrl: './crear-estructura-tipo-de-movimiento.component.html',
  styleUrl: './crear-estructura-tipo-de-movimiento.component.css'
})
export class CrearEstructuraTipoDeMovimientoComponent implements OnInit {
  tipoMovimientoForm!: FormGroup;
  nombreMovimiento: string = '';
  emailEdit: any;

  constructor(private fb: FormBuilder,private tablaService: TablaService,public dialogRef: MatDialogRef<CrearEstructuraTipoDeMovimientoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) { }

  ngOnInit(): void {
    this.tipoMovimientoForm = this.fb.group({
      emailEdit: [this.emailEdit],
      nombreMovimiento: ['', Validators.required],
      campos: this.fb.array([])
    });
  }

  get campos(): FormArray {
    return this.tipoMovimientoForm.get('campos') as FormArray;
  }

  agregarCampo() {
    this.campos.push(this.fb.group({
      nombre: ['', Validators.required],
      tipo: ['', Validators.required]
    }));
  }

  eliminarCampo(index: number) {
    this.campos.removeAt(index);
  }

  onSubmit() {
    if (this.tipoMovimientoForm.valid) {
      this.dialogRef.close(); location.reload();
	    this.nombreMovimiento = this.tipoMovimientoForm.value.nombreMovimiento;
      this.emailEdit = this.tipoMovimientoForm.value.emailEdit;
      const nombresCampos = this.campos.value.map((campo: { nombre: any; }) => campo.nombre);
      const configuracion = this.campos.value.map((campo: { tipo: string; }) => {
        const num = this.tipoNumerico(campo.tipo);
        return parseInt(num.toString(), 10);
      });
            console.log('Nombres de campos:', nombresCampos);
      console.log('Email:', this.data.emailEdit);
      console.log('Configuración de tipos:', configuracion);
      console.log('Nombre movimiento:', this.nombreMovimiento);
      this.tablaService.anadirVentanaMovimientos(this.nombreMovimiento, this.data.emailEdit).subscribe();
      this.tablaService.CrearTipoMovimiento(this.data.emailEdit,this.nombreMovimiento, nombresCampos, configuracion).subscribe();
    } else {
      // Manejar el caso cuando el formulario no es válido
    }
  }

  tipoNumerico(tipo: string): number {
    switch (tipo) {
      case 'string':
        return 1;
      case 'array':
        return 2;
      case 'integer':
        return 3;
      // Agrega más casos según tus necesidades
      default:
        return 0; // Valor por defecto o para otros tipos
    }
  }
}
