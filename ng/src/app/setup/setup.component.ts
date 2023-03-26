import {Component, OnInit} from '@angular/core';
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoginComponent} from "../login/login.component";

@Component({
  selector: 'app-setup',
  templateUrl: './setup.component.html',
  styleUrls: ['./setup.component.scss']
})
export class SetupComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private fb: FormBuilder,
  ) {

  }

  ngOnInit() {
    this.depsCheck();
    this.prepareDatabaseForm();
    this.prepareUserForm();
  }

  dbForm!: FormGroup;

  // page: string = 'deps';
  page: string = 'user';

  prepareDatabaseForm() {
    this.dbForm = this.fb.group({
      host: ['localhost', [Validators.required]],
      username: ['root', [Validators.required]],
      password: ['root', []],
      database: ['gf2', [Validators.required]],
      port: ['3306', [Validators.required]],
    });
  }

  userForm!: FormGroup;

  prepareUserForm() {
    this.userForm = this.fb.group({
      'email': ['asd@asd.com', [Validators.email, Validators.required]],
      'password': ['asdasdasd', [Validators.required, Validators.minLength(3)]],
      'confirm_password': ['asdasdasd', [Validators.required, Validators.minLength(3)]]
    });
  }

  setupLoading: boolean = false;
  setupProgress: string = '';

  setupSubmit() {
    if (this.userForm.invalid) {
      this.userForm.markAllAsTouched();
      return;
    }

    let userValues = this.userForm.value;
    if (userValues.password != userValues.confirm_password) {
      this.helper.alert({
        message: 'The password does not match, please try again',
        type: 'error',
      })
      return;
    }

    this.setupProgress = 'Creating config file';
    this.setupLoading = true;
    this.userForm.disable();
    this.apiService.post('auth/save-setup', {
      user: this.userForm.value,
      database: this.dbForm.value,
    }).subscribe({
      next: (res: ApiResponse) => {
        if (res.status) {
          // setup was saved
          this.setupProgress = 'Running database Migrate';
          this.apiService.post('auth/init-setup', {
            user: this.userForm.value,
          })
            .subscribe({
              next: (res: ApiResponse) => {
                if (res.status) {
                  this.setupProgress = 'Creating admin user';
                  setTimeout(() => {
                    this.helper.alert({
                      message: 'Yesss!'
                    });
                  }, 1000);
                  this.setupLoading = false;
                } else {
                  this.userForm.enable();
                  this.setupProgress = '';
                  this.setupLoading = false;
                  this.helper.alert({
                    message: res.message,
                    exception: res.exception,
                    type: 'error',
                  })
                }
              },
              error: (err) => {
                this.userForm.enable();
                this.setupProgress = '';
                this.setupLoading = false;
                this.helper.alert({
                  message: err,
                  type: 'error',
                })
              }
            })
        } else {
          this.userForm.enable();
          this.setupProgress = '';
          this.setupLoading = false;
          this.helper.alert({
            message: res.message,
            exception: res.exception,
            type: 'error'
          });

        }
      },
      error: (err) => {
        this.userForm.enable();
        this.setupProgress = '';
        this.setupLoading = false;
        this.helper.alert({
          message: err,
          type: 'error'
        });
      }
    })
  }


  testingDbConnection: boolean = false;
  dbError: string = '';

  dbMsg: string = '';

  testDbConnection() {
    if (this.dbForm.invalid) {
      this.dbForm?.markAllAsTouched();
      return;
    }
    this.testingDbConnection = true;
    this.dbError = '';
    this.dbMsg = '';
    this.apiService.post('auth/db-test', this.dbForm?.value)
      .subscribe({
        next: (res) => {
          if (res.status) {
            setTimeout(() => {
              this.testingDbConnection = false;
              this.page = 'user';
            }, 1000);
            this.dbMsg = 'Successfully connected to mysql server';
            this.dbForm.disable();
          } else {
            this.testingDbConnection = false;
            this.helper.alert({
              message: res.message,
              exception: res.exception,
              type: 'error',
            });
          }
        },
        error: err => {
          this.testingDbConnection = false;
          this.helper.alert({
            message: 'Network error',
            type: 'error',
          });
        }
      })
  }

  deps: any;

  checkingDeps: boolean = false

  depsCheck() {
    this.checkingDeps = true;
    this.apiService.post('auth/deps', {})
      .subscribe({
        next: (res) => {
          this.checkingDeps = false;
          this.deps = res.data;
        },
        error: (err) => {
          this.checkingDeps = false;
          this.helper.alert({
            message: err,
            type: 'error'
          });
        }
      })
  }

}

export interface DepsResponse {
  git?: string[];
  php?: string[];
  os?: string;
  status?: boolean;
}
