import { Component } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { TablaComponent } from '../../Tablas/tabla/tabla.component';

@Component({
  selector: 'app-clientify',
  standalone: true,
  imports: [TablaComponent,HttpClientModule],
  providers: [HttpClient],
  templateUrl: './clientify.component.html',
  styleUrl: './clientify.component.css'
})
export class ClientifyComponent {
  Clientify: string = 'Si';
}
 