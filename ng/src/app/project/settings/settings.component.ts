import {Component} from '@angular/core';
import {ApiService} from "../../api.service";
import {AppEvent, HelperService} from "../../helper.service";
import {ActivatedRoute} from "@angular/router";
import {ProjectObject} from "../project.component";

@Component({
  selector: 'app-settings',
  templateUrl: './settings.component.html',
  styleUrls: ['./settings.component.scss']
})
export class SettingsComponent {
  constructor(
    private apiService: ApiService,
    private helper: HelperService,
    private activatedRoute: ActivatedRoute,
  ) {

  }

  set setChildData(a: any) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId + 'settings');
  };

  projectId: string = '';
  project?: ProjectObject;

  ngOnInit() {
    // this.helper.appEvents.subscribe((e: AppEvent) => {
    //   if(e.name == 'projectLoad'){
    //     this.project = e.data.project;
    //     this.projectId = e.data.projectId;
    //     console.log('load settings', this.project);
    //   }
    // });
  }

}
