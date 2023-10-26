import {Component, Inject} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent {
  showTrace: boolean = false;
  req: any = {
    buttons: ['Close'],
  };

  colors: string[] = ['primary', 'accent' , 'warn'];
  constructor(public dialogRef: MatDialogRef<AlertComponent>,
              @Inject(MAT_DIALOG_DATA) public data: AlertOptions) {
    this.req = data;
    console.log(data);
    if(typeof this.req.message != 'string'){
      this.req.message = JSON.stringify(this.req.message);
    }
  }
  close(a: any){
    this.dialogRef.close(a);
  }
}


export interface AlertOptions {
  message?: string,
  exception?: {
    message: string,
    file: string,
    line: string,
    trace: string,
  } | string,
  type?: string,
  buttons?: string[],
}
