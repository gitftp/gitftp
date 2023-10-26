"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_logs_logs_module_ts"],{

/***/ 5134:
/*!****************************************!*\
  !*** ./src/app/logs/logs.component.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "LogsComponent": () => (/* binding */ LogsComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helper.service */ 2433);


const _c0 = ["frame"];
class LogsComponent {
  constructor(helper) {
    this.helper = helper;
  }
  onResize() {
    setTimeout(() => {
      let th = document.getElementsByClassName('mat-toolbar')[0].clientHeight;
      let bh = document.getElementsByTagName('body')[0].clientHeight;
      // console.log(th, bh);
      document.getElementsByClassName('lf')[0].setAttribute('style', 'height: ' + (bh - th - 10) + 'px');
    }, 4);
  }
  ngOnInit() {
    this.onResize();
    this.helper.setPage('logs');
    // document
    // width="100%"
    // style="height: 500px"
    // let bh = $('body').clientHeight;
  }
}

LogsComponent.ɵfac = function LogsComponent_Factory(t) {
  return new (t || LogsComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService));
};
LogsComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineComponent"]({
  type: LogsComponent,
  selectors: [["app-logs"]],
  viewQuery: function LogsComponent_Query(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵviewQuery"](_c0, 5);
    }
    if (rf & 2) {
      let _t;
      _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵloadQuery"]()) && (ctx.frame = _t.first);
    }
  },
  decls: 1,
  vars: 0,
  consts: [["src", "http://localhost/dot-log-viewer/dotlogviewer.php?file=", "frameborder", "0", 1, "lf", 3, "resize"]],
  template: function LogsComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementStart"](0, "iframe", 0);
      _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵlistener"]("resize", function LogsComponent_Template_iframe_resize_0_listener() {
        return ctx.onResize();
      }, false, _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵresolveWindow"]);
      _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementEnd"]();
    }
  },
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */", ".lf[_ngcontent-%COMP%] {\n  width: 100%;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvbG9ncy9sb2dzLmNvbXBvbmVudC50cyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUFJLFdBQUE7QUFFSiIsInNvdXJjZXNDb250ZW50IjpbIi5sZnt3aWR0aDogMTAwJTt9Il0sInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 7138:
/*!*************************************!*\
  !*** ./src/app/logs/logs.module.ts ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "LogsModule": () => (/* binding */ LogsModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _logs_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./logs.component */ 5134);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);





let routes = [{
  path: 'logs',
  component: _logs_component__WEBPACK_IMPORTED_MODULE_0__.LogsComponent
}];
class LogsModule {}
LogsModule.ɵfac = function LogsModule_Factory(t) {
  return new (t || LogsModule)();
};
LogsModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: LogsModule
});
LogsModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule.forChild(routes)]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](LogsModule, {
    declarations: [_logs_component__WEBPACK_IMPORTED_MODULE_0__.LogsComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_logs_logs_module_ts.js.map