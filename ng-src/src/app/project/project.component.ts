import {Component, OnInit} from '@angular/core';
import {GitAccountsObject} from "../git-accounts/git-accounts.component";
import {ApiResponse, ApiService} from "../api.service";
import {HelperService} from "../helper.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.scss']
})
export class ProjectComponent implements OnInit {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
  ) {

  }

  projectId: string = '';
  project?: ProjectObject;
  page: string = '';

  currentChild?: any;

  pageChanged(e: any) {
    this.currentChild = e;
    if (this.project) {
      this.currentChild.setChildData = {
        project: this.project,
        projectId: this.projectId,
      };
    }
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe((params: any) => {
      let page = this.page = params.page || 'go';
      if (params.id && this.projectId != this.helper.decode(params.id)) {
        this.project = undefined;
        this.projectId = this.helper.decode(params.id);
        this.load();
      }
    });
  }

  loading: boolean = false;
  load() {
    this.loading = true;
    this.apiService.post('get-project', {
      'project_id': this.projectId,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.loading = false;
          if (res.status) {
            // console.log(res.data.project);
            this.project = res.data.project;
            if (this.project) {
              this.currentChild.setChildData = {
                project: this.project,
                projectId: this.projectId,
              };
            }
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



export interface ProjectObject {
	project_id: number;
	account_id: number;
	name: string;
	repo_name?: any;
	path: string;
	uri: string;
	clone_url: string;
	git_uri: string;
	git_username: string;
	git_name: string;
	git_id: string;
	sh_name?: any;
	hook_id?: any;
	user_id: number;
	provider?: any;
	created_at: string;
	created_by: number;
	clone_state?: any;
	pull_state?: any;
	last_updated?: any;
	status?: any;
	deploy_pid?: any;
	provider_id: number;
	connect_url?: any;
	provider_key: string;
	provider_name: string;
	provider_param_1_name: string;
	provider_param_2_name: string;
	clone_dir: string;
}
