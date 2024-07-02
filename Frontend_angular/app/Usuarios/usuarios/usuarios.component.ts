import { Component } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { TablaComponent } from '../../Tablas/tabla/tabla.component';

@Component({
  selector: 'app-usuarios',
  standalone: true,
  imports: [TablaComponent,HttpClientModule],
  providers: [HttpClient],
  templateUrl: './usuarios.component.html',
  styleUrl: './usuarios.component.css'
})
export class UsuariosComponent {
  Tipo: string = 'Usuarios';
  Tipo2 : string = 'lista'
}
