import { Component, Input } from '@angular/core';
import { OperacionesComponent } from '../operaciones/operaciones.component';

@Component({
  selector: 'app-cabeceralista',
  standalone: true,
  imports: [OperacionesComponent],
  templateUrl: './cabeceralista.component.html',
  styleUrl: './cabeceralista.component.css'
})
export class CabeceralistaComponent {
@Input() Tipo:any;
@Input() Tipo2:any;
@Input() Clientify:any;
@Input() TituloClientify:any;


}
