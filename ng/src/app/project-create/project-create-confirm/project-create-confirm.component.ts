import {Component, Inject, OnInit, Optional} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {RepoObject} from "../project-create.component";
import {HelperService} from "../../helper.service";
import {ApiResponse, ApiService} from "../../api.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-project-create-confirm',
  templateUrl: './project-create-confirm.component.html',
  styleUrls: ['./project-create-confirm.component.scss']
})
export class ProjectCreateConfirmComponent implements OnInit {
  constructor(
    public dialogRef: MatDialogRef<any>,
    //@Optional() is used to prevent error if no data is passed
    @Optional() @Inject(MAT_DIALOG_DATA) public data: {
      repo: RepoObject,
    },
    private helper: HelperService,
    private apiService: ApiService,

    private router: Router,
  ) {

  }

  projectName: string = '';

  ngOnInit() {
    this.projectName = this.data.repo.full_name;
    this.getBranches();
  }

  creating: boolean = false;

  create() {
    this.creating = true;
    this.dialogRef.disableClose = true;

    this.apiService.post('proj/create', {
      'repo': this.data.repo,
      'project_name': this.projectName,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.creating = false
          this.dialogRef.disableClose = false;
          if (res.status) {
            this.router.navigate([
              'project',
              this.helper.encode(res.data.project_id),
            ]);
            this.helper.emit({
              name: 'projectCreate',
              data: {
                id: res.data.project_id,
              }
            });
            this.dialogRef.close();
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.creating = false;
          this.dialogRef.disableClose = false;
          this.helper.alertError(err);
        }
      })
  }

  gettingBranches: boolean = false;
  branches: string[] = [];

  getBranches() {
    this.gettingBranches = true;
    this.apiService.post('repo/get-branches', {
      account_id: this.data.repo.account_id,
      full_name: this.data.repo.full_name,
    })
      .subscribe({
        next: (res: ApiResponse) => {
          this.gettingBranches = false;
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
}
