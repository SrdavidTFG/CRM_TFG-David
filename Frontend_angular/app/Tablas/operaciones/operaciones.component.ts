import { Component , Input} from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { FiltroTablaComponent } from '../filtro-tabla/filtro-tabla.component';
import { AnadirUsuarioComponent } from '../../Usuarios/anadir-usuario/anadir-usuario.component';
import { ModificarUsuarioComponent } from '../../Usuarios/modificar-usuario/modificar-usuario.component';
import { EliminarUsuarioComponent } from '../../Usuarios/eliminar-usuario/eliminar-usuario.component';
import { DetalleUsuarioComponent } from '../detalle-usuario/detalle-usuario.component';
import { AnadirContactoComponent } from '../../Contactos/anadir-contacto/anadir-contacto.component';
import { ModificarContactoComponent } from '../../Contactos/modificar-contacto/modificar-contacto.component';
import { EliminarContactoComponent } from '../../Contactos/eliminar-contacto/eliminar-contacto.component';
import { AnadirVentanaMovimientosComponent } from '../../Contactos/anadir-ventana-movimientos/anadir-ventana-movimientos.component';
import { AnadirInstanciaComponent } from '../../Contactos/anadir-instancia/anadir-instancia.component';
import { BorrarMovimientoComponent } from '../../Contactos/borrar-movimiento/borrar-movimiento.component';
import { EditarInstanciaComponent } from '../../Contactos/editar-instancia/editar-instancia.component';
import { EliminarInstanciaComponent } from '../../Contactos/eliminar-instancia/eliminar-instancia.component';
import { CrearTipoMovimientoComponent } from '../Movimientos/crear-tipo-movimiento/crear-tipo-movimiento.component';
import { AnadirContactoClientifyComponent } from '../../Clientify/anadir-contacto-clientify/anadir-contacto-clientify.component';
import { CrearEstructuraTipoDeMovimientoComponent } from '../Movimientos/crear-estructura-tipo-de-movimiento/crear-estructura-tipo-de-movimiento.component';
import { TablaService } from '../../Tablas/tabla.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-operaciones',
  standalone: true,
  imports: [CommonModule,RouterOutlet, RouterLink, RouterLinkActive,AnadirUsuarioComponent,
            ModificarUsuarioComponent,EliminarUsuarioComponent,ModificarContactoComponent,
            AnadirContactoComponent, EliminarContactoComponent, AnadirVentanaMovimientosComponent,
            AnadirInstanciaComponent,BorrarMovimientoComponent, EditarInstanciaComponent, EliminarInstanciaComponent
          ,CrearTipoMovimientoComponent,CrearEstructuraTipoDeMovimientoComponent,AnadirContactoClientifyComponent], 
  templateUrl: './operaciones.component.html',
  styleUrl: './operaciones.component.css'
})
export class OperacionesComponent {
  Edit: String | undefined;
  @Input() item:any;
  @Input() Tipo:any;
  @Input() Tipo2:any;
  @Input() Movimientos:any;
  @Input() Lista: any;
  @Input() modificar : any;

  @Input() emailEdit : any;
  @Input() nombreEdit : any;
  @Input() userEdit : any;
  @Input() Cabecera : any;
  @Input() listaSeleccionada : any;

  @Input() instancia : any;

  @Input() Clientify : any;
  
  constructor(public dialog: MatDialog, private tablaService: TablaService,private location: Location)
  {
    this.Edit=="True";
  }
  openDialog(data: any): void {
    console.log(data);
    const dialogRef = this.dialog.open(FiltroTablaComponent, {
      width: '250px',
      data: { data }
    });
  }
  DetalleUsuario(data: any): void {
    console.log(data);
    const dialogRef = this.dialog.open(DetalleUsuarioComponent, {
      width: '250px',
      data: { data }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      // Aquí puedes realizar acciones después de cerrar el modal si es necesario
    });
  }
  AnadirUsuario(): void {
   
    const dialogRef = this.dialog.open(AnadirUsuarioComponent, {
      width: '250px'
      
    });
  }
  InsertarClientify(): void {
    console.log();
     const dialogRef = this.dialog.open(AnadirContactoClientifyComponent, {
       width: '600px',
       data: {}
     });
   }

