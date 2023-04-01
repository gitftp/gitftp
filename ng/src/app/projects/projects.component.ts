import {Component, OnInit} from '@angular/core';
import {GitAccountsObject} from "../git-accounts/git-accounts.component";
import {ApiResponse, ApiService} from "../api.service";
import {HelperService} from "../helper.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-projects',
  templateUrl: './projects.component.html',
  styleUrls: ['./projects.component.scss']
})
export class ProjectsComponent implements OnInit {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
  ) {

  }

  projectId: string = '';
  project?: ProjectObject;

  ngOnInit() {
    this.activatedRoute.queryParams.subscribe(params => {
      console.log(params);
    });
    this.activatedRoute.params.subscribe((params: any) => {
      this.project = undefined;
      this.projectId = this.helper.decode(params.id);
      this.load();
    });

  }

  displayedColumns: string[] = [
    'provider',
    'username',
    'token',
    'expires',
    'client_id',
  ];

  dataSource: GitAccountsObject[] = [];
  loading: boolean = false;


  load() {
    this.loading = true;
    this.apiService.post('proj/view', {
      'project_id': this.projectId,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.loading = false;
          if (res.status) {
            console.log(res.data.project);
            this.project = res.data.project;
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
}
