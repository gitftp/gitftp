import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {MatDialog} from "@angular/material/dialog";
import {AlertComponent} from "./components/alert/alert.component";

@Injectable({
  providedIn: 'root'
})
export class HelperService {
  constructor(
    private dialog: MatDialog,
  ) {

  }

  alert(options: AlertOptions) {
    return this.dialog.open(AlertComponent, {
      data: options,
    });
  }

}

export interface AlertOptions {
  message: string,
  exception?: {
    message: string,
    file: string,
    line: string,
    trace: string,
  } | string,
  type?: string,
}
