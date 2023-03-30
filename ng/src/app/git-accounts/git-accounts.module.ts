import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { GitAccountsComponent } from './git-accounts.component';
import {RouterModule, Routes} from "@angular/router";
import {GitAccountsCreateComponent} from "../git-accounts-create/git-accounts-create.component";
import {MatButtonModule} from "@angular/material/button";
import {MatIconModule} from "@angular/material/icon";




let routes: Routes = [
  {
    path: 'git-accounts',
    component: GitAccountsComponent,
  }
]
@NgModule({
  declarations: [
    GitAccountsComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatButtonModule,
    MatIconModule,
  ]
})
export class GitAccountsModule { }
