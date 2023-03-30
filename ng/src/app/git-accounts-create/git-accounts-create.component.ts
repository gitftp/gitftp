import {Component, OnInit} from '@angular/core';
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
  selector: 'app-git-accounts-create',
  templateUrl: './git-accounts-create.component.html',
  styleUrls: ['./git-accounts-create.component.scss']
})
export class GitAccountsCreateComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private fb: FormBuilder,
  ) {
    this.form = this.fb.group({
      'provider_id': ['', [Validators.required]],
      'client_id': ['cead9661bec124b3afc6', [Validators.required]],
      'client_secret': ['d3ba872e5c069fc91e3b7c7976492d5f7c94a81e', [Validators.required]],
    });
  }

  form: FormGroup;

  ngOnInit() {
    this.getProviders();
  }


  connecting: boolean = false;

  connect() {
    this.connecting = true;
    // save first then go to the connect page.
    this.apiService.post('oauth/save-oauth-app',
      this.form.value)
      .subscribe({
        next: (res: ApiResponse) => {
          this.connecting = false;
          console.log(res)
          if (res.status) {
            let user = this.helper.getUser();
            window.open('http://gf.local/api/connect?me=' + this.helper.encode(res.data.app_id) + '&token=' + user.token, '_empty_');
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.connecting = false;
          this.helper.alertError(err);
        }
      });
  }

  selectedProvider?: GitProviderObject;

  providerChanged() {
    console.log('what');
    console.log(this.form.value);
    let providerId = this.form?.get('provider_id')?.value;
    for (let p of this.providers) {
      console.log(providerId);
      if (p.provider_id == providerId) {
        this.labels['label1'] = p.provider_param_1_name;
        this.labels['label2'] = p.provider_param_2_name;
        console.log(p)
        this.selectedProvider = p;
      }
    }
  }

  providers: GitProviderObject[] = [];
  gettingProviders: boolean = false;
  labels: any = {};

  getProviders() {
    this.gettingProviders = true;
    this.apiService.post('oauth/all-providers', {})
      .subscribe({
        next: (res: ApiResponse) => {
          console.log(res);
          if (res.status) {
            this.providers = res.data.providers;
          } else {
            this.helper.alert({
              message: res.message,
              exception: res.exception,
              type: 'Error',
            });
          }
        },
        error: err => {
          this.helper.alert({
            message: err,
            type: 'Error',
          });
        }
      })
  }

}

export interface GitProviderObject {
  provider_id: number;
  provider_key: string;
  provider_name: string;
  provider_param_1_name: string;
  provider_param_2_name: string;
}
