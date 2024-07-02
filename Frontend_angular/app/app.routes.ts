import { Routes } from '@angular/router';
import { AppComponent} from './app.component';
import { LoginComponent } from './login/login.component';
import {ContactosComponent} from './Contactos/contactos/contactos.component';
import {UsuariosComponent} from './Usuarios/usuarios/usuarios.component';
import { CabeceraComponent } from './Tablas/detalle-contacto/cabecera/cabecera.component';
import { ClientifyComponent } from './Clientify/clientify/clientify.component';
import { FiltroTablaComponent } from './Tablas/filtro-tabla/filtro-tabla.component';

export const routes: Routes = [
    {path: '', component:LoginComponent},
    {path: 'app', component:AppComponent},
    {path: 'app-contactos', component:ContactosComponent},
    {path: 'app-usuarios', component: UsuariosComponent},
    {path: 'app-cabecera', component: CabeceraComponent},
    {path: 'app-clientify', component: ClientifyComponent},
    {path: 'app-filtro-tabla', component: FiltroTablaComponent}
];
