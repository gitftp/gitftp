import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {BaseComponent} from './base.component';
import {MatSidenavModule} from "@angular/material/sidenav";
import {MatButtonModule} from "@angular/material/button";
import {MatToolbarModule} from "@angular/material/toolbar";
import {MatIconModule} from "@angular/material/icon";
import {RouterModule, Routes} from "@angular/router";
import {DashboardComponent} from "../../dashboard/dashboard.component";


let routes: Routes = [
  {
    path: 'home',
    component: BaseComponent,
    loadChildren: () => {
      return import('./../../dashboard/dashboard.module').then((a) => {
        return a.DashboardModule;
      });
    }
  }
]

@NgModule({
  declarations: [
    BaseComponent,
  ],
  imports: [
    CommonModule,
    MatSidenavModule,
    MatButtonModule,
    MatToolbarModule,
    MatIconModule,
    RouterModule.forChild(routes),
  ]
})
export class BaseModule {
}
