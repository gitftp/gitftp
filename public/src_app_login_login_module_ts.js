"use strict";
(self["webpackChunkng"] = self["webpackChunkng"] || []).push([["src_app_login_login_module_ts"],{

/***/ 8458:
/*!******************************************!*\
  !*** ./src/app/login/login.component.ts ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "LoginComponent": () => (/* binding */ LoginComponent)
/* harmony export */ });
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../api.service */ 1491);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../helper.service */ 2433);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/input */ 8562);









class LoginComponent {
  constructor(
  // private updateMi
  fb, api, helper, router) {
    this.fb = fb;
    this.api = api;
    this.helper = helper;
    this.router = router;
    this.submitting = false;
    this.form = this.fb.group({
      'email': ['bonifacepereira@gmail.com', [_angular_forms__WEBPACK_IMPORTED_MODULE_2__.Validators.required, _angular_forms__WEBPACK_IMPORTED_MODULE_2__.Validators.email]],
      'password': ['asdasdasd', [_angular_forms__WEBPACK_IMPORTED_MODULE_2__.Validators.required]]
    });
    let user = this.helper.getUser();
    if (user.token) {
      this.router.navigate(['/']);
    }
  }
  ngOnInit() {}
  submit() {
    if (this.form?.invalid) {
      this.form.markAllAsTouched();
      return;
    }
    this.submitting = true;
    this.api.post('auth/login', this.form?.value).subscribe({
      next: res => {
        this.submitting = false;
        console.log(res);
        if (res.status) {
          let user = res.data;
          this.helper.setUser(user);
          this.router.navigate(['home']);
        } else {
          this.helper.alert({
            message: res.message,
            exception: res.exception
          });
        }
      },
      error: err => {
        this.submitting = false;
        this.helper.alert({
          message: err
        });
      }
    });
  }
}
LoginComponent.ɵfac = function LoginComponent_Factory(t) {
  return new (t || LoginComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_2__.FormBuilder), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_0__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_1__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_4__.Router));
};
LoginComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineComponent"]({
  type: LoginComponent,
  selectors: [["app-login"]],
  decls: 21,
  vars: 1,
  consts: [[1, "lc"], [1, "l"], ["src", "assets/logo.png", "alt", "", 1, "logo"], [1, "head-t", 2, "margin-top", "36px"], [2, "width", "500px", 3, "formGroup", "submit"], ["appearance", "outline", 1, "mr2", 2, "width", "300px"], ["matInput", "", "formControlName", "email"], ["matInput", "", "formControlName", "password"], ["type", "submit", "color", "primary", "mat-flat-button", ""]],
  template: function LoginComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](0, "div", 0)(1, "div", 1);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](2, "img", 2);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](3, "h1", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](4, "Login");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](5, "p");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](6, " Please enter credentials to log into Gitftp ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](7, "div", 1)(8, "form", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵlistener"]("submit", function LoginComponent_Template_form_submit_8_listener() {
        return ctx.submit();
      });
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](9, "mat-form-field", 5)(10, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](11, "Email");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](12, "input", 6);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](13, "br");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](14, "mat-form-field", 5)(15, "mat-label");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](16, "Password");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelement"](17, "input", 7);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementStart"](18, "div")(19, "button", 8);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵtext"](20, " Login ");
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵelementEnd"]()()()()();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵadvance"](8);
      _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵproperty"]("formGroup", ctx.form);
    }
  },
  dependencies: [_angular_material_button__WEBPACK_IMPORTED_MODULE_5__.MatButton, _angular_forms__WEBPACK_IMPORTED_MODULE_2__["ɵNgNoValidate"], _angular_forms__WEBPACK_IMPORTED_MODULE_2__.DefaultValueAccessor, _angular_forms__WEBPACK_IMPORTED_MODULE_2__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_2__.NgControlStatusGroup, _angular_forms__WEBPACK_IMPORTED_MODULE_2__.FormGroupDirective, _angular_forms__WEBPACK_IMPORTED_MODULE_2__.FormControlName, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_6__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_6__.MatLabel, _angular_material_input__WEBPACK_IMPORTED_MODULE_7__.MatInput],
  styles: ["\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsInNvdXJjZVJvb3QiOiIifQ== */", ".lc[_ngcontent-%COMP%] {\n  width: 100%;\n}\n.lc[_ngcontent-%COMP%]   .l[_ngcontent-%COMP%] {\n  margin: 55px;\n}\n.lc[_ngcontent-%COMP%]   .logo[_ngcontent-%COMP%] {\n  height: 50px;\n  margin-bottom: 10px;\n  margin-left: -10px;\n}\n.lc[_ngcontent-%COMP%]   mat-card[_ngcontent-%COMP%]   .head-t[_ngcontent-%COMP%] {\n  margin: 0;\n  font-weight: normal;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvc2V0dXAvc2V0dXAuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFFRSxXQUFBO0FBQUY7QUFHRTtFQUlFLFlBQUE7QUFKSjtBQU9FO0VBQ0UsWUFBQTtFQUNBLG1CQUFBO0VBQ0Esa0JBQUE7QUFMSjtBQVVJO0VBQ0UsU0FBQTtFQUNBLG1CQUFBO0FBUk4iLCJzb3VyY2VzQ29udGVudCI6WyIubGMge1xuICAvL2JhY2tncm91bmQtY29sb3I6IHdoaXRlO1xuICB3aWR0aDogMTAwJTtcbiAgLy90ZXh0LWFsaWduOiBjZW50ZXI7XG5cbiAgLmwge1xuICAgIC8vbWF4LXdpZHRoOiA0MDBweDtcbiAgICAvL21hcmdpbjogMCBhdXRvO1xuICAgIC8vbWFyZ2luLXRvcDogMjAwcHg7XG4gICAgbWFyZ2luOiA1NXB4O1xuICB9XG5cbiAgLmxvZ28ge1xuICAgIGhlaWdodDogNTBweDtcbiAgICBtYXJnaW4tYm90dG9tOiAxMHB4O1xuICAgIG1hcmdpbi1sZWZ0OiAtMTBweDtcbiAgICAvL21hcmdpbi10b3A6IC01cHg7XG4gIH1cblxuICBtYXQtY2FyZCB7XG4gICAgLmhlYWQtdCB7XG4gICAgICBtYXJnaW46IDA7XG4gICAgICBmb250LXdlaWdodDogbm9ybWFsO1xuICAgIH1cbiAgfVxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ }),

/***/ 107:
/*!***************************************!*\
  !*** ./src/app/login/login.module.ts ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "LoginModule": () => (/* binding */ LoginModule)
