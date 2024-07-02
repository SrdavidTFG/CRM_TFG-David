import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { ReactiveFormsModule } from '@angular/forms';
import { TablaService } from '../Tablas/tabla.service';
import  sha256 from 'crypto-js/sha256';


@Component({
  standalone : true,
  selector: 'app-login',
  imports : [ReactiveFormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm!: FormGroup;

  constructor(private fb: FormBuilder, private router: Router, private authservice : AuthService,private tablaService : TablaService) { }

  ngOnInit() {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  onLogin() {
    if (this.loginForm.valid) {
      // Simula una autenticación exitosa y redirige al componente principal
      console.log('Email:', this.loginForm.value.email);
      console.log('Password:', this.loginForm.value.password);
      const pswd =sha256(this.loginForm.value.password).toString();
      this.tablaService.ValidarUsuario(this.loginForm.value.email, pswd).subscribe((resultado) => {
        // Maneja el resultado aquí
        console.log('Resultado de la validación:', resultado);
        if(resultado == 1){
          this.authservice.setLoggedIn(true); // Establece el estado de autenticación como verdadero
          this.router.navigate(['/app']);
        }
    });
    console.log('Datos invalidos');
    } else {
      console.log('Por favor completa el formulario correctamente.');
    }
  }
}
