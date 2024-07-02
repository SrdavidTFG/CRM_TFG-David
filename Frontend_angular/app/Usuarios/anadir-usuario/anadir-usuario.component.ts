import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { TablaService } from '../../Tablas/tabla.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

@Component({
  selector: 'app-anadir-usuario',
  standalone: true,
  imports: [FormsModule, CommonModule, ReactiveFormsModule],
  templateUrl: './anadir-usuario.component.html',
  styleUrls: ['./anadir-usuario.component.css']
})
export class AnadirUsuarioComponent {
  miFormulario: FormGroup;

  constructor(
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<AnadirUsuarioComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private formBuilder: FormBuilder
  ) {
    this.miFormulario = this.formBuilder.group({
      nombre: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      usuario: ['', Validators.required]
    });
  }

  anadirUsuario(): void {
    if (this.miFormulario.valid) {
      const { nombre, email, usuario } = this.miFormulario.value;
      this.tablaService.AñadirUsuario(nombre, email, usuario).subscribe();
      this.dialogRef.close(); location.reload();
    }
  }
}
