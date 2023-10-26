"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["default-src_app_project_servers_browse-server_browse-server_component_ts"],{

/***/ 2824:
/*!**************************************************************************!*\
  !*** ./src/app/project/servers/browse-server/browse-server.component.ts ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BrowseServerComponent": () => (/* binding */ BrowseServerComponent)
/* harmony export */ });
/* harmony import */ var _angular_material_dialog__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/material/dialog */ 1484);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../helper.service */ 2433);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../api.service */ 1491);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/progress-spinner */ 1708);
/* harmony import */ var _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/material/tooltip */ 6896);













function BrowseServerComponent_div_25_mat_icon_1_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, "folder");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function BrowseServerComponent_div_25_mat_icon_2_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "mat-icon");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, "insert_drive_file");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function BrowseServerComponent_div_25_Template(rf, ctx) {
  if (rf & 1) {
    const _r5 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 15);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BrowseServerComponent_div_25_Template_div_click_0_listener() {
      const restoredCtx = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r5);
      const f_r1 = restoredCtx.$implicit;
      const ctx_r4 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](ctx_r4.gotoPath(f_r1));
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](1, BrowseServerComponent_div_25_mat_icon_1_Template, 2, 0, "mat-icon", 16);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](2, BrowseServerComponent_div_25_mat_icon_2_Template, 2, 0, "mat-icon", 16);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](3, "span", 13);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "span", 17);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](6);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
  }
  if (rf & 2) {
    const f_r1 = ctx.$implicit;
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵclassMapInterpolate1"]("f ", f_r1.type, "");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", f_r1.type == "dir");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", f_r1.type == "file");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", f_r1.path, " ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", f_r1.file_size, " ");
  }
}
const _c0 = function (a0) {
  return {
    "hide": a0
  };
};
class BrowseServerComponent {
  constructor(helper, apiService, dialogRef, data) {
    this.helper = helper;
    this.apiService = apiService;
    this.dialogRef = dialogRef;
    this.data = data;
    this.path = '';
    this.projectId = '';
    this.files = [];
    this.error = '';
    this.calling = false;
    this.projRoot = false;
    this.message = '';
    this.server = this.data.server;
    this.path = this.server.path;
    this.projectId = this.data.project_id;
  }
  ngOnInit() {
    this.call();
  }
  submit() {
    this.dialogRef.close(this.path);
  }
  callT() {
    if (this.callTI) {
      clearTimeout(this.callTI);
      this.callTI = false;
    }
    this.callTI = setTimeout(() => {
      this.call();
    }, 400);
  }
  gotoPath(a) {
    if (a.type == 'dir') {
      this.path = a.path;
      this.call();
    }
  }
  goBack() {
    let a = '../';
    if (this.path) {
      if (this.path.charAt(this.path.length - 1) != '/') this.path += '/';
      console.log(this.path);
      if (this.path.substring(this.path.length - 3) == '../') {
        a = this.path + a;
        // this.path = a;
      } else {
        if (this.path.charAt(this.path.length - 1) == '/') {
          a = this.path.substring(0, this.path.length - 1);
        }
        a = a.substring(0, a.lastIndexOf('/') + 1);
      }
    }
    this.path = a;
  }
  call(writeTest = false, pass = false) {
    this.error = '';
    let ser = Object.assign({}, this.server);
    ser.path = this.path;
    this.calling = true;
    if (writeTest && !pass) {
      // if (!confirm("")) {
      //   return;
      // }
      let dialog = this.helper.alert({
        message: 'Gitftp will attempt to write & delete gitftp-write-test.txt file on this path',
        type: 'alert',
        buttons: ['Close', 'Confirm']
      });
      dialog.afterClosed().subscribe({
        next: a => {
          if (a == 'Confirm') {
            this.call(true, true);
          }
        }
      });
      return;
    }
    this.projRoot = false;
    this.message = '';
    this.apiService.post('server/test', {
      payload: ser,
      write_test: writeTest,
      project_id: this.projectId
    }).subscribe({
      next: res => {
        this.calling = false;
        console.log(res);
        if (res.status) {
          this.message = res.message;
          this.files = res.data.list.map(a => {
            if (a.path.indexOf('gitftp.md') != -1) {
              this.projRoot = true;
            }
            a.file_size = this.helper.bytes(a.file_size, 1);
            return a;
          });
        } else {
          this.error = res.message;
        }
      },
      error: err => {
        this.calling = false;
        this.helper.alertError(err);
      }
    });
  }
}
BrowseServerComponent.ɵfac = function BrowseServerComponent_Factory(t) {
  return new (t || BrowseServerComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_3__.MatDialogRef), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_material_dialog__WEBPACK_IMPORTED_MODULE_3__.MAT_DIALOG_DATA));
};
BrowseServerComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
  type: BrowseServerComponent,
  selectors: [["app-browse-server"]],
  decls: 26,
  vars: 11,
  consts: [[2, "padding-top", "0px"], [1, "bootstrap-wrapper", 2, "padding", "0px 6px 10px", "min-width", "800px", "position", "relative"], [1, "container", 2, "position", "sticky", "padding-top", "25px", "top", "0", "z-index", "2", "background-color", "white"], [1, "row"], [1, "col-12"], [2, "margin-top", "0px"], ["appearance", "outline"], ["matPrefix", "", "diameter", "20", 2, "width", "50px", "padding-left", "5px", 3, "ngClass"], ["matInput", "", "placeholder", "Type path", 2, "font-family", "'Lucida Console', monospace, sans-serif", 3, "ngModel", "keyup.enter", "input", "ngModelChange"], ["matSuffix", "", "type", "button", "mat-icon-button", "", "matTooltip", "Select path", "color", "primary", 2, "margin-right", "5px", 3, "click"], ["type", "button", "mat-stroked-button", "", "color", "primary", 2, "float", "right", "margin-top", "-13px", 3, "click"], [1, "container"], [1, "f", "dir", 3, "click"], [1, "fp"], [3, "class", "click", 4, "ngFor", "ngForOf"], [3, "click"], [4, "ngIf"], [1, "fs"]],
  template: function BrowseServerComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "mat-dialog-content", 0)(1, "div", 1)(2, "div", 2)(3, "div", 3)(4, "div", 4)(5, "h2", 5);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](6, " Locate deploy path ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](7, "mat-form-field", 6);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](8, "mat-spinner", 7);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](9, "input", 8);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("keyup.enter", function BrowseServerComponent_Template_input_keyup_enter_9_listener() {
        return ctx.submit();
      })("input", function BrowseServerComponent_Template_input_input_9_listener() {
        return ctx.callT();
      })("ngModelChange", function BrowseServerComponent_Template_input_ngModelChange_9_listener($event) {
        return ctx.path = $event;
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](10, "button", 9);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BrowseServerComponent_Template_button_click_10_listener() {
        return ctx.submit();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](11, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](12, "check");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](13, "button", 10);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BrowseServerComponent_Template_button_click_13_listener() {
        return ctx.call(true);
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](14, " Test write permission ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](15, "p");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](16);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](17, "div", 11)(18, "div", 3)(19, "div", 4)(20, "div", 12);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function BrowseServerComponent_Template_div_click_20_listener() {
        ctx.goBack();
        return ctx.call();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](21, "mat-icon");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](22, "arrow_upward");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](23, "span", 13);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](24, "\n../ [Navigate up] ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](25, BrowseServerComponent_div_25_Template, 7, 7, "div", 14);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()()();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](8);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngClass", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpureFunction1"](9, _c0, !ctx.calling));
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngModel", ctx.path);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵstyleMapInterpolate1"]("margin-top: 0px;color: ", ctx.error ? "orangered" : "", "");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate3"]("", ctx.message, " ", ctx.error, "\u00A0 ", ctx.projRoot ? "This is the Gitftp installation dir, Navigate up to get parent directories" : "", "");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](9);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngForOf", ctx.files);
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_4__.NgClass, _angular_common__WEBPACK_IMPORTED_MODULE_4__.NgForOf, _angular_common__WEBPACK_IMPORTED_MODULE_4__.NgIf, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButton, _angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatIconButton, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.DefaultValueAccessor, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_6__.NgModel, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatPrefix, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatSuffix, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInput, _angular_material_icon__WEBPACK_IMPORTED_MODULE_9__.MatIcon, _angular_material_progress_spinner__WEBPACK_IMPORTED_MODULE_10__.MatProgressSpinner, _angular_material_dialog__WEBPACK_IMPORTED_MODULE_3__.MatDialogContent, _angular_material_tooltip__WEBPACK_IMPORTED_MODULE_11__.MatTooltip],
  styles: [".f[_ngcontent-%COMP%] {\n  padding: 6px 17px 5px;\n  background-color: white;\n  border-radius: 4px;\n  transition: background-color 0.3s;\n  opacity: 0.5;\n}\n\n.f[_ngcontent-%COMP%]   mat-icon[_ngcontent-%COMP%] {\n  color: #444;\n  margin-right: 14px;\n}\n\n.f[_ngcontent-%COMP%]    > *[_ngcontent-%COMP%] {\n  vertical-align: middle;\n}\n\n.f.dir[_ngcontent-%COMP%] {\n  cursor: pointer;\n  opacity: 1;\n}\n\n.f[_ngcontent-%COMP%]   .fs[_ngcontent-%COMP%] {\n  float: right;\n  margin-top: 5px;\n}\n\n.f[_ngcontent-%COMP%]:hover {\n  background-color: lightblue;\n}\n\n.hide[_ngcontent-%COMP%] {\n  opacity: 0;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvcHJvamVjdC9zZXJ2ZXJzL2Jyb3dzZS1zZXJ2ZXIvYnJvd3NlLXNlcnZlci5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLHFCQUFBO0VBQ0EsdUJBQUE7RUFDQSxrQkFBQTtFQUNBLGlDQUFBO0VBQ0EsWUFBQTtBQUNGOztBQUVBO0VBQ0UsV0FBQTtFQUNBLGtCQUFBO0FBQ0Y7O0FBRUE7RUFDRSxzQkFBQTtBQUNGOztBQUNBO0VBQ0UsZUFBQTtFQUNBLFVBQUE7QUFFRjs7QUFBQTtFQUNFLFlBQUE7RUFDQSxlQUFBO0FBR0Y7O0FBQUE7RUFDRSwyQkFBQTtBQUdGOztBQUtBO0VBQ0UsVUFBQTtBQUZGIiwic291cmNlc0NvbnRlbnQiOlsiLmYge1xuICBwYWRkaW5nOiA2cHggMTdweCA1cHg7XG4gIGJhY2tncm91bmQtY29sb3I6IHdoaXRlO1xuICBib3JkZXItcmFkaXVzOiA0cHg7XG4gIHRyYW5zaXRpb246IGJhY2tncm91bmQtY29sb3IgLjNzO1xuICBvcGFjaXR5OiAuNTtcbn1cblxuLmYgbWF0LWljb24ge1xuICBjb2xvcjogIzQ0NDtcbiAgbWFyZ2luLXJpZ2h0OiAxNHB4XG59XG5cbi5mID4gKiB7XG4gIHZlcnRpY2FsLWFsaWduOiBtaWRkbGU7XG59XG4uZi5kaXJ7XG4gIGN1cnNvcjogcG9pbnRlcjtcbiAgb3BhY2l0eTogMTtcbn1cbi5mIC5mcyB7XG4gIGZsb2F0OiByaWdodDtcbiAgbWFyZ2luLXRvcDogNXB4XG59XG5cbi5mOmhvdmVyIHtcbiAgYmFja2dyb3VuZC1jb2xvcjogbGlnaHRibHVlO1xufVxuLy9cbi8vOjpuZy1kZWVwe1xuLy8gIG1hdC1tZGMtZGlhbG9nLWNvbnRlbnR7XG4vL1xuLy8gIH1cbi8vfVxuLmhpZGV7XG4gIG9wYWNpdHk6IDA7XG59XG4iXSwic291cmNlUm9vdCI6IiJ9 */"]
});

/***/ })

}]);
//# sourceMappingURL=default-src_app_project_servers_browse-server_browse-server_component_ts.js.map