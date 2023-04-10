import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {ServersComponent} from './servers.component';
import {RouterModule, Routes} from "@angular/router";
import {SettingsComponent} from "../settings/settings.component";
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
import { BrowseServerComponent } from './browse-server/browse-server.component';
import {MatTooltipModule} from "@angular/material/tooltip";
import {NgIconsModule} from "@ng-icons/core";
import {ionGitBranch, ionGitBranchOutline} from "@ng-icons/ionicons";


let routes: Routes = [
  {
    path: '',
    component: ServersComponent,
  }
];


@NgModule({
  declarations: [
    ServersComponent,
    BrowseServerComponent
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
    MatTooltipModule,
    NgIconsModule.withIcons({
      ionGitBranch,
      ionGitBranchOutline,
    }),
  ]
})
export class ServersModule {
}
