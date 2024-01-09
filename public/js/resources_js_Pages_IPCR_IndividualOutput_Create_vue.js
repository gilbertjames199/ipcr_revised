"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_IPCR_IndividualOutput_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");
var _props;



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



 //import Places from "@/Shared/PlacesShared";

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: (_props = {
    editData: Object,
    id: String,
    offices: Object,
    major_final_outputs: Object,
    emp: Object,
    supervisors: Object
  }, _defineProperty(_props, "emp", Object), _defineProperty(_props, "dept_code", String), _defineProperty(_props, "source", String), _defineProperty(_props, "auth", Object), _props),
  components: {
    ModelSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_3__.ModelSelect
  },
  data: function data() {
    return {
      submitted: false,
      ffunccod: "",
      mfos: [],
      sub_mfos: [],
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.useForm)({
        // ipcr_code: "",
        idmfo: "",
        idsubmfo: "",
        id_div_output: "",
        individual_output: "",
        performance_measure: "",
        success_indicator: "",
        concerned_indiviual: "",
        quantity_type: "",
        quality_error: "",
        time_range_code: "",
        time_based: "",
        activity: "",
        verb: "",
        error_feedback: "",
        within: "",
        unit_of_time: "",
        concatenante: "",
        id: null
      }),
      emp_sg: this.auth.user.name.salary_grade,
      immediate_sg: "0",
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
    this.form.source = this.source;
    this.mfos = this.major_final_outputs; // this.form.ipcr_semester_id="0";

    if (this.editData !== undefined) {
      this.pageTitle = "Edit";
      this.form.sem = this.editData.sem;
      this.form.immediate_id = this.editData.immediate_id;
      this.form.next_higher = this.editData.next_higher;
      this.form.year = this.editData.year;
      this.form.employee_code = this.editData.employee_code;
      this.form.status = this.editData.status;
      this.form.id = this.editData.id; // alert(this.id)
    } else {
      // this.form.employee_code = this.emp.empl_id
      this.pageTitle = "Create";
      this.form.status = "-1"; // this.setYear();
    }
  },
  computed: {},
  methods: {
    submit: function submit() {
      if (this.editData !== undefined) {
        if (this.form.status > 0) {
          alert('Already approved or reviewed!');
        } else {
          this.form.patch("/ipcrsemestral/update/" + this.editData.id, this.form);
        }
      } else {
        this.form.post("/ipcrsemestral/store/" + this.id);
      }
    },
    loadMFOs: function loadMFOs() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.mfos = [];
                _this.sub_mfos = [];
                _this.form.idmfo = "";
                _this.form.idsubmfo = "";

                if (!_this.ffunccod) {
                  _context.next = 7;
                  break;
                }

                _context.next = 7;
                return axios__WEBPACK_IMPORTED_MODULE_2___default().post('/fetch/data/major/final/outputs', {
                  FFUNCCOD: _this.ffunccod
                }).then(function (response) {
                  _this.mfos = response.data;
                });

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    loadSubMFOs: function loadSubMFOs() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.sub_mfos = [];
                _this2.form.idsubmfo = "";
                alert("idmfo: " + _this2.form.idmfo);

                if (!_this2.ffunccod) {
                  _context2.next = 6;
                  break;
                }

                _context2.next = 6;
                return axios__WEBPACK_IMPORTED_MODULE_2___default().post('/fetch/data/sub/mfos', {
                  idmfo: _this2.form.idmfo
                }).then(function (response) {
                  _this2.sub_mfos = response.data;
                });

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    } // setYear() {
    //     const now = new Date();
    //     this.form.year = now.getFullYear();
    // },
    // setSG() {
    //     var recid = this.form.immediate_id;
    //     var index = this.supervisors.findIndex(superv => superv.empl_id === recid);
    //     if (index !== -1) {
    //         this.immediate_sg = this.supervisors[index].salary_grade;
    //     } else {
    //         this.immediate_sg = "0";
    //     }
    // }

  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881 ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************/
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

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
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

var _hoisted_5 = {
  "class": "col-md-8"
};

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  type: "hidden",
  required: ""
}, null, -1
/* HOISTED */
);

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Office: ", -1
/* HOISTED */
);

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, null, -1
/* HOISTED */
);

