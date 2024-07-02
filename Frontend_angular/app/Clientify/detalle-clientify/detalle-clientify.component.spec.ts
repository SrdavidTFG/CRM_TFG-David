import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetalleClientifyComponent } from './detalle-clientify.component';

describe('DetalleClientifyComponent', () => {
  let component: DetalleClientifyComponent;
  let fixture: ComponentFixture<DetalleClientifyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DetalleClientifyComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(DetalleClientifyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
