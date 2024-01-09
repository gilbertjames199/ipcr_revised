"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Employees_ProbationaryFlex_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_PlacesShared__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/Shared/PlacesShared */ "./resources/js/Shared/PlacesShared.vue");
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



 //import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    data: Object,
    editData: Object,
    employees: Object,
    divisions: Object,
    offices: Object,
    ids: Object,
    date_from: Object,
    date_to: Object,
    quantity: Object
  },
  components: {
    //BootstrapModalNoJquery,
    ModelSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_2__.ModelSelect,
    Places: function Places() {
      return new Promise(function (resolve) {
        setTimeout(function () {
          resolve(_Shared_PlacesShared__WEBPACK_IMPORTED_MODULE_1__["default"]);
        }, 2000);
      });
    }
  },
  data: function data() {
    return {
      my_paps: [],
      submitted: false,
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        employee_code: "",
        immediate_cats: "",
        next_higher_cats: "",
        no_of_months: "",
        prob_status: "",
        status: "",
        month_id: [],
        date_from: [],
        date_to: [],
        quantity: [],
        id: null
      }),
      pageTitle: "",
      isNotValid: false,
      isNotValidTo: false,
      immediate_sg: 0,
      emp_sg: 0,
      dept_code: '0'
    };
  },
  computed: {
    formattedEmployeeList: function formattedEmployeeList() {
      var dataEmp = this.employees;
      return dataEmp.map(function (employee) {
        return {
          value: employee.empl_id,
          label: employee.employee_name,
          position_long_title: employee.position_long_title,
          salary_grade: employee.salary_grade,
          department_code: employee.department_code
        };
      });
    },
    formattedImmediateList: function formattedImmediateList() {
      var _this = this;

      var dataEmp = this.employees;
      var my_sg = parseFloat(this.emp_sg);

      if (this.form.employee_code) {
        if (my_sg > 0) {
          dataEmp = dataEmp.filter(function (empl) {
            return empl.salary_grade > my_sg;
          });
        }

        if (this.dept_code) {
          dataEmp = dataEmp.filter(function (empl) {
            return empl.department_code === _this.dept_code;
          });
        }
      }

      return dataEmp.map(function (employee) {
        return {
          value: employee.empl_id,
          label: employee.employee_name,
          position_long_title: employee.position_long_title,
          salary_grade: employee.salary_grade // department_code: department_code,

        };
      });
    },
    formattedNextList: function formattedNextList() {
      var _this2 = this;

      var dataEmp = this.employees;
      var my_sg = parseFloat(this.immediate_sg);

      if (this.form.employee_code) {
        if (this.dept_code) {
          dataEmp = dataEmp.filter(function (empl) {
            return empl.department_code === _this2.dept_code;
          });
        }
      }

      if (this.form.immediate_cats) {
        if (my_sg > 0) {
          dataEmp = dataEmp.filter(function (empl) {
            return empl.salary_grade > my_sg;
          });
        }
      }

      return dataEmp.map(function (employee) {
        return {
          value: employee.empl_id,
          label: employee.employee_name,
          position_long_title: employee.position_long_title,
          salary_grade: employee.salary_grade //department_code: department_code

        };
      });
    }
  },
  mounted: function mounted() {
    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.employee_code = this.editData.employee_code;
      this.setSG();
      this.form.immediate_cats = this.editData.immediate_cats;
      this.setImmediateSG();
      this.form.next_higher_cats = this.editData.next_higher_cats;
      this.form.prob_status = this.editData.prob_status;
      this.form.no_of_months = this.editData.no_of_months;
      this.form.id = this.editData.id;
      this.form.date_from = this.date_from;
      this.form.date_to = this.date_to;
      this.form.month_id = this.ids;
    } else {
      this.form.no_of_months = 0;
      this.pageTitle = "Add";
      this.form.rating_period_from = null;
    }
  },
  methods: {
    submit: function submit() {
      this.form.target_qty = parseFloat(this.form.target_qty1) + parseFloat(this.form.target_qty2) + parseFloat(this.form.target_qty3) + parseFloat(this.form.target_qty4); //alert(this.form.target_qty);

      this.checkDateFrom();
      this.checkDateTo();

      if (this.isNotValid == true || this.isNotValidTo == true) {
        alert("Some dates are invalid!");
      } else {
        if (this.editData !== undefined) {
          this.form.patch("/probationary/update/" + this.form.id, this.form);
        } else {
          this.form.status = "-1";
          var url = "/probationary/store";
          this.form.post(url);
        }
      }
    },
    selected_employee: function selected_employee() {
      var _this3 = this;

      if (this.form.idIPCR !== null && this.form.idIPCR !== undefined) {
        // Find the index of the selected option in the array of ipcrs
        var index = this.data.findIndex(function (data) {
          return String(data.ipcr_code) === String(_this3.form.idIPCR);
        }); // alert(index);

        this.selected_value = this.data[index];
        this.form.individual_output = this.data[index].individual_output;
        this.ipcr_submfo = this.data[index].submfo_description;
        this.ipcr_div_output = this.data[index].div_output;
        this.ipcr_ind_output = this.data[index].individual_output;
        this.ipcr_performance = this.data[index].performance_measure; //this.ipcr_success = this.ipcrs[index].s
        //alert(index);
      } else {
        // Handle case when no option is selected (form.ipcr_code is null or undefined)
        return -1; // Return -1 to indicate no option is selected
      }
    },
    setDateTo: function setDateTo() {
      var i = 0;

      if (this.form.prob_status === 'Probationary') {
        this.form.no_of_months = 6;
      } else {
        this.form.no_of_months = 10;
      }

      this.setMonthsCreate(); // if(this.form.prob_status==='Probationary'){
      //     // alert('Probationary '+this.form.prob_status)
      //     //i=6;
      //     this.form.rating_period_from_7=null
      //     this.form.rating_period_to_7=null
      //     this.form.rating_period_from_8=null
      //     this.form.rating_period_to_8=null
      //     this.form.rating_period_from_9=null
      //     this.form.rating_period_to_9=null
      //     this.form.rating_period_from_10=null
      //     this.form.rating_period_to_10=null
      // }else{
      //     // alert('Temporary '+this.form.prob_status)
      //     i=10;
      // }
      // if (this.form.rating_period_from) {
      //     // Create a Date object from the selected date
      //     const selectedDateObj = new Date(this.form.rating_period_from);
      //     selectedDateObj.setMonth(selectedDateObj.getMonth() + i);
      //     this.form.rating_period_to = selectedDateObj.toISOString().split('T')[0];
      // } else {
      //     // If no date is selected, reset the calculated date
      //     this.form.rating_period_from=null;
      //     this.form.rating_period_to = null;
      // }
    },
    addOneToMonth: function addOneToMonth() {
      var i = this.form.no_of_months; // alert(i);
      // if(this.editData!==undefined){
      //     i=this.form.no_of_months+1;
      // }else{
      //     i=this.form.no_of_months;
      // }

      this.form.no_of_months = parseFloat(this.form.no_of_months) + 1;
      var currentDate = new Date();

      if (i > 0) {
        var my_day = new Date(this.form.date_to[i - 1]); //alert(my_day)

        my_day.setDate(my_day.getDate() + 1);
        my_day = my_day.toISOString().split('T')[0];
        this.form.date_from.push(my_day);
      } else {
        // var gt = currentDate.setMonth(currentDate.getMonth() + i);
        // alert(gt)
        var my_dt = currentDate.toISOString().split('T')[0];
        this.form.date_from.push(my_dt);
      } //DATE TO
      //var ia = i+1;


      var fromDate = new Date(this.form.date_from[i]);
      fromDate.setMonth(fromDate.getMonth() + 1);
      var dateTo = fromDate.toISOString().split('T')[0];
      this.form.date_to.push(dateTo);
      this.form.quantity.push('1'); //this.setMonthsCreate();
    },
    removeOneFromMonth: function removeOneFromMonth() {
      if (parseFloat(this.form.no_of_months) > 0) {
        this.form.no_of_months = parseFloat(this.form.no_of_months) - 1;
      }

      this.form.date_from.pop();
      this.form.date_to.pop();
      this.form.quantity.pop();
    },
    setMonthsCreate: function setMonthsCreate() {
      //alert(this.form.no_of_months);
      this.form.date_from = [];
      this.form.date_to = [];
      this.form.quantity = [];
      var mos = this.form.no_of_months;

      for (var i = 0; i < mos; i++) {
        var currentDate = new Date(); // alert(currentDate);
        //var my_dt = currentDate.toDateString();
        //DATE FROM

        if (i > 0) {
          var my_day = new Date(this.form.date_to[i - 1]); // alert(my_day)

          my_day.setDate(my_day.getDate() + 1);
          my_day = my_day.toISOString().split('T')[0];
          this.form.date_from.push(my_day);
        } else {
          currentDate.setMonth(currentDate.getMonth() + i);
          var my_dt = currentDate.toISOString().split('T')[0];
          this.form.date_from.push(my_dt);
        } //DATE TO


        var fromDate = new Date(this.form.date_from[i]);
        fromDate.setMonth(fromDate.getMonth() + 1);
        var dateTo = fromDate.toISOString().split('T')[0];
        this.form.date_to.push(dateTo);
        this.form.quantity.push('1');
      }
    },
    setMonthsBasedOnFirstMonth: function setMonthsBasedOnFirstMonth(my_date, ind) {
      // this.form.date_from=[];
      // this.form.date_to=[];
      // alert(my_date)
      ind = parseFloat(ind);

      if (this.editData !== undefined) {} else {
        ind = ind - 1;
      }

      var curDate = new Date();
      var myDate = new Date(my_date);

      if (myDate < curDate) {
        alert('Date selected is invalid!');
        var date_to1 = new Date(this.form.date_to[ind]);
        date_to1.setMonth(date_to1.getMonth() - 1);
        var dateTo = date_to1.toISOString().split('T')[0]; //alert("to "+dateTo)

        this.form.date_from[ind] = dateTo;
      } else {
        var mos = this.form.no_of_months;

        for (var i = ind; i < mos; i++) {
          var currentDate = new Date(my_date);

          if (i > 0) {
            // alert(this.form.date_to[i-1])
            var my_day = new Date(this.form.date_to[i - 1]);
            my_day.setDate(my_day.getDate() + 1);
            my_day = my_day.toISOString().split('T')[0]; //alert("from "+my_day)

            this.form.date_from[i] = my_day; //this.form.date_from.push(my_day);
          } else {
            // alert('First: '+i+" "+currentDate)
            currentDate.setMonth(currentDate.getMonth() + i); // alert('After: '+currentDate)

            var my_dt = currentDate.toISOString().split('T')[0]; //alert("from =0 "+my_dt)

            this.form.date_from[i] = my_dt; //this.form.date_from.push(my_dt);
          } //DATE TO
          //var ia = i+1;


          var fromDate = new Date(this.form.date_from[i]);
          fromDate.setMonth(fromDate.getMonth() + 1);
          var dateTo = fromDate.toISOString().split('T')[0]; //alert("to "+dateTo)

          this.form.date_to[i] = dateTo; //this.form.date_to.push(dateTo);
        }
      }
    },
    isValidDate: function isValidDate(dateString) {
      var date = new Date(dateString);
      return !isNaN(date) && date instanceof Date;
    },
    checkDateFrom: function checkDateFrom() {
      this.isNotValid = false;

      var _iterator = _createForOfIteratorHelper(this.form.date_from),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var date = _step.value;

          if (!this.isValidDate(date)) {
            //alert("Some dates are not valid.");
            this.isNotValid = true;
            return; // Prevent form submission
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    },
    checkDateTo: function checkDateTo() {
      this.isNotValidTo = false;

      var _iterator2 = _createForOfIteratorHelper(this.form.date_to),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var date = _step2.value;

          if (!this.isValidDate(date)) {
            //alert("Some dates are not valid.");
            this.isNotValidTo = true;
            return; // Prevent form submission
          }
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
    },
    setSG: function setSG() {
      var recid = this.form.employee_code;
      var index = this.employees.findIndex(function (emp) {
        return emp.empl_id === recid;
      });

      if (index !== -1) {
        this.emp_sg = this.employees[index].salary_grade;
        this.dept_code = this.employees[index].department_code;
      } else {
        this.emp_sg = "0";
        this.dept_code = "00";
      }
    },
    setImmediateSG: function setImmediateSG() {
      var recid = this.form.immediate_cats;
      var index = this.employees.findIndex(function (emp) {
        return emp.empl_id === recid;
      });

      if (index !== -1) {
        this.immediate_sg = this.employees[index].salary_grade;
        this.dept_code = this.employees[index].department_code;
      } else {
        this.immediate_sg = "0";
      }
    } //fdsfsdfsdfsfdsf

  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    mun: Array // bar: Array,

  },
  data: function data() {
    return {
      mun_code: "",
      barsel: "",
      munsel: "",
      bar: []
    };
  },
  computed: {
    my_mun: function my_mun() {
      return this.mun_code;
    },
    my_bar: function my_bar() {
      return this.bar;
    }
  },
  mounted: function mounted() {//this.bar=[];
  },
  watch: {},
  methods: {
    loadBar: function loadBar() {
      var _this = this;

      alert(this.munsel);

      if (this.munsel === "") {} else {
        axios.post("/places/bar", {
          mun: this.munsel
        }).then(function (response) {
          _this.bar = response.data.data;
        });
      }
    },
    showMun: function showMun() {
      alert(this.mun_code);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
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

var _hoisted_4 = {
  "class": "col-md-8"
};

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "border p-4"
};

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Employee ")], -1
/* HOISTED */
);

var _hoisted_8 = {
  key: 0,
  "class": "fs-6 c-red-500"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Status", -1
/* HOISTED */
);

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Probationary"
}, "Probationary", -1
/* HOISTED */
);

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Temporary"
}, "Temporary", -1
/* HOISTED */
);

