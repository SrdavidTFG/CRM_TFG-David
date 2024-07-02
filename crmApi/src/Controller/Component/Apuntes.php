import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormArray, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-dynamic-form',
  templateUrl: './dynamic-form.component.html',
  styleUrls: ['./dynamic-form.component.css']
})
export class DynamicFormComponent implements OnInit {
  dynamicForm: FormGroup;
  typesArray: number[] = [1, 2, 3, 1]; // Este array puede venir de una API o estar definido como quieras

  constructor(private fb: FormBuilder) { }

  ngOnInit(): void {
    this.dynamicForm = this.fb.group({
      inputs: this.fb.array([])  // Inicialmente un array vacío
    });

    this.initializeForm(this.typesArray);
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
      case 1: // String
        input = this.fb.control('', Validators.required);
        break;
      case 2: // Array
        input = this.fb.array(['', '', ''], Validators.required); // Inicializamos con tres strings vacíos
        break;
      case 3: // Integer
        input = this.fb.control('', [Validators.required, Validators.pattern("^[0-9]*$")]);
        break;
      default:
        input = this.fb.control('');
        break;
    }
    this.inputs.push(input);
  }

  onSubmit(): void {
    const result = this.transformValues(this.dynamicForm.value.inputs, this.typesArray);
    console.log(result);
    // Aquí puedes manejar los datos del formulario como desees
  }

  transformValues(values: any[], types: number[]): any[] {
    return values.map((value, index) => {
      if (types[index] === 2) {
        return value.filter((v: string) => v !== ''); // Filtra valores vacíos en el array
      }
      return value;
    });
  }
}


















//---------------------------------------------------------------------------------------------------$_COOKIE

<form [formGroup]="dynamicForm" (ngSubmit)="onSubmit()">
  <div formArrayName="inputs">
    <div *ngFor="let input of inputs.controls; let i = index">
      <div [formGroupName]="i" *ngIf="typesArray[i] !== 2">
        <input *ngIf="typesArray[i] === 1" formControlName="value" placeholder="Enter string">
        <input *ngIf="typesArray[i] === 3" formControlName="value" type="number" placeholder="Enter integer">
      </div>
      <div formArrayName="inputs" *ngIf="typesArray[i] === 2">
        <div *ngFor="let subInput of input.controls; let j = index">
          <input [formControlName]="j" placeholder="Enter array element">
        </div>
      </div>
    </div>
  </div>
  <button type="submit">Submit</button>
</form>
//---------------------------------------BOOTSTRAP---------------------------------------------------------------------------
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormArray, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-dynamic-form',
  templateUrl: './dynamic-form.component.html',
  styleUrls: ['./dynamic-form.component.css']
})
export class DynamicFormComponent implements OnInit {
  dynamicForm: FormGroup;
  typesArray: number[] = [1, 2, 3, 1]; // Este array puede venir de una API o estar definido como quieras

  constructor(private fb: FormBuilder) { }

  ngOnInit(): void {
    this.dynamicForm = this.fb.group({
      inputs: this.fb.array([])  // Inicialmente un array vacío
    });

    this.initializeForm(this.typesArray);
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
      case 1: // String
        input = this.fb.control('', Validators.required);
        break;
      case 2: // Array
        input = this.fb.array(['', '', ''], Validators.required); // Inicializamos con tres strings vacíos
        break;
      case 3: // Integer
        input = this.fb.control('', [Validators.required, Validators.pattern("^[0-9]*$")]);
        break;
      default:
        input = this.fb.control('');
        break;
    }
    this.inputs.push(input);
  }

  onSubmit(): void {
    const result = this.transformValues(this.dynamicForm.value.inputs, this.typesArray);
    console.log(result);
    // Aquí puedes manejar los datos del formulario como desees
  }

  transformValues(values: any[], types: number[]): any[] {
    return values.map((value, index) => {
      if (types[index] === 2) {
        return value.filter((v: string) => v !== ''); // Filtra valores vacíos en el array
      }
      return value;
    });
  }
}
//-----------------------------------------------------------------------------------------------------------
<form [formGroup]="dynamicForm" (ngSubmit)="onSubmit()" class="container mt-4">
  <div formArrayName="inputs">
    <div *ngFor="let input of inputs.controls; let i = index" class="mb-3">
      <div [formGroupName]="i" *ngIf="typesArray[i] !== 2" class="form-group">
        <label *ngIf="typesArray[i] === 1" for="stringInput{{i}}">String Input {{i + 1}}</label>
        <input *ngIf="typesArray[i] === 1" formControlName="value" id="stringInput{{i}}" class="form-control" placeholder="Enter string">

        <label *ngIf="typesArray[i] === 3" for="integerInput{{i}}">Integer Input {{i + 1}}</label>
        <input *ngIf="typesArray[i] === 3" formControlName="value" id="integerInput{{i}}" class="form-control" type="number" placeholder="Enter integer">
      </div>

      <div formArrayName="inputs" *ngIf="typesArray[i] === 2" class="form-group">
        <label for="arrayInput{{i}}">Array Input {{i + 1}}</label>
        <div *ngFor="let subInput of input.controls; let j = index" class="input-group mb-2">
          <input [formControlName]="j" id="arrayInput{{i}}-{{j}}" class="form-control" placeholder="Enter array element">
        </div>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
