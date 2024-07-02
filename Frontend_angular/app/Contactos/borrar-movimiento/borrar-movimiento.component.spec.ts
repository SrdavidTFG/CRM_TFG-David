import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BorrarMovimientoComponent } from './borrar-movimiento.component';

describe('BorrarMovimientoComponent', () => {
  let component: BorrarMovimientoComponent;
  let fixture: ComponentFixture<BorrarMovimientoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BorrarMovimientoComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(BorrarMovimientoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
