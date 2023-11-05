import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {HttpClientModule} from "@angular/common/http";
import {MatSidenavModule} from "@angular/material/sidenav";
import {MatButtonModule} from "@angular/material/button";
import {MatToolbarModule} from "@angular/material/toolbar";
import {MatIconModule} from "@angular/material/icon";
import {FirstComponent} from './first/first.component';
import {AlertComponent} from './components/alert/alert.component';
import {MatDialogModule} from "@angular/material/dialog";
import {MatCardModule} from "@angular/material/card";
import {NgIconsModule} from "@ng-icons/core";
import {
  ionGitBranch,
  ionGitBranchOutline,
} from "@ng-icons/ionicons";
import {APP_BASE_HREF} from "@angular/common";
import {OverlayLoadingComponent} from './components/overlay-loading/overlay-loading.component';

@NgModule({
  declarations: [
    AppComponent,
    FirstComponent,
    AlertComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    MatDialogModule,
    MatButtonModule,
    NgIconsModule.withIcons({
      ionGitBranch,
      ionGitBranchOutline,
    }),
  ],
  providers: [
    {
      provide: APP_BASE_HREF,
      useValue: (<any>window)['base-href']
    }
  ],
  bootstrap: [AppComponent],
  exports: [

  ]
})
export class AppModule {
}
