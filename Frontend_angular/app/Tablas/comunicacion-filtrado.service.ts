import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ComunicacionFiltradoService {
  private tableDataSubject = new BehaviorSubject<any[]>([]);
  tableData$ = this.tableDataSubject.asObservable();
  constructor() { }

  actualizarTablaData(nuevosDatos: any[]) {
    this.tableDataSubject.next(nuevosDatos);
  }
}
