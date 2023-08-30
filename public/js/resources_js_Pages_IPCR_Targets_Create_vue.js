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
      this.is_add = this.editData.is_additional_target;
      this.form.year = this.editData.year;
      this.form.ipcr_semester_id = this.editData.ipcr_semester_id;
      this.my_id = this.form.ipcr_semester_id;
    } else {
      this.form.employee_code = this.emp.empl_id;
      this.pageTitle = "Add";
      this.form.quantity_sem = "0";
      this.form.month_1 = "0";
      this.form.month_2 = "0";
      this.form.month_3 = "0";
      this.form.month_4 = "0";
      this.form.month_5 = "0";
      this.form.month_6 = "0";
      this.form.semester = this.sem.sem;
      this.form.ipcr_semester_id = this.id;
      this.form.is_additional_target = this.additional;

      if (this.additional == null) {
        this.form.is_additional_target = '0';
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
          label: ipcr.ipcr_code + "-" + ipcr.individual_output // FFUNCCOD: ipcr.FFUNCCOD,
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
      var v1 = parseFloat(this.form.month_1);
      var v2 = parseFloat(this.form.month_2);
      var v3 = parseFloat(this.form.month_3);
      var v4 = parseFloat(this.form.month_4);
      var v5 = parseFloat(this.form.month_5);
      var v6 = parseFloat(this.form.month_6);
      var sem_targ = parseFloat(this.form.quantity_sem);
      var sum = v1 + v2 + v3 + v4 + v5 + v6;

      if (sum != sem_targ) {
        alert(this.quantity_needed);
      } else {
        if (this.editData !== undefined) {
          //alert("patch");
          this.form.patch("/ipcrtargets/" + this.id, this.form);
        } else {
          this.form.post("/ipcrtargets/store/" + this.id);
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

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "col-md-8"
};
var _hoisted_6 = {
  "class": "border p-4"
};

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "IPCR Code")], -1
/* HOISTED */
);

var _hoisted_8 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_9 = {
  "class": "masonry-item w-100"
};
var _hoisted_10 = {
  "class": "row gap-20"
};
var _hoisted_11 = {
  "class": "col-md-12"
};
var _hoisted_12 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_13 = {
  key: 1,
  "class": "fs-6 c-red-500"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Major Final Output", -1
/* HOISTED */
);

var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Sub MFO", -1
/* HOISTED */
);

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Division Output", -1
/* HOISTED */
);

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Individual Final Output", -1
/* HOISTED */
);

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Performance Measure", -1
/* HOISTED */
);

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Semester", -1
/* HOISTED */
);

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "1"
}, "First Semester", -1
/* HOISTED */
);

var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "2"
}, "Second Semester", -1
/* HOISTED */
);

var _hoisted_22 = [_hoisted_20, _hoisted_21];
var _hoisted_23 = {
  key: 2,
  "class": "fs-6 c-red-500"
};

var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Type/Category", -1
/* HOISTED */
);

var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Core Function"
}, "Core Function", -1
/* HOISTED */
);

var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Support Function"
}, "Support Function", -1
/* HOISTED */
);

var _hoisted_27 = [_hoisted_25, _hoisted_26];
var _hoisted_28 = {
  key: 3,
  "class": "fs-6 c-red-500"
};
var _hoisted_29 = {
  key: 0,
  "class": "col-md-8"
};
var _hoisted_30 = {
  "class": "border p-4"
};

var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Target Quantity")], -1
/* HOISTED */
);

var _hoisted_32 = {
  "class": "small text-danger"
};
var _hoisted_33 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_34 = {
  "class": "masonry-item w-100"
};
var _hoisted_35 = {
  "class": "row gap-20"
};
var _hoisted_36 = {
  "class": "col-md-12"
};

var _hoisted_37 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Semestral Target  ", -1
/* HOISTED */
);

