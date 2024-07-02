import { Component, Inject, Input } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { TablaService } from '../../Tablas/tabla.service';
import { FormBuilder, FormGroup, Validators , ReactiveFormsModule} from '@angular/forms';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-editar-instancia',
  standalone: true,
  imports: [CommonModule,ReactiveFormsModule],
  templateUrl: './editar-instancia.component.html',
  styleUrl: './editar-instancia.component.css'
})
export class EditarInstanciaComponent {
  emailEdit: string = '';
  nombreLista: string = '';
  instanciaId: BigInteger | undefined;
  miFormulario!: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<EditarInstanciaComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {
    // Construir el formulario dinámicamente
    const formControls: any = {};
    Object.keys(data.instancia).forEach((campo) => {
      if (campo !== 'id') { // Excluir el campo 'id'
        formControls[campo] = ['', Validators.required];
      }
    });
    this.miFormulario = this.formBuilder.group(formControls);
  }
 
  submitForm(): void {
    if (this.miFormulario.valid) {
      // El formulario es válido, puedes enviar los datos
      console.log("Bien");
    } else {
      // El formulario no es válido, muestra un mensaje de error o realiza otra acción
    }
  }

  EditarInstancia(): void {
    if (this.miFormulario.valid) {
      // Cerrar el diálogo
      this.dialogRef.close(); location.reload();
      
      // Obtener los valores del formulario y convertirlos en un array
      const valuesArray = Object.values(this.miFormulario.value);

      // Llamar al servicio para editar la instancia
      this.tablaService.EditarInstancia(valuesArray, this.data.emailEdit, this.data.listaSeleccionada.nombre, this.data.instancia.id).subscribe();
    } else {
      // El formulario no es válido, muestra un mensaje de error o realiza otra acción
    }
    
  }
  getKeys(obj: any): string[] {
    return Object.keys(obj);
  }
}
