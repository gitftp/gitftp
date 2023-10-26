"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["main"],{

/***/ 1491:
/*!********************************!*\
  !*** ./src/app/api.service.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ApiService": () => (/* binding */ ApiService)
/* harmony export */ });
/* harmony import */ var rxjs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! rxjs */ 833);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/common/http */ 8987);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helper.service */ 2433);




class ApiService {
  constructor(http, helper) {
    this.http = http;
    this.helper = helper;
    this.baseUrl = window.location.origin + '/api/';
  }
  getRevisions(projectId, branchName) {
    return new rxjs__WEBPACK_IMPORTED_MODULE_1__.Observable(a => {
      this.post('repo/revisions', {
        project_id: projectId,
        branch_name: branchName
      }).subscribe({
        next: res => {
          if (res.status) {
            a.next(res.data.revisions);
          } else {
            this.helper.alertError(res);
          }
        },
        error: e => {
          console.error(e);
          a.error(e);
        },
        complete: () => {
          a.complete();
        }
      });
    });
  }
  post(url, data, options = {}) {
    return new rxjs__WEBPACK_IMPORTED_MODULE_1__.Observable(a => {
      let headers = {
        // 'token': this.userService.getToken(),
      };
      data = data || {};
      data.token = this.helper.getUser()?.token;
      this.http.post(this.baseUrl + url, data, {
        // headers: headers,
      }).subscribe({
        next: res => {
          a.next(res);
        },
        error: err => {
          a.error(err);
        },
        complete: () => {
          a.complete();
        }
      });
    });
  }
  get(url, options = {}) {
    return new rxjs__WEBPACK_IMPORTED_MODULE_1__.Observable(a => {
      let headers = {};
      this.http.get(this.baseUrl + url, {
        headers: headers,
        params: {
          token: this.helper.getUser()?.token
        }
      }).subscribe({
        next: res => {
          a.next(res);
        },
        error: err => {
          a.error(err);
        },
        complete: () => {
          a.complete();
        }
      });
    });
  }
}
ApiService.ɵfac = function ApiService_Factory(t) {
  return new (t || ApiService)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵinject"](_angular_common_http__WEBPACK_IMPORTED_MODULE_3__.HttpClient), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵinject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService));
};
ApiService.ɵprov = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineInjectable"]({
  token: ApiService,
  factory: ApiService.ɵfac,
  providedIn: 'root'
});

/***/ }),

/***/ 158:
/*!***************************************!*\
  !*** ./src/app/app-routing.module.ts ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AppRoutingModule": () => (/* binding */ AppRoutingModule)
/* harmony export */ });
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _first_first_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./first/first.component */ 7259);
/* harmony import */ var _layout_minimal_minimal_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./layout/minimal/minimal.component */ 881);
/* harmony import */ var _layout_base_base_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./layout/base/base.component */ 1453);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ 2560);






const routes = [{
  path: '',
  component: _first_first_component__WEBPACK_IMPORTED_MODULE_0__.FirstComponent
}, {
  path: '',
  component: _layout_minimal_minimal_component__WEBPACK_IMPORTED_MODULE_1__.MinimalComponent,
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_layout_minimal_minimal_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./layout/minimal/minimal.module */ 4760)).then(m => {
      return m.MinimalModule;
    });
  }
}, {
  path: '',
  component: _layout_base_base_component__WEBPACK_IMPORTED_MODULE_2__.BaseComponent,
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_layout_base_base_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./layout/base/base.module */ 1540)).then(m => {
      return m.BaseModule;
    });
  }
}, {
  path: '**',
  redirectTo: 'auth/login'
  // redirectTo: 'home',
}];

class AppRoutingModule {}
AppRoutingModule.ɵfac = function AppRoutingModule_Factory(t) {
  return new (t || AppRoutingModule)();
};
AppRoutingModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineNgModule"]({
  type: AppRoutingModule
});
AppRoutingModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineInjector"]({
  imports: [_angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule.forRoot(routes), _angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵsetNgModuleScope"](AppRoutingModule, {
    imports: [_angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule],
    exports: [_angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule]
  });
})();

/***/ }),

/***/ 5041:
/*!**********************************!*\
  !*** ./src/app/app.component.ts ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AppComponent": () => (/* binding */ AppComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ 124);