var _hoisted_12 = [_hoisted_10, _hoisted_11];

var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_14 = {
  "class": "border p-4"
};

var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Supervisors ")], -1
/* HOISTED */
);

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, "Immediate Supervisor", -1
/* HOISTED */
);

var _hoisted_17 = {
  key: 0,
  "class": "fs-6 c-red-500"
};

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, "Next Higher Supervisor", -1
/* HOISTED */
);

var _hoisted_19 = {
  key: 1,
  "class": "fs-6 c-red-500"
};

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_21 = {
  "class": "border p-4"
};

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Period ")], -1
/* HOISTED */
);

var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-sm-12"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Number of Months"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" class=\"btn btn-primary mt-3 text-white\"  class=\"btn btn-danger mt-3 text-white\"")], -1
/* HOISTED */
);

var _hoisted_24 = {
  "class": "col-md-12"
};
var _hoisted_25 = {
  "class": "row"
};
var _hoisted_26 = {
  "class": "col-md-9"
};
var _hoisted_27 = {
  "class": "col-md-3"
};

var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-caret-up-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"
})], -1
/* HOISTED */
);

var _hoisted_29 = [_hoisted_28];

var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ");

var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-caret-down-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"
})], -1
/* HOISTED */
);

var _hoisted_32 = [_hoisted_31];
var _hoisted_33 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_34 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_35 = {
  key: 1
};
var _hoisted_36 = {
  "class": "border p-4"
};
var _hoisted_37 = {
  "class": "float-none w-auto"
};
var _hoisted_38 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_39 = {
  "class": "masonry-item w-100"
};
var _hoisted_40 = {
  "class": "row gap-20"
};
var _hoisted_41 = {
  "class": "col-md-6"
};

