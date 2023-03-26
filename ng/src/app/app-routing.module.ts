import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {FirstComponent} from "./first/first.component";
import {MinimalComponent} from "./layout/minimal/minimal.component";

const routes: Routes = [
  {
    path:'',
    component: FirstComponent,
  },
  {
    path: '',
    loadChildren: () => {
      return import('./layout/minimal/minimal.module').then((m) => {
        return m.MinimalModule;
      })
    }
  },
  {
    path: '',
    loadChildren: () => {
      return import('./layout/base/base.module').then((m) => {
        return m.BaseModule;
      })
    }
  },
  {
    path: '**',
    redirectTo: 'auth/login',
    // redirectTo: 'home',
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
