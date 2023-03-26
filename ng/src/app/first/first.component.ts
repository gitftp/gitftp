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
    this.api.post('auth/check', {})
      .subscribe((res: ApiResponse) => {
        if(res.status){
          let next = res.data.nextPage;
          switch(next){
            case 'setup':
              this.router.navigate(['auth', 'setup']);
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
