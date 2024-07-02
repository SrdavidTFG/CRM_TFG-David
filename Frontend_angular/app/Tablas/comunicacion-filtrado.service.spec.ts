import { TestBed } from '@angular/core/testing';

import { ComunicacionFiltradoService } from './comunicacion-filtrado.service';

describe('ComunicacionFiltradoService', () => {
  let service: ComunicacionFiltradoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ComunicacionFiltradoService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
