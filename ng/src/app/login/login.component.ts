import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ApiResponse, ApiService} from "../api.service";
import {HelperService, UserToken} from "../helper.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss',
    './../setup/setup.component.scss']
})
export class LoginComponent implements OnInit {
  constructor(
    // private updateMi
    private fb: FormBuilder,
    private api:ApiService,
    private helper: HelperService,
    private router: Router,
  ) {
    this.form = this.fb.group({
      'email': ['bonifacepereira@gmail.com', [Validators.required, Validators.email]],
      'password': ['asdasdasd', [Validators.required]]
    });
    let user = this.helper.getUser();
    if(user.token){
      this.router.navigate(['/']);
    }
  }

  form: FormGroup;

  ngOnInit() {

  }

  submitting: boolean = false;
  submit(){
    if(this.form?.invalid){
      this.form.markAllAsTouched();
      return;
    }

    this.submitting = true;
    this.api.post('auth/login', this.form?.value)
      .subscribe({
        next: (res: ApiResponse) => {
          this.submitting = false;
          console.log(res);
          if(res.status){
            let user: UserToken = res.data;
            this.helper.setUser(user);
            this.router.navigate(['home']);
          }else{
            this.helper.alert({
              message: res.message,
              exception: res.exception,
            });
          }
        },
        error: err => {
          this.submitting = false;
          this.helper.alert({
            message: err,
          })
        },
      })

  }


}