var _hoisted_9 = ["value"];

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Major Final Outputs", -1
/* HOISTED */
);

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "00"
}, null, -1
/* HOISTED */
);

var _hoisted_12 = ["value"];

var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Sub MFO", -1
/* HOISTED */
);

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "00"
}, null, -1
/* HOISTED */
);

var _hoisted_15 = ["value"];

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Division Output", -1
/* HOISTED */
);

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "00"
}, null, -1
/* HOISTED */
);

var _hoisted_18 = ["value"];
var _hoisted_19 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " IPCR myIPCR: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.editData), 1
  /* TEXT */
  ), $props.editData !== undefined ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    href: "/ipcrsemestral/".concat($props.emp.id, "/").concat($props.source)
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 1,
    href: "/individual-final-output-crud/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_4];
    }),
    _: 1
    /* STABLE */

<<<<<<< HEAD
  }))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div>Name: <u>{{ emp.employee_name }}</u></div> {{ source }}\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
=======
  }))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div>Name: <u>{{ emp.employee_name }}</u></div> {{ source }}\r\n            <div>Position: <u>{{ emp.position_long_title }}</u></div>\r\n            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
>>>>>>> fe3972ecc969d56b308744fe811dd4cdb6e273c0
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_6, _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.ffunccod = $event;
    }),
    onChange: _cache[1] || (_cache[1] = function ($event) {
      return $options.loadMFOs();
    })
  }, [_hoisted_8, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.offices, function (office) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: office.ffunccod
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(office.office), 9
    /* TEXT, PROPS */
    , _hoisted_9);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.ffunccod]]), _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.form.idmfo = $event;
    }),
    onChange: _cache[3] || (_cache[3] = function ($event) {
      return $options.loadSubMFOs();
    })
  }, [_hoisted_11, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.mfos, function (mfo) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: mfo.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(mfo.mfo_desc), 9
    /* TEXT, PROPS */
    , _hoisted_12);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.idmfo]]), _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.form.idsubmfo = $event;
    }),
    onChange: _cache[5] || (_cache[5] = function ($event) {
      return $options.loadSubMFOs();
    })
  }, [_hoisted_14, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.sub_mfos, function (sub_mfo) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: sub_mfo.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(sub_mfo.submfo_description), 9
    /* TEXT, PROPS */
    , _hoisted_15);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 544
  /* HYDRATE_EVENTS, NEED_PATCH */
<<<<<<< HEAD
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.idsubmfo]]), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-select",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.id_div_output = $event;
    })
  }, [_hoisted_17, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.sub_mfos, function (sub_mfo) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: sub_mfo.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(sub_mfo.submfo_description), 9
    /* TEXT, PROPS */
    , _hoisted_18);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.id_div_output]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\n                <label>Sub MFO</label>\n                {{ mfos }}\n                <select class=\"form-select\" v-model=\"form.idsubmfo\" @change=\"loadSubMFOs()\">\n                    <option value=\"00\"></option>\n                    <option v-for=\"sub_mfo in sub_mfos\" :value=\"mfo.id\">\n                        {{ sub_mfo.submfo_description }}\n                    </option>\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Target Setting</label>\n                <select type=\"text\" v-model=\"form.sem\" class=\"form-control\" autocomplete=\"chrome-off\">\n                    <option value=\"1\">First Semester</option>\n                    <option value=\"2\">Second Semester</option>\n                </select>\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.sem\">{{ form.errors.sem }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Immediate Supervisor</label>\n                <div>\n                    <multiselect :options=\"supervisors_i\" :searchable=\"true\" v-model=\"form.immediate_id\" label=\"label\"\n                        track-by=\"label\" @close=\"setSG\">\n                    </multiselect>\n                </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.immediate_id\" class=\"form-control\" @change=\"setSG\" autocomplete=\"chrome-off\" >\n                    <option></option>\n                    <option v-for=\"superv in supervisors\" :value=\"superv.empl_id\" >{{ superv.employee_name }}</option>\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"fs-6 c-red-500\" v-if=\"form.errors.immediate_id\">{{ form.errors.immediate_id }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Next Higher Supervisor</label>\n                <div>\n                    <multiselect :options=\"supervisors_h\" :searchable=\"true\" v-model=\"form.next_higher\" label=\"label\"\n                        track-by=\"label\">\n                    </multiselect>\n                </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.next_higher }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.next_higher\" class=\"form-control\" autocomplete=\"chrome-off\" >\n                    <option></option>\n                    <option v-for=\"superv in supervisors_h\" :value=\"superv.empl_id\">{{ superv.employee_name }}</option>\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"fs-6 c-red-500\" v-if=\"form.errors.next_higher\">{{ form.errors.next_higher }}</div>\n\n                <label for=\"\">Year</label>\n                <input v-model=\"form.year\" class=\"form-control\" type=\"number\" name=\"year\" min=\"1900\" max=\"2099\" step=\"1\"\n                    oninput=\"javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);\" />\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.year\">{{ form.errors.year }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
