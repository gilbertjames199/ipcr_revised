"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Coaching_Report_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    sem: Object,
    auth: Object,
    immediate_head: String,
    immediate_position: String,
    coachee_name: String,
    emp_code: String,
    semester: String,
    year: String,
    month: String,
    editData: Object
  },
  data: function data() {
    var _this$coachee_name, _this$immediate_head, _this$immediate_posit, _this$emp_code, _this$month, _this$sem$0$year, _this$sem, _this$sem$0$sem, _this$sem2, _this$auth$user$depar, _this$auth;
    return {
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        date: new Date().toISOString().split('T')[0],
        coachee_name: (_this$coachee_name = this.coachee_name) !== null && _this$coachee_name !== void 0 ? _this$coachee_name : "",
        critical_incident: "",
        goals: "",
        reality: "",
        opportunities: "",
        way_forward: "",
        followup_date: "",
        followup_time: "",
        followup_notes: "",
        supervisor_name: (_this$immediate_head = this.immediate_head) !== null && _this$immediate_head !== void 0 ? _this$immediate_head : "",
        supervisor_position: (_this$immediate_posit = this.immediate_position) !== null && _this$immediate_posit !== void 0 ? _this$immediate_posit : "",
        emp_code: (_this$emp_code = this.emp_code) !== null && _this$emp_code !== void 0 ? _this$emp_code : "",
        month: (_this$month = this.month) !== null && _this$month !== void 0 ? _this$month : "",
        year: (_this$sem$0$year = (_this$sem = this.sem) === null || _this$sem === void 0 || (_this$sem = _this$sem[0]) === null || _this$sem === void 0 ? void 0 : _this$sem.year) !== null && _this$sem$0$year !== void 0 ? _this$sem$0$year : "",
        sem: (_this$sem$0$sem = (_this$sem2 = this.sem) === null || _this$sem2 === void 0 || (_this$sem2 = _this$sem2[0]) === null || _this$sem2 === void 0 ? void 0 : _this$sem2.sem) !== null && _this$sem$0$sem !== void 0 ? _this$sem$0$sem : "",
        department_code: (_this$auth$user$depar = (_this$auth = this.auth) === null || _this$auth === void 0 || (_this$auth = _this$auth.user) === null || _this$auth === void 0 ? void 0 : _this$auth.department_code) !== null && _this$auth$user$depar !== void 0 ? _this$auth$user$depar : ""
      }),
      pageTitle: ""
    };
  },
  mounted: function mounted() {
    var _this$auth2;
    this.form.month = this.month;
    this.form.department_code = (_this$auth2 = this.auth) === null || _this$auth2 === void 0 || (_this$auth2 = _this$auth2.user) === null || _this$auth2 === void 0 ? void 0 : _this$auth2.department_code;
    this.form.emp_code = this.emp_code;
    if (this.editData !== undefined) {
      if (this.bari) {
        this.bar = this.bari;
      }
      this.pageTitle = "Edit";
      this.form.date = this.editData.date;
      this.form.coachee_name = this.editData.employee_name;
      this.form.critical_incident = this.editData.critical_incidence_description;
      this.form.goals = this.editData.goal;
      this.form.reality = this.editData.reality;
      this.form.opportunities = this.editData.opportunities;
      this.form.way_forward = this.editData.way_forward;
      this.form.followup_date = this.editData.follow_up_date;
      this.form.followup_time = this.editData.follow_up_time;
      this.form.followup_notes = this.editData.way_forward;
      this.form.supervisor_name = this.editData.coach_name;
      this.form.supervisor_position = this.editData.position;
      this.form.sem_id = this.editData.sem_id;
      this.form.id = this.editData.id;
    } else {
      this.pageTitle = "Create";
      this.form.date = new Date().toISOString().substr(0, 10);
    }
  },
  methods: {
    submit: function submit() {
      console.log(this.form);
      this.form.post("/coaching-report/store");
      if (this.editData !== undefined) {
        this.form.patch("/coaching-report/" + this.form.id, this.form);
      } else {
        // alert("Sample");
        var url = "/coaching-report/store";
        // alert('for store '+url);
        this.form.post(url);
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "row gap-20"
};
var _hoisted_2 = {
  "class": "col-md-12"
};
var _hoisted_3 = {
  "class": "custom-fieldset"
};
var _hoisted_4 = {
  "class": "row"
};
var _hoisted_5 = {
  "class": "col-md-4"
};
var _hoisted_6 = {
  "class": "col-md-4"
};
var _hoisted_7 = {
  "class": "custom-fieldset"
};
var _hoisted_8 = {
  "class": "custom-fieldset"
};
var _hoisted_9 = {
  "class": "custom-fieldset"
};
var _hoisted_10 = {
  "class": "custom-fieldset"
};
var _hoisted_11 = {
  "class": "custom-fieldset"
};
var _hoisted_12 = {
  "class": "custom-fieldset"
};
var _hoisted_13 = {
  "class": "row"
};
var _hoisted_14 = {
  "class": "col-md-6"
};
var _hoisted_15 = {
  "class": "col-md-6"
};
var _hoisted_16 = {
  "class": "custom-fieldset"
};
var _hoisted_17 = {
  "class": "row"
};
var _hoisted_18 = {
  "class": "col-md-6"
};
var _hoisted_19 = {
  "class": "col-md-6"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " Coaching Report Form", 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
      return $options.submit && $options.submit.apply($options, arguments);
    }, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_3, [_cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Employee Information")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Date", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "date",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.form.date = $event;
    }),
    "class": "form-control",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Name of Coachee", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.form.coachee_name = $event;
    }),
    "class": "form-control",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.coachee_name]])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Critical Incident "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_7, [_cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Critical Incident Description")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "5",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.form.critical_incident = $event;
    }),
    "class": "form-control",
    placeholder: "Describe actual events and behaviors..."
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.critical_incident]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Goals "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_8, [_cache[17] || (_cache[17] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Goals")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "4",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.form.goals = $event;
    }),
    "class": "form-control",
    placeholder: "What the coachee wants to achieve"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.goals]]), _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"coaching-guide mt-3\" data-v-3f657429><h6 data-v-3f657429>Structure for Coaching</h6><ul data-v-3f657429><li data-v-3f657429>What would you like to work on?</li><li data-v-3f657429>What would you like to have after answering this set of questions (e.g. first step, strategy or solution)?</li><li data-v-3f657429>What is your goal related to this issue?</li><li data-v-3f657429>When are you going to achieve it?</li><li data-v-3f657429>What are the benefits for you in achieving this goal?</li><li data-v-3f657429>Who else will benefit and in what way?</li><li data-v-3f657429>What will it be like if you achieve your goal?</li><li data-v-3f657429>What will you see, hear and feel?</li></ul></div>", 1))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Reality "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_9, [_cache[19] || (_cache[19] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Reality")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "4",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.form.reality = $event;
    }),
    "class": "form-control",
    placeholder: "Current situation and challenges"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.reality]]), _cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"coaching-guide mt-3\" data-v-3f657429><h6 data-v-3f657429>Structure for Coaching</h6><ul data-v-3f657429><li data-v-3f657429>What action have you taken so far?</li><li data-v-3f657429>What is moving you toward your goal?</li><li data-v-3f657429>What is getting in the way?</li><li data-v-3f657429>What is happening at the moment?</li><li data-v-3f657429>How important is this to you?</li><li data-v-3f657429>On a scale of 1–10, if an ideal situation is 10, what number are you at now?</li><li data-v-3f657429>What number would you like to be at?</li><li data-v-3f657429>How do you feel about this?</li><li data-v-3f657429>What impact is this having on you?</li></ul></div>", 1))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Opportunities "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_10, [_cache[21] || (_cache[21] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Opportunities")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "4",
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.form.opportunities = $event;
    }),
    "class": "form-control",
    placeholder: "Possible solutions and remedies"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.opportunities]]), _cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"coaching-guide mt-3\" data-v-3f657429><h6 data-v-3f657429>Structure for Coaching</h6><ul data-v-3f657429><li data-v-3f657429>What different kinds of options do you have to achieve your goal?</li><li data-v-3f657429>What else could you do?</li><li data-v-3f657429>What are the principal advantages and disadvantages of each option?</li><li data-v-3f657429>What ideas do you have?</li><li data-v-3f657429>What alternatives do you have?</li><li data-v-3f657429>What steps could you take?</li><li data-v-3f657429>Who could help you with this?</li><li data-v-3f657429>Where could you find out the information?</li><li data-v-3f657429>How could you do that?</li></ul></div>", 1))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Way Forward "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_11, [_cache[23] || (_cache[23] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Way Forward")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "4",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.way_forward = $event;
    }),
    "class": "form-control",
    placeholder: "Actions to be executed"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.way_forward]]), _cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "coaching-guide mt-3"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", null, "Structure for Coaching"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, "Which options will you choose to act on?"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, "When are you going to start each action?"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, "How committed are you, on a scale of 1–10, to taking each action?"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, "If it is not a 10, what would make it a 10?"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, "What will you commit to doing?")])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Follow-up Session "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_12, [_cache[27] || (_cache[27] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Follow-Up Coaching Session")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_cache[25] || (_cache[25] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Follow-up Date", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "date",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.followup_date = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.followup_date]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [_cache[26] || (_cache[26] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Follow-up Time", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "time",
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $data.form.followup_time = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.followup_time]])])]), _cache[28] || (_cache[28] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "mt-3"
  }, " Improved behavior, competency, development, growth or new skills ", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    rows: "4",
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.form.followup_notes = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.followup_notes]]), _cache[29] || (_cache[29] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "coaching-guide mt-3"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", null, "Follow-up Coaching Guide"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "mb-0"
  }, " Identify the expectations, agreements, and commitments. Determine the progress and give the coachee the space to open up. Observe signs of growth and make a deliberate effort to observe improved behavior, competency, development, growth, or new skills. ")], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Supervisor "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", _hoisted_16, [_cache[32] || (_cache[32] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
    "class": "float-none w-auto"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Supervisor Information")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [_cache[30] || (_cache[30] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Supervisor Name", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return $data.form.supervisor_name = $event;
    }),
    "class": "form-control",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.supervisor_name]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [_cache[31] || (_cache[31] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Position", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $data.form.supervisor_position = $event;
    }),
    "class": "form-control",
    readonly: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.supervisor_position]])])])]), _cache[33] || (_cache[33] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    "class": "btn btn-primary text-white"
  }, " Save ", -1 /* CACHED */))], 32 /* NEED_HYDRATION */)])]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.coaching-guide[data-v-3f657429] {\n    border: 1px solid #0d6efd;\n    border-radius: 6px;\n    background: #f8f9fa;\n    padding: 15px;\n    margin-top: 20px;\n    margin-bottom: 15px;\n}\n.coaching-guide h6[data-v-3f657429] {\n    font-weight: bold;\n    color: #0d6efd;\n    margin-bottom: 10px;\n}\n.coaching-guide ul[data-v-3f657429] {\n    margin-bottom: 0;\n    padding-left: 20px;\n}\n.coaching-guide li[data-v-3f657429] {\n    margin-bottom: 6px;\n}\n.custom-fieldset[data-v-3f657429] {\n    border: 2px solid #000 !important;\n    border-radius: 8px;\n    padding: 1.5rem;\n    margin-bottom: 1.5rem;\n}\n.custom-fieldset legend[data-v-3f657429] {\n    width: auto;\n    padding: 0 10px;\n    font-size: 1.1rem;\n    color: #000;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_style_index_0_id_3f657429_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_style_index_0_id_3f657429_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_style_index_0_id_3f657429_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/Pages/Coaching_Report/Create.vue":
/*!*******************************************************!*\
  !*** ./resources/js/Pages/Coaching_Report/Create.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_3f657429_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=3f657429&scoped=true */ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _Create_vue_vue_type_style_index_0_id_3f657429_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css */ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_3f657429_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-3f657429"],['__file',"resources/js/Pages/Coaching_Report/Create.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js":
/*!*******************************************************************************!*\
  !*** ./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_style_index_0_id_3f657429_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=style&index=0&id=3f657429&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true":
/*!*************************************************************************************************!*\
  !*** ./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_3f657429_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_3f657429_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=3f657429&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Coaching_Report/Create.vue?vue&type=template&id=3f657429&scoped=true");


/***/ })

}]);