import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { GitAccountsComponent } from './git-accounts.component';
import {RouterModule, Routes} from "@angular/router";
import {MatButtonModule} from "@angular/material/button";
import {MatIconModule} from "@angular/material/icon";
import {MatTableModule} from "@angular/material/table";




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
    MatTableModule,
  ]
})
export class GitAccountsModule { }
