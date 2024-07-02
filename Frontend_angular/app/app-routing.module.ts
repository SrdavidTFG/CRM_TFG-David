import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
//import { TablaComponent } from './Tablas/tabla/tabla.component';
import { CabeceraComponent } from './Tablas/detalle-contacto/cabecera/cabecera.component';
import { FiltroTablaComponent } from './Tablas/filtro-tabla/filtro-tabla.component';

import { HttpClient, HttpClientModule } from '@angular/common/http';
import { AppComponent } from './app.component';


const routes: Routes = [
  { path: '', component: AppComponent },
  { path: 'detalle-contacto/:id', component: CabeceraComponent },
  { path : 'filtro-tabla', component: FiltroTablaComponent }
  // Puedes agregar más rutas según necesites
];

@NgModule({
  imports: [RouterModule.forRoot(routes),HttpClientModule],
  exports: [RouterModule],
  providers: [HttpClient]
})
export class AppRoutingModule { }