var _hoisted_42 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Date From ", -1
/* HOISTED */
);

var _hoisted_43 = ["onUpdate:modelValue", "onChange"];
var _hoisted_44 = ["onUpdate:modelValue"];
var _hoisted_45 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_46 = {
  "class": "col-md-6"
};

var _hoisted_47 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Date to ", -1
/* HOISTED */
);

var _hoisted_48 = ["onUpdate:modelValue"];
var _hoisted_49 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_50 = {
  key: 2
};
var _hoisted_51 = {
  "class": "border p-4"
};
var _hoisted_52 = {
  "class": "float-none w-auto"
};
var _hoisted_53 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_54 = {
  "class": "masonry-item w-100"
};
var _hoisted_55 = {
  "class": "row gap-20"
};
var _hoisted_56 = {
  "class": "col-md-6"
};

var _hoisted_57 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Date From ", -1
/* HOISTED */
);

var _hoisted_58 = ["onUpdate:modelValue", "onChange"];
var _hoisted_59 = ["onUpdate:modelValue"];
var _hoisted_60 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_61 = {
  "class": "col-md-6"
};

var _hoisted_62 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Date to ", -1
/* HOISTED */
);

var _hoisted_63 = ["onUpdate:modelValue"];
var _hoisted_64 = {
  key: 0,
  "class": "fs-6 c-red-500"
};