class AppComponent {
  constructor() {
    this.showFiller = false;
  }
}
AppComponent.ɵfac = function AppComponent_Factory(t) {
  return new (t || AppComponent)();
};
AppComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
  type: AppComponent,
  selectors: [["app-root"]],
  decls: 1,
  vars: 0,
  template: function AppComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](0, "router-outlet");
    }
  },
  dependencies: [_angular_router__WEBPACK_IMPORTED_MODULE_1__.RouterOutlet],
  styles: [".box[_ngcontent-%COMP%] {\n  border: solid 1px #eee;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvYXBwLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0Usc0JBQUE7QUFDRiIsInNvdXJjZXNDb250ZW50IjpbIi5ib3h7XG4gIGJvcmRlcjogc29saWQgMXB4ICNlZWU7XG59XG4iXSwic291cmNlUm9vdCI6IiJ9 */"]
});

/***/ }),

/***/ 6747:
/*!*******************************!*\
  !*** ./src/app/app.module.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AppModule": () => (/* binding */ AppModule)
/* harmony export */ });
/* harmony import */ var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/platform-browser */ 4497);
/* harmony import */ var _app_routing_module__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app-routing.module */ 158);
/* harmony import */ var _app_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app.component */ 5041);
/* harmony import */ var _angular_platform_browser_animations__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/platform-browser/animations */ 7146);
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/common/http */ 8987);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _first_first_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./first/first.component */ 7259);
/* harmony import */ var _components_alert_alert_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/alert/alert.component */ 9803);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _ng_icons_core__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @ng-icons/core */ 5512);
/* harmony import */ var _ng_icons_ionicons__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @ng-icons/ionicons */ 5953);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/core */ 2560);














class AppModule {}
AppModule.ɵfac = function AppModule_Factory(t) {
  return new (t || AppModule)();
};
AppModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdefineNgModule"]({
  type: AppModule,
  bootstrap: [_app_component__WEBPACK_IMPORTED_MODULE_1__.AppComponent]
});
AppModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdefineInjector"]({
  providers: [{
    provide: _angular_common__WEBPACK_IMPORTED_MODULE_5__.APP_BASE_HREF,
    useValue: window['base-href']
  }],
  imports: [_angular_platform_browser__WEBPACK_IMPORTED_MODULE_6__.BrowserModule, _app_routing_module__WEBPACK_IMPORTED_MODULE_0__.AppRoutingModule, _angular_platform_browser_animations__WEBPACK_IMPORTED_MODULE_7__.BrowserAnimationsModule, _angular_common_http__WEBPACK_IMPORTED_MODULE_8__.HttpClientModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_9__.MatDialogModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_10__.MatButtonModule, _ng_icons_core__WEBPACK_IMPORTED_MODULE_11__.NgIconsModule.withIcons({
    ionGitBranch: _ng_icons_ionicons__WEBPACK_IMPORTED_MODULE_12__.ionGitBranch,
    ionGitBranchOutline: _ng_icons_ionicons__WEBPACK_IMPORTED_MODULE_12__.ionGitBranchOutline
  })]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵsetNgModuleScope"](AppModule, {
    declarations: [_app_component__WEBPACK_IMPORTED_MODULE_1__.AppComponent, _first_first_component__WEBPACK_IMPORTED_MODULE_2__.FirstComponent, _components_alert_alert_component__WEBPACK_IMPORTED_MODULE_3__.AlertComponent],
    imports: [_angular_platform_browser__WEBPACK_IMPORTED_MODULE_6__.BrowserModule, _app_routing_module__WEBPACK_IMPORTED_MODULE_0__.AppRoutingModule, _angular_platform_browser_animations__WEBPACK_IMPORTED_MODULE_7__.BrowserAnimationsModule, _angular_common_http__WEBPACK_IMPORTED_MODULE_8__.HttpClientModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_9__.MatDialogModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_10__.MatButtonModule, _ng_icons_core__WEBPACK_IMPORTED_MODULE_11__.NgIconsModule]
  });
})();

/***/ }),

/***/ 9803:
/*!*****************************************************!*\
  !*** ./src/app/components/alert/alert.component.ts ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AlertComponent": () => (/* binding */ AlertComponent)
/* harmony export */ });
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/material/button */ 4522);





