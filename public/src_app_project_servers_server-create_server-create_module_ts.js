"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_project_servers_server-create_server-create_module_ts"],{

/***/ 7697:
/*!*************************************************************************!*\
  !*** ./src/app/components/overlay-loading/overlay-loading.component.ts ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OverlayLoadingComponent": () => (/* binding */ OverlayLoadingComponent)
/* harmony export */ });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ 2560);

class OverlayLoadingComponent {}
OverlayLoadingComponent.ɵfac = function OverlayLoadingComponent_Factory(t) {
  return new (t || OverlayLoadingComponent)();
};
OverlayLoadingComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
  type: OverlayLoadingComponent,
  selectors: [["overlay-loading"]],
  decls: 1,
  vars: 0,
  consts: [[1, "loading"]],
  template: function OverlayLoadingComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](0, "div", 0);
    }
  },
  styles: [".loading[_ngcontent-%COMP%] {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  background: rgba(255, 255, 255, 0.6);\n  z-index: 9999;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvY29tcG9uZW50cy9vdmVybGF5LWxvYWRpbmcvb3ZlcmxheS1sb2FkaW5nLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0Usa0JBQUE7RUFDQSxNQUFBO0VBQ0EsT0FBQTtFQUNBLFFBQUE7RUFDQSxTQUFBO0VBQ0Esb0NBQUE7RUFDQSxhQUFBO0FBQ0YiLCJzb3VyY2VzQ29udGVudCI6WyIubG9hZGluZyB7XG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgdG9wOiAwO1xuICBsZWZ0OiAwO1xuICByaWdodDogMDtcbiAgYm90dG9tOiAwO1xuICBiYWNrZ3JvdW5kOiByZ2JhKDI1NSwgMjU1LCAyNTUsIC42KTtcbiAgei1pbmRleDogOTk5OTtcbn1cbiJdLCJzb3VyY2VSb290IjoiIn0= */"]
});

/***/ }),

/***/ 5337:
/*!**********************************************************************!*\
  !*** ./src/app/components/overlay-loading/overlay-loading.module.ts ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OverlayLoadingModule": () => (/* binding */ OverlayLoadingModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _overlay_loading_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./overlay-loading.component */ 7697);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);



class OverlayLoadingModule {}
OverlayLoadingModule.ɵfac = function OverlayLoadingModule_Factory(t) {
  return new (t || OverlayLoadingModule)();
};
OverlayLoadingModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: OverlayLoadingModule
});
OverlayLoadingModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](OverlayLoadingModule, {
    declarations: [_overlay_loading_component__WEBPACK_IMPORTED_MODULE_0__.OverlayLoadingComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule],
    exports: [_overlay_loading_component__WEBPACK_IMPORTED_MODULE_0__.OverlayLoadingComponent]
  });
})();

/***/ }),

/***/ 8221:
/*!**************************************************************************!*\
  !*** ./src/app/project/servers/server-create/server-create.component.ts ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ServerCreateComponent": () => (/* binding */ ServerCreateComponent)
/* harmony export */ });
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _browse_server_browse_server_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../browse-server/browse-server.component */ 2824);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../helper.service */ 2433);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @angular/material/checkbox */ 4792);
/* harmony import */ var _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @angular/material/radio */ 2922);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);
/* harmony import */ var _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! @angular/material/slide-toggle */ 4714);
/* harmony import */ var _components_overlay_loading_overlay_loading_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../components/overlay-loading/overlay-loading.component */ 7697);




















