import {Component} from '@angular/core';
import {ApiService} from "../../api.service";
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
    // this.helper.setPage('project' + this.projectId);
    this.helper.setPage('project' + this.projectId + 'servers');
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

}
