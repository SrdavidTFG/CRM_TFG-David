import { Component, NgModule } from '@angular/core';
import { TablaService } from '../../Tablas/tabla.service';
import { FormsModule } from '@angular/forms';


@Component({
  selector: 'app-anadir-contacto-clientify',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './anadir-contacto-clientify.component.html',
  styleUrl: './anadir-contacto-clientify.component.css'
})

export class AnadirContactoClientifyComponent {
constructor(private serviceTable: TablaService){}
public first_name: any;
public last_name: any;
public email: any;
public phone: any;
public street: any;
public city: any;
public state: any;
public country: any;
public postal_code: any;
public status: any;
public title: any;
public company: any;
Enviar(
  first_name: any,
  last_name: any,
  email: any,
  phone: any,
  street: any,
  city: any,
  postal_code: any,
  state: any,
  country: any,
  status: any,
  title: any,
  company: any
) {
  const formulario = {
    first_name,
    last_name,
    email,
    phone,
    street,
    city,
    state,
    country,
    status,
    title,
    company
  };
  console.log(formulario);
  this.serviceTable.insertarContacto( first_name,last_name,email,phone,street,city,state,country,postal_code,status,title,company).subscribe((response: any) => {
    console.log(response); // Maneja la respuesta como desees
  });
}
}
