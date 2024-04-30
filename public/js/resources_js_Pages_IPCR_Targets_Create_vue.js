"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_IPCR_Targets_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");

 //import Places from "@/Shared/PlacesShared";

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    editData: Object,
    id: String,
    emp: Object,
    ipcrs: Object,
    sem: Object,
    additional: String
  },
  components: {
    ModelSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_1__.ModelSelect
  },
  data: function data() {
    return {
      is_add: '0',
      submitted: false,
      my_id: "",
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        ipcr_code: "",
        employee_code: "",
        semester: "",
        ipcr_type: "",
        is_additional_target: "",
        ipcr_semester_id: "",
        quantity_sem: "",
        month_1: "",
        month_2: "",
        month_3: "",
        month_4: "",
        month_5: "",
        month_6: "",
        year: "",
        remarks: "",
        id: null
      }),
      ipcr_mfo: "",
      ipcr_submfo: "",
      ipcr_div_output: "",
      ipcr_ind_output: "",
      ipcr_performance: "",
      ipcr_success: "",
      pageTitle: "",
      selected_value: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.form.ipcr_semester_id = "0";

    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.employee_code = this.editData.employee_code;
      this.form.id = this.editData.id;
      var index = this.ipcrs.findIndex(function (ipcr) {
        return ipcr.ipcr_code === _this.form.ipcr_code;
      });
      this.form.ipcr_code = this.editData.ipcr_code;
      this.$nextTick(function () {
        _this.selected_ipcr();
      });
      this.form.semester = this.editData.semester;
      this.form.quantity_sem = this.editData.quantity_sem;
      this.form.ipcr_type = this.editData.ipcr_type;
      this.form.month_1 = this.editData.month_1;
      this.form.month_2 = this.editData.month_2;
      this.form.month_3 = this.editData.month_3;
      this.form.month_4 = this.editData.month_4;
      this.form.month_5 = this.editData.month_5;
      this.form.month_6 = this.editData.month_6;
      this.form.is_additional_target = this.editData.is_additional_target;
      this.form.remarks = this.editData.remarks;
      this.is_add = this.editData.is_additional_target;
      this.form.year = this.editData.year;
      this.form.ipcr_semester_id = this.editData.ipcr_semester_id;
      this.my_id = this.form.ipcr_semester_id;
    } else {
      this.form.employee_code = this.emp.empl_id;
      this.pageTitle = "New";
      this.form.quantity_sem = "0"; // this.form.month_1 = "0";
      // this.form.month_2 = "0";
      // this.form.month_3 = "0";
      // this.form.month_4 = "0";
      // this.form.month_5 = "0";
      // this.form.month_6 = "0";

      this.form.semester = this.sem.sem;
      this.form.ipcr_semester_id = this.id;
      this.form.is_additional_target = this.additional; // alert(this.additional);

      if (this.additional == null) {
        this.form.is_additional_target = '0';
      } else {
        this.form.quantity_sem = "1";
        this.form.month_1 = "1";
        this.form.month_2 = "1";
        this.form.month_3 = "1";
        this.form.month_4 = "1";
        this.form.month_5 = "1";
        this.form.month_6 = "1";
      }

      this.my_id = this.id;
      this.setYear();
      this.is_add = this.additional;
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

      if (this.form.month_1 !== "" && this.form.month_1 !== undefined && this.form.month_1 != NaN && this.form.month_1 != null) {
        v1 = parseFloat(this.form.month_1);
      }

      if (this.form.month_2 !== "" && this.form.month_2 !== undefined && this.form.month_2 != NaN && this.form.month_2 != null) {
        v2 = parseFloat(this.form.month_2);
      }

      if (this.form.month_3 !== "" && this.form.month_3 !== undefined && this.form.month_3 !== NaN && this.form.month_3 !== null) {
        v3 = parseFloat(this.form.month_3);
      }

      if (this.form.month_4 !== "" && this.form.month_4 !== undefined && this.form.month_4 !== NaN && this.form.month_4 !== null) {
        v4 = parseFloat(this.form.month_4);
      }

      if (this.form.month_5 !== "" && this.form.month_5 !== undefined && this.form.month_5 !== NaN && this.form.month_5 !== null) {
        v5 = parseFloat(this.form.month_5);
      }

      if (this.form.month_6 !== "" && this.form.month_6 !== undefined && this.form.month_6 !== NaN && this.form.month_6 !== null) {
        v6 = parseFloat(this.form.month_6);
      }

      var sem_targ = parseFloat(this.form.quantity_sem);
      var sum = v1 + v2 + v3 + v4 + v5 + v6;
      var ret = "";
      var diff = 0;

      if (sem_targ > sum) {
        diff = sem_targ - sum;
        ret = "WARNING: Add " + diff + " to your monthly targets OR remove " + diff + " from your semestral target ";
      } else if (sem_targ < sum) {
        diff = sum - sem_targ;
        ret = "WARNING: Remove " + diff + " from your monthly targets OR add " + diff + " to your semestral target ";
      }

      return ret;
    },
    ipcr_sel: function ipcr_sel() {
      var ipcrs_1 = this.ipcrs;
      return ipcrs_1.map(function (ipcr) {
        return {
          value: ipcr.ipcr_code,
          label: ipcr.ipcr_code + "-" + ipcr.individual_output + " - " + ipcr.performance_measure // FFUNCCOD: ipcr.FFUNCCOD,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,

        };
      });
    }
  },
  methods: {
    submit: function submit() {
      var v1 = 0;
      var v2 = 0;
      var v3 = 0;
      var v4 = 0;
      var v5 = 0;
      var v6 = 0;

      if (this.form.month_1 !== "" && this.form.month_1 != NaN && this.form.month_1 != null) {
        // alert("form 1 is null1;")
        v1 = parseFloat(this.form.month_1); // alert("v1: " + v1);
      }

      if (this.form.month_2 !== "" && this.form.month_2 != NaN && this.form.month_2 != null) {
        v2 = parseFloat(this.form.month_2); // alert("v2: " + v2);
      }

      if (this.form.month_3 !== "" && this.form.month_3 != NaN && this.form.month_3 != null) {
        v3 = parseFloat(this.form.month_3); // alert("v3: " + v3);
      }

      if (this.form.month_4 !== "" && this.form.month_4 != NaN && this.form.month_4 != null) {
        v4 = parseFloat(this.form.month_4); // alert("v4: " + v4);
      }

      if (this.form.month_5 !== "" && this.form.month_5 != NaN && this.form.month_5 != null) {
        v5 = parseFloat(this.form.month_5); // alert("v5: " + v5);
      }

      if (this.form.month_6 !== "" && this.form.month_6 != NaN && this.form.month_6 != null) {
        v6 = parseFloat(this.form.month_6); // alert("v6: " + v6);
      } // alert("v1: " + v1 +
      //     " v2: " + v2 +
      //     " v3: " + v3 +
      //     " v4: " + v4 +
      //     " v5: " + v5 +
      //     " v6: " + v6
      // )


      var sem_targ = parseFloat(this.form.quantity_sem);
      var sum = v1 + v2 + v3 + v4 + v5 + v6;

      if (this.is_add != "1") {
        if (sum != sem_targ) {
          // "sum: " + sum + " " + " sem_targ: " + sem_targ + " " +
          alert(this.quantity_needed);
        } else {
          if (this.editData !== undefined) {
            //alert("patch");
            this.form.patch("/ipcrtargets/" + this.id, this.form);
          } else {
            if (this.is_add != '1') {
              this.form.post("/ipcrtargets/store/" + this.id);
            } // else {
            //     this.form.post("/ipcrtargets/store/" + this.id + "/additional/ipcr/targets/store");
            // }

          }
        }
      } else {
        if (this.editData !== undefined) {
          //alert("patch");
          this.form.patch("/ipcrtargets/" + this.id, this.form);
        } else {
          this.form.post("/ipcrtargets/store/" + this.id + "/additional/ipcr/targets/store");
        }
      }
    },
    cancelEdit: function cancelEdit() {
      //:href="`/ipcrtargets/${my_id}`"
      var text = "WARNING!\nYou have unsaved changes in this form. Are you sure you want to exit without saving changes?"; // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")

      if (confirm(text) == true) {
        this.$inertia.get("/ipcrtargets/" + this.my_id);
      }
    },
    selected_ipcr: function selected_ipcr() {
      var _this2 = this;

      if (this.form.ipcr_code !== null && this.form.ipcr_code !== undefined) {
        // Find the index of the selected option in the array of ipcrs
        var index = this.ipcrs.findIndex(function (ipcr) {
          return String(ipcr.ipcr_code) === String(_this2.form.ipcr_code);
        }); // alert(index);

        this.selected_value = this.ipcrs[index];
        this.ipcr_mfo = this.ipcrs[index].mfo_desc;
        this.ipcr_submfo = this.ipcrs[index].submfo_description;
        this.ipcr_div_output = this.ipcrs[index].div_output;
        this.ipcr_ind_output = this.ipcrs[index].individual_output;
        this.ipcr_performance = this.ipcrs[index].performance_measure; //this.ipcr_success = this.ipcrs[index].s
        //alert(index);
      } else {
        // Handle case when no option is selected (form.ipcr_code is null or undefined)
        return -1; // Return -1 to indicate no option is selected
      }
    },
    setYear: function setYear() {
      var now = new Date();
      this.form.year = now.getFullYear();
    },
    moveToNextInput: function moveToNextInput(nextInput) {
      this.$refs[nextInput].focus();
    },
    goBack: function goBack() {
      window.history.back();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
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

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "col-md-8"
};
var _hoisted_7 = {
  "class": "border p-4"
};

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b")], -1
/* HOISTED */
);

