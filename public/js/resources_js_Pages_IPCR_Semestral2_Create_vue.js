"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_IPCR_Semestral2_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");
var _props;



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


 //import Places from "@/Shared/PlacesShared";

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: (_props = {
    editData: Object,
    id: String,
    emp: Object,
    supervisors: Object
  }, _defineProperty(_props, "emp", Object), _defineProperty(_props, "dept_code", String), _defineProperty(_props, "source", String), _defineProperty(_props, "auth", Object), _defineProperty(_props, "offices", Object), _defineProperty(_props, "pgheads", Object), _props),
  components: {
    ModelSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_2__.ModelSelect
  },
  data: function data() {
    return {
      submitted: false,
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.useForm)({
        sem: "",
        employee_code: "",
        immediate_id: "",
        next_higher: "",
        employee_name: "",
        position: "",
        employment_type: "",
        salary_grade: "",
        division: "",
        year: "",
        status: "",
        status_accomplishment: "",
        department_code: "",
        department: "",
        division_name: "",
        pg_dept_head: "",
        empl_id_hashed: "",
        id: null
      }),
      emp_sg: this.auth.user.name.salary_grade,
      sal_grade: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33'],
      immediate_sg: "0",
      ipcr_mfo: "",
      ipcr_submfo: "",
      ipcr_div_output: "",
      ipcr_ind_output: "",
      ipcr_performance: "",
      ipcr_success: "",
      pageTitle: "",
      selected_value: [],
      divisions: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.form.source = this.source; // this.form.ipcr_semester_id="0";

    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.sem = this.editData.sem;
      this.form.employee_code = this.editData.employee_code;
      this.form.immediate_id = this.editData.immediate_id;
      this.form.next_higher = this.editData.next_higher;
      this.form.employee_name = this.editData.employee_name;
      this.form.position = this.editData.position;
      this.form.employment_type = this.editData.employment_type;
      this.form.salary_grade = this.editData.salary_grade;
      this.form.year = this.editData.year;
      this.form.status = this.editData.status;
      this.form.status_accomplishment = this.editData.status_accomplishment;
      this.form.department_code = this.editData.department_code;
      this.form.department = this.editData.department;
      this.form.empl_id_hashed = this.editData.empl_id_hashed;
      this.form.pg_dept_head = this.editData.pg_dept_head;
      this.form.id = this.editData.id;
      setTimeout(function () {
        _this.loadDivisions();

        _this.form.division = _this.editData.division;
        _this.form.division_name = _this.editData.division_name;
      }, 1000); // alert(this.id)
    } else {
      this.form.employee_code = this.emp.empl_id;
      this.pageTitle = "Create";
      this.form.status = "-1";
      this.setYear();
    }
  },
  computed: {
    month_list: function month_list() {
      var mos = [];

      if (this.form.semester === "1") {
        mos = ["January", "February", "March", "April", "May", "June"];
      } else if (this.form.semester === "2") {
        mos = ["July", "August", "September", "October", "November", "December"];
      } else {
        mos = ["", "", "", "", "", ""];
      }

      return mos;
    },
    quantity_needed: function quantity_needed() {
      var v1 = 0;
      var v2 = 0;
      var v3 = 0;
      var v4 = 0;
      var v5 = 0;
      var v6 = 0;

      if (this.form.month_1 !== "" || this.form.month_1 !== undefined) {
        v1 = parseFloat(this.form.month_1);
        v2 = parseFloat(this.form.month_2);
        v3 = parseFloat(this.form.month_3);
        v4 = parseFloat(this.form.month_4);
        v5 = parseFloat(this.form.month_5);
        v6 = parseFloat(this.form.month_6);
      }

      var sem_targ = parseFloat(this.form.quantity_sem);
      var sum = v1 + v2 + v3 + v4 + v5 + v6;
      var ret = "";
      var diff = 0;

      if (sem_targ > sum) {
        diff = sem_targ - sum;
        ret = "Add " + diff + " to your monthly targets!";
      } else if (sem_targ < sum) {
        diff = sum - sem_targ;
        ret = "Remove " + diff + " from your monthly targets!";
      }

      return ret;
    },
    supervisors_i: function supervisors_i() {
      var supervises = this.supervisors;
      return supervises.map(function (superv) {
        return {
          value: superv.empl_id,
          label: superv.employee_name,
          salary_grade: superv.salary_grade
        };
      });
    },
    supervisors_h: function supervisors_h() {
      var supervises = this.supervisors;
      var msg = parseFloat(this.immediate_sg);

      if (this.emp.department_code == 19 || this.emp.department_code == 18) {// alert('Hfsdfsdfsdf');
      } else {
        if (msg > 0) {
          supervises = supervises.filter(function (superv) {
            return superv.salary_grade >= msg;
          });
        }

        if (supervises.length === 0) {
          supervises = this.supervisors;
          supervises = supervises.filter(function (superv) {
            return superv.salary_grade >= msg;
          });
        }
      }

      return supervises.map(function (superv) {
        return {
          value: superv.empl_id,
          label: superv.employee_name,
          salary_grade: superv.salary_grade
        };
      });
    }
  },
  methods: {
    submit: function submit() {
      if (this.editData !== undefined) {
        /*if (this.form.status > 0) {
            alert('Already approved or reviewed!')
        } else {
         }*/
        //Route::patch('/update/{id}', [IpcrSemestralController::class, 'update2']);
        alert('ipcr sem2 update');
        this.form.patch("/ipcrsemestral2/update/" + this.editData.id + '/save/it/now', this.form);
      } else {
        alert('store'); // this.form.post("/ipcrsemestral/store/" + this.id);
      }
    },
    setYear: function setYear() {
      var now = new Date();
      this.form.year = now.getFullYear();
    },
    setSG: function setSG() {
      var recid = this.form.immediate_id;
      var index = this.supervisors.findIndex(function (superv) {
        return superv.empl_id === recid;
      });

      if (index !== -1) {
        this.immediate_sg = this.supervisors[index].salary_grade;
      } else {
        this.immediate_sg = "0";
      }
    },
    inheritDepartmentWord: function inheritDepartmentWord() {
      var _this2 = this;

      var selectedOffice = this.offices.find(function (office) {
        return office.department_code === _this2.form.department_code;
      });

      if (selectedOffice) {
        this.form.department = selectedOffice.office;
      }

      this.loadDivisions();
    },
    inheritDivisionWord: function inheritDivisionWord() {
      var _this3 = this;

      var selectedOffice = this.divisions.find(function (division) {
        return division.division_code === _this3.form.division;
      });

      if (selectedOffice) {
        this.form.division_name = selectedOffice.division_name1;
      }
    },
    loadDivisions: function loadDivisions() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                //alert("select_mun is :"+select_mun);
                _this4.all_barangays = [];
                _this4.all_puroks = [];
                axios.get("/ipcrsemestral2/get/divisions/" + _this4.form.department_code).then(function (response) {
                  _this4.divisions = response.data;
                }); // this.filterData();

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    goBack: function goBack() {
      window.history.back();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b":
/*!***************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "relative row gap-20 masonry pos-r"
};
var _hoisted_2 = {
  "class": "peers fxw-nw jc-sb ai-c"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "25",
  height: "25",
  fill: "currentColor",
  "class": "bi bi-x-lg",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"
})], -1
/* HOISTED */
);

var _hoisted_4 = [_hoisted_3];
var _hoisted_5 = {
  "class": "col-md-8"
};

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Name: ");

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Position: ");

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Employment Status: ");

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1
/* HOISTED */
);

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Employee Name", -1
/* HOISTED */
);

