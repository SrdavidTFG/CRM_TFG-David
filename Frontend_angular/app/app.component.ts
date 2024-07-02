import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { Router, NavigationEnd } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AuthService } from './auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterLink, RouterLinkActive,HttpClientModule, CommonModule],
  providers:[HttpClient],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'Crm David';
  isLandingPage: boolean = false;
  isLogged = false;
  storedIsLogged :any;
  constructor(private router: Router, private route: ActivatedRoute,private authService: AuthService) {
    
  }

  ngOnInit(): void {
    this.storedIsLogged = sessionStorage.getItem('isLogged');
    this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd) {
        this.isLandingPage = this.router.url === '/app';
      }else{
        this.isLandingPage=false;
      }
    });
    this.authService.isLoggedIn$.subscribe(isLogged => {
      this.isLogged = isLogged;
    });
    this.route.queryParams.subscribe(params => {
      this.isLogged = params['islogged'] === 'true';
      sessionStorage.setItem('isLogged', this.isLogged.toString());
      console.log('isLogged:', this.isLogged);
    });

  }
  nolanding(){
    this.isLandingPage = false;
  }
}
