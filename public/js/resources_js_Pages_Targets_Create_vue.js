"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Targets_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
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
    additional: String,
    dpcrs: Object,
    slug: String
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
        // ipcr_code: "",
        // individual_final_output_id: "",
        // employee_code: "",
        // semester: "",
        // ipcr_type: "",
        // is_additional_target: "",
        // ipcr_semestral_id: "",
        // quantity_sem: "",

        id: "",
        ipcr_semestral_id: "",
        individual_final_output_id: "",
        ifo_desc: "",
        ipcr_type: "",
        employee_code: "",
        is_additional_target: "",
        semester: "",
        year: "",
        status: "",
        remarks: "",
        slug: "",
        slug_sem: "",
        //----WALA NA NI------------------
        month_1: "",
        month_2: "",
        month_3: "",
        month_4: "",
        month_5: "",
        month_6: ""
        // year: "",
        // remarks: "",
        // id: null
      }),
      ipcr_mfo: "",
      ipcr_submfo: "",
      ipcr_div_output: "",
      ipcr_ind_output: "",
      ipcr_performance: "",
      ipcr_success: "",
      ipcr_prescribed_period: "",
      pageTitle: "",
      selected_value: []
    };
  },
  mounted: function mounted() {
    var _this = this;
    this.form.ipcr_semestral_id = "0";
    this.form.slug_sem = this.slug;
    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.employee_code = this.editData.employee_code;
      this.form.id = this.editData.id;
      // const index = this.ipcrs.findIndex(ipcr => ipcr.individual_final_output_id === this.form.individual_final_output_id);
      this.form.individual_final_output_id = this.editData.individual_final_output_id;
      this.$nextTick(function () {
        _this.selected_ipcr();
      });
      this.form.semester = this.editData.semester;
      this.form.quantity_sem = this.editData.quantity_sem;
      this.form.ipcr_type = this.editData.ipcr_type;
      // this.form.month_1 = this.editData.month_1
      // this.form.month_2 = this.editData.month_2
      // this.form.month_3 = this.editData.month_3
      // this.form.month_4 = this.editData.month_4
      // this.form.month_5 = this.editData.month_5
      // this.form.month_6 = this.editData.month_6
      this.form.is_additional_target = this.editData.is_additional_target;
      this.form.remarks = this.editData.remarks;
      this.is_add = this.editData.is_additional_target;
      this.form.year = this.editData.year;
      this.form.ipcr_semestral_id = this.editData.ipcr_semestral_id;
      this.my_id = this.form.ipcr_semestral_id;
    } else {
      this.form.employee_code = this.emp.empl_id;
      this.pageTitle = "New";
      this.form.quantity_sem = "0";
      // this.form.month_1 = "0";
      // this.form.month_2 = "0";
      // this.form.month_3 = "0";
      // this.form.month_4 = "0";
      // this.form.month_5 = "0";
      // this.form.month_6 = "0";
      this.form.status = '-1';
      this.form.semester = this.sem.sem;
      this.form.ipcr_semestral_id = this.id;
      this.form.is_additional_target = this.additional;
      // alert(this.additional);
      if (this.additional == null) {
        this.form.is_additional_target = '0';
      }
      // else {
      //     this.form.quantity_sem = "1";
      //     this.form.month_1 = "1";
      //     this.form.month_2 = "1";
      //     this.form.month_3 = "1";
      //     this.form.month_4 = "1";
      //     this.form.month_5 = "1";
      //     this.form.month_6 = "1";
      // }
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
    // dpcr_sel() {
    //     let dpcrs_1 = this.dpcrs;
    //     return dpcrs_1.map((dpcr) => ({
    //         value: dpcr.id,
    //         label: dpcr.division_output,
    //         // FFUNCCOD: dpcr.FFUNCCOD
    //     }));
    // },
    ipcr_sel: function ipcr_sel() {
      var ipcrs_1 = this.ipcrs;
      return ipcrs_1.map(function (ipcr) {
        return {
          value: ipcr.individual_final_output_id,
          label: ipcr.individual_output + " - " + ipcr.performance_measure
          // ipcr.individual_final_output_id + "-" +
          // FFUNCCOD: ipcr.FFUNCCOD,
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
      if (this.editData !== undefined) {
        this.form.patch("/ipcrtargets/r/" + this.form.id, this.form);
      } else {
        this.form.ifo_desc = this.ipcr_ind_output;
        // if (this.is_add != '1') {
        this.form.post("/ipcrtargets/r/store/" + this.id);
        // }
      }
    },
    cancelEdit: function cancelEdit() {
      //:href="`/ipcrtargets/${my_id}`"
      var text = "WARNING!\nYou have unsaved changes in this form. Are you sure you want to exit without saving changes?";
      // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
      if (confirm(text) == true) {
        this.$inertia.get("/ipcrtargets/" + this.my_id);
      }
    },
    selected_ipcr: function selected_ipcr() {
      var _this2 = this;
      setTimeout(function () {
        if (String(_this2.form.individual_final_output_id) !== null && String(_this2.form.individual_final_output_id) !== undefined && String(_this2.form.individual_final_output_id) !== '') {
          // Find the index of the selected option in the array of ipcrs
          var index = _this2.ipcrs.findIndex(function (ipcr) {
            return String(ipcr.individual_final_output_id) === String(_this2.form.individual_final_output_id);
          });
          // alert(this.form.individual_final_output_id);
          _this2.selected_value = _this2.ipcrs[index];
          // this.ipcr_mfo = this.ipcrs[index].mfo_desc;
          // this.ipcr_submfo = this.ipcrs[index].submfo_description;
          _this2.ipcr_div_output = _this2.ipcrs[index].div_output;
          _this2.ipcr_ind_output = _this2.ipcrs[index].individual_output;
          _this2.ipcr_performance = _this2.ipcrs[index].performance_measure;
          _this2.ipcr_prescribed_period = _this2.ipcrs[index].prescribed_period;
          //this.ipcr_success = this.ipcrs[index].s
          //alert(index);
        } else {
          // Handle case when no option is selected (form.ipcr_code is null or undefined)
          return -1; // Return -1 to indicate no option is selected
        }
      }, 300);
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c":
/*!*******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
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
})], -1 /* HOISTED */);
var _hoisted_4 = [_hoisted_3];
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1 /* HOISTED */);
var _hoisted_6 = {
  "class": "col-md-8"
};
var _hoisted_7 = {
  "class": "border p-4"
};
var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b")], -1 /* HOISTED */);
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
}, "Individual Final Output *", -1 /* HOISTED */);
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
}, "Division Output", -1 /* HOISTED */);
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Performance Measure", -1 /* HOISTED */);
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Prescribed Period", -1 /* HOISTED */);
var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Year", -1 /* HOISTED */);
var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Semester", -1 /* HOISTED */);
var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "1"
}, "First Semester", -1 /* HOISTED */);
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "2"
}, "Second Semester", -1 /* HOISTED */);
var _hoisted_23 = [_hoisted_21, _hoisted_22];
var _hoisted_24 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Type/Category *", -1 /* HOISTED */);
var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Core Function"
}, "Core Function", -1 /* HOISTED */);
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Support Function"
}, "Support Function", -1 /* HOISTED */);
var _hoisted_28 = [_hoisted_26, _hoisted_27];
var _hoisted_29 = {
  key: 3,
  "class": "fs-6 c-red-500"
};
var _hoisted_30 = {
  key: 4
};
var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Remarks", -1 /* HOISTED */);
var _hoisted_32 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_33 = {
  hidden: ""
};
var _hoisted_34 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_35 = ["disabled"];
var _hoisted_36 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " IPCR Target", 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Link :href=\"`/ipcrtargets/${my_id}`\"> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-danger text-white",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.goBack && $options.goBack.apply($options, arguments);
    })
  }, [].concat(_hoisted_4)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" </Link> ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\n            <div>Name: <u>{{ emp.employee_name }}</u></div>\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_7, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">IPCR Code</label> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Division Output *</label>\n                                    <div>\n                                        <multiselect :options=\"dpcr_sel\" :searchable=\"true\" v-model=\"form.idDPCR\"\n                                            label=\"label\" track-by=\"label\" @close=\"selected_dpcr\">\n                                        </multiselect>\n                                    </div> "), _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.ipcr_sel,
    searchable: true,
    modelValue: $data.form.individual_final_output_id,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.individual_final_output_id = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: $options.selected_ipcr
  }, null, 8 /* PROPS */, ["options", "modelValue", "onClose"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.ipcr_code\" :disabled=\"editData !== undefined\" class=\"form-control\" autocomplete=\"chrome-off\" @change=\"selected_ipcr\">\n                                        <option v-for=\"ipcr, index in ipcrs\" :value=\"ipcr.ipcr_code\">\n                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}\n                                        </option>\n                                    </select> "), $data.form.errors.individual_final_output_id && $data.form.individual_final_output_id == '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.individual_final_output_id), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.form.errors.employee_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employee_code), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Major Final Output</label>\n                                    <input type=\"text\" v-model=\"ipcr_mfo\" class=\"form-control\" autocomplete=\"chrome-off\"\n                                        readonly>\n\n                                    <label for=\"\">Sub MFO</label>\n                                    <input type=\"text\" v-model=\"ipcr_submfo\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" readonly> "), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.ipcr_div_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_div_output]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Individual Final Output</label>\n                                    <input type=\"text\" v-model=\"ipcr_ind_output\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" readonly> "), _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.ipcr_ind_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_ind_output]]), _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.ipcr_prescribed_period = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_prescribed_period]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.form.id = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.id]]), _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.year = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.year]]), _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.semester = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    disabled: ""
  }, [].concat(_hoisted_23), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.semester]]), $data.form.errors.semester ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.semester), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.ipcr_type = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, [].concat(_hoisted_28), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.ipcr_type]]), $data.form.errors.ipcr_type && $data.form.ipcr_type == '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_29, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_type), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.is_add === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_30, [_hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.remarks = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), $data.form.errors.remarks ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.remarks), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\" v-if=\"is_add != '1'\">\n                <fieldset class=\"border p-4\">\n                    <legend class=\"float-none w-auto\">\n                        <b>Targets</b>\n                    </legend>\n                    <span class=\"small text-danger\">{{ quantity_needed }}</span>\n                    <div class=\"layers bd bgc-white p-20\">\n                        <div class=\"masonry-item w-100 \">\n                            <div class=\"row gap-20\">\n                                <div class=\"col-md-12\">\n                                    <div>\n                                        <label for=\"\">Semestral Target *&nbsp;</label>\n                                        <input ref=\"sem_target\" type=\"number\" v-model=\"form.quantity_sem\"\n                                            class=\"form-control\" autocomplete=\"chrome-off\"\n                                            @keydown.enter.prevent=\"moveToNextInput('month1Input')\"\n                                            @keydown.up.prevent=\"moveToNextInput('month6Input')\"\n                                            @keydown.down.prevent=\"moveToNextInput('month1Input')\">\n                                        <div class=\"fs-6 c-red-500\" v-if=\"form.errors.quantity_sem\">{{\n                form.errors.quantity_sem }}</div>\n                                    </div>\n                                </div>\n                                <div class=\"col-md-6\">\n                                    <label for=\"\">{{ month_list[0] }} *</label>\n                                    <input ref=\"month1Input\" type=\"number\" v-model=\"form.month_1\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('month2Input')\"\n                                        @keydown.down.prevent=\"moveToNextInput('month2Input')\"\n                                        @keydown.up.prevent=\"moveToNextInput('sem_target')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_1\">{{ form.errors.month_1 }}\n                                    </div>\n\n                                    <label for=\"\">{{ month_list[1] }} *</label>\n                                    <input ref=\"month2Input\" type=\"number\" v-model=\"form.month_2\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('month3Input')\"\n                                        @keydown.down.prevent=\"moveToNextInput('month3Input')\"\n                                        @keydown.up.prevent=\"moveToNextInput('month1Input')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_2\">{{ form.errors.month_2 }}\n                                    </div>\n\n                                    <label for=\"\">{{ month_list[2] }} *</label>\n                                    <input ref=\"month3Input\" type=\"number\" v-model=\"form.month_3\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('month4Input')\"\n                                        @keydown.down.prevent=\"moveToNextInput('month4Input')\"\n                                        @keydown.up.prevent=\"moveToNextInput('month2Input')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_3\">{{ form.errors.month_3 }}\n                                    </div>\n                                </div>\n                                <div class=\"col-md-6\">\n                                    <label for=\"\">{{ month_list[3] }} *</label>\n                                    <input ref=\"month4Input\" type=\"number\" v-model=\"form.month_4\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('month5Input')\"\n                                        @keydown.down.prevent=\"moveToNextInput('month5Input')\"\n                                        @keydown.up.prevent=\"moveToNextInput('month3Input')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_4\">{{ form.errors.month_4 }}\n                                    </div>\n\n                                    <label for=\"\">{{ month_list[4] }} *</label>\n                                    <input ref=\"month5Input\" type=\"number\" v-model=\"form.month_5\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('month6Input')\"\n                                        @keydown.down.prevent=\"moveToNextInput('month6Input')\"\n                                        @keydown.up.prevent=\"moveToNextInput('month4Input')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_5\">{{ form.errors.month_5 }}\n                                    </div>\n\n                                    <label for=\"\">{{ month_list[5] }} *</label>\n                                    <input ref=\"month6Input\" type=\"number\" v-model=\"form.month_6\" class=\"form-control\"\n                                        autocomplete=\"chrome-off\" min=\"0\" @keyup.enter=\"moveToNextInput('sem_target')\"\n                                        @keydown.down.prevent=\"moveToNextInput('sem_target')\"\n                                        @keydown.up.prevent=\"moveToNextInput('month5Input')\">\n                                    <div class=\"fs-6 c-red-500\" v-if=\"form.errors.month_6\">{{ form.errors.month_6 }}\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </fieldset>\n            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return $data.form.year = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.year]]), $data.form.errors.year ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.year), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $data.form.is_additional_target = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.is_additional_target]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[12] || (_cache[12] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8 /* PROPS */, _hoisted_35), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger mt-3 text-white",
    onClick: _cache[13] || (_cache[13] = function ($event) {
      return $options.cancelEdit();
    }),
    disabled: $data.form.processing
  }, " Cancel ", 8 /* PROPS */, _hoisted_36)], 32 /* NEED_HYDRATION */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" year: {{ form.year }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <br>**************************************************************<br>\n        {{ editData.year }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData }}\n        {{ additional }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" additional {{ additional }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" //{{ id }} {{ form.year }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{  sem }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.ipcr_code }}\n           "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ ipcrs }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.additional), 1 /* TEXT */)]);
}

/***/ }),

/***/ "./resources/js/Pages/Targets/Create.vue":
/*!***********************************************!*\
  !*** ./resources/js/Pages/Targets/Create.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_9261df9c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=9261df9c */ "./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_9261df9c__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Targets/Create.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js":
/*!***********************************************************************!*\
  !*** ./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c":
/*!*****************************************************************************!*\
  !*** ./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_9261df9c__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_9261df9c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=9261df9c */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Targets/Create.vue?vue&type=template&id=9261df9c");


/***/ })

}]);