var _hoisted_65 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_66 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " Probationary/Temporary Employee", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/probationary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.form.emp_code = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.emp_code]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_6, [_hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.formattedEmployeeList,
    searchable: true,
    modelValue: $data.form.employee_code,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.employee_code = $event;
    }),
    label: "label",
    "track-by": "label",
    disabled: $props.editData !== undefined,
    onClose: _cache[2] || (_cache[2] = function ($event) {
      return $options.setSG();
    })
  }, null, 8
  /* PROPS */
  , ["options", "modelValue", "disabled"])]), $data.form.errors.employee_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employee_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" @change=\"selected_ipcr\" :disabled=\"pageTitle=='Edit'\" status: {{ form.prob_status }}"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control form-select",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.form.prob_status = $event;
    }),
    onChange: _cache[4] || (_cache[4] = function () {
      return $options.setDateTo && $options.setDateTo.apply($options, arguments);
    })
  }, _hoisted_12, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.prob_status]]), _hoisted_13]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_14, [_hoisted_15, _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.formattedImmediateList,
    searchable: true,
    modelValue: $data.form.immediate_cats,
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.form.immediate_cats = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: _cache[6] || (_cache[6] = function ($event) {
      return $options.setImmediateSG();
    })
  }, null, 8
  /* PROPS */
  , ["options", "modelValue"])]), $data.form.errors.immediate_cats ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.immediate_cats), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.formattedNextList,
    searchable: true,
    modelValue: $data.form.next_higher_cats,
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.next_higher_cats = $event;
    }),
    label: "label",
    "track-by": "label"
  }, null, 8
  /* PROPS */
  , ["options", "modelValue"])]), $data.form.errors.next_higher_cats ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.next_higher_cats), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_20]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_21, [_hoisted_22, _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    onChange: _cache[8] || (_cache[8] = function () {
      return $options.setMonthsCreate && $options.setMonthsCreate.apply($options, arguments);
    }),
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.no_of_months = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.no_of_months]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary text-white",
    onClick: _cache[10] || (_cache[10] = function ($event) {
      return $options.addOneToMonth();
    })
  }, _hoisted_29), _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger text-white",
    onClick: _cache[11] || (_cache[11] = function ($event) {
      return $options.removeOneFromMonth();
    })
  }, _hoisted_32)])])]), $data.form.errors.no_of_months ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.no_of_months), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), $data.form.errors.prob_status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.prob_status), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.no_of_months }} "), $props.editData !== undefined ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_35, [$data.form.date_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.form.date_from, function (dt_from, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      "class": "col-md-12",
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Month " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1
    /* TEXT */
    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [_hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <input v-model=\"form.month_id[index]\"\n                                                    class=\"form-control\"\n                                                    hidden\n                                            > "), index < 1 ? (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)(((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("input", {
      key: 0,
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_from[index] = $event;
      },
      "class": "form-control",
      onChange: function onChange($event) {
        return $options.setMonthsBasedOnFirstMonth($data.form.date_from[index], index);
      },
      autocomplete: "positionchrome-off"
    }, null, 40
    /* PROPS, HYDRATE_EVENTS */
    , _hoisted_43)), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_from[index]]]) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)(((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("input", {
      key: 1,
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_from[index] = $event;
      },
      "class": "form-control",
      autocomplete: "positionchrome-off"
    }, null, 8
    /* PROPS */
    , _hoisted_44)), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_from[index]]]), $data.form.errors.rating_period_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_45, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.rating_period_from), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [_hoisted_47, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_to[index] = $event;
      },
      "class": "form-control",
      autocomplete: "positionchrome-off"
    }, null, 8
    /* PROPS */
    , _hoisted_48), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_to[index]]]), $data.form.errors.rating_period_to ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.rating_period_to), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-4\">\n                            <label for=\"\">Quantity </label>\n                            <input type=\"number\"\n                                    v-model=\"form.quantity[index]\"\n                                    class=\"form-control\"\n                                    autocomplete=\"positionchrome-off\">\n                            <div class=\"fs-6 c-red-500\" v-if=\"form.errors.quantity\">{{ form.errors.quantity }}</div>\n                        </div> ")]);
  }), 128
  /* KEYED_FRAGMENT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_50, [$data.form.date_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.form.no_of_months, function (index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      "class": "col-md-12",
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", _hoisted_52, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Month " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index), 1
    /* TEXT */
    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_55, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_56, [_hoisted_57, index - 1 < 1 ? (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)(((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("input", {
      key: 0,
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_from[index - 1] = $event;
      },
      "class": "form-control",
      onChange: function onChange($event) {
        return $options.setMonthsBasedOnFirstMonth($data.form.date_from[index - 1], index);
      },
      autocomplete: "positionchrome-off"
    }, null, 40
    /* PROPS, HYDRATE_EVENTS */
    , _hoisted_58)), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_from[index - 1]]]) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)(((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("input", {
      key: 1,
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_from[index - 1] = $event;
      },
      "class": "form-control",
      autocomplete: "positionchrome-off"
    }, null, 8
    /* PROPS */
    , _hoisted_59)), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_from[index - 1]]]), $data.form.errors.rating_period_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_60, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.rating_period_from), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_61, [_hoisted_62, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "date",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.date_to[index - 1] = $event;
      },
      "class": "form-control",
      autocomplete: "positionchrome-off"
    }, null, 8
    /* PROPS */
    , _hoisted_63), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_to[index - 1]]]), $data.form.errors.rating_period_to ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_64, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.rating_period_to), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-4\">\n                                            <label for=\"\">Quantity </label>\n                                            <input type=\"number\"\n                                                    v-model=\"form.quantity[index-1]\"\n                                                    class=\"form-control\"\n                                                    autocomplete=\"positionchrome-off\">\n                                            <div class=\"fs-6 c-red-500\" v-if=\"form.errors.quantity\">{{ form.errors.quantity }}</div>\n                                        </div> ")])])])])]);
  }), 128
  /* KEYED_FRAGMENT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])), _hoisted_65, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[12] || (_cache[12] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save ", 8
  /* PROPS */
  , _hoisted_66)], 32
  /* HYDRATE_EVENTS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ employees }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.date_from }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.date_from }}\n        <br />\n        {{ form.date_to }} ")]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "masonry-item w-100"
};
var _hoisted_2 = {
  "class": "row gap-20"
};
var _hoisted_3 = {
  "class": "col-md-3 col-6"
};
var _hoisted_4 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_5 = {
  "class": "layer w-100 mB-10"
};
var _hoisted_6 = {
  "class": "lh-1"
};
var _hoisted_7 = {
  "class": "layer w-100"
};
var _hoisted_8 = {
  "class": "peers ai-sb fxw-nw"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "peer peer-greed"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  id: "sparklinedash"
})], -1
/* HOISTED */
);

