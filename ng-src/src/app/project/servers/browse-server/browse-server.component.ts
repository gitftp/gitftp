import {Component, Inject, OnInit} from '@angular/core';
import {HelperService} from "../../../helper.service";
import {ApiResponse, ApiService} from "../../../api.service";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ServerObject} from "../server-create/server-create.component";

@Component({
  selector: 'app-browse-server',
  templateUrl: './browse-server.component.html',
  styleUrls: ['./browse-server.component.scss']
})
export class BrowseServerComponent implements OnInit {
  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    public dialogRef: MatDialogRef<any>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {
    this.server = this.data.server;
    this.path = this.server.path;
    this.projectId = this.data.project_id;
  }

  server: ServerObject;
  path: string = '';
  projectId: string = '';

  ngOnInit() {
    this.call();
  }

  submit() {
    this.dialogRef.close(this.path);
  }

  callTI: any;

  callT() {
    if (this.callTI) {
      clearTimeout(this.callTI);
      this.callTI = false;
    }
    this.callTI = setTimeout(() => {
      this.call();
    }, 400);
  }

  gotoPath(a: ServerBrowseFileObject) {
    if (a.type == 'dir') {
      this.path = a.path;
      this.call();
    }
  }

  goBack() {
    let a = '../'
    if (this.path) {
      if (this.path.charAt(this.path.length - 1) != '/')
        this.path += '/';
      console.log(this.path);
      if (this.path.substring(this.path.length - 3) == '../') {
        a = this.path + a;
        // this.path = a;
      } else {
        if (this.path.charAt(this.path.length - 1) == '/') {
          a = this.path.substring(0, this.path.length - 1);
        }
        a = a.substring(0, a.lastIndexOf('/') + 1);
      }
    }
    this.path = a;
  }

  files: ServerBrowseFileObject[] = [];
  error: string = '';
  calling: boolean = false;
  projRoot: boolean = false;
  message: string = '';

  call(writeTest: boolean = false, pass = false) {
    this.error = '';
    let ser = Object.assign({}, this.server);
    ser.path = this.path;
    this.calling = true;
    if (writeTest && !pass) {
      // if (!confirm("")) {
      //   return;
      // }
      let dialog = this.helper.alert({
        message: 'Gitftp will attempt to write & delete gitftp-write-test.txt file on this path',
        type: 'alert',
        buttons: ['Close', 'Confirm'],
      });
      dialog.afterClosed().subscribe({
        next: (a: any) => {
          if(a == 'Confirm'){
            this.call(true, true);
          }
        }
      })
      return;
    }
    this.projRoot = false
    this.message = '';
    this.apiService.post('server/test', {
      payload: ser,
      write_test: writeTest,
      project_id: this.projectId
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.calling = false;
          console.log(res);
          if (res.status) {
            this.message = res.message;
            this.files = res.data.list.map((a: any) => {
              if (a.path.indexOf('gitftp.md') != -1) {
                this.projRoot = true;
              }
              a.file_size = this.helper.bytes(a.file_size, 1);
              return a;
            });

          } else {
            this.error = res.message;
          }

        },
        error: err => {
          this.calling = false;
          this.helper.alertError(err);
        }
      });
  }
}

export interface ServerBrowseFileObject {
  type: string;
  path: string;
  file_size: number;
  visibility: string;
  last_modified: number;
  mime_type?: any;
  extra_metadata: any[];
}