var _hoisted_9 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_10 = {
  "class": "masonry-item w-100"
};
var _hoisted_11 = {
  "class": "row gap-20"
};
var _hoisted_12 = {
  "class": "col-md-12"
};

var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "IPCR Code *", -1
/* HOISTED */
);

var _hoisted_14 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_15 = {
  key: 1,
  "class": "fs-6 c-red-500"
};

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Major Final Output", -1
/* HOISTED */
);

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Sub MFO", -1
/* HOISTED */
);

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Division Output", -1
/* HOISTED */
);

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Individual Final Output", -1
/* HOISTED */
);

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Performance Measure", -1
/* HOISTED */
);

var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Semester", -1
/* HOISTED */
);

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "1"
}, "First Semester", -1
/* HOISTED */
);

var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "2"
}, "Second Semester", -1
/* HOISTED */
);

var _hoisted_24 = [_hoisted_22, _hoisted_23];
var _hoisted_25 = {
  key: 2,
  "class": "fs-6 c-red-500"
};

var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Type/Category *", -1
/* HOISTED */
);

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Core Function"
}, "Core Function", -1
/* HOISTED */
);

var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Support Function"
}, "Support Function", -1
/* HOISTED */
);

var _hoisted_29 = [_hoisted_27, _hoisted_28];
var _hoisted_30 = {
  key: 3,
  "class": "fs-6 c-red-500"
};
var _hoisted_31 = {
  key: 4
};

