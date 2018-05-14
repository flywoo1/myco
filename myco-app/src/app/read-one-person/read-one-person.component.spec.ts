import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReadOnePersonComponent } from './read-one-person.component';

describe('ReadOnePersonComponent', () => {
  let component: ReadOnePersonComponent;
  let fixture: ComponentFixture<ReadOnePersonComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReadOnePersonComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReadOnePersonComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
