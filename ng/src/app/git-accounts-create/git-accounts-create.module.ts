import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { GitAccountsCreateComponent } from './git-accounts-create.component';
import {RouterModule, Routes} from "@angular/router";
import {ProfileComponent} from "../profile/profile.component";
import {MatIconModule} from "@angular/material/icon";
import {MatButtonModule} from "@angular/material/button";
import {MatCardModule} from "@angular/material/card";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatInputModule} from "@angular/material/input";
import {MatSelectModule} from "@angular/material/select";





let routes: Routes = [
  {
    path: 'git-accounts/create',
    component: GitAccountsCreateComponent,
  }
]

@NgModule({
  declarations: [
    GitAccountsCreateComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatButtonModule,
    MatCardModule,
    FormsModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
  ]
})
export class GitAccountsCreateModule { }