function ServerCreateComponent_overlay_loading_6_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](0, "overlay-loading");
  }
}
function ServerCreateComponent_mat_option_25_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "mat-option", 32);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const b_r8 = ctx.$implicit;
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("value", b_r8);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtextInterpolate"](b_r8);
  }
}
function ServerCreateComponent_div_60_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 19)(1, "mat-checkbox", 33);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](2, " Use FTP over TLS (FTPS) (recommended) ");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_61_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 8)(1, "mat-form-field", 15)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](3, "Host");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](4, "input", 34);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_62_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 8)(1, "mat-form-field", 15)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](3, "Port");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](4, "input", 35);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_63_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 8)(1, "mat-form-field", 15)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](3, "Username");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](4, "input", 36);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_64_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 8)(1, "mat-form-field", 15)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](3, "Password");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](4, "input", 37);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_65_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 19)(1, "mat-slide-toggle", 38);
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](2, "Use public key for authentication ");
    _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
  }
}
class ServerCreateComponent {
  constructor(apiService, helper, activatedRoute, fb, dialog, router) {
    this.apiService = apiService;
    this.helper = helper;
    this.activatedRoute = activatedRoute;
    this.fb = fb;
    this.dialog = dialog;
    this.router = router;
    this.projectId = '';
    this.serverId = '';
    this.loading = true;
    this.saving = false;
    this.branches = [];
    // branches: Branch
    this.gettingBranches = false;
    this.form = this.fb.group({
      'server_name': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_5__.Validators.required]],
      'branch': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_5__.Validators.required]],
      'type': ['local', [_angular_forms__WEBPACK_IMPORTED_MODULE_5__.Validators.required]],
      'secure': ['', []],
      'host': ['', []],
      'port': ['', []],
      'username': ['', []],
      'password': ['', []],
      'path': ['', []],
      'key_id': ['', []],
      'auto_deploy': ['', []],
      'revision': ['', []]
    });
  }
  encode(a) {
    return this.helper.encode(a);
  }
  set setChildData(a) {
    this.projectId = a.projectId;
    this.project = a.project;
    // this.helper.setPage('project' + this.projectId);
    this.helper.setPage('project' + this.projectId + 'servers');
    this.getBranches();
    this.activatedRoute.params.subscribe(params => {
      // console.log(params);
      this.serverId = this.helper.decode(params.id);
      this.load();
    });
  }
  load() {
    this.loading = true;
    this.apiService.post('servers/list', {
      server_id: this.serverId,
      project_id: this.projectId
    }).subscribe({
      next: res => {
        this.loading = false;
        console.log(res);
        if (res.status) {
          this.form.patchValue(res.data.servers[0]);
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.loading = false;
        this.helper.alertError(err);
      }
    });
  }
  save() {
    this.saving = true;
    this.apiService.post('server/save', {
      project_id: this.projectId,
      server_id: this.serverId,
      payload: this.form.value
    }).subscribe({
      next: res => {
        this.saving = false;
        console.log(res);
        if (res.status) {
          // this.helper.alert('Server')
          this.router.navigate(['project', this.helper.encode(this.projectId), 'servers']);
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.saving = false;
        this.helper.alertError(err);
      }
    });
  }
  ngOnInit() {}
  getBranches() {
    this.gettingBranches = true;
    console.log(this.projectId);
    this.apiService.post('repo/git/branches', {
      project_id: this.projectId
    }).subscribe({
      next: res => {
        this.gettingBranches = false;
        console.log(res);
        if (res.status) {
          this.branches = res.data.branches;
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.gettingBranches = false;
        this.helper.alertError(err);
      }
    });
  }
  browseDir() {
    this.dialog.open(_browse_server_browse_server_component__WEBPACK_IMPORTED_MODULE_0__.BrowseServerComponent, {
      data: {
        server: this.form.value
      }
    }).afterClosed().subscribe({
      next: r => {
        if (r) {
          this.form.get('path')?.setValue(r);
        }
      }
    });
  }
}
ServerCreateComponent.ɵfac = function ServerCreateComponent_Factory(t) {
  return new (t || ServerCreateComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_2__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_6__.ActivatedRoute), _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_5__.FormBuilder), _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_7__.MatDialog), _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_6__.Router));
};
ServerCreateComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdefineComponent"]({
  type: ServerCreateComponent,
  selectors: [["app-server-create"]],
  decls: 80,
  vars: 14,
  consts: [[1, "page", "bootstrap-wrapper"], [1, "header", 2, "margin-bottom", "0"], [1, "btns"], [1, "pr", 3, "formGroup", "submit"], [4, "ngIf"], [2, "margin-top", "10px"], [1, "container"], [1, "row"], [1, "col-6"], [1, "col-3"], ["appearance", "outline", 1, "mr2"], ["matInput", "", "formControlName", "server_name"], ["formControlName", "branch", 3, "disabled"], [3, "value", 4, "ngFor", "ngForOf"], [1, "col-4"], ["appearance", "outline"], ["matInput", "", "placeholder", "SHA hash", "formControlName", "revision"], ["formControlName", "auto_deploy", 2, "margin-top", "-4px"], [2, "margin-top", "30px"], [1, "col-12"], [2, "margin-bottom", "10px"], ["aria-label", "Select an option", "formControlName", "type"], ["value", "ftp", 2, "margin-right", "20px"], ["value", "sftp", 2, "margin-right", "20px"], ["value", "local", 2, "margin-right", "20px"], [1, "col-7"], ["class", "col-12", 4, "ngIf"], ["class", "col-6", 4, "ngIf"], ["matInput", "", "placeholder", "../path/to/htdocs/", "formControlName", "path"], ["matSuffix", "", "mat-icon-button", "", "type", "button", "matTooltip", "Browse server", "aria-label", "Clear", 2, "margin-right", "5px", 3, "click"], ["type", "submit", "mat-flat-button", "", "color", "primary"], [2, "height", "200px"], [3, "value"], ["formControlName", "secure", 2, "margin-bottom", "15px"], ["matInput", "", "formControlName", "host"], ["matInput", "", "formControlName", "port"], ["matInput", "", "formControlName", "username"], ["matInput", "", "formControlName", "password"], ["formControlName", "password", 2, "margin-bottom", "20px"]],
  template: function ServerCreateComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](0, "div", 0)(1, "div", 1)(2, "h2");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](4, "div", 2);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](5, "form", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵlistener"]("submit", function ServerCreateComponent_Template_form_submit_5_listener() {
        return ctx.save();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](6, ServerCreateComponent_overlay_loading_6_Template, 1, 0, "overlay-loading", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](7, "div", 5)(8, "div", 6)(9, "div", 7)(10, "div", 8)(11, "h3")(12, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](13, "Environment details");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](14, "div", 7)(15, "div", 9)(16, "mat-form-field", 10)(17, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](18, "Server name");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](19, "input", 11);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](20, "div", 9)(21, "mat-form-field", 10)(22, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](23, "Branch to deploy");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](24, "mat-select", 12);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](25, ServerCreateComponent_mat_option_25_Template, 2, 2, "mat-option", 13);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](26, "div", 7)(27, "div", 14)(28, "mat-form-field", 15)(29, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](30, "Current revision");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](31, "input", 16);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](32, "mat-hint");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](33, "Leave empty if fresh upload");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](34, "div", 9)(35, "mat-checkbox", 17);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](36, " Continuous deployment ");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](37, "br");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](38, "mat-hint");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](39, "Deploy will be triggered when commits are pushed to repository");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](40, "div");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](41, "div", 6)(42, "div", 7)(43, "div", 8)(44, "h3", 18)(45, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](46, "Server connection");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](47, "div", 7)(48, "div", 19)(49, "div", 20)(50, "mat-radio-group", 21)(51, "mat-radio-button", 22);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](52, "FTP ");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](53, "mat-radio-button", 23);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](54, "SFTP ");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](55, "mat-radio-button", 24);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](56, "Local ");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](57, "div", 7)(58, "div", 25)(59, "div", 7);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](60, ServerCreateComponent_div_60_Template, 3, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](61, ServerCreateComponent_div_61_Template, 5, 0, "div", 27);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](62, ServerCreateComponent_div_62_Template, 5, 0, "div", 27);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](63, ServerCreateComponent_div_63_Template, 5, 0, "div", 27);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](64, ServerCreateComponent_div_64_Template, 5, 0, "div", 27);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtemplate"](65, ServerCreateComponent_div_65_Template, 3, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](66, "div", 8)(67, "mat-form-field", 15)(68, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](69, "Deploy path");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](70, "input", 28);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](71, "button", 29);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵlistener"]("click", function ServerCreateComponent_Template_button_click_71_listener() {
        return ctx.browseDir();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](72, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](73, "folder_open");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementStart"](74, "div", 19)(75, "button", 30);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](76, " Save ");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelementEnd"]()()()()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵelement"](77, "div", 31);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtext"](78);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵpipe"](79, "json");
    }
    if (rf & 2) {
      let tmp_5_0;
      let tmp_6_0;
      let tmp_7_0;
      let tmp_8_0;
      let tmp_9_0;
      let tmp_10_0;
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtextInterpolate1"](" ", ctx.serverId ? "Update" : "Create", " server");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("formGroup", ctx.form);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ctx.loading || ctx.gettingBranches);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](18);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("disabled", ctx.gettingBranches);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngForOf", ctx.branches);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](35);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_5_0 = ctx.form.get("type")) == null ? null : tmp_5_0.value) == "ftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_6_0 = ctx.form.get("type")) == null ? null : tmp_6_0.value) == "ftp" || ((tmp_6_0 = ctx.form.get("type")) == null ? null : tmp_6_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_7_0 = ctx.form.get("type")) == null ? null : tmp_7_0.value) == "ftp" || ((tmp_7_0 = ctx.form.get("type")) == null ? null : tmp_7_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_8_0 = ctx.form.get("type")) == null ? null : tmp_8_0.value) == "ftp" || ((tmp_8_0 = ctx.form.get("type")) == null ? null : tmp_8_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_9_0 = ctx.form.get("type")) == null ? null : tmp_9_0.value) == "ftp" || ((tmp_9_0 = ctx.form.get("type")) == null ? null : tmp_9_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵproperty"]("ngIf", ((tmp_10_0 = ctx.form.get("type")) == null ? null : tmp_10_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵadvance"](13);
      _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵtextInterpolate1"]("\n", _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵpipeBind1"](79, 12, ctx.form.value), "\n");
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_8__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_8__.NgIf, _angular_material_button__WEBPACK_IMPORTED_MODULE_9__.MatButton, _angular_material_button__WEBPACK_IMPORTED_MODULE_9__.MatIconButton, _angular_forms__WEBPACK_IMPORTED_MODULE_5__["ɵNgNoValidate"], _angular_forms__WEBPACK_IMPORTED_MODULE_5__.DefaultValueAccessor, _angular_forms__WEBPACK_IMPORTED_MODULE_5__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_5__.NgControlStatusGroup, _angular_forms__WEBPACK_IMPORTED_MODULE_5__.FormGroupDirective, _angular_forms__WEBPACK_IMPORTED_MODULE_5__.FormControlName, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_10__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_10__.MatLabel, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_10__.MatHint, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_10__.MatSuffix, _angular_material_input__WEBPACK_IMPORTED_MODULE_11__.MatInput, _angular_material_icon__WEBPACK_IMPORTED_MODULE_12__.MatIcon, _angular_material_core__WEBPACK_IMPORTED_MODULE_13__.MatOption, _angular_material_select__WEBPACK_IMPORTED_MODULE_14__.MatSelect, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_15__.MatCheckbox, _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__.MatRadioGroup, _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__.MatRadioButton, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_17__.MatTooltip, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_18__.MatSlideToggle, _components_overlay_loading_overlay_loading_component__WEBPACK_IMPORTED_MODULE_3__.OverlayLoadingComponent, _angular_common__WEBPACK_IMPORTED_MODULE_8__.JsonPipe],
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 6370:
/*!***********************************************************************!*\
  !*** ./src/app/project/servers/server-create/server-create.module.ts ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ServerCreateModule": () => (/* binding */ ServerCreateModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _server_create_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./server-create.component */ 8221);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_material_card__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/card */ 2156);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/progress-spinner */ 1708);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_material_table__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @angular/material/table */ 5288);
