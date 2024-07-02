import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { TablaComponent } from './Tablas/tabla/tabla.component';
import {CabeceraComponent } from './Tablas/detalle-contacto/cabecera/cabecera.component';
import { FiltroTablaComponent } from './Tablas/filtro-tabla/filtro-tabla.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { TablaService } from './Tablas/tabla.service';
import { ConexionApiService } from './conexion-api.service';
import { FormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    AppComponent,
    TablaComponent,
    CabeceraComponent,
    FiltroTablaComponent,
    FormsModule,

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [TablaService, ConexionApiService,HttpClient],
  bootstrap: [AppComponent]
})
export class AppModule { }
