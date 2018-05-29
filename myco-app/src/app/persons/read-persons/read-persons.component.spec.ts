import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReadPersonsComponent } from './read-persons.component';

describe('ReadPersonsComponent', () => {
  let component: ReadPersonsComponent;
  let fixture: ComponentFixture<ReadPersonsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReadPersonsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReadPersonsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
