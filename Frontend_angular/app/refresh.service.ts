import { Injectable } from '@angular/core';
import { Subject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RefreshService {
  private hasRefreshed = false;

  constructor() {
    const refreshed = sessionStorage.getItem('hasRefreshed');
    this.hasRefreshed = refreshed === 'true';
  }

  shouldRefreshPage(): boolean {
    console.log("hola");
    return !this.hasRefreshed;
  }

  markAsRefreshed() {
    this.hasRefreshed = true;
    sessionStorage.setItem('hasRefreshed', 'true');
  }
}
