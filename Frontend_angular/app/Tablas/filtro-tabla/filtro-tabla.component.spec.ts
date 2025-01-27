import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FiltroTablaComponent } from './filtro-tabla.component';

describe('FiltroTablaComponent', () => {
  let component: FiltroTablaComponent;
  let fixture: ComponentFixture<FiltroTablaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FiltroTablaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(FiltroTablaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
