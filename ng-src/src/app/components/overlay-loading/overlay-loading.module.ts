import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {OverlayLoadingComponent} from "./overlay-loading.component";

@NgModule({
  declarations: [
    OverlayLoadingComponent,
  ],
  imports: [
    CommonModule
  ],
  exports: [
    OverlayLoadingComponent,
  ]
})
export class OverlayLoadingModule {
}