var _hoisted_11 = {
  key: 0,
  "class": "fs-6 c-red-500"
};

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Position", -1
/* HOISTED */
);

var _hoisted_13 = {
  key: 1,
  "class": "fs-6 c-red-500"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Salary Grade", -1
/* HOISTED */
);

var _hoisted_15 = {
  key: 2,
  "class": "fs-6 c-red-500"
};

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Employment Status", -1
/* HOISTED */
);

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, "Job Order", -1
/* HOISTED */
);

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, "Casual", -1
/* HOISTED */
);

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, "Regular", -1
/* HOISTED */
);

var _hoisted_20 = [_hoisted_17, _hoisted_18, _hoisted_19];
var _hoisted_21 = {
  key: 3,
  "class": "fs-6 c-red-500"
};

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Department", -1
/* HOISTED */
);

var _hoisted_23 = ["value"];
var _hoisted_24 = {
  key: 4,
  "class": "fs-6 c-red-500"
};

var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Division", -1
/* HOISTED */
);

var _hoisted_26 = ["value"];
var _hoisted_27 = {
  key: 5,
  "class": "fs-6 c-red-500"
};

var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Department Head", -1
/* HOISTED */
);

var _hoisted_29 = ["value"];
var _hoisted_30 = {
  key: 6,
  "class": "fs-6 c-red-500"
};

var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Immediate Supervisor", -1
/* HOISTED */
);

var _hoisted_32 = {
  key: 7,
  "class": "fs-6 c-red-500"
};

var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Next Higher Supervisor", -1
/* HOISTED */
);