/* harmony import */ var _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @angular/material/checkbox */ 4792);
/* harmony import */ var _angular_material_radio__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! @angular/material/radio */ 2922);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);
/* harmony import */ var _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! @angular/material/slide-toggle */ 4714);
/* harmony import */ var _components_overlay_loading_overlay_loading_module__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../components/overlay-loading/overlay-loading.module */ 5337);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);





















let routes = [{
  path: 'add',
  component: _server_create_component__WEBPACK_IMPORTED_MODULE_0__.ServerCreateComponent
}, {
  path: 'setup/:id',
  component: _server_create_component__WEBPACK_IMPORTED_MODULE_0__.ServerCreateComponent
}];
class ServerCreateModule {}
ServerCreateModule.ɵfac = function ServerCreateModule_Factory(t) {
  return new (t || ServerCreateModule)();
};
ServerCreateModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineNgModule"]({
  type: ServerCreateModule
});
ServerCreateModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_3__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule.forChild(routes), _angular_material_card__WEBPACK_IMPORTED_MODULE_5__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_9__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_11__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_12__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_13__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_14__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_15__.MatTableModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_16__.MatCheckboxModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_17__.MatRadioModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_18__.MatTooltipModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_19__.MatSlideToggleModule, _components_overlay_loading_overlay_loading_module__WEBPACK_IMPORTED_MODULE_1__.OverlayLoadingModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵsetNgModuleScope"](ServerCreateModule, {
    declarations: [_server_create_component__WEBPACK_IMPORTED_MODULE_0__.ServerCreateComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_3__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_5__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_9__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_11__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_12__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_13__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_14__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_15__.MatTableModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_16__.MatCheckboxModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_17__.MatRadioModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_18__.MatTooltipModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_19__.MatSlideToggleModule, _components_overlay_loading_overlay_loading_module__WEBPACK_IMPORTED_MODULE_1__.OverlayLoadingModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_project_servers_server-create_server-create_module_ts.js.map