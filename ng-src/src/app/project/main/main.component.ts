import {Component, OnInit} from '@angular/core';
import {AppEvent, HelperService} from "../../helper.service";
import {ActivatedRoute} from "@angular/router";
import {ApiResponse, ApiService} from "../../api.service";
import {ProjectObject} from "../project.component";
import {RepoService} from "../../repo.service";

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})
export class MainComponent implements OnInit {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
    private repo: RepoService,
  ) {

  }

  set setChildData(a: any) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId);
  };

  projectId: string = '';
  project?: ProjectObject;

  ngOnInit() {
    // this.helper.appEvents.subscribe((e: AppEvent) => {
    //   if (e.name == 'projectLoad') {
    //     this.project = e.data.project;
    //     this.projectId = e.data.projectId;
    //     console.log('load main')
    //   }
    // });
  }

  clone() {
    this.repo.requestDeploy({
      projectId: this.projectId,
      type: 'clone',
    })
      .subscribe({
        next: (res: ApiResponse) => {
          console.log(res)
        },
        error: err => {
          console.log(err)
        },
      })
  }

}
