import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProjectCreateConfirmComponent } from './project-create-confirm.component';

describe('ProjectCreateConfirmComponent', () => {
  let component: ProjectCreateConfirmComponent;
  let fixture: ComponentFixture<ProjectCreateConfirmComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProjectCreateConfirmComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProjectCreateConfirmComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
