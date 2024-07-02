import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientifyComponent } from './clientify.component';

describe('ClientifyComponent', () => {
  let component: ClientifyComponent;
  let fixture: ComponentFixture<ClientifyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ClientifyComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ClientifyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
