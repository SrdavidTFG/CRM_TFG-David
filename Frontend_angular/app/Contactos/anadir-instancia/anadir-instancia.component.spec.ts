import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnadirInstanciaComponent } from './anadir-instancia.component';

describe('AnadirInstanciaComponent', () => {
  let component: AnadirInstanciaComponent;
  let fixture: ComponentFixture<AnadirInstanciaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AnadirInstanciaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AnadirInstanciaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
