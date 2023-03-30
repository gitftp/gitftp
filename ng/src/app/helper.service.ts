import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {MatDialog} from "@angular/material/dialog";
import {AlertComponent} from "./components/alert/alert.component";
import {ApiResponse} from "./api.service";

@Injectable({
  providedIn: 'root'
})
export class HelperService {
  constructor(
    private dialog: MatDialog,
  ) {

  }

  encode(a: any){
    a = encodeURIComponent(a);
    a = btoa(a);
    a = a.replace(/=/ig, '');
    return a;
  }

  decode(a: any){
    a = atob(a);
    a = decodeURIComponent(a);
    return a;
  }

  // ive decided to write user service stuff here


  isUserLoggedIn() {
    let user = this.getUser();
    return !!user.token;
  }

  getUser(): UserToken {
    let user: UserToken = JSON.parse(localStorage.getItem(this.localStorageName) || '{}');
    return user;
  }

  localStorageName: string = 'gf.user';

  setUser(user: UserToken) {
    localStorage.setItem(this.localStorageName, JSON.stringify(user));
  }

  alertError(r: any) {
    if (typeof r == 'string') {
      console.warn(r);
      if (r.substring(0, 1) == '{') {
        console.log('in!');
      }
    } else {
      if (!r.status) {
        this.alert({
          message: r.message,
          exception: r.exception || '',
          type: r.status ? 'Success' : 'Error',
        });
      }
    }

  }

  alert(options: AlertOptions) {
    return this.dialog.open(AlertComponent, {
      data: options,
    });
  }

}

export interface AlertOptions {
  message: string,
  exception?: {
    message: string,
    file: string,
    line: string,
    trace: string,
  } | string,
  type?: string,
}


export interface UserToken {
  token: string;
  user: User;
}

export interface User {
  user_id: number;
  email: string;
  last_login: string;
}
