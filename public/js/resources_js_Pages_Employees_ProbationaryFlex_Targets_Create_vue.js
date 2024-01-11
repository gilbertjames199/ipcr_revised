"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Employees_ProbationaryFlex_Targets_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }


 //import Places from "@/Shared/PlacesShared";

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    editData: Object,
    id: String,
    emp: Object,
    ipcrs: Object,
    prob: Object,
    date_from: Object,
    date_to: Object,
    editQuantity: Object
  },
  components: {
    ModelSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_1__.ModelSelect
  },
  data: function data() {
    return {
      submitted: false,
      my_id: "",
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        probationary_temporary_employees_id: "",
        ipcr_code: "",
        ipcr_type: "",
        quantity: [],
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

    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.probationary_temporary_employees_id = this.editData.probationary_temporary_employees_id;
      this.form.id = this.editData.id;
      var index = this.ipcrs.findIndex(function (ipcr) {
        return ipcr.ipcr_code === _this.form.ipcr_code;
      });
      this.form.ipcr_code = this.editData.ipcr_code;
      this.form.ipcr_pob_tempo_id = this.editData.ipcr_pob_tempo_id;
      this.$nextTick(function () {
        _this.selected_ipcr();
      });
      this.form.ipcr_type = this.editData.ipcr_type;
      this.form.quantity = this.editQuantity;
      this.my_id = this.editData.ipcr_pob_tempo_id;
      this.adjustQuantity();
    } else {
      this.pageTitle = "Add";
      this.form.probationary_temporary_employees_id = this.id;
      this.push_values_to_quantity();
      this.my_id = this.id;
    }
  },
  computed: {
    month_list: function month_list() {
      var mos = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      return mos;
    },
    quantity_needed: function quantity_needed() {
      var v1 = 0;
      var v2 = 0;
      var v3 = 0;
      var v4 = 0;
      var v5 = 0;
      var v6 = 0;
      var v7 = 0;
      var v8 = 0;
      var v9 = 0;
      var v10 = 0;

      if (this.form.month_1 !== "" || this.form.month_1 !== undefined) {
        v1 = parseFloat(this.form.month_1);
        v2 = parseFloat(this.form.month_2);
        v3 = parseFloat(this.form.month_3);
        v4 = parseFloat(this.form.month_4);
        v5 = parseFloat(this.form.month_5);
        v6 = parseFloat(this.form.month_6);

        if (this.prob.prob_status === 'Temporary') {
          v7 = parseFloat(this.form.month_7);
          v8 = parseFloat(this.form.month_8);
          v9 = parseFloat(this.form.month_9);
          v10 = parseFloat(this.form.month_10);
        }
      }

      var targq = parseFloat(this.form.target_quantity);
      var sum = v1 + v2 + v3 + v4 + v5 + v6 + v7 + v8 + v9 + v10;
      var ret = "";
      var diff = 0;

      if (targq > sum) {
        diff = targq - sum;
        ret = "WARNING: Add " + diff + " to your monthly targets OR remove " + diff + " from your total target ";
      } else if (targq < sum) {
        diff = sum - targq;
        ret = "WARNING: Remove " + diff + " from your monthly targets OR add " + diff + " to your total target ";
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
      if (this.editData !== undefined) {
        //alert("patch");
        this.form.patch("/prob/individual/targets/update/" + this.id, this.form);
      } else {
        // alert(this.id)
        this.form.post("/prob/individual/targets/store/" + this.id);
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
    push_values_to_quantity: function push_values_to_quantity() {
      var _this3 = this;

      this.date_from.forEach(function () {
        _this3.form.quantity.push(0);
      });
    },
    adjustQuantity: function adjustQuantity() {
      var dateFromKeys = Object.keys(this.date_from);

      var editQuantityCopy = _toConsumableArray(this.editQuantity); // If date_from has more keys, push zeros to editQuantity


      while (dateFromKeys.length > editQuantityCopy.length) {
        editQuantityCopy.push(0);
      } // If date_from has fewer keys, remove extra elements from editQuantity


      while (dateFromKeys.length < editQuantityCopy.length) {
        editQuantityCopy.pop();
      }

      this.form.quantity = editQuantityCopy;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074 ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, "Type/Category", -1
/* HOISTED */
);

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Core Function"
}, "Core Function", -1
/* HOISTED */
);

var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Support Function"
}, "Support Function", -1
/* HOISTED */
);

var _hoisted_22 = [_hoisted_20, _hoisted_21];
var _hoisted_23 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_24 = {
  "class": "col-md-8"
};
var _hoisted_25 = {
  "class": "border p-4"
};

var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "float-none w-auto"
}, " Target Quantity ", -1
/* HOISTED */
);

var _hoisted_27 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_28 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_29 = {
  "class": "masonry-item w-100"
};
var _hoisted_30 = {
  "class": "row gap-20"
};
var _hoisted_31 = ["onUpdate:modelValue"];
var _hoisted_32 = ["disabled"];

var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ");

var _hoisted_34 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.prob.prob_status) + " IPCR Target", 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" my_id: {{ my_id }} {{ id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/prob/individual/targets/".concat($data.my_id)
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\n            <div>Name: <u>{{ emp.employee_name }}</u></div>\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
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
      return $data.form.ipcr_type = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, _hoisted_22, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.ipcr_type]]), $data.form.errors.ipcr_type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.ipcr_type), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_25, [_hoisted_26, $data.form.errors.quantity ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.quantity), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [$props.date_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.date_from, function (dt_from, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      "class": "col-md-6",
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Month " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1
    /* TEXT */
    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" - (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.formatDateRange($props.date_from[index], $props.date_to[index])) + ") ", 1
    /* TEXT */
    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "number",
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.form.quantity[index] = $event;
      },
      "class": "form-control",
      autocomplete: "positionchrome-off"
    }, null, 8
    /* PROPS */
    , _hoisted_31), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.quantity[index]]])]);
  }), 128
  /* KEYED_FRAGMENT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[8] || (_cache[8] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_32), _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger mt-3 text-white",
    onClick: _cache[9] || (_cache[9] = function ($event) {
      return $options.cancelEdit();
    }),
    disabled: $data.form.processing
  }, " Cancel ", 8
  /* PROPS */
  , _hoisted_34)], 32
  /* HYDRATE_EVENTS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ prob.date_from }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ editData }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" //{{ id }}  ")]);
}

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=4cc02074 */ "./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js");
<<<<<<< HEAD
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
=======
<<<<<<< HEAD
/* harmony import */ var _var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
=======
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e
>>>>>>> f8a3a594d02a1d8306f43905cc42447284c97957




;
<<<<<<< HEAD
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue"]])
=======
<<<<<<< HEAD
const __exports__ = /*#__PURE__*/(0,_var_www_html_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue"]])
=======
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue"]])
>>>>>>> 71fb437343767af8be195a8079fb21532fabf70e
>>>>>>> f8a3a594d02a1d8306f43905cc42447284c97957
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js":
/*!**************************************************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074":
/*!********************************************************************************************************!*\
  !*** ./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074 ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_4cc02074__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=4cc02074 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue?vue&type=template&id=4cc02074");


/***/ })

}]);