var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Remarks", -1
/* HOISTED */
);

var _hoisted_33 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_34 = {
  key: 0,
  "class": "col-md-8"
};
var _hoisted_35 = {
  "class": "border p-4"
};

var _hoisted_36 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Targets")], -1
/* HOISTED */
);

var _hoisted_37 = {
  "class": "small text-danger"
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
  "class": "col-md-12"
};

var _hoisted_42 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Semestral Target * ", -1
/* HOISTED */
);

var _hoisted_43 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_44 = {
  "class": "col-md-6"
};
var _hoisted_45 = {
  "for": ""
};
var _hoisted_46 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_47 = {
  "for": ""
};
var _hoisted_48 = {
  key: 1,
  "class": "fs-6 c-red-500"
};
var _hoisted_49 = {
  "for": ""
};
var _hoisted_50 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_51 = {
  "class": "col-md-6"
};
var _hoisted_52 = {
  "for": ""
};
var _hoisted_53 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_54 = {
  "for": ""
};
var _hoisted_55 = {
  key: 1,
  "class": "fs-6 c-red-500"
};
var _hoisted_56 = {
  "for": ""
};
var _hoisted_57 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_58 = {
  hidden: ""
};
var _hoisted_59 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_60 = ["disabled"];

var _hoisted_61 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ");