/* harmony export */ });
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _login_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./login.component */ 8458);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _setup_setup_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../setup/setup.component */ 4743);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/material/icon */ 7822);
/* harmony import */ var _angular_material_card__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/material/card */ 2156);
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/material/input */ 8562);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);












let routes = [{
  path: 'login',
  component: _login_component__WEBPACK_IMPORTED_MODULE_0__.LoginComponent
}, {
  path: 'setup',
  component: _setup_setup_component__WEBPACK_IMPORTED_MODULE_1__.SetupComponent
}];
class LoginModule {}
LoginModule.ɵfac = function LoginModule_Factory(t) {
  return new (t || LoginModule)();
};
LoginModule.ɵmod = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineNgModule"]({
  type: LoginModule
});
LoginModule.ɵinj = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineInjector"]({
  imports: [_angular_common__WEBPACK_IMPORTED_MODULE_3__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule.forChild(routes), _angular_material_card__WEBPACK_IMPORTED_MODULE_5__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_9__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__.MatIconModule]
});
(function () {
  (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵsetNgModuleScope"](LoginModule, {
    declarations: [_login_component__WEBPACK_IMPORTED_MODULE_0__.LoginComponent, _setup_setup_component__WEBPACK_IMPORTED_MODULE_1__.SetupComponent],
    imports: [_angular_common__WEBPACK_IMPORTED_MODULE_3__.CommonModule, _angular_router__WEBPACK_IMPORTED_MODULE_4__.RouterModule, _angular_material_card__WEBPACK_IMPORTED_MODULE_5__.MatCardModule, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButtonModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.FormsModule, _angular_forms__WEBPACK_IMPORTED_MODULE_7__.ReactiveFormsModule, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_8__.MatFormFieldModule, _angular_material_input__WEBPACK_IMPORTED_MODULE_9__.MatInputModule, _angular_material_icon__WEBPACK_IMPORTED_MODULE_10__.MatIconModule]
  });
})();

