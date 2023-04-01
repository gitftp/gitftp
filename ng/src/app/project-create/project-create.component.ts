import {Component, OnInit} from '@angular/core';
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {FormBuilder, FormGroup} from "@angular/forms";

@Component({
  selector: 'app-project-create',
  templateUrl: './project-create.component.html',
  styleUrls: ['./project-create.component.scss']
})
export class ProjectCreateComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private fb: FormBuilder
  ) {

    // this.form = this.fb.group({
    //   'repo_id': ['']
    // });
  }

  ngOnInit() {
    this.loadRepos();
  }

  loading: boolean = false;

  loadRepos() {
    this.loading = true;
    this.apiService.post('repo/get-all', {})
      .subscribe({
        next: (res: ApiResponse) => {
          console.log(res)
          if (res.status) {
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.helper.alertError(err);
        },
      })
  }
}

