import { TestBed } from '@angular/core/testing';

import { PeliculaTempService } from './pelicula-temp.service';

describe('PeliculaTempService', () => {
  let service: PeliculaTempService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PeliculaTempService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
