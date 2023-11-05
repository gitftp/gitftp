"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_layout_minimal_minimal_module_ts"],{

/***/ 4760:
/*!**************************************************!*\
  !*** ./src/app/layout/minimal/minimal.module.ts ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MinimalModule": () => (/* binding */ MinimalModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _minimal_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./minimal.component */ 881);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);





let routes = [{
  path: 'auth',
  component: _minimal_component__WEBPACK_IMPORTED_MODULE_0__.MinimalComponent,
  loadChildren: () => {
    return Promise.all(/*! import() */[__webpack_require__.e("default-node_modules_angular_material_fesm2020_card_mjs-node_modules_angular_material_fesm202-e033e4"), __webpack_require__.e("src_app_login_login_module_ts")]).then(__webpack_require__.bind(__webpack_require__, /*! ./../../login/login.module */ 107)).then(m => {
      return m.LoginModule;
    });
  }
}];
class MinimalModule {}
MinimalModule.ɵfac = function MinimalModule_Factory(t) {
  return new (t || MinimalModule)();
};
MinimalModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: MinimalModule
});
MinimalModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule.forChild(routes)]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](MinimalModule, {
    declarations: [_minimal_component__WEBPACK_IMPORTED_MODULE_0__.MinimalComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_layout_minimal_minimal_module_ts.js.map