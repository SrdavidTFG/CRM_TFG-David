import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnadirVentanaMovimientosComponent } from './anadir-ventana-movimientos.component';

describe('AnadirVentanaMovimientosComponent', () => {
  let component: AnadirVentanaMovimientosComponent;
  let fixture: ComponentFixture<AnadirVentanaMovimientosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AnadirVentanaMovimientosComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AnadirVentanaMovimientosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