function AlertComponent_span_7_Template(rf, ctx) {
  if (rf & 1) {
    const _r4 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "span", 6);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function AlertComponent_span_7_Template_span_click_0_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵrestoreView"](_r4);
      const ctx_r3 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵresetView"](ctx_r3.showTrace = true);
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](1, " [Show trace] ");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
  }
}
function AlertComponent_div_8_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "div", 7)(1, "strong");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](3, "br");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](4, "strong", 8)(5, "em");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](6, "file:");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](7);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](8, "br");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](9, "em");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](10, " Trace: ");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](11, "code");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](12);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]()();
  }
  if (rf & 2) {
    const ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate1"](" ", ctx_r1.req.exception.message, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](5);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate2"](" ", ctx_r1.req.exception.file, ":", ctx_r1.req.exception.line, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](5);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate"](ctx_r1.req.exception.trace);
  }
}
function AlertComponent_button_10_Template(rf, ctx) {
  if (rf & 1) {
    const _r8 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "button", 9);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function AlertComponent_button_10_Template_button_click_0_listener() {
      const restoredCtx = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵrestoreView"](_r8);
      const b_r5 = restoredCtx.$implicit;
      const ctx_r7 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵresetView"](ctx_r7.close(b_r5));
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const b_r5 = ctx.$implicit;
    const indx_r6 = ctx.index;
    const ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("color", ctx_r2.colors[indx_r6]);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate1"](" ", b_r5, " ");
  }
}
class AlertComponent {
  constructor(dialogRef, data) {
    this.dialogRef = dialogRef;
    this.data = data;
    this.showTrace = false;
    this.req = {
      buttons: ['Close']
    };
    this.colors = ['primary', 'accent', 'warn'];
    this.req = data;
    console.log(data);
    if (typeof this.req.message != 'string') {
      this.req.message = JSON.stringify(this.req.message);
    }
  }
  close(a) {
    this.dialogRef.close(a);
  }
}
AlertComponent.ɵfac = function AlertComponent_Factory(t) {
  return new (t || AlertComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_1__.MatDialogRef), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_1__.MAT_DIALOG_DATA));
};
AlertComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
  type: AlertComponent,
  selectors: [["app-alert"]],
  decls: 11,
  vars: 5,
  consts: [[1, "al"], [2, "text-align", "right"], ["class", "st", 3, "click", 4, "ngIf"], ["class", "trace", 4, "ngIf"], [2, "height", "15px"], ["mat-stroked-button", "", "type", "button", "class", "mr2", 3, "color", "click", 4, "ngFor", "ngForOf"], [1, "st", 3, "click"], [1, "trace"], [2, "margin", "10px 0", "display", "inline-block"], ["mat-stroked-button", "", "type", "button", 1, "mr2", 3, "color", "click"]],
  template: function AlertComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "mat-dialog-content")(1, "div", 0)(2, "h2");
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](4, "p");
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](5);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](6, "div", 1);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtemplate"](7, AlertComponent_span_7_Template, 2, 0, "span", 2);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtemplate"](8, AlertComponent_div_8_Template, 13, 4, "div", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](9, "div", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtemplate"](10, AlertComponent_button_10_Template, 2, 2, "button", 5);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]()();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate1"](" ", ctx.req.type || "Alert", " ");
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate1"](" ", ctx.req.message, " ");
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("ngIf", ctx.req.exception && ctx.req.exception.message && !ctx.showTrace);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("ngIf", ctx.req.exception && ctx.req.exception.message && ctx.showTrace);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("ngForOf", ctx.req.buttons);
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_2__.NgIf, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_1__.MatDialogContent, _angular_material_button__WEBPACK_IMPORTED_MODULE_3__.MatButton],
  styles: [".al[_ngcontent-%COMP%] {\n  min-width: 300px;\n  padding: 0 10px;\n  padding-bottom: 15px;\n  padding-right: 25px;\n}\n\npre[_ngcontent-%COMP%] {\n  overflow: auto;\n  max-height: 300px;\n  max-width: 100%;\n}\n\n.trace[_ngcontent-%COMP%] {\n  background-color: ghostwhite;\n  padding: 10px 15px;\n  border-radius: 20px;\n  line-height: 20px;\n  margin-top: 10px;\n}\n\n.st[_ngcontent-%COMP%] {\n  cursor: pointer;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvY29tcG9uZW50cy9hbGVydC9hbGVydC5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLGdCQUFBO0VBQ0EsZUFBQTtFQUNBLG9CQUFBO0VBQ0EsbUJBQUE7QUFDRjs7QUFDQTtFQUNFLGNBQUE7RUFDQSxpQkFBQTtFQUNBLGVBQUE7QUFFRjs7QUFBQTtFQUNFLDRCQUFBO0VBQ0Esa0JBQUE7RUFDQSxtQkFBQTtFQUNBLGlCQUFBO0VBQ0EsZ0JBQUE7QUFHRjs7QUFEQTtFQUNFLGVBQUE7QUFJRiIsInNvdXJjZXNDb250ZW50IjpbIi5hbHtcbiAgbWluLXdpZHRoOiAzMDBweDtcbiAgcGFkZGluZzogMCAxMHB4O1xuICBwYWRkaW5nLWJvdHRvbTogMTVweDtcbiAgcGFkZGluZy1yaWdodDogMjVweDtcbn1cbnByZXtcbiAgb3ZlcmZsb3c6IGF1dG87XG4gIG1heC1oZWlnaHQ6IDMwMHB4O1xuICBtYXgtd2lkdGg6IDEwMCU7XG59XG4udHJhY2V7XG4gIGJhY2tncm91bmQtY29sb3I6IGdob3N0d2hpdGU7XG4gIHBhZGRpbmc6IDEwcHggMTVweDtcbiAgYm9yZGVyLXJhZGl1czogMjBweDtcbiAgbGluZS1oZWlnaHQ6IDIwcHg7XG4gIG1hcmdpbi10b3A6IDEwcHg7XG59XG4uc3R7XG4gIGN1cnNvcjogcG9pbnRlcjtcblxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 7259:
/*!******************************************!*\
  !*** ./src/app/first/first.component.ts ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FirstComponent": () => (/* binding */ FirstComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../helper.service */ 2433);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ 124);