var _hoisted_62 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " IPCR Target", 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Link :href=\"`/ipcrtargets/${my_id}`\"> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-danger text-white",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.goBack && $options.goBack.apply($options, arguments);
    })
  }, _hoisted_4), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" </Link> ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\n            <div>Name: <u>{{ emp.employee_name }}</u></div>\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[43] || (_cache[43] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_7, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">IPCR Code</label> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [_hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.ipcr_sel,
    searchable: true,
    modelValue: $data.form.ipcr_code,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.ipcr_code = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: $options.selected_ipcr
  }, null, 8
  /* PROPS */
  , ["options", "modelValue", "onClose"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.ipcr_code\" :disabled=\"editData !== undefined\" class=\"form-control\" autocomplete=\"chrome-off\" @change=\"selected_ipcr\">\n                                        <option v-for=\"ipcr, index in ipcrs\" :value=\"ipcr.ipcr_code\">\n                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}\n                                        </option>\n                                    </select> "), $data.form.errors.ipcr_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.form.errors.employee_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employee_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.ipcr_mfo = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_mfo]]), _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.ipcr_submfo = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_submfo]]), _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.ipcr_div_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_div_output]]), _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.ipcr_ind_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_ind_output]]), _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.ipcr_ind_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_ind_output]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.id = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.id]]), _hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.semester = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    disabled: ""
  }, _hoisted_24, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.semester]]), $data.form.errors.semester ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.semester), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.ipcr_type = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, _hoisted_29, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.ipcr_type]]), $data.form.errors.ipcr_type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_type), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.is_add === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_31, [_hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return $data.form.remarks = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), $data.form.errors.remarks ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.remarks), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])]), $data.is_add != '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_35, [_hoisted_36, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.quantity_needed), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "sem_target",
    type: "number",
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $data.form.quantity_sem = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    onKeydown: [_cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month1Input');
    }, ["prevent"]), ["enter"])), _cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month6Input');
    }, ["prevent"]), ["up"])), _cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month1Input');
    }, ["prevent"]), ["down"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.quantity_sem]]), $data.form.errors.quantity_sem ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.quantity_sem), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_45, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[0]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month1Input",
    type: "number",
    "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
      return $data.form.month_1 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('month2Input');
    }, ["enter"])),
    onKeydown: [_cache[17] || (_cache[17] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month2Input');
    }, ["prevent"]), ["down"])), _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('sem_target');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_1]]), $data.form.errors.month_1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_46, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_1), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_47, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[1]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month2Input",
    type: "number",
    "onUpdate:modelValue": _cache[19] || (_cache[19] = function ($event) {
      return $data.form.month_2 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('month3Input');
    }, ["enter"])),
    onKeydown: [_cache[21] || (_cache[21] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month3Input');
    }, ["prevent"]), ["down"])), _cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month1Input');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_2]]), $data.form.errors.month_2 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_48, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_2), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[2]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month3Input",
    type: "number",
    "onUpdate:modelValue": _cache[23] || (_cache[23] = function ($event) {
      return $data.form.month_3 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('month4Input');
    }, ["enter"])),
    onKeydown: [_cache[25] || (_cache[25] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month4Input');
    }, ["prevent"]), ["down"])), _cache[26] || (_cache[26] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month2Input');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_3]]), $data.form.errors.month_3 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_3), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[3]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month4Input",
    type: "number",
    "onUpdate:modelValue": _cache[27] || (_cache[27] = function ($event) {
      return $data.form.month_4 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[28] || (_cache[28] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('month5Input');
    }, ["enter"])),
    onKeydown: [_cache[29] || (_cache[29] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month5Input');
    }, ["prevent"]), ["down"])), _cache[30] || (_cache[30] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month3Input');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_4]]), $data.form.errors.month_4 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_53, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_4), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_54, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[4]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month5Input",
    type: "number",
    "onUpdate:modelValue": _cache[31] || (_cache[31] = function ($event) {
      return $data.form.month_5 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[32] || (_cache[32] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('month6Input');
    }, ["enter"])),
    onKeydown: [_cache[33] || (_cache[33] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month6Input');
    }, ["prevent"]), ["down"])), _cache[34] || (_cache[34] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month4Input');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_5]]), $data.form.errors.month_5 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_55, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_5), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_56, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[5]) + " *", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    ref: "month6Input",
    type: "number",
    "onUpdate:modelValue": _cache[35] || (_cache[35] = function ($event) {
      return $data.form.month_6 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    min: "0",
    onKeyup: _cache[36] || (_cache[36] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('sem_target');
    }, ["enter"])),
    onKeydown: [_cache[37] || (_cache[37] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('sem_target');
    }, ["prevent"]), ["down"])), _cache[38] || (_cache[38] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)((0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.moveToNextInput('month5Input');
    }, ["prevent"]), ["up"]))]
  }, null, 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_6]]), $data.form.errors.month_6 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_6), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[39] || (_cache[39] = function ($event) {
      return $data.form.year = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.year]]), $data.form.errors.year ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_59, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.year), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[40] || (_cache[40] = function ($event) {
      return $data.form.is_additional_target = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.is_additional_target]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[41] || (_cache[41] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_60), _hoisted_61, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger mt-3 text-white",
    onClick: _cache[42] || (_cache[42] = function ($event) {
      return $options.cancelEdit();
    }),
    disabled: $data.form.processing
  }, " Cancel ", 8
  /* PROPS */
  , _hoisted_62)], 32
  /* HYDRATE_EVENTS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData }}\n        {{ additional }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" additional {{ additional }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" //{{ id }} {{ form.year }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{  sem }} ")]);
}

/***/ }),

/***/ "./resources/js/Pages/IPCR/Targets/Create.vue":
/*!****************************************************!*\
  !*** ./resources/js/Pages/IPCR/Targets/Create.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=63f63b49 */ "./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/IPCR/Targets/Create.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49":
/*!**********************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49 ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=63f63b49 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/Targets/Create.vue?vue&type=template&id=63f63b49");


/***/ })

}]);