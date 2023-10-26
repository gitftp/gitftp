import {Component, OnInit} from '@angular/core';
import {ApiResponse, ApiService} from "../api.service";
import {HelperService} from "../helper.service";
import {GitAccountsCreateComponent} from "../git-accounts-create/git-accounts-create.component";

@Component({
  selector: 'app-git-accounts',
  templateUrl: './git-accounts.component.html',
  styleUrls: ['./git-accounts.component.scss']
})
export class GitAccountsComponent implements OnInit {
  displayedColumns: string[] = [
    'actions',
    'provider',
    'username',
    'token',
    'expires',
    'client_id',
  ];
  dataSource: GitAccountsObject[] = [];

  constructor(
    private apiService: ApiService,
    private helper: HelperService,
  ) {
  }

  ngOnInit() {
    this.load();
    this.helper
      .setPage('git-accounts');
  }

  remove(el: GitAccountsObject) {
    let dialog = this.helper.alert({
      type: 'warning',
      message: 'Do you want to delete the oauth app',
      buttons: ['Close', 'Delete'],
    });

    dialog.afterClosed().subscribe({
      next: (btn: any) => {
        if(btn == 'Delete'){
          this._remove(el);
        }
      },
      error: () => {

      }
    })
  }

  _remove(el: GitAccountsObject){
    this.apiService.post('oauth/delete-git-accounts', el)
      .subscribe({
        next: () => {
          this.load();
        },
        error: () => {

        }
      })
  }


  loading: boolean = false;

  load() {

    this.loading = true;
    this.apiService.post('oauth/git-accounts', {})
      .subscribe({
        next: (res: ApiResponse) => {
          this.loading = false;
          if (res.status) {
            console.log(res);
            this.dataSource = res.data.accounts;
          } else {
            this.helper.alertError(res);
          }
        }, error: error => {
          this.loading = false;
          this.helper.alertError(error);
        }
      })

  }
}


export interface GitAccountsObject {
  git_username: string;
  expires?: any;
  client_id: string;
  access_token: string;
  provider_name: string;
  provider_key: string;
}
