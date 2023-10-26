import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {LogsComponent} from './logs.component';
import {RouterModule, Routes} from "@angular/router";


let routes: Routes = [
  {
    path: 'logs',
    component: LogsComponent,
  }
];

@NgModule({
  declarations: [
    LogsComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
  ]
})
export class LogsModule {
}
