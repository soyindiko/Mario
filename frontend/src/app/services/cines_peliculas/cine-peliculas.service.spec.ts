import { TestBed } from '@angular/core/testing';

import { CinePeliculasService } from '../../cine-peliculas.service';

describe('CinePeliculasService', () => {
  let service: CinePeliculasService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CinePeliculasService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
