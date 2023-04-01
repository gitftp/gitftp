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
    path: '',
    loadChildren: () => {
      return import('./../../dashboard/dashboard.module').then((a) => {
        return a.DashboardModule;
      });
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./../../project-create/project-create.module').then((a) => {
        return a.ProjectCreateModule;
      });
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./../../profile/profile.module').then((a) => {
        return a.ProfileModule;
      });
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./../../git-accounts/git-accounts.module').then((a) => {
        return a.GitAccountsModule;
      });
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./../../git-accounts-create/git-accounts-create.module').then((a) => {
        return a.GitAccountsCreateModule;
      });
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./../../logs/logs.module').then((a) => {
        return a.LogsModule;
      });
    }
  },
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