var _hoisted_10 = {
  "class": "layers bd bgc-white p-20"
};

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "layer w-100 mB-10"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", {
  "class": "lh-1"
}, "Barangay")], -1
/* HOISTED */
);

var _hoisted_12 = {
  "class": "layer w-100"
};
var _hoisted_13 = {
  "class": "peers ai-sb fxw-nw"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "peer peer-greed"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  id: "sparklinedash"
})], -1
/* HOISTED */
);

var _hoisted_15 = {
  "class": "form-control"
};

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, null, -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", _hoisted_6, "Municipalities " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.my_mun), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.munsel = $event;
    }),
    onChange: _cache[1] || (_cache[1] = function () {
      return $options.loadBar && $options.loadBar.apply($options, arguments);
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.mun, function (munn) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(munn.citymunDesc), 1
    /* TEXT */
    );
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.munsel]])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [_hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", _hoisted_15, [_hoisted_16, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.bar, function (barr) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(barr.brgyDesc), 1
    /* TEXT */
    );
  }), 256
  /* UNKEYED_FRAGMENT */
  ))])])])])])])]);
}

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Create.vue":
/*!******************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Create.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_5cfacc27__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=5cfacc27 */ "./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js");
<<<<<<< HEAD
/* harmony import */ var _var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
=======
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e




;
<<<<<<< HEAD
const __exports__ = /*#__PURE__*/(0,_var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_5cfacc27__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/ProbationaryFlex/Create.vue"]])
=======
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_5cfacc27__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/ProbationaryFlex/Create.vue"]])
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/PlacesShared.vue":
/*!**********************************************!*\
  !*** ./resources/js/Shared/PlacesShared.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PlacesShared.vue?vue&type=template&id=ee3222a6 */ "./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6");
/* harmony import */ var _PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PlacesShared.vue?vue&type=script&lang=js */ "./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js");
<<<<<<< HEAD
/* harmony import */ var _var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
=======
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e




;
<<<<<<< HEAD
const __exports__ = /*#__PURE__*/(0,_var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/PlacesShared.vue"]])
=======
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/PlacesShared.vue"]])
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PlacesShared.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27":
/*!************************************************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27 ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_5cfacc27__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_5cfacc27__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=5cfacc27 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Create.vue?vue&type=template&id=5cfacc27");


/***/ }),

/***/ "./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6":
/*!****************************************************************************!*\
  !*** ./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PlacesShared.vue?vue&type=template&id=ee3222a6 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6");


/***/ })

}]);