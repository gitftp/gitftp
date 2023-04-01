import {Component, OnInit} from '@angular/core';
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {FormBuilder, FormGroup} from "@angular/forms";
import {MatDialog} from "@angular/material/dialog";
import {ProjectCreateConfirmComponent} from "./project-create-confirm/project-create-confirm.component";

@Component({
  selector: 'app-project-create',
  templateUrl: './project-create.component.html',
  styleUrls: ['./project-create.component.scss']
})
export class ProjectCreateComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private fb: FormBuilder,
    private dialog: MatDialog,
  ) {


  }

  ngOnInit() {
    this.loadRepos();
  }

  create(selectedRepo: RepoObject) {
    let dialog = this.dialog.open(ProjectCreateConfirmComponent, {
      data: {
        repo: selectedRepo
      }
    });
    dialog.afterClosed().subscribe({
      next: v => {
        console.log(v);
      },
    })
    return dialog;
  }

  loading: boolean = false;

  repos: RepoObject[] = [];
  filterTerm: string = '';

  getFilteredRepos() {
    return this.repos.filter((a) => {
      return a.full_name.toLowerCase().indexOf(this.filterTerm.toLowerCase()) != -1;
    })
  }

  loadRepos() {
    this.loading = true;
    this.apiService.post('repo/get-all', {})
      .subscribe({
        next: (res: ApiResponse) => {
          this.loading = false;
          if (res.status) {
            this.repos = res.data.repos.map((a: RepoObject) => {
              a.size = this.helper.bytes(a.size, 2);
              return a;
            });
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.loading = false;
          this.helper.alertError(err);
        },
      })
  }
}

export interface RepoObject {
  id: number;
  name: string;
  full_name: string;
  repo_url: string;
  api_url: string;
  clone_url: string;
  size: number | string;
  provider: string;
  account_id: string;
}