class FirstComponent {
  constructor(api, helper, router) {
    this.api = api;
    this.helper = helper;
    this.router = router;
  }
  ngOnInit() {
    let user = this.helper.getUser();
    this.api.post('auth/check', {
      token: user.token
    }).subscribe(res => {
      if (res.status) {
        let next = res.data.nextPage;
        switch (next) {
          case 'setup':
            this.router.navigate(['auth', 'setup']);
            break;
          case 'login':
            this.router.navigate(['auth', 'login']);
            break;
          case 'home':
            this.router.navigate(['home']);
            break;
        }
        console.log(res.data);
      } else {
        this.helper.alert({
          message: res.message,
          exception: res.exception
        });
      }
    });
  }
}
FirstComponent.ɵfac = function FirstComponent_Factory(t) {
  return new (t || FirstComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_0__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_1__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_3__.Router));
};
FirstComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
  type: FirstComponent,
  selectors: [["app-first"]],
  decls: 2,
  vars: 0,
  consts: [[2, "padding", "100px"]],
  template: function FirstComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 0);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, " Loading...\n");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    }
  },
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 2433:
/*!***********************************!*\
  !*** ./src/app/helper.service.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "HelperService": () => (/* binding */ HelperService)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _components_alert_alert_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/alert/alert.component */ 9803);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/material/dialog */ 1484);




class HelperService {
  constructor(dialog) {
    this.dialog = dialog;
    this.appEvents = new _angular_core__WEBPACK_IMPORTED_MODULE_1__.EventEmitter();
    this.localStorageName = 'gf.user';
  }
  emit(e) {
    this.appEvents.emit(e);
  }
  setPage(page) {
    this.appEvents.emit({
      data: page,
      name: 'setPage'
    });
  }
  bytes(bytes, precision) {
    bytes += 1000;
    if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
    if (typeof precision === 'undefined') precision = 1;
    var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
      number = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
  }
  encode(a) {
    a = encodeURIComponent(a);
    a = btoa(a);
    a = a.replace(/=/ig, '-');
    return a;
  }
  decode(a) {
    if (!a) return '';
    a = a.replace(/-/ig, '=');
    a = atob(a);
    a = decodeURIComponent(a);
    return a;
  }
  // ive decided to write user service stuff here
  isUserLoggedIn() {
    let user = this.getUser();
    return !!user.token;
  }
  getUser() {
    let user = JSON.parse(localStorage.getItem(this.localStorageName) || '{}');
    return user;
  }
  setUser(user) {
    localStorage.setItem(this.localStorageName, JSON.stringify(user));
  }
  alertError(r) {
    if (typeof r == 'string') {
      console.warn(r);
      if (r.substring(0, 1) == '{') {
        console.log('in!');
      }
    } else {
      if (!r.status) {
        this.alert({
          message: r.message,
          exception: r.exception || '',
          type: r.status ? 'Success' : 'Error'
        });
      }
    }
  }
  alert(options) {
    return this.dialog.open(_components_alert_alert_component__WEBPACK_IMPORTED_MODULE_0__.AlertComponent, {
      data: options
    });
  }
}
HelperService.ɵfac = function HelperService_Factory(t) {
  return new (t || HelperService)(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵinject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_2__.MatDialog));
};
HelperService.ɵprov = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjectable"]({
  token: HelperService,
  factory: HelperService.ɵfac,
  providedIn: 'root'
});

