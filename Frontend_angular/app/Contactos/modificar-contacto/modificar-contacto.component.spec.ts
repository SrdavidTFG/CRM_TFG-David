import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModificarContactoComponent } from './modificar-contacto.component';

describe('ModificarContactoComponent', () => {
  let component: ModificarContactoComponent;
  let fixture: ComponentFixture<ModificarContactoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ModificarContactoComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ModificarContactoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
