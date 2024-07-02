import { Component , Input} from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ListaComponent } from '../lista/lista.component';
import { OperacionesComponent } from '../../operaciones/operaciones.component';
import { FormsModule } from '@angular/forms';


@Component({
  selector: 'app-cabecera',
  standalone: true,
  imports: [CommonModule,ListaComponent,OperacionesComponent,FormsModule],
  templateUrl: './cabecera.component.html',
  styleUrl: './cabecera.component.css'
})
export class CabeceraComponent {
  item: any;
  nombreEdit: string | undefined;
  emailEdit: string | undefined;
  userEdit: string | undefined;
  Edit:any | undefined;
  modificar: any |undefined;
  Movimientos: any | undefined;
  constructor(private route: ActivatedRoute) { 
    this.Movimientos="Si";
    this.modificar="Si";
  }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      this.nombreEdit = params['nombre'];
      this.emailEdit = params['email'];
      this.userEdit = params['user'];
      this.Edit= params['Edit'];
      this.item = params['Item']
    });   
  }
}