/***/ }),

/***/ 1453:
/*!***********************************************!*\
  !*** ./src/app/layout/base/base.component.ts ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BaseComponent": () => (/* binding */ BaseComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helper.service */ 2433);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../api.service */ 1491);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/material/sidenav */ 6643);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_toolbar__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/toolbar */ 2543);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/router */ 124);









const _c0 = function (a0) {
  return {
    selected: a0
  };
};
function BaseComponent_ng_container_12_div_5_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 18)(1, "div", 19)(2, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](3, " dns ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Servers ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "div", 19)(6, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](7, " settings ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](8, " Project settings ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
  }
  if (rf & 2) {
    const p_r3 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]().$implicit;
    const ctx_r4 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](4, _c0, ctx_r4.page == "project" + p_r3.project_id + "servers"))("routerLink", "/project/" + ctx_r4.encode(p_r3.project_id) + "/servers");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](4);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](6, _c0, ctx_r4.page == "project" + p_r3.project_id + "settings"))("routerLink", "/project/" + ctx_r4.encode(p_r3.project_id) + "/settings");
  }
}
function BaseComponent_ng_container_12_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementContainerStart"](0);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](1, "div", 16)(2, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](3, " code ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](5, BaseComponent_ng_container_12_div_5_Template, 9, 8, "div", 17);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementContainerEnd"]();
  }
  if (rf & 2) {
    const p_r3 = ctx.$implicit;
    const ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpropertyInterpolate"]("title", p_r3.name);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](5, _c0, ctx_r1.page == "project" + p_r3.project_id))("routerLink", "/project/" + ctx_r1.encode(p_r3.project_id) + "");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](3);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", p_r3.name, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r1.menuShow["project" + p_r3.project_id]);
  }
}
function BaseComponent_div_21_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 7)(1, "div", 20)(2, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](3, " user ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Profile ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "div", 21)(6, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](7, " git ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](8, " Git Accounts ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](9, "div", 22)(10, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](11, " log ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](12, " Logs ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
  }
  if (rf & 2) {
    const ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](3, _c0, ctx_r2.page == "profile"));
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](4);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](5, _c0, ctx_r2.page == "git-accounts"));
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](4);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](7, _c0, ctx_r2.page == "logs"));
  }
}
class BaseComponent {
  constructor(helper, apiService, cd) {
    this.helper = helper;
    this.apiService = apiService;
    this.cd = cd;
    this.showFiller = false;
    this.menuShow = {};
    this.page = '';
    this.projects = [];
    this.gettingProjects = false;
  }
  encode(a) {
    return this.helper.encode(a);
  }
  ngOnInit() {
    this.getProjects();
    this.helper.appEvents.subscribe({
      next: e => {
        if (e.name == 'setPage') {
          this.page = e.data;
          if (this.page.indexOf('project') != -1) {
            let keys = Object.keys(this.menuShow);
            for (let k of keys) {
              if (k.indexOf('project') != -1 && k != this.page) {
                this.menuShow[k] = false;
              }
            }
            let p = this.page.replace('servers', '').replace('settings', '');
            this.menuShow[p] = true;
          }
        }
        if (e.name == 'projectCreate') this.getProjects();
        this.cd.detectChanges();
      }
    });
  }
  getProjects() {
    this.gettingProjects = true;
    this.apiService.post('dash/sidebar', {}).subscribe({
      next: res => {
        this.gettingProjects = false;
        // console.log(res);
        if (res.status) {
          this.projects = res.data.projects;
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.gettingProjects = false;
        this.helper.alertError(err);
      }
    });
  }
}
BaseComponent.ɵfac = function BaseComponent_Factory(t) {
  return new (t || BaseComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_2__.ChangeDetectorRef));
};
BaseComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
  type: BaseComponent,
  selectors: [["app-base"]],
  decls: 30,
  vars: 12,
  consts: [["autosize", "", 1, "example-container"], ["mode", "side", 1, "example-sidenav", 3, "opened"], ["drawer", ""], [2, "margin", "21px 25px 30px", "user-select", "none"], [1, "menu-container"], [2, "height", "1px"], ["routerLink", "/home", 1, "m-item", 3, "ngClass"], [1, "m-item-c"], [4, "ngFor", "ngForOf"], ["routerLink", "/project/create", 1, "m-item", 3, "ngClass"], [1, "m-item", 3, "ngClass", "click"], ["class", "m-item-c", 4, "ngIf"], [1, "example-sidenav-content"], ["color", ""], ["mat-icon-button", "", "aria-label", "Example icon-button with menu icon", 1, "example-icon", 3, "click"], ["src", "assets/logo.png", "alt", "", 2, "height", "40px", "margin-left", "10px", "user-select", "none"], [1, "m-item", 3, "title", "ngClass", "routerLink"], ["class", "m-item-c2", 4, "ngIf"], [1, "m-item-c2"], [1, "m-item", 3, "ngClass", "routerLink"], ["routerLink", "/profile", 1, "m-item", 3, "ngClass"], ["routerLink", "/git-accounts", 1, "m-item", 3, "ngClass"], ["routerLink", "/logs", 1, "m-item", 3, "ngClass"]],
  template: function BaseComponent_Template(rf, ctx) {
    if (rf & 1) {
      const _r6 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "mat-drawer-container", 0)(1, "mat-drawer", 1, 2)(3, "h3", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Menu ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "div", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](6, "div", 5);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](7, "div", 6)(8, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](9, " home ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](10, " Home ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](11, "div", 7);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](12, BaseComponent_ng_container_12_Template, 6, 7, "ng-container", 8);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](13, "div", 9)(14, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](15, " add ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](16, " Add Project ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](17, "div", 10);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BaseComponent_Template_div_click_17_listener() {
        return ctx.menuShow.settings = !ctx.menuShow.settings;
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](18, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](19, " settings ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](20, " Settings ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](21, BaseComponent_div_21_Template, 13, 9, "div", 11);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](22, "div", 12)(23, "mat-toolbar", 13)(24, "button", 14);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BaseComponent_Template_button_click_24_listener() {
        _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r6);
        const _r0 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵreference"](2);
        return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](_r0.toggle());
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](25, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](26, "menu");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](27, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](28, "img", 15);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](29, "router-outlet");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("opened", true);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](6, _c0, ctx.page == "home"));
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](5);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngForOf", ctx.projects);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](8, _c0, ctx.page == "project-create"));
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](10, _c0, ctx.page == "settings"));
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.menuShow.settings);
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_3__.NgClass, _angular_common__WEBPACK_IMPORTED_MODULE_3__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_3__.NgIf, _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_4__.MatDrawer, _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_4__.MatDrawerContainer, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatIconButton, _angular_material_toolbar__WEBPACK_IMPORTED_MODULE_6__.MatToolbar, _angular_material_icon__WEBPACK_IMPORTED_MODULE_7__.MatIcon, _angular_router__WEBPACK_IMPORTED_MODULE_8__.RouterOutlet, _angular_router__WEBPACK_IMPORTED_MODULE_8__.RouterLink],
  styles: ["mat-drawer-container[_ngcontent-%COMP%] {\n  height: 100%;\n}\n\n.menu-container[_ngcontent-%COMP%] {\n  width: 250px;\n  padding: 2px 15px;\n  padding-bottom: 100px;\n}\n\n.m-item-c[_ngcontent-%COMP%] {\n  padding-left: 10px;\n  position: relative;\n}\n.m-item-c[_ngcontent-%COMP%]:before {\n  content: \"\";\n  position: absolute;\n  width: 4px;\n  border-radius: 4px;\n  top: 12px;\n  bottom: 12px;\n  left: -2px;\n  background-color: #ddd;\n}\n\n.m-item-c2[_ngcontent-%COMP%] {\n  margin-left: 15px;\n  position: relative;\n}\n.m-item-c2[_ngcontent-%COMP%]:before {\n  content: \"\";\n  position: absolute;\n  width: 4px;\n  border-radius: 4px;\n  top: 12px;\n  bottom: 12px;\n  left: -12px;\n  background-color: #848484;\n}\n\n.m-item[_ngcontent-%COMP%] {\n  padding: 9px 10px;\n  margin: 4px 0px;\n  cursor: pointer;\n  -webkit-user-select: none;\n  user-select: none;\n  border-radius: 6px;\n  user-select: none;\n  border-radius: 6px;\n  white-space: nowrap;\n  text-overflow: ellipsis;\n  \n  overflow: hidden;\n}\n.m-item.selected[_ngcontent-%COMP%] {\n  background-color: #cbe8fb;\n  font-weight: 500;\n}\n.m-item[_ngcontent-%COMP%]:hover {\n  background-color: #cbe8fb;\n}\n.m-item[_ngcontent-%COMP%]    > *[_ngcontent-%COMP%] {\n  vertical-align: middle;\n}\n.m-item[_ngcontent-%COMP%]   mat-icon[_ngcontent-%COMP%] {\n  vertical-align: middle;\n  margin-top: -3px;\n  margin-right: 5px;\n  color: #4d4d4f;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvbGF5b3V0L2Jhc2UvYmFzZS5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLFlBQUE7QUFDRjs7QUFFQTtFQUNFLFlBQUE7RUFDQSxpQkFBQTtFQUNBLHFCQUFBO0FBQ0Y7O0FBRUE7RUFFRSxrQkFBQTtFQUVBLGtCQUFBO0FBREY7QUFHRTtFQUNFLFdBQUE7RUFDQSxrQkFBQTtFQUNBLFVBQUE7RUFDQSxrQkFBQTtFQUNBLFNBQUE7RUFDQSxZQUFBO0VBQ0EsVUFBQTtFQUVBLHNCQUFBO0FBRko7O0FBTUE7RUFHRSxpQkFBQTtFQUVBLGtCQUFBO0FBTkY7QUFRRTtFQUNFLFdBQUE7RUFDQSxrQkFBQTtFQUNBLFVBQUE7RUFDQSxrQkFBQTtFQUNBLFNBQUE7RUFDQSxZQUFBO0VBQ0EsV0FBQTtFQUNBLHlCQUFBO0FBTko7O0FBVUE7RUFDRSxpQkFBQTtFQUNBLGVBQUE7RUFDQSxlQUFBO0VBQ0EseUJBQUE7RUFDQSxpQkFBQTtFQUNBLGtCQUFBO0VBQ0EsaUJBQUE7RUFDQSxrQkFBQTtFQUNBLG1CQUFBO0VBQ0EsdUJBQUE7RUFDQSxnQkFBQTtFQUNBLGdCQUFBO0FBUEY7QUFTRTtFQUNFLHlCQUFBO0VBQ0EsZ0JBQUE7QUFQSjtBQVdFO0VBQ0UseUJBQUE7QUFUSjtBQWdCRTtFQUNFLHNCQUFBO0FBZEo7QUFpQkU7RUFDRSxzQkFBQTtFQUNBLGdCQUFBO0VBQ0EsaUJBQUE7RUFDQSxjQUFBO0FBZkoiLCJzb3VyY2VzQ29udGVudCI6WyJtYXQtZHJhd2VyLWNvbnRhaW5lciB7XG4gIGhlaWdodDogMTAwJTtcbn1cblxuLm1lbnUtY29udGFpbmVyIHtcbiAgd2lkdGg6IDI1MHB4O1xuICBwYWRkaW5nOiAycHggMTVweDtcbiAgcGFkZGluZy1ib3R0b206IDEwMHB4O1xufVxuXG4ubS1pdGVtLWMge1xuICAvL2JhY2tncm91bmQtY29sb3I6IGxpZ2h0Ymx1ZTtcbiAgcGFkZGluZy1sZWZ0OiAxMHB4O1xuICAvL2JvcmRlci1sZWZ0OiBzb2xpZCAxcHggIzg4ODtcbiAgcG9zaXRpb246IHJlbGF0aXZlO1xuXG4gICY6YmVmb3JlIHtcbiAgICBjb250ZW50OiAnJztcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XG4gICAgd2lkdGg6IDRweDtcbiAgICBib3JkZXItcmFkaXVzOiA0cHg7XG4gICAgdG9wOiAxMnB4O1xuICAgIGJvdHRvbTogMTJweDtcbiAgICBsZWZ0OiAtMnB4O1xuICAgIC8vcmlnaHQ6IDA7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2RkZDtcbiAgfVxufVxuXG4ubS1pdGVtLWMyIHtcbiAgLy9iYWNrZ3JvdW5kLWNvbG9yOiBsaWdodGJsdWU7XG4gIC8vbWFyZ2luLWxlZnQ6IDMwcHg7XG4gIG1hcmdpbi1sZWZ0OiAxNXB4O1xuICAvL2JvcmRlci1sZWZ0OiBzb2xpZCAxcHggIzg4ODtcbiAgcG9zaXRpb246IHJlbGF0aXZlO1xuXG4gICY6YmVmb3JlIHtcbiAgICBjb250ZW50OiBcIlwiO1xuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICB3aWR0aDogNHB4O1xuICAgIGJvcmRlci1yYWRpdXM6IDRweDtcbiAgICB0b3A6IDEycHg7XG4gICAgYm90dG9tOiAxMnB4O1xuICAgIGxlZnQ6IC0xMnB4O1xuICAgIGJhY2tncm91bmQtY29sb3I6ICM4NDg0ODQ7XG4gIH1cbn1cblxuLm0taXRlbSB7XG4gIHBhZGRpbmc6IDlweCAxMHB4O1xuICBtYXJnaW46IDRweCAwcHg7XG4gIGN1cnNvcjogcG9pbnRlcjtcbiAgLXdlYmtpdC11c2VyLXNlbGVjdDogbm9uZTtcbiAgdXNlci1zZWxlY3Q6IG5vbmU7XG4gIGJvcmRlci1yYWRpdXM6IDZweDtcbiAgdXNlci1zZWxlY3Q6IG5vbmU7XG4gIGJvcmRlci1yYWRpdXM6IDZweDtcbiAgd2hpdGUtc3BhY2U6IG5vd3JhcDtcbiAgdGV4dC1vdmVyZmxvdzogZWxsaXBzaXM7XG4gIC8qIHdpZHRoOiA5MSU7ICovXG4gIG92ZXJmbG93OiBoaWRkZW47XG5cbiAgJi5zZWxlY3RlZCB7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2NiZThmYjtcbiAgICBmb250LXdlaWdodDogNTAwO1xuXG4gIH1cblxuICAmOmhvdmVyIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjY2JlOGZiO1xuICB9XG5cbiAgJi5zZWxlY3RlZDpob3ZlcntcblxuICB9XG5cbiAgPiAqIHtcbiAgICB2ZXJ0aWNhbC1hbGlnbjogbWlkZGxlO1xuICB9XG5cbiAgbWF0LWljb24ge1xuICAgIHZlcnRpY2FsLWFsaWduOiBtaWRkbGU7XG4gICAgbWFyZ2luLXRvcDogLTNweDtcbiAgICBtYXJnaW4tcmlnaHQ6IDVweDtcbiAgICBjb2xvcjogIzRkNGQ0ZjtcbiAgICAvL3dpZHRoOiAyNHB4O1xuICB9XG59XG4iXSwic291cmNlUm9vdCI6IiJ9 */"]
});