=======
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.idsubmfo]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n                <label>Sub MFO</label>\r\n                {{ mfos }}\r\n                <select class=\"form-select\" v-model=\"form.idsubmfo\" @change=\"loadSubMFOs()\">\r\n                    <option value=\"00\"></option>\r\n                    <option v-for=\"sub_mfo in sub_mfos\" :value=\"mfo.id\">\r\n                        {{ sub_mfo.submfo_description }}\r\n                    </option>\r\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_value }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Target Setting</label>\r\n                <select type=\"text\" v-model=\"form.sem\" class=\"form-control\" autocomplete=\"chrome-off\">\r\n                    <option value=\"1\">First Semester</option>\r\n                    <option value=\"2\">Second Semester</option>\r\n                </select>\r\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.sem\">{{ form.errors.sem }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Immediate Supervisor</label>\r\n                <div>\r\n                    <multiselect :options=\"supervisors_i\" :searchable=\"true\" v-model=\"form.immediate_id\" label=\"label\"\r\n                        track-by=\"label\" @close=\"setSG\">\r\n                    </multiselect>\r\n                </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.immediate_id\" class=\"form-control\" @change=\"setSG\" autocomplete=\"chrome-off\" >\r\n                    <option></option>\r\n                    <option v-for=\"superv in supervisors\" :value=\"superv.empl_id\" >{{ superv.employee_name }}</option>\r\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"fs-6 c-red-500\" v-if=\"form.errors.immediate_id\">{{ form.errors.immediate_id }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Next Higher Supervisor</label>\r\n                <div>\r\n                    <multiselect :options=\"supervisors_h\" :searchable=\"true\" v-model=\"form.next_higher\" label=\"label\"\r\n                        track-by=\"label\">\r\n                    </multiselect>\r\n                </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form.next_higher }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select type=\"text\" v-model=\"form.next_higher\" class=\"form-control\" autocomplete=\"chrome-off\" >\r\n                    <option></option>\r\n                    <option v-for=\"superv in supervisors_h\" :value=\"superv.empl_id\">{{ superv.employee_name }}</option>\r\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"fs-6 c-red-500\" v-if=\"form.errors.next_higher\">{{ form.errors.next_higher }}</div>\r\n\r\n                <label for=\"\">Year</label>\r\n                <input v-model=\"form.year\" class=\"form-control\" type=\"number\" name=\"year\" min=\"1900\" max=\"2099\" step=\"1\"\r\n                    oninput=\"javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);\" />\r\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.year\">{{ form.errors.year }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
>>>>>>> fe3972ecc969d56b308744fe811dd4cdb6e273c0
    type: "button",
    "class": "btn btn-primary mt-3 text-white font-weight-bold",
    onClick: _cache[7] || (_cache[7] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_19)], 32
  /* HYDRATE_EVENTS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" sub_mfo: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.sub_mfos), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ supervisors_h }} ")]);
}

/***/ }),

/***/ "./resources/js/Pages/IPCR/IndividualOutput/Create.vue":
/*!*************************************************************!*\
  !*** ./resources/js/Pages/IPCR/IndividualOutput/Create.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_103e9881__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=103e9881 */ "./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_103e9881__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/IPCR/IndividualOutput/Create.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js":
/*!*************************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881":
/*!*******************************************************************************************!*\
  !*** ./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881 ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_103e9881__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_103e9881__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=103e9881 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/IPCR/IndividualOutput/Create.vue?vue&type=template&id=103e9881");


/***/ })

}]);