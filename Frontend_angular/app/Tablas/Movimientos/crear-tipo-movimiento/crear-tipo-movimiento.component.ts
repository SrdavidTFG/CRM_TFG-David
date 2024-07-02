import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormArray, FormGroup, Validators, ReactiveFormsModule, AbstractControl } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { TablaService } from '../../tabla.service';

@Component({
  selector: 'app-crear-tipo-movimiento',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './crear-tipo-movimiento.component.html',
  styleUrls: ['./crear-tipo-movimiento.component.css']
})
export class CrearTipoMovimientoComponent implements OnInit {
  dynamicForm!: FormGroup;
  typesArray!: number[];

  constructor(
    private fb: FormBuilder,
    private tablaService: TablaService,
    public dialogRef: MatDialogRef<CrearTipoMovimientoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) { }

  ngOnInit(): void {
    this.dynamicForm = this.fb.group({
      inputs: this.fb.array([])
    });
console.log(this.data);
    this.tablaService.obtenerCamposMovimiento(this.data.emailEdit, this.data.valorNombre).subscribe(data => {
      if (data != null) {
        this.typesArray = data.flat().map((type: any) => parseInt(type, 10));
        console.log(this.typesArray);

        this.initializeForm(this.typesArray);
      }
    });
  }

  get inputs(): FormArray {
    return this.dynamicForm.get('inputs') as FormArray;
  }

  initializeForm(types: number[]): void {
    types.forEach(type => this.addInput(type));
  }

  addInput(type: number): void {
    let input;
    switch (type) {
      case 1:
        input = this.fb.group({
          value: this.fb.control('', Validators.required)
        });
        break;
      case 2:
        input = this.fb.control('', Validators.required);
        break;
      case 3:
        input = this.fb.group({
          value: this.fb.control('', [Validators.required, Validators.pattern("^[0-9]*$")])
        });
        break;
      default:
        input = this.fb.control('');
        break;
    }
    this.inputs.push(input);
  }

  asFormArray(control: AbstractControl): FormArray {
    return control as FormArray;
  }

  onSubmit(): void {
    this.dialogRef.close(); location.reload();
    const result = this.transformValues(this.dynamicForm.value.inputs, this.typesArray);
    console.log(result);
    console.log(this.typesArray);
    this.tablaService.anadirInstanciasMovimientos(result, this.data.valorNombre, this.data.emailEdit, this.typesArray).subscribe();
  }

  transformValues(values: any[], types: number[]): any[] {
    return values.map((value, index) => {
      if (types[index] === 2) {
        return value.split(',').map((v: string) => v.trim()).filter((v: string) => v !== '');
      }
      return value.value;
    });
  }
}
