import {Component, Inject} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent {
  showTrace: boolean = false;
  req: {
    exception?: any,
    type?: string,
    message?: string,
  } = {};

  constructor(public dialogRef: MatDialogRef<AlertComponent>,
              @Inject(MAT_DIALOG_DATA) public data: any) {
    this.req = data;
    if(typeof this.req.message != 'string'){
      this.req.message = JSON.stringify(this.req.message);
    }
  }
}