var _hoisted_34 = {
  key: 8,
  "class": "fs-6 c-red-500"
};
var _hoisted_35 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " IPCR", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Link v-if=\"editData !== undefined\" :href=\"`/ipcrsemestral/${emp.id}/${source}`\">\n            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"25\" fill=\"currentColor\" class=\"bi bi-x-lg\"\n                viewBox=\"0 0 16 16\">\n                <path fill-rule=\"evenodd\"\n                    d=\"M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z\" />\n                <path fill-rule=\"evenodd\"\n                    d=\"M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z\" />\n            </svg>\n            </Link>\n            <Link v-else :href=\"`/ipcrsemestral/${id}/${source}`\">\n            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"25\" fill=\"currentColor\" class=\"bi bi-x-lg\"\n                viewBox=\"0 0 16 16\">\n                <path fill-rule=\"evenodd\"\n                    d=\"M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z\" />\n                <path fill-rule=\"evenodd\"\n                    d=\"M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z\" />\n            </svg>\n            </Link> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-danger text-white",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.goBack && $options.goBack.apply($options, arguments);
    })
  }, _hoisted_4)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData.id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData }}{{ form.semester }}{{ editData.sem }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.status }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.emp.employee_name), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.emp.position_long_title), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.emp.employment_type_descr), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "class": "form-control",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.employee_name = $event;
    })
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.employee_name]]), $data.form.errors.employee_name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employee_name), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "class": "form-control",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.form.position = $event;
    })
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.position]]), $data.form.errors.position ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.position), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.form.salary_grade = $event;
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.sal_grade, function (sg) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(sg), 1
    /* TEXT */
    );
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.salary_grade]]), $data.form.errors.salary_grade ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.salary_grade), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "class": "form-control",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.form.employment_type = $event;
    })
  }, _hoisted_20, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.employment_type]]), $data.form.errors.employment_type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employment_type), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "class": "form-control",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.form.department = $event;
    }),
    hidden: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.department]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.department_code = $event;
    }),
    onChange: _cache[7] || (_cache[7] = function () {
      return $options.inheritDepartmentWord && $options.inheritDepartmentWord.apply($options, arguments);
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.offices, function (office) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: office.department_code
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(office.office), 9
    /* TEXT, PROPS */
    , _hoisted_23);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.department_code]]), $data.form.errors.department_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.department_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.division }}\n{{ divisions }} "), _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "class": "form-control",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.division_name = $event;
    }),
    hidden: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.division_name]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.division = $event;
    }),
    onChange: _cache[10] || (_cache[10] = function () {
      return $options.inheritDivisionWord && $options.inheritDivisionWord.apply($options, arguments);
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.divisions, function (division) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: division.division_code
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(division.division_name1), 9
    /* TEXT, PROPS */
    , _hoisted_26);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.division]]), $data.form.errors.department_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.department_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <input type=\"text\" class=\"form-control\" v-model=\"form.division_name\" /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $data.form.pg_dept_head = $event;
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.pgheads, function (pghead) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: pghead.employee_name
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(pghead.employee_name), 9
    /* TEXT, PROPS */
    , _hoisted_29);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.pg_dept_head]]), $data.form.errors.department_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.department_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Rating Period</label>\n                <select type=\"text\" v-model=\"form.sem\" class=\"form-control\" autocomplete=\"chrome-off\"\n                    :disabled=\"form.status == -2\">\n                    <option value=\"1\">First Semester</option>\n                    <option value=\"2\">Second Semester</option>\n                </select>\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.sem\">{{ form.errors.sem }}</div> "), _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.supervisors_i,
    searchable: true,
    modelValue: $data.form.immediate_id,
    "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
      return $data.form.immediate_id = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: $options.setSG
  }, null, 8
  /* PROPS */
  , ["options", "modelValue", "onClose"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.immediate_id\" class=\"form-control\" @change=\"setSG\" autocomplete=\"chrome-off\" >\n                    <option></option>\n                    <option v-for=\"superv in supervisors\" :value=\"superv.empl_id\" >{{ superv.employee_name }}</option>\n                </select> "), $data.form.errors.immediate_id ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.immediate_id), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.supervisors_h,
    searchable: true,
    modelValue: $data.form.next_higher,
    "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
      return $data.form.next_higher = $event;
    }),
    label: "label",
    "track-by": "label"
  }, null, 8
  /* PROPS */
  , ["options", "modelValue"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.next_higher }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.next_higher\" class=\"form-control\" autocomplete=\"chrome-off\" >\n                    <option></option>\n                    <option v-for=\"superv in supervisors_h\" :value=\"superv.empl_id\">{{ superv.employee_name }}</option>\n                </select> "), $data.form.errors.next_higher ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.next_higher), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Year</label>\n                <input v-model=\"form.year\" class=\"form-control\" type=\"number\" name=\"year\" min=\"1900\" max=\"2099\" step=\"1\"\n                    oninput=\"javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);\"\n                    :disabled=\"form.status == -2\" />\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.year\">{{ form.errors.year }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white font-weight-bold",
    onClick: _cache[14] || (_cache[14] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_35)], 32
  /* HYDRATE_EVENTS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ supervisors_h }} ")]);
}

/***/ }),

/***/ "./resources/js/Pages/IPCR/Semestral2/Create.vue":
/*!*******************************************************!*\
  !*** ./resources/js/Pages/IPCR/Semestral2/Create.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_7720323b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=7720323b */ "./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_7720323b__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/IPCR/Semestral2/Create.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js":
/*!*******************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b":
/*!*************************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_7720323b__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_7720323b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=7720323b */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Semestral2/Create.vue?vue&type=template&id=7720323b");


/***/ })

}]);