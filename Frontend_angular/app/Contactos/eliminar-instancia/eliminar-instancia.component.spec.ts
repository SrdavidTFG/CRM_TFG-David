import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EliminarInstanciaComponent } from './eliminar-instancia.component';

describe('EliminarInstanciaComponent', () => {
  let component: EliminarInstanciaComponent;
  let fixture: ComponentFixture<EliminarInstanciaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EliminarInstanciaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(EliminarInstanciaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
