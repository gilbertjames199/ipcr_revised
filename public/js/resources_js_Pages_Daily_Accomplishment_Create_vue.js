"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Daily_Accomplishment_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_PlacesShared__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/Shared/PlacesShared */ "./resources/js/Shared/PlacesShared.vue");

 //import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    mfo: Object,
    paps: Object,
    editData: Object,
    sectors: Object
  },
  components: {
    //BootstrapModalNoJquery,
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
        idmfo: "",
        date_from: "",
        date_to: "",
        description: "",
        quantity: "",
        remarks: "",
        Link: "",
        idpaps: "",
        amount: "",
        responsible_person: "",
        source_of_fund: "",
        id: null
      }),
      pageTitle: ""
    };
  },
  mounted: function mounted() {
    this.form.idpaps = this.idpaps;

    if (this.editData !== undefined) {
      if (this.bari) {
        this.bar = this.bari;
      }

      this.pageTitle = "Edit";
      this.form.date_from = this.editData.date_from;
      this.form.date_to = this.editData.date_to;
      this.form.description = this.editData.description;
      this.form.quantity = this.editData.quantity;
      this.form.remarks = this.editData.remarks;
      this.form.Link = this.editData.Link;
      this.form.idpaps = this.editData.idpaps;
      this.form.idmfo = this.editData.idmfo;
      this.form.amount = this.editData.amount;
      this.form.source_of_fund = this.editData.source_of_fund;
      this.form.responsible_person = this.editData.responsible_person;
      this.form.id = this.editData.id;
    } else {
      this.pageTitle = "Create";
    }
  },
  methods: {
    submit: function submit() {
      this.form.target_qty = parseFloat(this.form.target_qty1) + parseFloat(this.form.target_qty2) + parseFloat(this.form.target_qty3) + parseFloat(this.form.target_qty4); //alert(this.form.target_qty);

      if (this.editData !== undefined) {
        this.form.patch("/AddAccomplishment/" + this.form.id, this.form);
      } else {
        // alert("Sample");
        var url = "/AddAccomplishment/store"; // alert('for store '+url);

        this.form.post(url);
      }
    },
    filterPaps: function filterPaps() {
      var _this = this;

      this.my_paps = [];
      this.paps.forEach(function (i) {
        if (i.idmfo === _this.form.idmfo) {
          _this.my_paps.push(i);
        }
      });
      console.log(this.my_paps);
      return this.my_paps;
    }
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a":
/*!********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************/
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

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "IPCR Code", -1
/* HOISTED */
);

var _hoisted_7 = ["value"];
var _hoisted_8 = {
  key: 0,
  "class": "fs-6 c-red-500"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Individual Output", -1
/* HOISTED */
);

var _hoisted_10 = ["value"];
var _hoisted_11 = {
  key: 1,
  "class": "fs-6 c-red-500"
};

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Activity", -1
/* HOISTED */
);

var _hoisted_13 = {
  key: 2,
  "class": "fs-6 c-red-500"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Quantity (if any)", -1
/* HOISTED */
);

var _hoisted_15 = {
  key: 3,
  "class": "fs-6 c-red-500"
};

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Date", -1
/* HOISTED */
);

var _hoisted_17 = {
  key: 4,
  "class": "fs-6 c-red-500"
};

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Remarks", -1
/* HOISTED */
);

var _hoisted_19 = {
  key: 5,
  "class": "fs-6 c-red-500"
};

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": ""
}, "Link", -1
/* HOISTED */
);

var _hoisted_21 = {
  key: 6,
  "class": "fs-6 c-red-500"
};
var _hoisted_22 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " Accomplishment", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/AddAccomplishment"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\n            <button class=\"btn btn-secondary\" @click=\"showModal\" :disabled=\"submitted\">Permissions</button>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.form.idpaps = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.idpaps]]), _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control form-select",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.idmfo = $event;
    }),
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return $options.filterPaps();
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.mfo, function (mfo) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: mfo.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(mfo.mfo_desc), 9
    /* TEXT, PROPS */
    , _hoisted_7);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.idmfo]]), $data.form.errors.description ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.description), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control form-select",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.form.idpaps = $event;
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.my_paps, function (paps) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: paps.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(paps.paps_desc), 9
    /* TEXT, PROPS */
    , _hoisted_10);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.idpaps]]), $data.form.errors.description ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.description), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.form.description = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.description]]), $data.form.errors.description ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.description), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.form.quantity = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.quantity]]), $data.form.errors.quantity ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.quantity), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Amount (if any)</label>\n                <input type=\"number\" v-model=\"form.amount\" class=\"form-control\" autocomplete=\"positionchrome-off\">\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.amount\">{{ form.errors.amount }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Source of Fund (if any)</label>\n                <input type=\"text\" v-model=\"form.source_of_fund\" class=\"form-control\" autocomplete=\"positionchrome-off\">\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.source_of_fund\">{{ form.errors.source_of_fund }}</div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Responsible Person/Unit</label>\n                <input type=\"text\" v-model=\"form.responsible_person\" class=\"form-control\" autocomplete=\"positionchrome-off\">\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.responsible_person\">{{ form.errors.responsible_person }}</div> "), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "date",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.date_from = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date_from]]), $data.form.errors.date_from ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.date_from), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Date To</label>\n                <input type=\"date\" v-model=\"form.date_to\" class=\"form-control\" autocomplete=\"positionchrome-off\">\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.date_to\">{{ form.errors.date_to }}</div> "), _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.remarks = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), $data.form.errors.remarks ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.remarks), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.Link = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.Link]]), $data.form.errors.Link ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.Link), 1
  /* TEXT */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.id = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.id]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-primary mt-3",
    onClick: _cache[10] || (_cache[10] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing
  }, " Save changes ", 8
  /* PROPS */
  , _hoisted_22)], 32
  /* HYDRATE_EVENTS */
  )])]);
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

/***/ "./resources/js/Pages/Daily_Accomplishment/Create.vue":
/*!************************************************************!*\
  !*** ./resources/js/Pages/Daily_Accomplishment/Create.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=a2e7602a */ "./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Daily_Accomplishment/Create.vue"]])
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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/PlacesShared.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js":
/*!************************************************************************************!*\
  !*** ./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=script&lang=js");
 

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

/***/ "./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a":
/*!******************************************************************************************!*\
  !*** ./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=a2e7602a */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a");


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