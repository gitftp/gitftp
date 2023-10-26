import {Component, OnInit} from '@angular/core';
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-first',
  templateUrl: './first.component.html',
  styleUrls: ['./first.component.scss']
})
export class FirstComponent implements OnInit {
  constructor(
    private api: ApiService,
    private helper: HelperService,
    private router: Router,
  ) {

  }

  ngOnInit() {
    let user = this.helper
      .getUser();

    this.api.post('auth/check', {
      token: user.token,
    })
      .subscribe((res: ApiResponse) => {
        if(res.status){
          let next = res.data.nextPage;
          switch(next){
            case 'setup':
              this.router.navigate(['auth', 'setup']);
              break;
            case 'login':
              this.router.navigate(['auth', 'login']);
              break;
            case 'home':
              this.router.navigate(['home']);
              break;
          }
          console.log(res.data)
        }else{
          this.helper.alert({
            message: res.message,
            exception: res.exception,
          })
        }
      });
  }

}
