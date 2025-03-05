import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BuscadorDisponibilidadComponent } from './buscador-disponibilidad.component';

describe('BuscadorDisponibilidadComponent', () => {
  let component: BuscadorDisponibilidadComponent;
  let fixture: ComponentFixture<BuscadorDisponibilidadComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [BuscadorDisponibilidadComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BuscadorDisponibilidadComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
