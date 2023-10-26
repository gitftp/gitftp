"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_deploy_deploy_module_ts"],{

/***/ 678:
/*!********************************************!*\
  !*** ./src/app/deploy/deploy.component.ts ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DeployComponent": () => (/* binding */ DeployComponent)
/* harmony export */ });
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helper.service */ 2433);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../api.service */ 1491);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/chips */ 1169);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _ng_icons_core__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @ng-icons/core */ 5512);
/* harmony import */ var _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/progress-spinner */ 1708);















function DeployComponent_mat_option_7_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "mat-option", 21);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const s_r2 = ctx.$implicit;
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("value", s_r2.server_id);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", s_r2.server_name, " ");
  }
}
function DeployComponent_div_30_div_10_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 27);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](1, "mat-spinner", 28);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function DeployComponent_div_30_div_11_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 29)(1, "div", 30);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipe"](3, "slice");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](4, "div", 31);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](6, "div", 32);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](7, "img", 33);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](8, "span");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](9);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](10, "span", 34);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](11);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipe"](12, "lowercase");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipe"](13, "date");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()();
  }
  if (rf & 2) {
    const ctx_r5 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipeBind3"](3, 5, ctx_r5.latestCommits[0].sha, 0, 8), " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](3);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", ctx_r5.latestCommits[0].message, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("src", ctx_r5.latestCommits[0].author_avatar, _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵsanitizeUrl"]);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", ctx_r5.latestCommits[0].author, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" committed ", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipeBind1"](12, 9, _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipeBind2"](13, 11, ctx_r5.latestCommits[0].time, "medium")), " ");
  }
}
function DeployComponent_div_30_Template(rf, ctx) {
  if (rf & 1) {
    const _r7 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 11)(1, "div", 18)(2, "p")(3, "mat-icon", 22);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, "info");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "span", 23);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](6, " All project files will be uploaded to the server. Files will be updated if they already exists. ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](7, "div", 12)(8, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](9, " Revision to be deployed ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](10, DeployComponent_div_30_div_10_Template, 2, 0, "div", 24);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](11, DeployComponent_div_30_div_11_Template, 14, 14, "div", 25);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](12, "button", 26);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function DeployComponent_div_30_Template_button_click_12_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r7);
      const ctx_r6 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](ctx_r6.freshDeploy());
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](13, " Deploy ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()();
  }
  if (rf & 2) {
    const ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](10);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r1.loadingLatestCommit);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r1.latestCommits.length && !ctx_r1.loadingLatestCommit);
  }
}
class DeployComponent {
  constructor(helper, apiService, fb, activatedRoutes) {
    this.helper = helper;
    this.apiService = apiService;
    this.fb = fb;
    this.activatedRoutes = activatedRoutes;
    this.projectId = '';
    this.serverId = '';
    this.servers = [];
    this.gettingServers = false;
    this.type = '';
    this.latestCommits = [];
    this.loadingLatestCommit = false;
    this.deploying = false;
    this.form = this.fb.group({
      'server_id': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      'type': ['', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]]
    });
  }
  set setChildData(a) {
    this.projectId = a.projectId;
    this.project = a.project;
    this.helper.setPage('project' + this.projectId + 'servers');
    this.activatedRoutes.params.subscribe({
      next: a => {
        let id = this.helper.decode(a.id);
        this.serverId = id;
        this.form.get('server_id')?.setValue(parseInt(this.serverId));
        // console.log('asd')
        this.onChangeType();
      }
    });
    this.getServers();
  }
  getServers() {
    this.gettingServers = true;
    this.apiService.post('servers/list', {
      project_id: this.projectId
    }).subscribe({
      next: res => {
        // console.log(res);
        this.gettingServers = false;
        if (res.status) {
          this.servers = res.data.servers;
          console.log(this.servers, res);
        } else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.gettingServers = false;
        this.helper.alertError(err);
      }
    });
  }
  ngOnInit() {
    this.form.get('type')?.valueChanges.subscribe(a => {
      this.onChangeType();
    });
  }
  getSelectedBranch() {
    let sid = this.form.get('server_id')?.value;
    // console.log(sid)
    let f;
    for (let s of this.servers) {
      if (s.server_id == sid) {
        f = s;
        break;
      }
    }
    return f;
  }
  onChangeType(o = false) {
    if (this.form.get('type')?.value == this.type && !o) return;
    if (this.form.get('type')?.value == 'fresh') {
      this.getLatestCommit();
    }
    if (this.form.get('type')?.value == 'deploy') {}
    this.type = this.form.get('type')?.value;
  }
  getLatestCommit() {
    this.loadingLatestCommit = true;
    this.apiService.post('repo/git/commits', {
      project_id: this.projectId,
      branch: this.getSelectedBranch()?.branch
    }).subscribe({
      next: res => {
        this.loadingLatestCommit = false;
        console.log(res);
        if (res.status) {
          this.latestCommits = res.data.commits;
        } else {
          this.helper.alertError(res.message);
        }
      },
      error: err => {
        this.loadingLatestCommit = false;
        this.helper.alertError(err);
      }
    });
  }
  freshDeploy() {
    this.deploying = true;
    this.apiService.post('deploy', {
      project_id: this.projectId,
      server_id: this.serverId,
      deploy_type: this.type,
      revision: this.latestCommits[0].sha
    }).subscribe({
      next: res => {
        console.log(res);
        this.deploying = false;
        if (res.status) {} else {
          this.helper.alertError(res);
        }
      },
      error: err => {
        this.deploying = false;
        this.helper.alertError(err);
      }
    });
  }
}
DeployComponent.ɵfac = function DeployComponent_Factory(t) {
  return new (t || DeployComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormBuilder), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_4__.ActivatedRoute));
};
DeployComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
  type: DeployComponent,
  selectors: [["app-deploy"]],
  decls: 34,
  vars: 10,
  consts: [[1, "page", "bootstrap-wrapper"], [3, "formGroup"], [1, "header", 2, "margin-bottom", "0"], [1, "field-nude", 2, "width", "500px", "margin-left", "-7px"], ["formControlName", "server_id", "placeholder", "[select]", 3, "selectionChange"], [3, "value", 4, "ngFor", "ngForOf"], [2, "display", "block", "margin-top", "-30px"], ["name", "ionGitBranch", 2, "font-size", "21px", "vertical-align", "middle"], [1, "btns"], [2, "margin-top", "10px"], [1, "container"], [1, "row"], [1, "col-6"], [1, "no-m-t"], [1, "col-3"], ["aria-label", "Fish selection", "formControlName", "type"], ["value", "deploy", 3, "disabled"], ["value", "fresh", 3, "disabled"], [1, "col-12"], ["class", "row", 4, "ngIf"], [2, "height", "200px"], [3, "value"], [1, "vm", "muted2"], [1, "vm"], ["style", "padding: 20px 0;", 4, "ngIf"], ["class", "commit", 4, "ngIf"], ["type", "submit", "mat-flat-button", "", "btn-big", "", "color", "primary", 3, "click"], [2, "padding", "20px 0"], ["diameter", "30"], [1, "commit"], [1, "sha", "c"], [1, "m"], [1, "mc"], ["alt", "", 3, "src"], [2, "color", "#888"]],
  template: function DeployComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 0)(1, "form", 1)(2, "div", 2)(3, "h2");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Deploy to ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "mat-form-field", 3)(6, "mat-select", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("selectionChange", function DeployComponent_Template_mat_select_selectionChange_6_listener() {
        return ctx.onChangeType(true);
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](7, DeployComponent_mat_option_7_Template, 2, 2, "mat-option", 5);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](8, "div", 6);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](9, " from ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](10, "ng-icon", 7);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](11, "strong");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](12);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](13, "div", 8);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](14, "div", 9)(15, "div", 10)(16, "div", 11)(17, "div", 12)(18, "h3", 13)(19, "span");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](20, "Deployment type");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](21, "div", 11)(22, "div", 14)(23, "form", 1)(24, "mat-chip-listbox", 15)(25, "mat-chip-option", 16);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](26, "Deploy ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](27, "mat-chip-option", 17);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](28, "Fresh upload ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](29, "div", 18);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](30, DeployComponent_div_30_Template, 14, 2, "div", 19);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](31, "div", 20);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](32);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipe"](33, "json");
    }
    if (rf & 2) {
      let tmp_2_0;
      let tmp_4_0;
      let tmp_5_0;
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("formGroup", ctx.form);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngForOf", ctx.servers);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](5);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", (tmp_2_0 = ctx.getSelectedBranch()) == null ? null : tmp_2_0.branch, " ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](11);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("formGroup", ctx.form);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("disabled", ((tmp_4_0 = ctx.form.get("type")) == null ? null : tmp_4_0.value) == "deploy");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("disabled", ((tmp_5_0 = ctx.form.get("type")) == null ? null : tmp_5_0.value) == "fresh");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](3);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.form.value.type == "fresh");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"]("\n", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipeBind1"](33, 8, ctx.form.value), "\n");
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_5__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_5__.NgIf, _angular_forms__WEBPACK_IMPORTED_MODULE_3__["ɵNgNoValidate"], _angular_forms__WEBPACK_IMPORTED_MODULE_3__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.NgControlStatusGroup, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButton, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatLabel, _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__.MatChipListbox, _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__.MatChipOption, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIcon, _angular_material_core__WEBPACK_IMPORTED_MODULE_10__.MatOption, _angular_material_select__WEBPACK_IMPORTED_MODULE_11__.MatSelect, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormGroupDirective, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormControlName, _ng_icons_core__WEBPACK_IMPORTED_MODULE_12__.NgIconComponent, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_13__.MatProgressSpinner, _angular_common__WEBPACK_IMPORTED_MODULE_5__.LowerCasePipe, _angular_common__WEBPACK_IMPORTED_MODULE_5__.JsonPipe, _angular_common__WEBPACK_IMPORTED_MODULE_5__.SlicePipe, _angular_common__WEBPACK_IMPORTED_MODULE_5__.DatePipe],
  styles: [".mdc-evolution-chip-set[_ngcontent-%COMP%] {\n  margin-bottom: 15px;\n}\n\n.commit[_ngcontent-%COMP%] {\n  border: solid 1px #ddd;\n  margin: 10px 0 20px;\n  position: relative;\n  padding: 10px 15px;\n  background-color: ghostwhite;\n  border-radius: 6px;\n  padding: 10px 15px;\n}\n.commit[_ngcontent-%COMP%]   .m[_ngcontent-%COMP%] {\n  font-weight: bold;\n  margin-bottom: 5px;\n}\n.commit[_ngcontent-%COMP%]   .mc[_ngcontent-%COMP%] {\n  vertical-align: middle;\n}\n.commit[_ngcontent-%COMP%]   .mc[_ngcontent-%COMP%]    > *[_ngcontent-%COMP%] {\n  vertical-align: middle;\n}\n.commit[_ngcontent-%COMP%]   .mc[_ngcontent-%COMP%]   img[_ngcontent-%COMP%] {\n  height: 24px;\n  border-radius: 50px;\n}\n.commit[_ngcontent-%COMP%]   .sha[_ngcontent-%COMP%] {\n  float: right;\n  color: dodgerblue;\n  padding: 1px 10px;\n  \n  border-radius: 6px;\n  margin-top: -1px;\n  font-size: 14px;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvZGVwbG95L2RlcGxveS5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLG1CQUFBO0FBQ0Y7O0FBQ0E7RUFDRSxzQkFBQTtFQUNBLG1CQUFBO0VBQ0Esa0JBQUE7RUFDQSxrQkFBQTtFQUNBLDRCQUFBO0VBQ0Esa0JBQUE7RUFDQSxrQkFBQTtBQUVGO0FBQUU7RUFDRSxpQkFBQTtFQUNBLGtCQUFBO0FBRUo7QUFDRTtFQUNFLHNCQUFBO0FBQ0o7QUFDSTtFQUNFLHNCQUFBO0FBQ047QUFFSTtFQUNFLFlBQUE7RUFDQSxtQkFBQTtBQUFOO0FBSUU7RUFDRSxZQUFBO0VBTUEsaUJBQUE7RUFDQSxpQkFBQTtFQUNBLHVCQUFBO0VBQ0Esa0JBQUE7RUFDQSxnQkFBQTtFQUVBLGVBQUE7QUFSSiIsInNvdXJjZXNDb250ZW50IjpbIi5tZGMtZXZvbHV0aW9uLWNoaXAtc2V0e1xuICBtYXJnaW4tYm90dG9tOiAxNXB4O1xufVxuLmNvbW1pdCB7XG4gIGJvcmRlcjogc29saWQgMXB4ICNkZGQ7XG4gIG1hcmdpbjogMTBweCAwIDIwcHg7XG4gIHBvc2l0aW9uOiByZWxhdGl2ZTtcbiAgcGFkZGluZzogMTBweCAxNXB4O1xuICBiYWNrZ3JvdW5kLWNvbG9yOiBnaG9zdHdoaXRlO1xuICBib3JkZXItcmFkaXVzOiA2cHg7XG4gIHBhZGRpbmc6IDEwcHggMTVweDtcblxuICAubSB7XG4gICAgZm9udC13ZWlnaHQ6IGJvbGQ7XG4gICAgbWFyZ2luLWJvdHRvbTogNXB4O1xuICB9XG5cbiAgLm1jIHtcbiAgICB2ZXJ0aWNhbC1hbGlnbjogbWlkZGxlO1xuXG4gICAgPiAqIHtcbiAgICAgIHZlcnRpY2FsLWFsaWduOiBtaWRkbGVcbiAgICB9XG5cbiAgICBpbWcge1xuICAgICAgaGVpZ2h0OiAyNHB4O1xuICAgICAgYm9yZGVyLXJhZGl1czogNTBweDtcbiAgICB9XG4gIH1cblxuICAuc2hhIHtcbiAgICBmbG9hdDogcmlnaHQ7XG4gICAgLy9mb250LWZhbWlseTogbW9ub3NwYWNlO1xuICAgIC8vd2lkdGg6IDE0NXB4O1xuICAgIC8vb3ZlcmZsb3c6IGhpZGRlbjtcbiAgICAvL3RleHQtb3ZlcmZsb3c6IGVsbGlwc2lzO1xuICAgIC8vYmFja2dyb3VuZC1jb2xvcjogI2ZmZjtcbiAgICBjb2xvcjogZG9kZ2VyYmx1ZTtcbiAgICBwYWRkaW5nOiAxcHggMTBweDtcbiAgICAvKiBjb2xvcjogZG9kZ2VyYmx1ZTsgKi9cbiAgICBib3JkZXItcmFkaXVzOiA2cHg7XG4gICAgbWFyZ2luLXRvcDogLTFweDtcbiAgICAvL2ZvbnQtd2VpZ2h0OiBib2xkO1xuICAgIGZvbnQtc2l6ZTogMTRweDtcbiAgfVxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 7392:
/*!*****************************************!*\
  !*** ./src/app/deploy/deploy.module.ts ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DeployModule": () => (/* binding */ DeployModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _deploy_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./deploy.component */ 678);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/checkbox */ 4792);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_core__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/core */ 9121);
