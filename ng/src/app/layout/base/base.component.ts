import {ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {AppEvent, HelperService} from "../../helper.service";
import {ApiResponse, ApiService} from "../../api.service";

@Component({
  selector: 'app-base',
  templateUrl: './base.component.html',
  styleUrls: ['./base.component.scss']
})
export class BaseComponent implements OnInit {
  showFiller = false;
  menuShow: any = {};
  page: string = '';

  constructor(
    private helper: HelperService,
    private apiService: ApiService,
    private cd: ChangeDetectorRef,
  ) {

  }

  encode(a: any) {
    return this.helper.encode(a);
  }


  ngOnInit() {
    this.getProjects();
    this.helper.appEvents
      .subscribe({
        next: (e: AppEvent) => {
          if (e.name == 'setPage') {
            this.page = e.data;
            if (this.page.indexOf('project') != -1) {
              let keys = Object.keys(this.menuShow);
              for (let k of keys) {
                if (
                  k.indexOf('project') != -1
                  && k != this.page
                ) {
                  this.menuShow[k] = false;
                }
              }

              let p = this.page.replace('servers', '')
                .replace('settings', '');
              this.menuShow[p] = true;
            }
          }
          if (e.name == 'projectCreate')
            this.getProjects();

          this.cd.detectChanges();
        }
      })
  }

  projects: ProjectsSidebarObject[] = [];

  gettingProjects: boolean = false;

  getProjects() {

    this.gettingProjects = true;
    this.apiService.post('dash/sidebar', {})
      .subscribe({
        next: (res: ApiResponse) => {
          this.gettingProjects = false;
          // console.log(res);
          if (res.status) {
            this.projects = res.data.projects;
          } else {
            this.helper.alertError(res);
          }
        },
        error: err => {
          this.gettingProjects = false;
          this.helper.alertError(err);

        },
      })
  }

}

export interface ProjectsSidebarObject {
  project_id: number;
  name: string;
}
