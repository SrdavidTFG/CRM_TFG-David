import { Component } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { TablaComponent } from '../../Tablas/tabla/tabla.component';

@Component({
  selector: 'app-contactos',
  standalone: true,
  imports: [TablaComponent,HttpClientModule],
  templateUrl: './contactos.component.html',
  styleUrl: './contactos.component.css'
})
export class ContactosComponent {
  constructor(){}
Tipo: string = 'Contactos';
Tipo2 :string ="lista";
landing :string ="Si";

}
