import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BrowseServerComponent } from './browse-server.component';

describe('BrowseServerComponent', () => {
  let component: BrowseServerComponent;
  let fixture: ComponentFixture<BrowseServerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BrowseServerComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BrowseServerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
