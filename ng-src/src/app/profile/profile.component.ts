import {Component} from '@angular/core';
import {HelperService} from "../helper.service";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent {
  constructor(private helper: HelperService) {

    this.helper
      .setPage('profile');
  }
}
