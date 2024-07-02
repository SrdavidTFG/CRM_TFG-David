import { HttpClient} from '@angular/common/http';
import { Component, Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class ConexionApiService {
  constructor(public httpClient: HttpClient) {
    console.log('ConexionApiService constructor called');
  }
 conectar (): Observable<any[]> {
    // Hacer la solicitud GET a la API externa
     return  this.httpClient.get<any>('http://BeefCrmApi.com/Api/hola');
     //return  this.httpClient.get<any>('https://randomuser.me/api');
  
  }
} 
 