import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnadirContactoClientifyComponent } from './anadir-contacto-clientify.component';

describe('AnadirContactoClientifyComponent', () => {
  let component: AnadirContactoClientifyComponent;
  let fixture: ComponentFixture<AnadirContactoClientifyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AnadirContactoClientifyComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AnadirContactoClientifyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
