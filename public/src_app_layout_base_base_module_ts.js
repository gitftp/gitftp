"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_layout_base_base_module_ts"],{

/***/ 1540:
/*!********************************************!*\
  !*** ./src/app/layout/base/base.module.ts ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BaseModule": () => (/* binding */ BaseModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./base.component */ 1453);
/* harmony import */ var _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/material/sidenav */ 6643);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_toolbar__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/toolbar */ 2543);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);









let routes = [{
  path: '',
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_dashboard_dashboard_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./../../dashboard/dashboard.module */ 4814)).then(a => {
      return a.DashboardModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_card_mjs-node_modules_angular_material_fesm202-e033e4"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_select_mjs"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_progress-spinner_mjs"), __webpack_require__.e("src_app_project-create_project-create_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../../project-create/project-create.module */ 3538)).then(a => {
      return a.ProjectCreateModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_profile_profile_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./../../profile/profile.module */ 4523)).then(a => {
      return a.ProfileModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_table_mjs"), __webpack_require__.e("src_app_git-accounts_git-accounts_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../../git-accounts/git-accounts.module */ 5130)).then(a => {
      return a.GitAccountsModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_card_mjs-node_modules_angular_material_fesm202-e033e4"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_select_mjs"), __webpack_require__.e("src_app_git-accounts-create_git-accounts-create_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../../git-accounts-create/git-accounts-create.module */ 8606)).then(a => {
      return a.GitAccountsCreateModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return __webpack_require__.e(/*! import() */ "src_app_logs_logs_module_ts").then(__webpack_require__.bind(__webpack_require__, /*! ./../../logs/logs.module */ 7138)).then(a => {
      return a.LogsModule;
    });
  }
}, {
  path: '',
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_card_mjs-node_modules_angular_material_fesm202-e033e4"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_select_mjs"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_table_mjs"), __webpack_require__.e("default-node_modules_angular_material_fesm2020_progress-spinner_mjs"), __webpack_require__.e("src_app_project_project_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ../../project/project.module */ 5318)).then(a => {
      return a.ProjectModule;
    });
  }
}
// {
//   path: '',
//   loadChildren: () => {
//     return import('./../../servers/servers.module').then((a) => {
//       return a.ServersModule;
//     });
//   }
// },
];

class BaseModule {}
BaseModule.ɵfac = function BaseModule_Factory(t) {
  return new (t || BaseModule)();
};
BaseModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: BaseModule
});
BaseModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_3__.MatSidenavModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_4__.MatButtonModule, _angular_material_toolbar__WEBPACK_IMPORTED_MODULE_5__.MatToolbarModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_6__.MatIconModule, _angular_router__WEBPACK_IMPORTED_MODULE_7__.RouterModule.forChild(routes)]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](BaseModule, {
    declarations: [_base_component__WEBPACK_IMPORTED_MODULE_0__.BaseComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_material_sidenav__WEBPACK_IMPORTED_MODULE_3__.MatSidenavModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_4__.MatButtonModule, _angular_material_toolbar__WEBPACK_IMPORTED_MODULE_5__.MatToolbarModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_6__.MatIconModule, _angular_router__WEBPACK_IMPORTED_MODULE_7__.RouterModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_layout_base_base_module_ts.js.map