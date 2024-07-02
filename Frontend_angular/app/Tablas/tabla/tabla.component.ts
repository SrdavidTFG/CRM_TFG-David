import { Component, Input, OnInit, OnDestroy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavigationStart, Router } from '@angular/router';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { TablaService } from '../tabla.service';
import { ComunicacionFiltradoService } from '../comunicacion-filtrado.service';
import { ConexionApiService } from '../../conexion-api.service';
import { CabeceraComponent } from '../detalle-contacto/cabecera/cabecera.component';
import { CabeceralistaComponent } from '../cabeceralista/cabeceralista.component';
import { OperacionesComponent } from '../operaciones/operaciones.component';
import { DetalleUsuarioComponent } from '../detalle-usuario/detalle-usuario.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FiltroTablaComponent } from '../filtro-tabla/filtro-tabla.component';
import { DetalleClientifyComponent } from '../../Clientify/detalle-clientify/detalle-clientify.component';
import { FormsModule } from '@angular/forms';
import { RefreshService } from '../../refresh.service';
import { NgxPaginationModule } from 'ngx-pagination';
import { take } from 'rxjs/operators';
import { takeUntil } from 'rxjs/operators';
import { Subject } from 'rxjs';

@Component({
  selector: 'app-tabla',
  standalone: true,
  imports: [HttpClientModule,FormsModule , NgxPaginationModule,CommonModule,CabeceralistaComponent,OperacionesComponent,DetalleUsuarioComponent
            ,CabeceraComponent,RouterOutlet, RouterLink, RouterLinkActive,DetalleClientifyComponent],
  providers:[HttpClient],
  templateUrl: './tabla.component.html',
  styleUrl: './tabla.component.css'
})
export class TablaComponent  implements OnInit {
  tableData: any = [];
  filteredData: any = [];
  filterText: string = '';
  @Input() Tipo:any;
  @Input() Tipo2 :any;
  private ngUnsubscribe: Subject<void> = new Subject<void>();
  @Input() Clientify:any;
  @Input() landing:any;
  page: number = 1;
  pageSize: number = 10;
  data: any;
  time : number=0;
  TituloClientify: any;
  private isFirstLoad: boolean = true;
  constructor(private tablaService: TablaService, private refreshService: RefreshService ,private comunicacionservice: ComunicacionFiltradoService,public conexionApiService: ConexionApiService,  public dialog: MatDialog,private router:Router) {this.Tipo2="lista" ;}
 

  ngOnInit(): void {

    const Valor= sessionStorage.getItem('miClave');
    console.log(Valor);
    if(Valor!=="miValor"){
      sessionStorage.setItem('miClave', 'miValor');
      console.log(sessionStorage.getItem('miClave'));
      location.reload();
    }

    if(this.Tipo === "Contactos"){
      this.cargarDatosTablaContactos();
    }
    else if(this.Tipo === "Usuarios"){
    this.cargarDatosTablaUsuarios();
    console.log(this.Tipo);
    }
    else {
      this.cargarDatosClientify();
      if(this.Clientify==="Si"){
        this.TituloClientify=="Contactos Clientify";
      }
    } 
    console.log(this.Tipo2);
    this.comunicacionservice.tableData$.subscribe(data => {
      this.tableData = data;
      console.log(this.tableData);
    });
  }
  
  OpenDetalle(item: any):void{
    this.router.navigate(['Tablas/detalle-contacto/cabecera/cabecera.component'])
  }
  cargarDatosTablaUsuarios(): void {
    this.tablaService.obtenerDatosTablaUsuarios().subscribe(data => {
      this.tableData = data;
    });
    
  }
  cargarDatosTablaContactos(): void {
    this.tablaService.obtenerDatosTablaContactos().subscribe(data => {
      this.tableData = data;
      console.log(data);
    });
    
  }
  cargarDatosClientify(): void {
    this.tablaService.obtenerDatosTablaClientify().subscribe(data => {
      this.tableData = data;
      this.TituloClientify = "Contactos Clientify"; 
      console.log(data);
    });
  }
  DetalleClientify(data : any): void {
    console.log(data);
    const dialogRef = this.dialog.open(DetalleClientifyComponent, {
      width: '600px',
      data : {data}
    });
  }
  applyFilter(): void {
    console.log(this.filteredData);
    if (this.filterText) {
      this.filteredData = this.tableData.filter((item: { nombre: string; }) => item.nombre.toLowerCase().includes(this.filterText.toLowerCase()));
    } else {
      this.filteredData = this.tableData;
    }
    this.tableData= this.filteredData;
  }
  Buscar(Tipo : any): void {
    console.log(Tipo);
    const dialogRef = this.dialog.open(FiltroTablaComponent, {
      width: '250px',
      data : {Tipo}
      
    });
}
}
