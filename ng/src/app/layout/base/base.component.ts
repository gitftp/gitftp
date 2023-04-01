import {Component, OnInit} from '@angular/core';
import {HelperService} from "../../helper.service";
import {ApiResponse, ApiService} from "../../api.service";

@Component({
  selector: 'app-base',
  templateUrl: './base.component.html',
  styleUrls: ['./base.component.scss']
})
export class BaseComponent implements OnInit {
  showFiller = false;
  menuShow: any = {};

  constructor(
    private helper: HelperService,
    private apiService: ApiService,
  ) {

  }

  encode(a: any){
    return this.helper.encode(a);
  }

  ngOnInit() {
    this.getProjects();
  }

  projects: ProjectsSidebarObject[] = [];

  gettingProjects: boolean = false;

  getProjects() {

    this.gettingProjects = true;
    this.apiService.post('dash/sidebar', {})
      .subscribe({
        next: (res: ApiResponse) => {
          this.gettingProjects = false;
          console.log(res);
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
