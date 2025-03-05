import { TestBed } from '@angular/core/testing';
import { OpinionesPeliculasService } from './opiniones-peliculas.service';


describe('OpinionesPeliculasService', () => {
  let service: OpinionesPeliculasService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(OpinionesPeliculasService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
