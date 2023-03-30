import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GitAccountsComponent } from './git-accounts.component';

describe('GitAccountsComponent', () => {
  let component: GitAccountsComponent;
  let fixture: ComponentFixture<GitAccountsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ GitAccountsComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GitAccountsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
