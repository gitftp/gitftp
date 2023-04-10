import {Component, OnInit} from '@angular/core';
import {ProjectObject} from "../project/project.component";
import {HelperService} from "../helper.service";
import {ApiResponse, ApiService} from "../api.service";
import {ServerObject} from "../project/servers/servers.component";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute} from "@angular/router";

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

  }

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

  onChangeType() {
    if (this.form.get('type')?.value == 'fresh') {
      this.getLatestRevision();
    }
    if (this.form.get('type')?.value == 'deploy') {

    }
  }

  loading: boolean = false;

  getLatestRevision() {
    this.loading = true;
    this.apiService.post('servers/list', {
      server_id: this.serverId
    })
      .subscribe({
        next: (res: ApiResponse) => {
          if (res.status) {
            console.log(res);

          } else {
            this.helper.alertError(res.message);
          }
        }, error: err => {
          this.helper.alertError(err);
        },
      })
  }

}
