import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GitAccountsCreateComponent } from './git-accounts-create.component';

describe('GitAccountsCreateComponent', () => {
  let component: GitAccountsCreateComponent;
  let fixture: ComponentFixture<GitAccountsCreateComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ GitAccountsCreateComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GitAccountsCreateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
