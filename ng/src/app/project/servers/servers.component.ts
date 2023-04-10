import {Component} from '@angular/core';
import {ApiResponse, ApiService} from "../../api.service";
import {AppEvent, HelperService} from "../../helper.service";
import {ActivatedRoute} from "@angular/router";
import {ProjectObject} from "../project.component";

@Component({
  selector: 'app-servers',
  templateUrl: './servers.component.html',
  styleUrls: ['./servers.component.scss']
})
export class ServersComponent {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
  ) {

  }

  encode(a: string) {
    return this.helper.encode(a);
  }

  set setChildData(a: any) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId + 'servers');

    this.getServers();
  };

  projectId: string = '';
  project?: ProjectObject;

  ngOnInit() {
    // this.helper.appEvents.subscribe((e: AppEvent) => {
    //   if (e.name == 'projectLoad') {
    //     this.project = e.data.project;
    //     this.projectId = e.data.projectId;
    //     console.log('load servers');
    //   }
    // });
  }

  displayedColumns: string[] = [
    'action',
    'server_name',
    'branch',
    'r',
    'type',
    'host',
    'auto_deploy',
    'revision',
  ];

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
}


export interface ServerObject {
  server_id: number;
  server_name: string;
  project_id: number;
  branch: string;
  type: number;
  secure: number;
  host: string;
  port: string;
  username: string;
  password: string;
  path: string;
  key_id: number;
  created_by: number;
  auto_deploy: number;
  created_at: string;
  updated_at?: any;
  revision: string;
}
