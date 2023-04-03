import {Component} from '@angular/core';
import {ProjectObject} from "../../project.component";
import {ApiResponse, ApiService} from "../../../api.service";
import {HelperService} from "../../../helper.service";
import {ActivatedRoute} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {MatDialog} from "@angular/material/dialog";
import {BrowseServerComponent} from "../browse-server/browse-server.component";

@Component({
  selector: 'app-server-create',
  templateUrl: './server-create.component.html',
  styleUrls: ['./server-create.component.scss',]
})
export class ServerCreateComponent {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
    private fb: FormBuilder,
    private dialog: MatDialog,
  ) {

    this.form = this.fb.group({
      'server_name': ['', [Validators.required]],
      'branch': ['', [Validators.required]],
      'type': ['local', [Validators.required]],
      'secure': ['', []],
      'host': ['', []],
      'port': ['', []],
      'username': ['', []],
      'password': ['', []],
      'path': ['', []],
      'key_id': ['', []],
      'auto_deploy': ['', []],
      'revision': ['', []],
    })
  }

  form: FormGroup;

  encode(a: string) {
    return this.helper.encode(a);
  }

  set setChildData(a: any) {
    this.projectId = a.projectId;
    this.project = a.project;
    // this.helper.setPage('project' + this.projectId);
    this.helper.setPage('project' + this.projectId + 'servers');
    this.getBranches();
  };

  projectId: string = '';
  project?: ProjectObject;

  ngOnInit() {
  }

  branches: string[] = [];
  // branches: Branch
  gettingBranches: boolean = false;

  getBranches() {
    this.gettingBranches = true;
    console.log(this.projectId);
    this.apiService.post('repo/get-branches', {
      project_id: this.projectId,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.gettingBranches = false;
          console.log(res);
          if (res.status) {
            this.branches = res.data.branches;
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.gettingBranches = false;
          this.helper.alertError(err);
        }
      })
  }

  browseDir() {
    this.dialog.open(BrowseServerComponent, {
      data: {
        server: <ServerObject>this.form.value,
      }
    })
      .afterClosed().subscribe({
      next: r => {
        if(r){
          this.form.get('path')?.setValue(r);
        }
      }
    })
  }
}

export interface ServerObject{
  server_name: string,
  branch: string,
  type: string,
  secure: string,
  host: string,
  port: string,
  username: string,
  password: string,
  path: string,
  key_id: string,
  auto_deploy: string,
  revision: string,
}
