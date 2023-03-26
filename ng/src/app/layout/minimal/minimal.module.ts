import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {MinimalComponent} from './minimal.component';
import {RouterModule, Routes} from "@angular/router";

let routes: Routes = [
  {
    path: 'auth',
    component: MinimalComponent,
    loadChildren: () => {
      return import('./../../login/login.module').then((m) => {
        return m.LoginModule;
      })
    }
  },
];

@NgModule({
  declarations: [
    MinimalComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
  ]
})
export class MinimalModule {
}
