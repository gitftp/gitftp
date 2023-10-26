import {Component, OnInit, ViewChild} from '@angular/core';
import {HelperService} from "../helper.service";

@Component({
  selector: 'app-logs',
  templateUrl: './logs.component.html',
  styleUrls: ['./logs.component.scss'],
  styles: [
    `.lf{width: 100%;}`
  ]
})
export class LogsComponent implements OnInit {
  constructor(
    private helper: HelperService,
  ) {
  }

  @ViewChild('frame') frame: any;

  onResize() {
    setTimeout(() => {
      let th = document.getElementsByClassName('mat-toolbar')[0].clientHeight;
      let bh = document.getElementsByTagName('body')[0].clientHeight;
      // console.log(th, bh);
      document.getElementsByClassName('lf')[0].setAttribute('style', 'height: ' + ((bh - th) - 10) + 'px');
    }, 4);
  }

  ngOnInit() {
    this.onResize();
    this.helper.setPage('logs');
    // document
    // width="100%"
    // style="height: 500px"
    // let bh = $('body').clientHeight;

  }
}
