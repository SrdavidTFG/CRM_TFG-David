import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditarInstanciaComponent } from './editar-instancia.component';

describe('EditarInstanciaComponent', () => {
  let component: EditarInstanciaComponent;
  let fixture: ComponentFixture<EditarInstanciaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EditarInstanciaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(EditarInstanciaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