/***/ }),

/***/ 4743:
/*!******************************************!*\
  !*** ./src/app/setup/setup.component.ts ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SetupComponent": () => (/* binding */ SetupComponent)
/* harmony export */ });
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/forms */ 2508);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/core */ 2560);
/* harmony import */ var _helper_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helper.service */ 2433);
/* harmony import */ var _api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../api.service */ 1491);
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/router */ 124);
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/common */ 4666);
/* harmony import */ var _angular_material_button__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material/button */ 4522);
/* harmony import */ var _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/material/form-field */ 5074);
/* harmony import */ var _angular_material_input__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/material/input */ 8562);










function SetupComponent_div_7_li_6_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "li");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r3 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate2"](" Git: ", ctx_r3.deps.git[0], " ", ctx_r3.deps == null ? null : ctx_r3.deps.git[1], " ");
  }
}
function SetupComponent_div_7_li_7_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "li");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r4 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate2"](" Php: ", ctx_r4.deps.php[0], " ", ctx_r4.deps == null ? null : ctx_r4.deps.php[1], " ");
  }
}
function SetupComponent_div_7_li_8_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "li");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r5 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" OS: ", ctx_r5.deps.os, " ");
  }
}
function SetupComponent_div_7_li_9_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "li");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, " All OK \uD83D\uDC4D ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function SetupComponent_div_7_button_10_Template(rf, ctx) {
  if (rf & 1) {
    const _r9 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "button", 7);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("click", function SetupComponent_div_7_button_10_Template_button_click_0_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r9);
      const ctx_r8 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
      return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](ctx_r8.page = "db");
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, " Continue ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function SetupComponent_div_7_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 1)(1, "h2");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](2, "Dependency Check");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](3, "p");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Checking if all the required dependencies are met. ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "ul");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](6, SetupComponent_div_7_li_6_Template, 2, 2, "li", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](7, SetupComponent_div_7_li_7_Template, 2, 2, "li", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](8, SetupComponent_div_7_li_8_Template, 2, 1, "li", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](9, SetupComponent_div_7_li_9_Template, 2, 0, "li", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](10, SetupComponent_div_7_button_10_Template, 2, 0, "button", 6);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r0 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r0.deps && ctx_r0.deps.git);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r0.deps && ctx_r0.deps.php);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r0.deps && ctx_r0.deps.php);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r0.deps && ctx_r0.deps.status);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r0.deps && ctx_r0.deps.status);
  }
}
function SetupComponent_div_8_p_32_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "p", 19);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r10 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", ctx_r10.dbMsg, " ");
  }
}
function SetupComponent_div_8_span_35_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "span");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1, "ing");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
}
function SetupComponent_div_8_Template(rf, ctx) {
  if (rf & 1) {
    const _r13 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 1)(1, "h2");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](2, "Setup MySQL database");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](3, "p");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, " Please enter the credentials for database where you want Gitftp schema to be installed. ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](5, "div", 8);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](6, "form", 9);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("submit", function SetupComponent_div_8_Template_form_submit_6_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r13);
      const ctx_r12 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](ctx_r12.testDbConnection());
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](7, "mat-form-field", 10)(8, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](9, "Host");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](10, "input", 11);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](11, "mat-form-field", 10)(12, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](13, "Database name");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](14, "input", 12);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](15, "mat-form-field", 10)(16, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](17, "Username");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](18, "input", 13);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](19, "mat-form-field", 10)(20, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](21, "Password");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](22, "input", 14);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](23, "mat-form-field", 10)(24, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](25, "Port");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](26, "input", 15);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](27, "mat-form-field", 10)(28, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](29, "Unix socket");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](30, "input", 16);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](31, "div");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](32, SetupComponent_div_8_p_32_Template, 2, 1, "p", 17);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](33, "button", 18);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](34, " Test");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](35, SetupComponent_div_8_span_35_Template, 2, 0, "span", 5);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](36, " connection ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()();
  }
  if (rf & 2) {
    const ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("formGroup", ctx_r1.dbForm);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](26);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r1.dbMsg);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("disabled", ctx_r1.testingDbConnection);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r1.testingDbConnection);
  }
}
function SetupComponent_div_9_p_26_Template(rf, ctx) {
  if (rf & 1) {
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "p", 26);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
  }
  if (rf & 2) {
    const ctx_r14 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"](2);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", ctx_r14.setupProgress, "... ");
  }
}
function SetupComponent_div_9_Template(rf, ctx) {
  if (rf & 1) {
    const _r16 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵgetCurrentView"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 1)(1, "form", 9);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("submit", function SetupComponent_div_9_Template_form_submit_1_listener() {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵrestoreView"](_r16);
      const ctx_r15 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
      return _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵresetView"](ctx_r15.setupSubmit());
    });
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](2, "h2");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](3, "Create admin user");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](4, "p");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](5, " Please enter new credentials to log into Gitftp ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](6, "mat-form-field", 20)(7, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](8, "Email");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](9, "input", 21);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](10, "br");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](11, "mat-form-field", 10)(12, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](13, "Password");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](14, "input", 14);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](15, "mat-form-field", 10)(16, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](17, "Confirm password");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](18, "input", 22);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](19, "h2");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](20, "Site");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](21, "mat-form-field", 23)(22, "mat-label");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](23, "Public domain");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](24, "input", 24);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](25, "div");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](26, SetupComponent_div_9_p_26_Template, 2, 1, "p", 25);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](27, "button", 18);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](28, " Start setup ");
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()()()();
  }
  if (rf & 2) {
    const ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("formGroup", ctx_r2.userForm);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](25);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx_r2.setupProgress);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
    _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("disabled", ctx_r2.setupLoading || ctx_r2.userForm.invalid);
  }
}
class SetupComponent {
  constructor(helper, apiService, fb, router) {
    this.helper = helper;
    this.apiService = apiService;
    this.fb = fb;
    this.router = router;
    this.page = 'deps';
    this.setupLoading = false;
    this.setupProgress = '';
    this.testingDbConnection = false;
    this.dbError = '';
    this.dbMsg = '';
    this.checkingDeps = false;
  }
  ngOnInit() {
    this.depsCheck();
    this.prepareDatabaseForm();
    this.prepareUserForm();
  }
  // page: string = 'user';
  prepareDatabaseForm() {
    this.dbForm = this.fb.group({
      host: ['gfdatabase', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      username: ['root', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      password: ['root', []],
      database: ['gf', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      port: ['3306', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      socket: ['', []]
    });
  }
  prepareUserForm() {
    this.userForm = this.fb.group({
      'email': ['asd@asd.com', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.email, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]],
      'password': ['asdasdasd', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.minLength(3)]],
      'confirm_password': ['asdasdasd', [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.minLength(3)]],
      public_domain: [window.location.origin, [_angular_forms__WEBPACK_IMPORTED_MODULE_3__.Validators.required]]
    });
  }
  setupSubmit() {
    if (this.userForm.invalid) {
      this.userForm.markAllAsTouched();
      return;
    }
    let userValues = this.userForm.value;
    if (userValues.password != userValues.confirm_password) {
      this.helper.alert({
        message: 'The password does not match, please try again',
        type: 'error'
      });
      return;
    }
    this.setupProgress = 'Creating config file';
    this.setupLoading = true;
    this.userForm.disable();
    this.apiService.post('auth/save-setup', {
      user: this.userForm.value,
      database: this.dbForm.value
    }).subscribe({
      next: res => {
        if (res.status) {
          // setup was saved
          this.setupProgress = 'Running database Migrate';
          this.apiService.post('auth/init-setup', {
            user: this.userForm.value
          }).subscribe({
            next: res => {
              if (res.status) {
                this.setupProgress = 'Creating admin user';
                setTimeout(() => {
                  this.router.navigate(['/']);
                }, 1000);
                this.setupLoading = false;
              } else {
                this.userForm.enable();
                this.setupProgress = '';
                this.setupLoading = false;
                this.helper.alert({
                  message: res.message,
                  exception: res.exception,
                  type: 'error'
                });
              }
            },
            error: err => {
              this.userForm.enable();
              this.setupProgress = '';
              this.setupLoading = false;
              this.helper.alert({
                message: err,
                type: 'error'
              });
            }
          });
        } else {
          this.userForm.enable();
          this.setupProgress = '';
          this.setupLoading = false;
          this.helper.alert({
            message: res.message,
            exception: res.exception,
            type: 'error'
          });
        }
      },
      error: err => {
        this.userForm.enable();
        this.setupProgress = '';
        this.setupLoading = false;
        this.helper.alert({
          message: err,
          type: 'error'
        });
      }
    });
  }
  testDbConnection() {
    if (this.dbForm.invalid) {
      this.dbForm?.markAllAsTouched();
      return;
    }
    this.testingDbConnection = true;
    this.dbError = '';
    this.dbMsg = '';
    this.apiService.post('auth/db-test', this.dbForm?.value).subscribe({
      next: res => {
        if (res.status) {
          setTimeout(() => {
            this.testingDbConnection = false;
            this.page = 'user';
          }, 1000);
          this.dbMsg = 'Successfully connected to mysql server';
          this.dbForm.disable();
        } else {
          this.testingDbConnection = false;
          this.helper.alert({
            message: res.message,
            exception: res.exception,
            type: 'error'
          });
        }
      },
      error: err => {
        this.testingDbConnection = false;
        this.helper.alert({
          message: 'Network error',
          type: 'error'
        });
      }
    });
  }
  depsCheck() {
    this.checkingDeps = true;
    this.apiService.post('auth/deps', {}).subscribe({
      next: res => {
        this.checkingDeps = false;
        if (res.status) {
          this.deps = res.data;
        } else {
          this.helper.alert({
            message: res.message,
            type: 'Error'
          });
        }
      },
      error: err => {
        this.checkingDeps = false;
        this.helper.alert({
          message: err,
          type: 'error'
        });
      }
    });
  }
}
SetupComponent.ɵfac = function SetupComponent_Factory(t) {
  return new (t || SetupComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_helper_service__WEBPACK_IMPORTED_MODULE_0__.HelperService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_api_service__WEBPACK_IMPORTED_MODULE_1__.ApiService), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormBuilder), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_4__.Router));
};
SetupComponent.ɵcmp = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
  type: SetupComponent,
  selectors: [["app-setup"]],
  decls: 10,
  vars: 3,
  consts: [[1, "lc"], [1, "l"], ["src", "assets/logo.png", "alt", "", 1, "logo"], [1, "head-t"], ["class", "l", 4, "ngIf"], [4, "ngIf"], ["type", "button", "color", "primary", "mat-flat-button", "", 3, "click", 4, "ngIf"], ["type", "button", "color", "primary", "mat-flat-button", "", 3, "click"], [2, "height", "10px"], [2, "width", "500px", 3, "formGroup", "submit"], ["appearance", "outline", 1, "mr2"], ["matInput", "", "formControlName", "host"], ["matInput", "", "formControlName", "database"], ["matInput", "", "formControlName", "username"], ["matInput", "", "formControlName", "password"], ["matInput", "", "formControlName", "port"], ["matInput", "", "formControlName", "socket"], ["style", "color: forestgreen;\n                  margin-top: 0;\n                  margin-bottom: 21px;", 4, "ngIf"], ["type", "submit", "color", "primary", "mat-flat-button", "", 3, "disabled"], [2, "color", "forestgreen", "margin-top", "0", "margin-bottom", "21px"], ["appearance", "outline", 1, "mr2", 2, "width", "300px"], ["matInput", "", "formControlName", "email"], ["matInput", "", "formControlName", "confirm_password"], ["appearance", "outline", 1, "mr2", 2, "width", "350px"], ["matInput", "", "formControlName", "public_domain"], ["style", "color: black;\n                  margin-top: 0;\n                  margin-bottom: 21px;", 4, "ngIf"], [2, "color", "black", "margin-top", "0", "margin-bottom", "21px"]],
  template: function SetupComponent_Template(rf, ctx) {
    if (rf & 1) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 0)(1, "div", 1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](2, "img", 2);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](3, "h1", 3);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](4, "Welcome to Gitftp");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](5, "p");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](6, " no .env file is present, setup will continue. ");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]()();
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](7, SetupComponent_div_7_Template, 11, 5, "div", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](8, SetupComponent_div_8_Template, 37, 4, "div", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](9, SetupComponent_div_9_Template, 29, 3, "div", 4);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
    }
    if (rf & 2) {
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](7);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.page == "deps");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.deps && ctx.deps.status && ctx.page == "db");
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);
      _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.deps && ctx.deps.status && ctx.page == "user");
    }
  },
  dependencies: [_angular_common__WEBPACK_IMPORTED_MODULE_5__.NgIf, _angular_material_button__WEBPACK_IMPORTED_MODULE_6__.MatButton, _angular_forms__WEBPACK_IMPORTED_MODULE_3__["ɵNgNoValidate"], _angular_forms__WEBPACK_IMPORTED_MODULE_3__.DefaultValueAccessor, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.NgControlStatus, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.NgControlStatusGroup, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormGroupDirective, _angular_forms__WEBPACK_IMPORTED_MODULE_3__.FormControlName, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatFormField, _angular_material_form_field__WEBPACK_IMPORTED_MODULE_7__.MatLabel, _angular_material_input__WEBPACK_IMPORTED_MODULE_8__.MatInput],
  styles: [".lc[_ngcontent-%COMP%] {\n  width: 100%;\n}\n.lc[_ngcontent-%COMP%]   .l[_ngcontent-%COMP%] {\n  margin: 55px;\n}\n.lc[_ngcontent-%COMP%]   .logo[_ngcontent-%COMP%] {\n  height: 50px;\n  margin-bottom: 10px;\n  margin-left: -10px;\n}\n.lc[_ngcontent-%COMP%]   mat-card[_ngcontent-%COMP%]   .head-t[_ngcontent-%COMP%] {\n  margin: 0;\n  font-weight: normal;\n}\n/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8uL3NyYy9hcHAvc2V0dXAvc2V0dXAuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFFRSxXQUFBO0FBQUY7QUFHRTtFQUlFLFlBQUE7QUFKSjtBQU9FO0VBQ0UsWUFBQTtFQUNBLG1CQUFBO0VBQ0Esa0JBQUE7QUFMSjtBQVVJO0VBQ0UsU0FBQTtFQUNBLG1CQUFBO0FBUk4iLCJzb3VyY2VzQ29udGVudCI6WyIubGMge1xuICAvL2JhY2tncm91bmQtY29sb3I6IHdoaXRlO1xuICB3aWR0aDogMTAwJTtcbiAgLy90ZXh0LWFsaWduOiBjZW50ZXI7XG5cbiAgLmwge1xuICAgIC8vbWF4LXdpZHRoOiA0MDBweDtcbiAgICAvL21hcmdpbjogMCBhdXRvO1xuICAgIC8vbWFyZ2luLXRvcDogMjAwcHg7XG4gICAgbWFyZ2luOiA1NXB4O1xuICB9XG5cbiAgLmxvZ28ge1xuICAgIGhlaWdodDogNTBweDtcbiAgICBtYXJnaW4tYm90dG9tOiAxMHB4O1xuICAgIG1hcmdpbi1sZWZ0OiAtMTBweDtcbiAgICAvL21hcmdpbi10b3A6IC01cHg7XG4gIH1cblxuICBtYXQtY2FyZCB7XG4gICAgLmhlYWQtdCB7XG4gICAgICBtYXJnaW46IDA7XG4gICAgICBmb250LXdlaWdodDogbm9ybWFsO1xuICAgIH1cbiAgfVxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ== */"]
});

/***/ })

}]);
//# sourceMappingURL=src_app_login_login_module_ts.js.map