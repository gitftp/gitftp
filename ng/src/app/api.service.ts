import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {UserService} from "./user.service";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  baseUrl: string = 'http://gf.local/api/';

  constructor(
    private http: HttpClient,
    private userService: UserService,
  ) {
  }

  post(url: string, data: any, options: {} = {}): Observable<ApiResponse> {
    return new Observable((a) => {
      let headers = {
        // 'token': this.userService.getToken(),
      };
      // data = data || {};
      // data.token = this.userService.getToken();
      this.http.post(this.baseUrl + url, data, {
        // headers: headers,
      })
        .subscribe({
          next: (res) => {
            a.next(<ApiResponse>res);
          },
          error: err => {
            a.error(err);
          },
          complete: () => {
            a.complete();
          }
        });
    });
  }

  get(url: string, options: {} = {}): Observable<ApiResponse> {
    return new Observable((a) => {
      let headers = {
      };
      this.http.get(this.baseUrl + url, {
        headers: headers,
        params: {
          token: this.userService.getToken(),
        }
      })
        .subscribe({
          next: (res) => {
            a.next(<ApiResponse>res);
          },
          error: err => {
            a.error(err);
          },
          complete: () => {
            a.complete();
          }
        })
    });
  }
}


export interface ApiResponse {
  status: boolean,
  message: string,
  data: any,
  exception: {
    message: string,
    file: string,
    line: string,
    trace: string,
  },
}
