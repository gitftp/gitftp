import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable, Subscriber} from "rxjs";
import {HelperService} from "./helper.service";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  baseUrl: string = window.location.origin + '/api/';
  constructor(
    private http: HttpClient,
    private helper: HelperService,
  ) {
  }

  getRevisions(projectId: string, branchName: string): Observable<any> {
    return new Observable((a: Subscriber<any>) => {
      this.post('repo/revisions', {
        project_id: projectId,
        branch_name: branchName,
      })
        .subscribe({
          next: (res: ApiResponse) => {
            if (res.status) {
              a.next(res.data.revisions);
            } else {
              this.helper.alertError(res);
            }
          }, error: (e: any) => {
            console.error(e);
            a.error(e);
          },
          complete: () => {
            a.complete();
          }
        });
    })
  }


  post(url: string, data: any, options: {} = {}): Observable<ApiResponse> {
    return new Observable((a) => {
      let headers = {
        // 'token': this.userService.getToken(),
      };
      data = data || {};
      data.token = this.helper.getUser()?.token;
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
      let headers = {};
      this.http.get(this.baseUrl + url, {
        headers: headers,
        params: {
          token: this.helper.getUser()?.token,
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
