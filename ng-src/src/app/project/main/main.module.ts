import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {MainComponent} from './main.component';
import {RouterModule, Routes} from "@angular/router";
import {MatCardModule} from "@angular/material/card";
import {MatButtonModule} from "@angular/material/button";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatInputModule} from "@angular/material/input";
import {MatIconModule} from "@angular/material/icon";
import {MatOptionModule} from "@angular/material/core";
import {MatSelectModule} from "@angular/material/select";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {MatDialogModule} from "@angular/material/dialog";
import {MatTableModule} from "@angular/material/table";
import {ServersComponent} from "../servers/servers.component";
import {ProjectComponent} from "../project.component";


let routes: Routes = [
  {
    path: '',
    component: MainComponent,
  },
  {
    path: 'servers',
    loadChildren: () => {
      return import('./../servers/servers.module').then((a) => {
        return a.ServersModule;
      });
    }
  },
  {
    path: 'settings',
    loadChildren: () => {
      return import('./../settings/settings.module').then((a) => {
        return a.SettingsModule;
      });
    }
  },
  {
    path: 'server',
    loadChildren: () => {
      return import('./../servers/server-create/server-create.module').then((a) => {
        return a.ServerCreateModule;
      });
    }
  },
  {
    path: 'deploy',
    loadChildren: () => {
      return import('../../deploy/deploy.module').then((a) => {
        return a.DeployModule;
      });
    }
  },
];


@NgModule({
  declarations: [
    MainComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatCardModule,
    MatButtonModule,
    FormsModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatIconModule,
    MatOptionModule,
    MatSelectModule,
    MatProgressSpinnerModule,
    MatDialogModule,
    MatTableModule,
  ]
})
export class MainModule {
}
