import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CrearEstructuraTipoDeMovimientoComponent } from './crear-estructura-tipo-de-movimiento.component';

describe('CrearEstructuraTipoDeMovimientoComponent', () => {
  let component: CrearEstructuraTipoDeMovimientoComponent;
  let fixture: ComponentFixture<CrearEstructuraTipoDeMovimientoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CrearEstructuraTipoDeMovimientoComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CrearEstructuraTipoDeMovimientoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
