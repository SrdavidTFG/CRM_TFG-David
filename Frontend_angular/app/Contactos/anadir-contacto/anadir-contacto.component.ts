import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TablaService } from '../../Tablas/tabla.service';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

@Component({
  selector: 'app-anadir-contacto',
  standalone: true,
  imports: [FormsModule, CommonModule, ReactiveFormsModule],
  templateUrl: './anadir-contacto.component.html',
  styleUrls: ['./anadir-contacto.component.css']
})
export class AnadirContactoComponent {
  miFormulario: FormGroup;

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<AnadirContactoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private formBuilder: FormBuilder
  ) {
    this.miFormulario = this.formBuilder.group({
      nombre: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      usuario: ['', Validators.required]
    });
  }

  anadirContacto(): void {
    if (this.miFormulario.valid) {
      const { nombre, email, usuario } = this.miFormulario.value;
      this.tablaService.AñadirContacto(nombre, email, usuario).subscribe();
      this.dialogRef.close(); location.reload();
    }
  }
}