var _hoisted_38 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_39 = {
  "class": "col-md-6"
};
var _hoisted_40 = {
  "for": ""
};
var _hoisted_41 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_42 = {
  "for": ""
};
var _hoisted_43 = {
  key: 1,
  "class": "fs-6 c-red-500"
};
var _hoisted_44 = {
  "for": ""
};
var _hoisted_45 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_46 = {
  "class": "col-md-6"
};
var _hoisted_47 = {
  "for": ""
};
var _hoisted_48 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_49 = {
  "for": ""
};
var _hoisted_50 = {
  key: 1,
  "class": "fs-6 c-red-500"
};
var _hoisted_51 = {
  "for": ""
};
var _hoisted_52 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_53 = {
  hidden: ""
};
var _hoisted_54 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_55 = ["disabled"];

var _hoisted_56 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ");

var _hoisted_57 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " IPCR Target", 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/ipcrtargets/".concat($data.my_id)
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\n            <div>Name: <u>{{ emp.employee_name }}</u></div>\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
<<<<<<< HEAD
    onSubmit: _cache[19] || (_cache[19] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
=======
    onSubmit: _cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
>>>>>>> 2cb1dbe9a7609f808f7c2561270827a3b332620b
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_6, [_hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">IPCR Code</label> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    options: $options.ipcr_sel,
    searchable: true,
    modelValue: $data.form.ipcr_code,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.form.ipcr_code = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: $options.selected_ipcr
  }, null, 8
  /* PROPS */
  , ["options", "modelValue", "onClose"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.ipcr_code\" :disabled=\"editData !== undefined\" class=\"form-control\" autocomplete=\"chrome-off\" @change=\"selected_ipcr\">\n                                        <option v-for=\"ipcr, index in ipcrs\" :value=\"ipcr.ipcr_code\">\n                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}\n                                        </option>\n                                    </select> "), $data.form.errors.ipcr_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.form.errors.employee_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.employee_code), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.ipcr_mfo = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_mfo]]), _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.ipcr_submfo = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_submfo]]), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.ipcr_div_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_div_output]]), _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.ipcr_ind_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_ind_output]]), _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.ipcr_ind_output = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    readonly: ""
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.ipcr_ind_output]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.id = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.id]]), _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.semester = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off",
    disabled: ""
  }, _hoisted_22, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.semester]]), $data.form.errors.semester ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.semester), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    type: "text",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.ipcr_type = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, _hoisted_27, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.ipcr_type]]), $data.form.errors.ipcr_type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_type), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])]), $data.is_add != '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_30, [_hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.quantity_needed), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.quantity_sem = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.quantity_sem]]), $data.form.errors.quantity_sem ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.quantity_sem), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_40, "Monthly Target 1 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[0]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return $data.form.month_1 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_1]]), $data.form.errors.month_1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_1), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_42, "Monthly Target 2 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[1]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $data.form.month_2 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_2]]), $data.form.errors.month_2 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_2), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_44, "Monthly Target 3 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[2]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
      return $data.form.month_3 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_3]]), $data.form.errors.month_3 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_45, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_3), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_47, "Monthly Target 4 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[3]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
      return $data.form.month_4 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_4]]), $data.form.errors.month_4 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_48, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_4), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_49, "Monthly Target 5 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[4]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[14] || (_cache[14] = function ($event) {
      return $data.form.month_5 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_5]]), $data.form.errors.month_5 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_5), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_51, "Monthly Target 6 (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.month_list[5]) + ")", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
      return $data.form.month_6 = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.month_6]]), $data.form.errors.month_6 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.month_6), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
      return $data.form.year = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.year]]), $data.form.errors.year ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_54, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.year), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
      return $data.form.is_additional_target = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.is_additional_target]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[18] || (_cache[18] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_55), _hoisted_56, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger mt-3 text-white",
    onClick: _cache[19] || (_cache[19] = function ($event) {
      return $options.cancelEdit();
    }),
    disabled: $data.form.processing
  }, " Cancel ", 8
  /* PROPS */
  , _hoisted_57)], 32
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
<<<<<<< HEAD
/* harmony import */ var _var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
=======
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
>>>>>>> 2cb1dbe9a7609f808f7c2561270827a3b332620b




;
<<<<<<< HEAD
const __exports__ = /*#__PURE__*/(0,_var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/IPCR/Targets/Create.vue"]])
=======
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_63f63b49__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/IPCR/Targets/Create.vue"]])
>>>>>>> 2cb1dbe9a7609f808f7c2561270827a3b332620b
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