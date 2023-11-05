"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_project_main_main_module_ts"],{

/***/ 3815:
/*!************************************************!*\
  !*** ./src/app/project/main/main.component.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MainComponent": () => (/* binding */ MainComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../helper.service */ 2433);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _repo_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../repo.service */ 7699);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/icon */ 7822);








function MainComponent_div_1_Template(rf, ctx) {
  if (rf & 1) {
    const _r2 = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 2)(1, "h2")(2, "mat-icon", 3);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3, " filter_hdr ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](4, "span", 4);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](5, " Get started ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](6, "p");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](7, " Gitftp will clone the project on this machine ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](8, "br");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](9, " Project will be cloned at ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](10, "code");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](11);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](12, "button", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵlistener"]("click", function MainComponent_div_1_Template_button_click_12_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵrestoreView"](_r2);
      const ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵresetView"](ctx_r1.clone());
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](13, " Start clone ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
  if (rf & 2) {
    const ctx_r0 = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](11);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtextInterpolate1"]("<gitftp installation dir>/storage/", ctx_r0.project == null ? null : ctx_r0.project.clone_dir, "");
  }
}
class MainComponent {
  constructor(apiService, helper, activatedRoute, repo) {
    this.apiService = apiService;
    this.helper = helper;
    this.activatedRoute = activatedRoute;
    this.repo = repo;
    this.projectId = '';
  }
  set setChildData(a) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId);
  }
  ngOnInit() {
    // this.helper.appEvents.subscribe((e: AppEvent) => {
    //   if (e.name == 'projectLoad') {
    //     this.project = e.data.project;
    //     this.projectId = e.data.projectId;
    //     console.log('load main')
    //   }
    // });
  }
  clone() {
    this.repo.requestDeploy({
      projectId: this.projectId,
      type: 'clone'
    }).subscribe({
      next: res => {
        console.log(res);
      },
      error: err => {
        console.log(err);
      }
    });
  }
}
MainComponent.ɵfac = function MainComponent_Factory(t) {
  return new (t || MainComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_0__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_1__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_4__.ActivatedRoute), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_repo_service__WEBPACK_IMPORTED_MODULE_2__.RepoService));
};
MainComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineComponent"]({
  type: MainComponent,
  selectors: [["app-main"]],
  decls: 2,
  vars: 1,
  consts: [[1, "page"], ["style", "padding: 30px 0;border-top: solid 1px #ddd", 4, "ngIf"], [2, "padding", "30px 0", "border-top", "solid 1px #ddd"], [1, "vm", 2, "font-size", "50px", "height", "auto", "width", "auto"], [1, "vm", "m-l-10"], ["type", "button", "mat-flat-button", "", "btn-big", "", "color", "primary", 3, "click"]],
  template: function MainComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 0);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](1, MainComponent_div_1_Template, 14, 1, "div", 1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", (ctx.project == null ? null : ctx.project.clone_state) != "cloned");
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_5__.NgIf, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButton, _angular_material_icon__WEBPACK_IMPORTED_MODULE_7__.MatIcon],
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 185:
/*!*********************************************!*\
  !*** ./src/app/project/main/main.module.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MainModule": () => (/* binding */ MainModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _main_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main.component */ 3815);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_material_card__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/material/card */ 2156);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/material/progress-spinner */ 1708);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_material_table__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @angular/material/table */ 5288);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);
















let routes = [{
  path: '',
  component: _main_component__WEBPACK_IMPORTED_MODULE_0__.MainComponent
}, {
  path: 'servers',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_tooltip_mjs"), __webpack_require__.e("default-src_app_project_servers_browse-server_browse-server_component_ts"), __webpack_require__.e("src_app_project_servers_servers_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../servers/servers.module */ 9171)).then(a => {
      return a.ServersModule;
    });
  }
}, {
  path: 'settings',
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_project_settings_settings_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./../settings/settings.module */ 2207)).then(a => {
      return a.SettingsModule;
    });
  }
}, {
  path: 'server',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_tooltip_mjs"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_checkbox_mjs-node_modules_angular_material_fes-46350f"), __webpack_require__.e("default-src_app_project_servers_browse-server_browse-server_component_ts"), __webpack_require__.e("src_app_project_servers_server-create_server-create_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../servers/server-create/server-create.module */ 6370)).then(a => {
      return a.ServerCreateModule;
    });
  }
}, {
  path: 'deploy',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_tooltip_mjs"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_checkbox_mjs-node_modules_angular_material_fes-46350f"), __webpack_require__.e("src_app_deploy_deploy_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ../../deploy/deploy.module */ 7392)).then(a => {
      return a.DeployModule;
    });
  }
}];
class MainModule {}
MainModule.ɵfac = function MainModule_Factory(t) {
  return new (t || MainModule)();
};
MainModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: MainModule
});
MainModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule.forChild(routes), _angular_material_card__WEBPACK_IMPORTED_MODULE_4__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_10__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_11__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_12__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_13__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_14__.MatTableModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](MainModule, {
    declarations: [_main_component__WEBPACK_IMPORTED_MODULE_0__.MainComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_4__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_10__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_11__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_12__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_13__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_14__.MatTableModule]
  });
})();

/***/ }),

/***/ 7699:
/*!*********************************!*\
  !*** ./src/app/repo.service.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "RepoService": () => (/* binding */ RepoService)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helper.service */ 2433);



class RepoService {
  constructor(api, helper) {
    this.api = api;
    this.helper = helper;
  }
  requestDeploy(options) {
    return this.api.post('add-deploy-request', {
      project_id: options.projectId,
      server_id: options.serverId,
      type: options.type,
      revision: options.revision
    });
  }
}
RepoService.ɵfac = function RepoService_Factory(t) {
  return new (t || RepoService)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵinject"](_api_service__WEBPACK_IMPORTED_MODULE_0__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵinject"](_helper_service__WEBPACK_IMPORTED_MODULE_1__.HelperService));
};
RepoService.ɵprov = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineInjectable"]({
  token: RepoService,
  factory: RepoService.ɵfac,
  providedIn: 'root'
});

/***/ })

}]);
//# sourceMappingURL=src_app_project_main_main_module_ts.js.map