import {Component, OnInit} from '@angular/core';
import {ProjectObject} from "../project/project.component";
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {ServerObject} from "../project/servers/servers.component";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute} from "@angular/router";
import {DeployModule} from "./deploy.module";

@Component({
  selector: 'app-deploy',
  templateUrl: './deploy.component.html',
  styleUrls: ['./deploy.component.scss']
})
export class DeployComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private fb: FormBuilder,
    private activatedRoutes: ActivatedRoute,
  ) {

    this.form = this.fb.group({
      'server_id': ['', [Validators.required]],
      'type': ['', [Validators.required]],
    });
  }

  form: FormGroup;

  set setChildData(a: any) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId + 'servers');

    this.activatedRoutes.params.subscribe({
      next: (a: any) => {
        let id = this.helper.decode(a.id);
        this.serverId = id;
        this.form.get('server_id')?.setValue(parseInt(this.serverId));

        // console.log('asd')
        this.onChangeType();
      }
    });
    this.getServers();
  };

  projectId: string = '';
  project?: ProjectObject;

  serverId: string = '';

  servers: ServerObject[] = [];
  gettingServers: boolean = false;

  getServers() {
    this.gettingServers = true;
    this.apiService.post('servers/list', {
      project_id: this.projectId
    }).subscribe({
      next: (res: ApiResponse) => {
        // console.log(res);
        this.gettingServers = false;
        if (res.status) {
          this.servers = res.data.servers;
          console.log(this.servers, res);
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.gettingServers = false;
        this.helper.alertError(err);
      }
    })
  }

  ngOnInit() {
    this.form.get('type')?.valueChanges.subscribe((a: any) => {
      this.onChangeType();
    });
  }

  type: string = '';

  getSelectedBranch() {
    let sid = this.form.get('server_id')?.value;
    // console.log(sid)
    let f: ServerObject | undefined;
    for (let s of this.servers) {
      if (s.server_id == sid) {
        f = s;
        break;
      }
    }
    return f;
  }

  onChangeType(o: boolean = false) {
    if (this.form.get('type')?.value == this.type && !o)
      return;

    if (this.form.get('type')?.value == 'fresh') {
      this.getLatestCommit();
    }
    if (this.form.get('type')?.value == 'deploy') {

    }
    this.type = this.form.get('type')?.value;
  }

  latestCommits: CommitObject[] = [];
  loadingLatestCommit: boolean = false;

  getLatestCommit() {
    this.loadingLatestCommit = true;
    this.apiService.post('repo/git/commits', {
      project_id: this.projectId,
      branch: this.getSelectedBranch()?.branch,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.loadingLatestCommit = false;
          console.log(res);
          if (res.status) {
            this.latestCommits = res.data.commits;
          } else {
            this.helper.alertError(res.message);
          }
        }, error: err => {
          this.loadingLatestCommit = false;
          this.helper.alertError(err);
        },
      })
  }

  deploying: boolean = false;

  public freshDeploy() {

    this.deploying = true;
    this.apiService.post('repo/deploy/fresh', {})
      .subscribe({
        next: (res: ApiResponse) => {
          this.deploying = false;
          if (res.status) {

          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.deploying = false;
          this.helper.alertError(err);
        }
      })
  }
}


export interface CommitObject {
  sha: string;
  message: string;
  author_avatar: string;
  author: string;
  time: string;
}