/* harmony import */ var _angular_material_radio__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @angular/material/radio */ 2922);
/* harmony import */ var _angular_material_select__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @angular/material/select */ 7371);
/* harmony import */ var _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @angular/material/slide-toggle */ 4714);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);
/* harmony import */ var _ng_icons_core__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @ng-icons/core */ 5512);
/* harmony import */ var _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/chips */ 1169);
/* harmony import */ var _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! @angular/material/progress-spinner */ 1708);
/* harmony import */ var _angular_material_card__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! @angular/material/card */ 2156);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ 2560);




















let routes = [{
  path: '',
  component: _deploy_component__WEBPACK_IMPORTED_MODULE_0__.DeployComponent
}, {
  path: ':id',
  component: _deploy_component__WEBPACK_IMPORTED_MODULE_0__.DeployComponent
}];
class DeployModule {}
DeployModule.ɵfac = function DeployModule_Factory(t) {
  return new (t || DeployModule)();
};
DeployModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
  type: DeployModule
});
DeployModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule.forChild(routes), _angular_forms__WEBPACK_IMPORTED_MODULE_4__.FormsModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_6__.MatCheckboxModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__.MatChipsModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_10__.MatInputModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_11__.MatOptionModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_12__.MatRadioModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_13__.MatSelectModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_14__.MatSlideToggleModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_15__.MatTooltipModule, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.ReactiveFormsModule, _ng_icons_core__WEBPACK_IMPORTED_MODULE_16__.NgIconComponent, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_17__.MatProgressSpinnerModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_18__.MatCardModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](DeployModule, {
    declarations: [_deploy_component__WEBPACK_IMPORTED_MODULE_0__.DeployComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_2__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_3__.RouterModule, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.FormsModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButtonModule, _angular_material_checkbox__WEBPACK_IMPORTED_MODULE_6__.MatCheckboxModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormFieldModule, _angular_material_chips__WEBPACK_IMPORTED_MODULE_8__.MatChipsModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIconModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_10__.MatInputModule, _angular_material_core__WEBPACK_IMPORTED_MODULE_11__.MatOptionModule, _angular_material_radio__WEBPACK_IMPORTED_MODULE_12__.MatRadioModule, _angular_material_select__WEBPACK_IMPORTED_MODULE_13__.MatSelectModule, _angular_material_slide_toggle__WEBPACK_IMPORTED_MODULE_14__.MatSlideToggleModule, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_15__.MatTooltipModule, _angular_forms__WEBPACK_IMPORTED_MODULE_4__.ReactiveFormsModule, _ng_icons_core__WEBPACK_IMPORTED_MODULE_16__.NgIconComponent, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_17__.MatProgressSpinnerModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_18__.MatCardModule]
  });
})();

/***/ })

}]);
//# sourceMappingURL=src_app_deploy_deploy_module_ts.js.map