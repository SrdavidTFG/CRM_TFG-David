import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CabeceralistaComponent } from './cabeceralista.component';

describe('CabeceralistaComponent', () => {
  let component: CabeceralistaComponent;
  let fixture: ComponentFixture<CabeceralistaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CabeceralistaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CabeceralistaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