/***/ }),

/***/ 881:
/*!*****************************************************!*\
  !*** ./src/app/layout/minimal/minimal.component.ts ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MinimalComponent": () => (/* binding */ MinimalComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ 124);


class MinimalComponent {}
MinimalComponent.ɵfac = function MinimalComponent_Factory(t) {
  return new (t || MinimalComponent)();
};
MinimalComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
  type: MinimalComponent,
  selectors: [["app-minimal"]],
  decls: 4,
  vars: 0,
  consts: [[2, "height", "30px"], [1, "footer"]],
  template: function MinimalComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](0, "router-outlet")(1, "div", 0);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](2, "div", 1);
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](3, " Gitftp \u2022 Boniface Pereira \u2022 made with love (\u2665).\n");
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
    }
  },
  dependencies: [_angular_router__WEBPACK_IMPORTED_MODULE_1__.RouterOutlet],
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 4431:
/*!*********************!*\
  !*** ./src/main.ts ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/platform-browser */ 4497);
/* harmony import */ var _app_app_module__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app/app.module */ 6747);


_angular_platform_browser__WEBPACK_IMPORTED_MODULE_1__.platformBrowser().bootstrapModule(_app_app_module__WEBPACK_IMPORTED_MODULE_0__.AppModule).catch(err => console.error(err));

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendor"], () => (__webpack_exec__(4431)));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=main.js.map