  EditarUsuario(item : any ): void {
   console.log(item);
    const dialogRef = this.dialog.open(ModificarUsuarioComponent, {
      width: '250px',
      data: { item }
    });
  }
  EliminarUsuario(item : any ): void {
    console.log(item);
     const dialogRef = this.dialog.open(EliminarUsuarioComponent, {
       width: '250px',
       data: { item }
     });
   }
   ModificarContacto(emailEdit: string, nombreEdit:string, userEdit:string):void{
    console.log(nombreEdit);
    console.log(userEdit);
    this.tablaService.EditarContacto(nombreEdit, emailEdit, userEdit).subscribe();
   }
   AnadirContacto(): void {
   
    const dialogRef = this.dialog.open(AnadirContactoComponent, {
      width: '250px'
      
    });
  }
  BorrarContacto(item : any ): void {
    console.log(item);
     const dialogRef = this.dialog.open(EliminarContactoComponent, {
       width: '250px',
       data: { item }
     });
   }
   anadirVentanaMovimientos(emailEdit: string): void{
    console.log("operaciones email");
    console.log(emailEdit);
    const dialogRef = this.dialog.open(AnadirVentanaMovimientosComponent, {
      width: '250px',
      data : {emailEdit}
    });
  }
  BorrarMovimiento( listaSeleccionada: any ,emailEdit: string): void{
    const dialogRef = this.dialog.open(BorrarMovimientoComponent, {
      width: '250px',
      data : {listaSeleccionada, emailEdit}
    });
  }
  
    anadirInstanciaMovimiento(listaSeleccionada: any, emailEdit : any){
      console.log(listaSeleccionada.nombre);
      const valorNombre= listaSeleccionada.nombre;
      console.log(valorNombre);
      const dialogRef = this.dialog.open(CrearTipoMovimientoComponent, {
        width: '600px',
        data : {valorNombre,emailEdit}
      });

    }
    EditarInstancia(instancia: any, emailEdit : any, listaSeleccionada : any){
      console.log(instancia.id);
      console.log(listaSeleccionada.nombre);
      const dialogRef = this.dialog.open(EditarInstanciaComponent, {
        width: '250px',
        data : {instancia, emailEdit, listaSeleccionada}
      });

    }
    EliminarInstancia(instancia: any, emailEdit : any, listaSeleccionada : any){
      console.log(instancia.id);
      console.log(listaSeleccionada.nombre);
      const dialogRef = this.dialog.open(EliminarInstanciaComponent, {
        width: '250px',
        data : {instancia, emailEdit, listaSeleccionada}
      });

    }
    CrearTipoMovimiento(emailEdit : any){
      const dialogRef = this.dialog.open(CrearTipoMovimientoComponent, {
        width: '250px',
        data : {emailEdit}
      });
    }
    CrearNuevoTipoMovimiento(emailEdit : any){
      const dialogRef = this.dialog.open(CrearEstructuraTipoDeMovimientoComponent, {
        width: '600px',
        data : {emailEdit}
      });
    }
    goBack(): void {
      this.location.back();
    }

    DescargarListaPDF(Tipo: string): void {
      const email = -1;
      this.tablaService.ListaPdf(Tipo, email).subscribe(response => {
        const blob = new Blob([response], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'Lista.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
      }, error => {
        console.error('Error downloading the PDF', error);
      });
    }
    DescargarEnPDF(Tipo: string, email: string): void {
      this.tablaService.ListaPdf(Tipo, email).subscribe(response => {
        const blob = new Blob([response], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'Registro.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
      }, error => {
        console.error('Error downloading the PDF', error);
      });
    }
}
 