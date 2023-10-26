"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_project_servers_server-create_server-create_module_ts"],{

/***/ 8221:
/*!**************************************************************************!*\
  !*** ./src/app/project/servers/server-create/server-create.component.ts ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ServerCreateComponent": () => (/* binding */ ServerCreateComponent)
/* harmony export */ });
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _browse_server_browse_server_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../browse-server/browse-server.component */ 2824);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../helper.service */ 2433);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @angular/material/checkbox */ 4792);
/* harmony import */ var _angular_material_radio__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @angular/material/radio */ 2922);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);
/* harmony import */ var _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! @angular/material/slide-toggle */ 4714);



















function ServerCreateComponent_mat_option_24_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "mat-option", 31);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const b_r7 = ctx.$implicit;
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("value", b_r7);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtextInterpolate"](b_r7);
  }
}
function ServerCreateComponent_div_59_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 18)(1, "mat-checkbox", 32);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](2, " Use FTP over TLS (FTPS) (recommended) ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_60_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 7)(1, "mat-form-field", 14)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3, "Host");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](4, "input", 33);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_61_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 7)(1, "mat-form-field", 14)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3, "Port");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](4, "input", 34);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_62_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 7)(1, "mat-form-field", 14)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3, "Username");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](4, "input", 35);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_63_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 7)(1, "mat-form-field", 14)(2, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3, "Password");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](4, "input", 36);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
  }
}
function ServerCreateComponent_div_64_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 18)(1, "mat-slide-toggle", 37);
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](2, "Use public key for authentication ");
    _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
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
    this.loading = false;
    this.saving = false;
    this.branches = [];
    // branches: Branch
    this.gettingBranches = false;
    this.form = this.fb.group({
      'server_name': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_4__.Validators.required]],
      'branch': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_4__.Validators.required]],
      'type': ['local', [_angular_forms__WEBPACK_IMPORTED_MODULE_4__.Validators.required]],
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
        console.log(res);
        if (res.status) {
          this.form.patchValue(res.data.servers[0]);
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
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
  return new (t || ServerCreateComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_2__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_5__.ActivatedRoute), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_4__.FormBuilder), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_6__.MatDialog), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_5__.Router));
};
ServerCreateComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineComponent"]({
  type: ServerCreateComponent,
  selectors: [["app-server-create"]],
  decls: 79,
  vars: 13,
  consts: [[1, "page", "bootstrap-wrapper"], [1, "header", 2, "margin-bottom", "0"], [1, "btns"], [3, "formGroup", "submit"], [2, "margin-top", "10px"], [1, "container"], [1, "row"], [1, "col-6"], [1, "col-3"], ["appearance", "outline", 1, "mr2"], ["matInput", "", "formControlName", "server_name"], ["formControlName", "branch", 3, "disabled"], [3, "value", 4, "ngFor", "ngForOf"], [1, "col-4"], ["appearance", "outline"], ["matInput", "", "placeholder", "SHA hash", "formControlName", "revision"], ["formControlName", "auto_deploy", 2, "margin-top", "-4px"], [2, "margin-top", "30px"], [1, "col-12"], [2, "margin-bottom", "10px"], ["aria-label", "Select an option", "formControlName", "type"], ["value", "ftp", 2, "margin-right", "20px"], ["value", "sftp", 2, "margin-right", "20px"], ["value", "local", 2, "margin-right", "20px"], [1, "col-7"], ["class", "col-12", 4, "ngIf"], ["class", "col-6", 4, "ngIf"], ["matInput", "", "placeholder", "../path/to/htdocs/", "formControlName", "path"], ["matSuffix", "", "mat-icon-button", "", "type", "button", "matTooltip", "Browse server", "aria-label", "Clear", 2, "margin-right", "5px", 3, "click"], ["type", "submit", "mat-flat-button", "", "color", "primary"], [2, "height", "200px"], [3, "value"], ["formControlName", "secure", 2, "margin-bottom", "15px"], ["matInput", "", "formControlName", "host"], ["matInput", "", "formControlName", "port"], ["matInput", "", "formControlName", "username"], ["matInput", "", "formControlName", "password"], ["formControlName", "password", 2, "margin-bottom", "20px"]],
  template: function ServerCreateComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 0)(1, "div", 1)(2, "h2");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](4, "div", 2);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](5, "form", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵlistener"]("submit", function ServerCreateComponent_Template_form_submit_5_listener() {
        return ctx.save();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](6, "div", 4)(7, "div", 5)(8, "div", 6)(9, "div", 7)(10, "h3")(11, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](12, "Environment details");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](13, "div", 6)(14, "div", 8)(15, "mat-form-field", 9)(16, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](17, "Server name");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](18, "input", 10);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](19, "div", 8)(20, "mat-form-field", 9)(21, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](22, "Branch to deploy");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](23, "mat-select", 11);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](24, ServerCreateComponent_mat_option_24_Template, 2, 2, "mat-option", 12);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](25, "div", 6)(26, "div", 13)(27, "mat-form-field", 14)(28, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](29, "Current revision");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](30, "input", 15);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](31, "mat-hint");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](32, "Leave empty if fresh upload");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](33, "div", 8)(34, "mat-checkbox", 16);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](35, " Continuous deployment ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](36, "br");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](37, "mat-hint");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](38, "Deploy will be triggered when commits are pushed to repository");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](39, "div");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](40, "div", 5)(41, "div", 6)(42, "div", 7)(43, "h3", 17)(44, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](45, "Server connection");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](46, "div", 6)(47, "div", 18)(48, "div", 19)(49, "mat-radio-group", 20)(50, "mat-radio-button", 21);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](51, "FTP ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](52, "mat-radio-button", 22);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](53, "SFTP ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](54, "mat-radio-button", 23);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](55, "Local ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](56, "div", 6)(57, "div", 24)(58, "div", 6);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](59, ServerCreateComponent_div_59_Template, 3, 0, "div", 25);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](60, ServerCreateComponent_div_60_Template, 5, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](61, ServerCreateComponent_div_61_Template, 5, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](62, ServerCreateComponent_div_62_Template, 5, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](63, ServerCreateComponent_div_63_Template, 5, 0, "div", 26);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtemplate"](64, ServerCreateComponent_div_64_Template, 3, 0, "div", 25);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](65, "div", 7)(66, "mat-form-field", 14)(67, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](68, "Deploy path");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](69, "input", 27);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](70, "button", 28);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵlistener"]("click", function ServerCreateComponent_Template_button_click_70_listener() {
        return ctx.browseDir();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](71, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](72, "folder_open");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](73, "div", 18)(74, "button", 29);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](75, " Save ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](76, "div", 30);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](77);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵpipe"](78, "json");
    }
    if (rf & 2) {
      let tmp_4_0;
      let tmp_5_0;
      let tmp_6_0;
      let tmp_7_0;
      let tmp_8_0;
      let tmp_9_0;
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtextInterpolate1"](" ", ctx.serverId ? "Update" : "Create", " server");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("formGroup", ctx.form);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](18);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("disabled", ctx.gettingBranches);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngForOf", ctx.branches);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](35);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_4_0 = ctx.form.get("type")) == null ? null : tmp_4_0.value) == "ftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_5_0 = ctx.form.get("type")) == null ? null : tmp_5_0.value) == "ftp" || ((tmp_5_0 = ctx.form.get("type")) == null ? null : tmp_5_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_6_0 = ctx.form.get("type")) == null ? null : tmp_6_0.value) == "ftp" || ((tmp_6_0 = ctx.form.get("type")) == null ? null : tmp_6_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_7_0 = ctx.form.get("type")) == null ? null : tmp_7_0.value) == "ftp" || ((tmp_7_0 = ctx.form.get("type")) == null ? null : tmp_7_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_8_0 = ctx.form.get("type")) == null ? null : tmp_8_0.value) == "ftp" || ((tmp_8_0 = ctx.form.get("type")) == null ? null : tmp_8_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("ngIf", ((tmp_9_0 = ctx.form.get("type")) == null ? null : tmp_9_0.value) == "sftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](13);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtextInterpolate1"]("\n", _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵpipeBind1"](78, 11, ctx.form.value), "\n");
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_7__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_7__.NgIf, _angular_material_button__WEBPACK_IMPORTED_MODULE_8__.MatButton, _angular_material_button__WEBPACK_IMPORTED_MODULE_8__.MatIconButton, _angular_forms__WEBPACK_IMPORTED_MODULE_4__["ɵNgNoValidate"], _angular_forms__WEBPACK_IMPORTED_MODULE_4__.DefaultValueAccessor, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.NgControlStatusGroup, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.FormGroupDirective, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.FormControlName, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_9__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_9__.MatLabel, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_9__.MatHint, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_9__.MatSuffix, _angular_material_input__WEBPACK_IMPORTED_MODULE_10__.MatInput, _angular_material_icon__WEBPACK_IMPORTED_MODULE_11__.MatIcon, _angular_material_core__WEBPACK_IMPORTED_MODULE_12__.MatOption, _angular_material_select__WEBPACK_IMPORTED_MODULE_13__.MatSelect, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_14__.MatCheckbox, _angular_material_radio__WEBPACK_IMPORTED_MODULE_15__.MatRadioGroup, _angular_material_radio__WEBPACK_IMPORTED_MODULE_15__.MatRadioButton, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_16__.MatTooltip, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_17__.MatSlideToggle, _angular_common__WEBPACK_IMPORTED_MODULE_7__.JsonPipe],
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
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _server_create_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./server-create.component */ 8221);
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
/* harmony import */ var _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @angular/material/checkbox */ 4792);
/* harmony import */ var _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @angular/material/radio */ 2922);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);
/* harmony import */ var _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! @angular/material/slide-toggle */ 4714);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);




















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
ServerCreateModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: ServerCreateModule
});
ServerCreateModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule.forChild(routes), _angular_material_card__WEBPACK_IMPORTED_MODULE_4__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_10__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_11__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_12__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_13__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_14__.MatTableModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_15__.MatCheckboxModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__.MatRadioModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_17__.MatTooltipModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_18__.MatSlideToggleModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](ServerCreateModule, {
    declarations: [_server_create_component__WEBPACK_IMPORTED_MODULE_0__.ServerCreateComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_4__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_10__.MatOptionModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_11__.MatSelectModule, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_12__.MatProgressSpinnerModule, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_13__.MatDialogModule, _angular_material_table__WEBPACK_IMPORTED_MODULE_14__.MatTableModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_15__.MatCheckboxModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_16__.MatRadioModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_17__.MatTooltipModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_18__.MatSlideToggleModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_project_servers_server-create_server-create_module_ts.js.map