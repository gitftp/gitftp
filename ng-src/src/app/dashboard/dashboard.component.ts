import { Component } from '@angular/core';
import {HelperService} from "../helper.service";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent {
  constructor(
    private helper: HelperService,
  ) {
    this.helper.setPage('home');
  }

}
