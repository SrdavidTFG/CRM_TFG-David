
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { HttpClient ,HttpClientModule, HttpParams } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})

export class TablaService {
  constructor(public httpClient: HttpClient) {}

  obtenerDatosTablaUsuarios() : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    return  this.httpClient.get<any>('http://BeefCrmApi.com/Api/TraerUsuarios');
    
  
  }
  obtenerDatosTablaClientify() : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    return  this.httpClient.get<any>('http://BeefCrmApi.com/Api/TraerClientify');
    
  
  }
  AñadirUsuario(nombreU: any, emailU:any, userU: any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    console.log(nombreU);
    let params = new HttpParams()
    .set('database', 'Usuarios')
    .set('nombre', nombreU)
    .set('email', emailU)
    .set('user', userU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/InsertarUsuario', {params: params});
  
  }
  ModificarUsuario(nombreU: any, emailU:any, userU: any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    console.log(nombreU);
    let params = new HttpParams()
    .set('database', 'Usuarios')
    .set('nombre', nombreU)
    .set('email', emailU)
    .set('user', userU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/ModificarUsuario', {params: params});
  }

  EliminarUsuario(emailU:any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    let params = new HttpParams()
    .set('database', 'Usuarios')
    .set('email', emailU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/EliminarUsuario', {params: params});
  }

  obtenerDatosTablaContactos(): Observable<any[]> {
    // Simulando una solicitud asíncrona, como una llamada a una API
    return  this.httpClient.get<any>('http://BeefCrmApi.com/Api/TraerContactos');
  }
// #------------------------------------------------------------CONTACTOS-----------------------------------------------------
  AñadirContacto(nombreU: any, emailU:any, userU: any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    console.log(nombreU);
    let params = new HttpParams()
    .set('database', 'CRM_CONTACTS')
    .set('nombre', nombreU)
    .set('email', emailU)
    .set('user', userU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/InsertarUsuario', {params: params});
  
  }
  EditarContacto(nombreU: any, emailU:any, userU: any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    console.log(nombreU);
    let params = new HttpParams()
    .set('database', 'CRM_CONTACTS')
    .set('nombre', nombreU)
    .set('email', emailU)
    .set('user', userU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/ModificarUsuario', {params: params});
  
  }

  EliminarContacto(emailU:any) : Observable<any[]> {
    // Hacer la solicitud GET a la API externa
    let params = new HttpParams()
    .set('database', 'CRM_CONTACTS')
    .set('email', emailU);
     return this.httpClient.get<any>('http://BeefCrmApi.com/Api/EliminarUsuario', {params: params});
  }

  FiltrarPorNombre(Nombre : any , Base : any): Observable<any[]> {
    let params = new HttpParams()
    .set('Nombre', Nombre)
    .set('Base',Base);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/FiltrarPorNombre', {params: params});
  }
  obtenerListaMovimientos(email:any): Observable<any[]> {
    let params = new HttpParams()
    .set('email', email);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/obtenerMovimientos', {params: params});
  }
  anadirVentanaMovimientos(nombre:any, email: any ): Observable<any[]> {
    let params = new HttpParams()
    .set('nombre', nombre)
    .set('email', email);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/anadirVentanaMovimientos', {params: params});
  }
  eliminarMovimiento(email:any, NombreListaMovimiento: any ): Observable<any[]> {
    let params = new HttpParams()
    .set('email', email)
    .set('NombreListaMovimiento', NombreListaMovimiento);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/eliminarMovimiento', {params: params});
  }
  anadirInstanciasMovimientos(nombre:any,lista: any , email: any ,TiposCampos:any): Observable<any[]> {
    console.log(nombre);
    let params = new HttpParams()
    .set('nombre', nombre)
    .set('lista',lista)
    .set('TiposCampos',TiposCampos)
    .set('email', email);

  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/anadirInstanciasMovimientos', {params: params});
  }
  EditarInstancia(Contenido:any,email: any , nombreLista: any , instanciaId: any ): Observable<any[]> {
    let params = new HttpParams()
    .set('contenido', Contenido)
    .set('email',email)
    .set('nombreLista', nombreLista)
    .set('id',instanciaId);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/EditarInstanciasMovimientos', {params: params});
  }

  eliminarInstancia(email: string, nombreLista: any, instanciaId: any): Observable<any[]> {
    let params = new HttpParams()
    .set('email',email)
    .set('nombreLista', nombreLista)
    .set('id',instanciaId);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/EliminarInstanciasMovimientos', {params: params});
  }
  CrearTipoMovimiento(email: string, nombre: any, nombresCampos: any,tiposCampos: any): Observable<any[]> {
    let params = new HttpParams()
    .set('email',email)
    .set('nombre', nombre)
    .set('nombresCampos', nombresCampos)
    .set('tiposCampos',tiposCampos);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/CrearTipoMovimiento', {params: params});
  }
  obtenerMovimientosUsuario(email:any) : Observable<any[]> {
    let params = new HttpParams()
    .set('email',email);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/obtenerMovimientosUsuario', {params: params});
  }
  obtenerCamposMovimiento(email:any, nombreMovimiento : any) : Observable<any[]> {
    let params = new HttpParams()
    .set('nombreMovimiento',nombreMovimiento)
    .set('email',email);
    
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/obtenerCamposMovimiento', {params: params});
  }
  //-------------------------------------------------------------------------------------------------------------------
  insertarContacto(first_name:any,
    last_name:any,
    email:any,
    phone:any,
    street:any,
    city:any,
    state:any,
    country:any,
    postal_code:any,
    status:any,
    title:any,
    company:any) : Observable<any[]> {
      let params = new HttpParams()
      .set('first_name',first_name)
      .set('last_name',last_name)
      .set('email',email)
      .set('phone',phone)
      .set('street',street)
      .set('city',city)
      .set('state',state)
      .set('country',country)
      .set('postal_code',postal_code)
      .set('title',title)
      .set('company',company)
      .set('status',status);
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/enviarContactoClientify', {params: params});
  }
  ListaPdf(BaseDatos:any, email : any) : Observable<Blob> {
    let params = new HttpParams()
    .set('database',BaseDatos)
    .set('email',email);
    
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/DescargarAPdf', {params: params,responseType: 'blob' as 'json'});
  }
  ValidarUsuario(email : any, contraseña: any) : Observable<number> {
    let params = new HttpParams()
    .set('contraseña',contraseña)
    .set('email',email);
    
  return this.httpClient.get<any>('http://BeefCrmApi.com/Api/ValidarUsuario', {params: params});
  }
}
