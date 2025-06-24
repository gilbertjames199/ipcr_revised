"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Semestral_Accomplishment_Approve_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_Filter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/Shared/Filter */ "./resources/js/Shared/Filter.vue");
/* harmony import */ var _Shared_Pagination__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/Shared/Pagination */ "./resources/js/Shared/Pagination.vue");
/* harmony import */ var _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/Shared/PrintModal */ "./resources/js/Shared/PrintModal.vue");
/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @inertiajs/inertia */ "./node_modules/@inertiajs/inertia/dist/index.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }









/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    accomplishments: Object,
    pghead: Object,
    filters: Object
  },
  computed: {
    quantityArray: function quantityArray() {
      var _ref;
      var allArrays = this.ipcr_targets.map(function (target) {
        return JSON.parse(target.quantity);
      });
      var mergedArray = (_ref = []).concat.apply(_ref, _toConsumableArray(allArrays));
      var quant = JSON.parse(this.ipcr_targets[0].quantity);
      return mergedArray;
    }
  },
  data: function data() {
    return {
      report_link: "",
      my_link: "",
      displayModal: false,
      modal_title: "Add",
      ipcr_targets: [],
      ipcr_accomplishments: [],
      ipcr_accomplishments_review: [],
      core_support: [],
      emp_sem_id: "",
      emp_name: "",
      emp_year: "",
      emp_sem: "",
      emp_status: "",
      empl_id: "",
      imm_id_loc: "",
      nxt_id_loc: "",
      Average_Point_Core: 0,
      Average_Point_Support: 0,
      displayModal2: false,
      displayModal3: false,
      displayModal4: false,
      displayModalDaily: false,
      length: 0,
      id_accomp_selected: "",
      pg_head: "",
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        type: "",
        remarks: "",
        ipcr_semestral_id: "",
        employee_code: "",
        ipcr_monthly_accomplishment_id: ""
      }),
      search: this.$props.filters.search,
      //FOR MODAL
      opened: [],
      show: [],
      // LOADING
      isLoading: false
    };
  },
  watch: {
    search: _.debounce(function (value) {
      this.$inertia.get("/approve/semestral-accomplishments", {
        search: value
      }, {
        preserveScroll: true,
        preserveState: true,
        replace: true
      });
    }, 300)
  },
  components: {
    Pagination: _Shared_Pagination__WEBPACK_IMPORTED_MODULE_2__["default"],
    Filtering: _Shared_Filter__WEBPACK_IMPORTED_MODULE_1__["default"],
    Modal: _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__["default"],
    Modal2: _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__["default"],
    Modal3: _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__["default"],
    Modal4: _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__["default"],
    ModalDaily: _Shared_PrintModal__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  mounted: function mounted() {
    this.Average_Point_Core = this.calculateAverageCoreSem(this.ipcr_accomplishments_review.data);
    this.Average_Point_Support = this.calculateAverageSupportSem(this.ipcr_accomplishments_review.data);
  },
  methods: {
    Status: function Status(status) {
      var result = "";
      if (status == "0") {
        result = "Submitted";
      } else if (status == 1) {
        result = "Reviewed";
      } else if (status == 2) {
        result = "Approved";
      }
      return result;
    },
    showModals: function showModals(e_sem_id, empl_id, a_status, immid, nxtid) {
      var _this = this;
      this.emp_sem_id = e_sem_id;
      this.emp_status = a_status;
      this.imm_id_loc = immid;
      // alert(this.immid_id_loc)
      this.isLoading = true;
      this.nxt_id_loc = nxtid;
      axios.get("/semester-accomplishment/get/semestralAccomplishment", {
        params: {
          sem_id: e_sem_id,
          empl_id: empl_id
        }
      }).then(function (response) {
        _this.ipcr_accomplishments_review = response.data;
        console.log(_this.ipcr_accomplishments_review);
        _this.sem_data = _this.ipcr_accomplishments_review.sem_data;
        _this.Average_Point_Core = _this.calculateAverageCoreSem(_this.ipcr_accomplishments_review.data);
        _this.Average_Point_Support = _this.calculateAverageSupportSem(_this.ipcr_accomplishments_review.data);
        _this.hideModal2();
        _this.hideModal();
        _this.displayModal4 = true;
      })["catch"](function (error) {
        console.error(error);
      })["finally"](function () {
        _this.isLoading = false;
      });
    },
    hideModal4: function hideModal4() {
      this.displayModal4 = false;
    },
    showModal1: function showModal1() {
      this.displayModal = true;
    },
    hideModal: function hideModal() {
      this.displayModal = false;
    },
    hideModal2: function hideModal2() {
      this.displayModal2 = false;
    },
    // async
    submitAction: function submitAction(stat, sem_id) {
      // alert(stat);
      var acc = "";
      if (stat < 0) {
        acc = "return";
      } else if (stat < 2) {
        acc = "review";
      } else if (stat < 3) {
        acc = "approve";
      } else {
        acc = "final approve";
      }
      console.log(this.ipcr_accomplishments_review.sem);
      var text = "Are you sure you want to " + acc + " this accomplishment?";
      // alert(this.id_accomp_selected)
      // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")/review/approve/
      if (confirm(text) == true) {
        //'/approve/semestral-accomplishments/up/stat/acc/{status}/{acc_id}'
        // /approve/semestral-accomplishments/{status}/{acc_id}
        var myurl = "/approve/semestral-accomplishments/up/stat/acc/" + stat + "/" + this.emp_sem_id;
        // alert(myurl)
        // alert(this.form.remarks);
        // alert(this.empl_id)
        this.form.employee_code = this.ipcr_accomplishments_review.sem.employee_code;
        // await axios
        this.$inertia.post(myurl, {
          params: {
            remarks: this.form.remarks,
            employee_code: this.form.employee_code,
            Average_Point_Core: this.Average_Point_Core,
            Average_Point_Support: this.Average_Point_Support
          }
        });
      }
      this.hideModal4();
      this.form.remarks = "";
    },
    showModal2: function showModal2(my_id, empl_id, e_name, e_year, e_sem, e_stat) {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this2.emp_name = e_name;
              _this2.emp_year = e_year;
              _this2.emp_sem = e_sem;
              _this2.emp_status = e_stat;
              _this2.emp_sem_id = my_id;
              _this2.empl_id = empl_id;
              // alert('ipcr_sem: '+my_id+' emp_code: '+empl_id)
              _context.next = 8;
              return axios.get("/ipcrtargets/get/ipcr/targets/2", {
                params: {
                  sem_id: my_id,
                  empl_id: empl_id
                }
              }).then(function (response) {
                _this2.ipcr_targets = response.data;
              })["catch"](function (error) {
                console.error(error);
              });
            case 8:
              _this2.displayModal2 = true;
            case 9:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    parseQuantity: function parseQuantity(quantarr) {
      // Remove brackets and split by commas, then convert to numbers
      var cleanedString = quantarr.replace(/[\[\]]/g, '');
      var numberArray = cleanedString.split(',').map(Number);
      //this.length = numberArray[0].quantity.length
      return numberArray;
    },
    submitActionProb: function submitActionProb(stat) {
      //alert(stat);
      var acc = "";
      if (stat < 2) {
        acc = "review";
      } else {
        acc = "approve";
      }
      var text = "Are you sure you want to " + acc + " the IPCR Target?";
      // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
      if (confirm(text) == true) {
        this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id + "/probationary");
      }
      this.hideModal2();
    },
    showModal3: function showModal3() {
      if (this.emp_sem === "1" || this.emp_sem === "2") {
        this.form.type = "ipcr_semestrals";
      } else {
        this.form.type = "probationary/temporary";
      }
      this.form.ipcr_semestral_id = this.emp_sem_id;
      this.form.employee_code = this.empl_id;
      this.hideModal2();
      this.hideModal();
      // alert("ipcr_semestral_id: " + this.form.ipcr_semestral_id +
      //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id +
      //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id)
      // this.displayModal3 = true
    },
    hideModal3: function hideModal3() {
      this.displayModal3 = false;
    },
    submitReturnReason: function submitReturnReason() {
      // alert("Type: " + this.form.type + "; ipcr_semestral_id: " +
      //     this.form.ipcr_semestral_id + "; employee_code: " +
      //     this.form.employee_code + "; remarks: " +
      //     this.form.remarks)
      var text = "Are you sure you want to return this IPCR?";
      if (confirm(text) == true) {
        if (this.form.remarks) {
          //this.$inertia.post("/return/remarks" + id+"/"+this.idmfo);
          this.form.post("/return/accomplishments/remarks", this.form);
        } else {
          alert("Input remarks!");
        }
      }
      this.hideModal();
      this.hideModal2();
      this.cancelReason();
    },
    cancelReason: function cancelReason() {
      this.hideModal3();
      this.form.remarks = "";
      this.form.type = "";
      this.form.ipcr_semestral_id = "";
      this.form.employee_code = "";
    },
    showModalDaily: function showModalDaily() {
      this.displayModalDaily = true;
    },
    hideModalDaily: function hideModalDaily() {
      this.displayModalDaily = false;
    },
    viewDailyAccomplishments: function viewDailyAccomplishments(emp_code, sem, yval) {
      // alert(this.emp_code);
      //var office_ind = document.getElementById("selectOffice").selectedIndex;

      // this.office =this.auth.user.office.office;
      // var pg_head = this.functions.DEPTHEAD;
      // var forFFUNCCOD = this.auth.user.office.department_code;
      this.my_link = this.viewlinkaa(emp_code, sem, yval);
      this.showModalDaily();
    },
    viewlinkaa: function viewlinkaa(username, sem, yval) {
      //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
      // var date_from =
      var moval_beg = 1;
      var moval_lst = 6;
      if (sem > 1) {
        moval_beg = 7;
        moval_lst = 12;
      }
      var linkt = "http://";
      var date_from = new Date(yval, moval_beg - 1, 1).toISOString().split('T')[0];
      var date_to = new Date(yval, moval_lst, 0).toISOString().split('T')[0];
      var jasper_ip = this.jasper_ip;
      var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FDaily_Accomplishment&reportUnit=%2Freports%2FIPCR%2FDaily_Accomplishment%2FIPCR_Daily&standAlone=true&decorate=no&output=pdf';
      var params = '&username=' + username + '&date_from=' + date_from + '&date_to=' + date_to;
      var linkl = linkt + jasper_ip + jasper_link + params;
      return linkl;
    },
    toggle: function toggle(id, i) {
      var _this3 = this;
      // alert(this.data.length);
      // for (var x = 0; x < this.data.length; x++) {
      //     this.$('#collapse-b' + x).removeClass('show');
      // }
      var index = this.opened.indexOf(id);
      if (index > -1) {
        // this.opened.splice(index, 1)
      } else {
        this.opened = [];
        this.opened.push(id);
      }
      // alert(this.show);
      setTimeout(function () {
        // alert(this.show);
        for (var t = 0; t < _this3.ipcr_accomplishments_review.data.length; t++) {
          if (i != t) {
            _this3.show[t] = false;
          }
        }
        _this3.show[i] = !_this3.show[i];
      }, 100);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    title: String
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    prev: String,
    next: String
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    //userId: Object,
  },
  data: function data() {
    return {
      //my_id: this.props.userId,
      value: null,
      options: ['Batman', 'Robin', 'Joker']
    };
  },
  mounted: function mounted() {},
  methods: {
    logU_ID: function logU_ID() {},
    closeModal: function closeModal() {
      this.$emit('close-modal-event');
    },
    saveChanges: function saveChanges() {
      this.closeModal();
    },
    loadPermissions: function loadPermissions() {}
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("title", null, "Home", -1 /* HOISTED */);
var _hoisted_2 = {
  "class": "row gap-20 masonry pos-r"
};
var _hoisted_3 = {
  "class": "peers fxw-nw jc-sb ai-c"
};
var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, "Review/Approve Semestral Accomplishment", -1 /* HOISTED */);
var _hoisted_5 = {
  "class": "peers"
};
var _hoisted_6 = {
  "class": "peer mR-10"
};
var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "masonry-sizer col-md-6"
}, null, -1 /* HOISTED */);
var _hoisted_8 = {
  "class": "masonry-item w-100"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "row gap-20"
}, null, -1 /* HOISTED */);
var _hoisted_10 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_11 = {
  "class": "table-responsive"
};
var _hoisted_12 = {
  "class": "table table-sm table-borderless table-striped table-hover"
};
var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", {
  "class": "bg-secondary text-white"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Period"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Actions")])], -1 /* HOISTED */);
var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("{{ accomp }} - {{ accomp }}")], -1 /* HOISTED */);
var _hoisted_15 = {
  "class": "dropdown dropstart"
};
var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  "class": "btn btn-secondary btn-sm action-btn",
  type: "button",
  id: "dropdownMenuButton1",
  "data-bs-toggle": "dropdown",
  "aria-expanded": "false"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-three-dots",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
})])], -1 /* HOISTED */);
var _hoisted_17 = {
  "class": "dropdown-menu action-dropdown",
  "aria-labelledby": "dropdownMenuButton1"
};
var _hoisted_18 = {
  key: 0
};
var _hoisted_19 = ["onClick"];
var _hoisted_20 = {
  key: 1
};
var _hoisted_21 = ["onClick"];
var _hoisted_22 = ["onClick"];
var _hoisted_23 = {
  "class": "justify-content-center"
};
var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  style: {
    "text-align": "center"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", null, "IPCR Accomplishment Modal")], -1 /* HOISTED */);
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Employee Name: ", -1 /* HOISTED */);
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Semester/Period: ", -1 /* HOISTED */);
var _hoisted_28 = {
  key: 0
};
var _hoisted_29 = {
  key: 1
};
var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Status: ", -1 /* HOISTED */);
var _hoisted_31 = {
  key: 0
};
var _hoisted_32 = {
  key: 1
};
var _hoisted_33 = {
  "class": "masonry-item w-100"
};
var _hoisted_34 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_35 = {
  "class": "table-responsive"
};
var _hoisted_36 = ["src"];
var _hoisted_37 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Remarks:", -1 /* HOISTED */);
var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_39 = {
  style: {
    "align": "center"
  }
};
var _hoisted_40 = {
  key: 0
};
var _hoisted_41 = {
  key: 1
};
var _hoisted_42 = {
  "class": "justify-content-center"
};
var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  style: {
    "text-align": "center"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", null, "IPCR Targets Modal2")], -1 /* HOISTED */);
var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_45 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Employee Name: ", -1 /* HOISTED */);
var _hoisted_46 = {
  "class": "masonry-item w-100"
};
var _hoisted_47 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_48 = {
  "class": "table-responsive"
};
var _hoisted_49 = {
  key: 0
};
var _hoisted_50 = {
  "class": "table table-hover table-bordered border-dark"
};
var _hoisted_51 = {
  "class": "text-dark",
  style: {
    "background-color": "#B7DEE8"
  }
};
var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "IPCR Code", -1 /* HOISTED */);
var _hoisted_53 = {
  "class": "bg-secondary text-white"
};
var _hoisted_54 = ["colspan"];
var _hoisted_55 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Core Function", -1 /* HOISTED */);
var _hoisted_56 = [_hoisted_55];
var _hoisted_57 = {
  key: 0,
  style: {
    "text-align": "center",
    "background-color": "#edd29d"
  }
};
var _hoisted_58 = {
  key: 1
};
var _hoisted_59 = {
  "class": "bg-secondary text-white"
};
var _hoisted_60 = ["colspan"];
var _hoisted_61 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Support Function", -1 /* HOISTED */);
var _hoisted_62 = [_hoisted_61];
var _hoisted_63 = {
  key: 0,
  style: {
    "text-align": "center",
    "background-color": "#edd29d"
  }
};
var _hoisted_64 = {
  key: 1
};
var _hoisted_65 = {
  style: {
    "align": "center"
  }
};
var _hoisted_66 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, "Remarks Modal3", -1 /* HOISTED */);
var _hoisted_67 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", null, "State the reason for not reviewing/approving IPCR", -1 /* HOISTED */);
var _hoisted_68 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_69 = {
  "class": "d-flex justify-content-center"
};
var _hoisted_70 = ["src"];
var _hoisted_71 = {
  "class": "justify-content-center"
};
var _hoisted_72 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  style: {
    "text-align": "center"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", null, "IPCR Accomplishment")], -1 /* HOISTED */);
var _hoisted_73 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_74 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Employee Name: ", -1 /* HOISTED */);
var _hoisted_75 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Position: ", -1 /* HOISTED */);
var _hoisted_76 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Semester/Period: ", -1 /* HOISTED */);
var _hoisted_77 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Status: ", -1 /* HOISTED */);
var _hoisted_78 = {
  "class": "masonry-item w-100"
};
var _hoisted_79 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "row gap-20"
}, null, -1 /* HOISTED */);
var _hoisted_80 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_81 = {
  "class": "table-responsive"
};
var _hoisted_82 = {
  "class": "table table-sm table-bordered border-dark table-hover"
};
var _hoisted_83 = {
  style: {
    "background-color": "#B7DEE8"
  },
  "class": "text-center table-bordered"
};
var _hoisted_84 = {
  style: {
    "width": "15%"
  },
  rowspan: "2",
  colspan: "1"
};
var _hoisted_85 = {
  key: 0
};
var _hoisted_86 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Division Output", -1 /* HOISTED */);
var _hoisted_87 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Section Output", -1 /* HOISTED */);
var _hoisted_88 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Section Output", -1 /* HOISTED */);
var _hoisted_89 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "30%"
  },
  rowspan: "2",
  colspan: "1"
}, "Success Indicator", -1 /* HOISTED */);
var _hoisted_90 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "20%"
  },
  colspan: "4"
}, "Rating", -1 /* HOISTED */);
var _hoisted_91 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "20%"
  },
  rowspan: "2",
  colspan: "1"
}, "Remarks", -1 /* HOISTED */);
var _hoisted_92 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  rowspan: "2",
  colspan: "1"
}, null, -1 /* HOISTED */);
var _hoisted_93 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", {
  style: {
    "background-color": "#B7DEE8"
  },
  "class": "text-center"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "5%"
  }
}, "Quality Rating"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "5%"
  }
}, "Efficiency Rating"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "5%"
  }
}, "Timeliness Rating"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  style: {
    "width": "5%"
  }
}, "Average")], -1 /* HOISTED */);
var _hoisted_94 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, null, -1 /* HOISTED */);
var _hoisted_95 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td colspan=\"9\">\n                                                <b>CORE FUNCTION</b> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "8"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "CORE FUNCTION")])], -1 /* HOISTED */);
var _hoisted_96 = ["onClick"];
var _hoisted_97 = ["innerHTML"];
var _hoisted_98 = ["onClick"];
var _hoisted_99 = ["onClick"];
var _hoisted_100 = {
  key: 1
};
var _hoisted_101 = {
  colspan: "8",
  "class": "background-white"
};
var _hoisted_102 = {
  key: 0
};
var _hoisted_103 = {
  "class": "table-responsive full-width table-bordered border-dark text-center"
};
var _hoisted_104 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  "class": "text-white text-center",
  style: {
    "background-color": "#727272"
  },
  colspan: "31"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", null, "  Accomplishment")])])], -1 /* HOISTED */);
var _hoisted_105 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  colspan: "3",
  style: {
    "text-align": "center"
  }
}, "Quality/Effectiveness"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  colspan: "3",
  style: {
    "text-align": "center"
  }
}, "Efficiency"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  rowspan: "1",
  style: {
    "text-align": "center"
  }
}, "Timeliness")], -1 /* HOISTED */);
var _hoisted_106 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_107 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_108 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_109 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_110 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_111 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_112 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_113 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_114 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_115 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_116 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_117 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_118 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_119 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_120 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_121 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_122 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_123 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_124 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_125 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_126 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_127 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_128 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_129 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_130 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_131 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_132 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_133 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_134 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_135 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Standard Response Time"))], -1 /* HOISTED */);
var _hoisted_136 = {
  key: 0
};
var _hoisted_137 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_138 = [_hoisted_137];
var _hoisted_139 = {
  key: 1
};
var _hoisted_140 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_141 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_142 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_143 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_144 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_145 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_146 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_147 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_148 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Quantity Based"))], -1 /* HOISTED */);
var _hoisted_149 = {
  key: 0
};
var _hoisted_150 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_151 = [_hoisted_150];
var _hoisted_152 = {
  key: 1
};
var _hoisted_153 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_154 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_155 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_156 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_157 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_158 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_159 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_160 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_161 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Optimum use of resources"))], -1 /* HOISTED */);
var _hoisted_162 = {
  key: 0
};
var _hoisted_163 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_164 = [_hoisted_163];
var _hoisted_165 = {
  key: 1
};
var _hoisted_166 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_167 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_168 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_169 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_170 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_171 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_172 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_173 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_174 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Timeliness"))], -1 /* HOISTED */);
var _hoisted_175 = {
  key: 0
};
var _hoisted_176 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_177 = [_hoisted_176];
var _hoisted_178 = {
  key: 1
};
var _hoisted_179 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_180 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_181 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_182 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_183 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_184 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_185 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Average Point Score - Core Function")], -1 /* HOISTED */);
var _hoisted_186 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Multiply by Weighted Allocation")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, " 70% ")], -1 /* HOISTED */);
var _hoisted_187 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Weighted Average Score - Core Function")], -1 /* HOISTED */);
var _hoisted_188 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "8"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Support FUNCTION ")])], -1 /* HOISTED */);
var _hoisted_189 = ["onClick"];
var _hoisted_190 = ["innerHTML"];
var _hoisted_191 = ["onClick"];
var _hoisted_192 = ["onClick"];
var _hoisted_193 = {
  key: 1
};
var _hoisted_194 = {
  colspan: "8",
  "class": "background-white"
};
var _hoisted_195 = {
  key: 0
};
var _hoisted_196 = {
  "class": "table-responsive full-width table-bordered border-dark text-center"
};
var _hoisted_197 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  "class": "text-white text-center",
  style: {
    "background-color": "#727272"
  },
  colspan: "31"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", null, "  Accomplishment")])])], -1 /* HOISTED */);
var _hoisted_198 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  colspan: "3",
  style: {
    "text-align": "center"
  }
}, "Quality/Effectiveness"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  colspan: "3",
  style: {
    "text-align": "center"
  }
}, "Efficiency"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  rowspan: "1",
  style: {
    "text-align": "center"
  }
}, "Timeliness")], -1 /* HOISTED */);
var _hoisted_199 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_200 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_201 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_202 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_203 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_204 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_205 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_206 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_207 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_208 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_209 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_210 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_211 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_212 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_213 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_214 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_215 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_216 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_217 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_218 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_219 = {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_220 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_221 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_222 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_223 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_224 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_225 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_226 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_227 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_228 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Standard Response Time"))], -1 /* HOISTED */);
var _hoisted_229 = {
  key: 0
};
var _hoisted_230 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_231 = [_hoisted_230];
var _hoisted_232 = {
  key: 1
};
var _hoisted_233 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_234 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_235 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_236 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_237 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_238 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_239 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_240 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_241 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Quantity Based"))], -1 /* HOISTED */);
var _hoisted_242 = {
  key: 0
};
var _hoisted_243 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_244 = [_hoisted_243];
var _hoisted_245 = {
  key: 1
};
var _hoisted_246 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_247 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_248 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_249 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_250 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_251 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_252 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_253 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_254 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Optimum use of resources"))], -1 /* HOISTED */);
var _hoisted_255 = {
  key: 0
};
var _hoisted_256 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_257 = [_hoisted_256];
var _hoisted_258 = {
  key: 1
};
var _hoisted_259 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_260 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_261 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_262 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_263 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_264 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_265 = {
  style: {
    "padding": "0"
  }
};
var _hoisted_266 = {
  style: {
    "width": "100%",
    "border-collapse": "collapse",
    "text-align": "center"
  }
};
var _hoisted_267 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000"
  }
}, /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Timeliness"))], -1 /* HOISTED */);
var _hoisted_268 = {
  key: 0
};
var _hoisted_269 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "6",
  style: {
    "border": "1px solid #000",
    "text-align": "center"
  }
}, "Not to be Rated", -1 /* HOISTED */);
var _hoisted_270 = [_hoisted_269];
var _hoisted_271 = {
  key: 1
};
var _hoisted_272 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_273 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_274 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_275 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_276 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_277 = {
  style: {
    "border": "1px solid #000"
  }
};
var _hoisted_278 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Average Point Score - Support Function")], -1 /* HOISTED */);
var _hoisted_279 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Multiply by Weighted Allocation")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, " 30% ")], -1 /* HOISTED */);
var _hoisted_280 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Weighted Average Score - Support Function")], -1 /* HOISTED */);
var _hoisted_281 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Total Average Score")], -1 /* HOISTED */);
var _hoisted_282 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Additional Point Intervening Factor - if applicable - Maximum: 0.5 pts")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td")], -1 /* HOISTED */);
var _hoisted_283 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Total Final Average Rating")], -1 /* HOISTED */);
var _hoisted_284 = {
  style: {
    "background-color": "yellow"
  }
};
var _hoisted_285 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "7"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
  style: {
    "float": "right"
  }
}, "Final Adjectival Rating")], -1 /* HOISTED */);
var _hoisted_286 = {
  style: {
    "background-color": "yellow"
  }
};
var _hoisted_287 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "8"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Supervisor's comments and recommendations for development purposes or Rewards/Promotion")])], -1 /* HOISTED */);
var _hoisted_288 = {
  colspan: "8"
};
var _hoisted_289 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_290 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Remarks:", -1 /* HOISTED */);
var _hoisted_291 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_292 = {
  style: {
    "align": "center"
  }
};
var _hoisted_293 = {
  key: 0
};
var _hoisted_294 = {
  key: 1
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");
  var _component_pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("pagination");
  var _component_LoadingOverlay = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LoadingOverlay");
  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");
  var _component_Modal2 = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal2");
  var _component_Modal3 = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal3");
  var _component_ModalDaily = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalDaily");
  var _component_Modal4 = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal4");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_1];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<p style=\"text-align: justify;\">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.\n    </p>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("SEMESTRAL***************************************************************************************"), _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.search = $event;
    }),
    type: "text",
    "class": "form-control form-control-sm",
    placeholder: "Search..."
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])])])]), _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_12, [_hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.accomplishments.data, function (accomp) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [_hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(accomp.employee_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.getPeriod(accomp.sem, accomp.year)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ getStatus(accomp.employment_type_descr) }}  "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td>{{ accomp.employment_type_descr }}\n                                    -- sem: {{ accomp.sem }}</td> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.getStatus(accomp.a_status.toString())), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [_hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_17, [accomp.sem === '1' || accomp.sem === '2' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.showModals(accomp.id, accomp.empl_id, accomp.a_status, accomp.imm_id, accomp.next_higher_id);
      }
    }, " View Submission ", 8 /* PROPS */, _hoisted_19)])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.showModal2(accomp.empl_id, accomp.employee_name, accomp.year, accomp.sem, accomp.status);
      }
    }, " View Submission 2 ", 8 /* PROPS */, _hoisted_21)])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.viewDailyAccomplishments(accomp.empl_id, accomp.sem, accomp.year);
      }
    }, " View Daily Accomplishments ", 8 /* PROPS */, _hoisted_22)])])])])]);
  }), 256 /* UNKEYED_FRAGMENT */))])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <pagination :next=\"data.next_page_url\" :prev=\"data.prev_page_url\" /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
    next: $props.accomplishments.next_page_url,
    prev: $props.accomplishments.prev_page_url
  }, null, 8 /* PROPS */, ["next", "prev"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LoadingOverlay, {
    active: $data.isLoading,
    "is-full-page": true,
    "can-cancel": false,
    loader: "bars"
  }, null, 8 /* PROPS */, ["active"]), $data.displayModal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal, {
    key: 0,
    onCloseModalEvent: $options.hideModal
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, [_hoisted_24, _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.emp_name), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, [$data.emp_sem === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_28, "First Semester -January to June, ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.emp_sem === '2' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_29, "Second Semester -July to December, ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.emp_year) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ emp_status }} ")])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, [$data.emp_status.toString() === '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_31, "Submitted")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.emp_status.toString() === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_32, "Reviewed")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ report_link }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("iframe", {
        src: $data.report_link,
        style: {
          "width": "100%",
          "height": "450px"
        }
      }, null, 8 /* PROPS */, _hoisted_36)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "text",
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          return $data.form.remarks = $event;
        }),
        "class": "form-control",
        autocomplete: "chrome-off"
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), _hoisted_38]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" imm_id_loc\n                    nxt_id_loc "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ imm_id_loc }} - {{ nxt_id_loc }} "), $data.imm_id_loc === $data.nxt_id_loc ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[2] || (_cache[2] = function ($event) {
          return $options.submitAction('2');
        })
      }, " Approve "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ")])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_41, [$data.emp_status.toString() === '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 0,
        "class": "btn btn-primary text-white",
        onClick: _cache[3] || (_cache[3] = function ($event) {
          return $options.submitAction('1');
        })
      }, " Review ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.emp_status.toString() === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 1,
        "class": "btn btn-primary text-white",
        onClick: _cache[4] || (_cache[4] = function ($event) {
          return $options.submitAction('2');
        })
      }, " Approve ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  "), $data.emp_status.toString() === '2' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 2,
        "class": "btn btn-primary text-white",
        onClick: _cache[5] || (_cache[5] = function ($event) {
          return $options.submitAction('3');
        })
      }, " Final Approve ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ")])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        style: {
          "float": "right"
        },
        "class": "btn btn-danger text-white",
        onClick: _cache[6] || (_cache[6] = function ($event) {
          return $options.submitAction('-2');
        })
      }, " Return ")])])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayModal2 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal2, {
    key: 1,
    onCloseModalEvent: $options.hideModal2
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [_hoisted_43, _hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_45, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.emp_name), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" lendsgth: {{ length }}\n                ipcr_targets: {{ ipcr_targets[0].quantity }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" quantityArray : {{ quantityArray() }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [$data.ipcr_targets && $data.ipcr_targets.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_50, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" v-if=\"ipcr_targets[0].quantity\" "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", _hoisted_51, [_hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Individual Final Output " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.ipcr_targets[0].quantity), 1 /* TEXT */), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($options.parseQuantity($data.ipcr_targets[0].quantity), function (item, index) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("th", {
          key: index
        }, " Month " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1 /* TEXT */);
      }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
        colspan: 9 + parseFloat($options.parseQuantity($data.ipcr_targets[0].quantity).length)
      }, [].concat(_hoisted_56), 8 /* PROPS */, _hoisted_54)]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.ipcr_targets, function (target) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [target.ipcr_type == 'Core Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(target.ipcr_code), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), target.ipcr_type == 'Core Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_58, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(target.individual_output), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), target.ipcr_type == 'Core Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
          key: 2
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($options.parseQuantity(target.quantity), function (quant, index) {
          return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", {
            key: index
          }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(quant), 1 /* TEXT */);
        }), 128 /* KEYED_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]);
      }), 256 /* UNKEYED_FRAGMENT */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", _hoisted_59, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
        colspan: 9 + parseFloat($options.parseQuantity($data.ipcr_targets[0].quantity).length)
      }, [].concat(_hoisted_62), 8 /* PROPS */, _hoisted_60)]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.ipcr_targets, function (target) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [target.ipcr_type == 'Support Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_63, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(target.ipcr_code), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), target.ipcr_type == 'Support Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_64, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(target.individual_output), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), target.ipcr_type == 'Support Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
          key: 2
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($options.parseQuantity(target.quantity), function (quant, index) {
          return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", {
            key: index
          }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(quant), 1 /* TEXT */);
        }), 128 /* KEYED_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]);
      }), 256 /* UNKEYED_FRAGMENT */))])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_65, [$data.emp_status === '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 0,
        "class": "btn btn-primary text-white",
        onClick: _cache[7] || (_cache[7] = function ($event) {
          return $options.submitActionProb('1');
        })
      }, " Review ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.emp_status === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 1,
        "class": "btn btn-primary text-white",
        onClick: _cache[8] || (_cache[8] = function ($event) {
          return $options.submitActionProb('2');
        })
      }, " Approve ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-danger text-white",
        onClick: _cache[9] || (_cache[9] = function ($event) {
          return $options.showModal3();
        })
      }, " Return ")])])])])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayModal3 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal3, {
    key: 2,
    onCloseModalEvent: $options.hideModal3
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_66, _hoisted_67, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "text",
        "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
          return $data.form.remarks = $event;
        }),
        "class": "form-control",
        autocomplete: "chrome-off"
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), _hoisted_68, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[11] || (_cache[11] = function ($event) {
          return $options.submitReturnReason();
        })
      }, " Done "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-danger text-white",
        onClick: _cache[12] || (_cache[12] = function ($event) {
          return $options.cancelReason();
        })
      }, " Cancel ")];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayModalDaily ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_ModalDaily, {
    key: 3,
    onCloseModalEvent: $options.hideModalDaily
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_69, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("iframe", {
        src: $data.my_link,
        style: {
          "width": "100%",
          "height": "450px"
        }
      }, null, 8 /* PROPS */, _hoisted_70)])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayModal4 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal4, {
    key: 4,
    onCloseModalEvent: $options.hideModal4
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_71, [_hoisted_72, _hoisted_73, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ ipcr_accomplishments_review.sem }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_74, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.ipcr_accomplishments_review.sem.employee_name), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_75, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.ipcr_accomplishments_review.sem.position), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_76, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.sem($data.ipcr_accomplishments_review.sem.sem)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_77, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.Status($data.ipcr_accomplishments_review.sem_data.status_accomplishment)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_78, [_hoisted_79, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_80, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_81, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ ipcr_accomplishments_review.data }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_82, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", _hoisted_83, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th style=\"width: 5%;\" rowspan=\"2\" colspan=\"1\">IPCR Code</th> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_84, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ ipcr_accomplishments_review[0].Accomplishment_type == \"ipcr\"? \"Individual Output\": ipcr_accomplishments_review[0].Accomplishment_type == \"dpcr\"? \"Division Output\" : \"\" }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.ipcr_accomplishments_review.form_type) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\n                                                div\n                                                emp\n                                                hemp\n                                                hdiv\n                                                hos\n                                                hsec\n                                              "), $data.ipcr_accomplishments_review.form_type == 'emp' || $data.ipcr_accomplishments_review.form_type == 'emp' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_85, "Individual Output")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_86, _hoisted_87, _hoisted_88]), _hoisted_89, _hoisted_90, _hoisted_91, _hoisted_92]), _hoisted_93, _hoisted_94]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("CORE FUNCTION"), _hoisted_95, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.ipcr_accomplishments_review.data, function (dat, index) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
          key: index
        }, [dat.ipcr_type === 'Core Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
          key: 0,
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
            opened: $data.opened.includes(dat.individual_output)
          }, "text-center"])
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
          onClick: function onClick($event) {
            return $options.toggle(dat.individual_output, index);
          },
          style: {
            "cursor": "pointer",
            "background-color": "lightblue"
          }
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.individual_output), 9 /* TEXT, PROPS */, _hoisted_96), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.efficiency1 == "Yes" ? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.AverageComputationSem(_ctx.QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), _ctx.EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
          innerHTML: dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks
        }, null, 8 /* PROPS */, _hoisted_97), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [dat.remarks == '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
          key: 0,
          "class": "btn btn-primary btn-sm mL-2 text-white",
          onClick: function onClick($event) {
            return $options.showModal2(dat.individual_output_id, dat.sem_id, dat.result[0].year);
          }
        }, "Add Remarks", 8 /* PROPS */, _hoisted_98)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
          key: 1,
          "class": "btn btn-primary btn-sm mL-2 text-white",
          onClick: function onClick($event) {
            return $options.showModal3(dat.individual_output_id, dat.sem_id, dat.remarks, dat.remarks_id);
          }
        }, "Edit/Delete Remarks", 8 /* PROPS */, _hoisted_99))])], 2 /* CLASS */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.opened.includes(dat.individual_output) && dat.ipcr_type === 'Core Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_100, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_101, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(vue__WEBPACK_IMPORTED_MODULE_0__.Transition, {
          name: "bounce"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [$data.show[index] ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", _hoisted_102, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_103, [_hoisted_104, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [_hoisted_105, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_106, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_107, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_108, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality1), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_109, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q1 == null ? 0 : dat.result[0].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_110, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q1 == null ? 0 : dat.result[1].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_111, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q1 == null ? 0 : dat.result[2].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_112, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q1 == null ? 0 : dat.result[3].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_113, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q1 == null ? 0 : dat.result[4].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_114, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q1 == null ? 0 : dat.result[5].q1), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_115, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_116, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_117, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality2), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_118, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q2 == null ? 0 : dat.result[0].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_119, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q2 == null ? 0 : dat.result[1].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_120, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q2 == null ? 0 : dat.result[2].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_121, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q2 == null ? 0 : dat.result[3].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_122, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q2 == null ? 0 : dat.result[4].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_123, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q2 == null ? 0 : dat.result[5].q2), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_124, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_125, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_126, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality3), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_127, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q3 == null ? 0 : dat.result[0].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_128, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q3 == null ? 0 : dat.result[1].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_129, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q3 == null ? 0 : dat.result[2].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_130, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q3 == null ? 0 : dat.result[3].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_131, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q3 == null ? 0 : dat.result[4].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_132, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q3 == null ? 0 : dat.result[5].q3), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_133, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_134, [_hoisted_135, dat.efficiency1 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_136, [].concat(_hoisted_138))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_139, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_140, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e1 == null ? 0 : dat.result[1].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_141, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e1 == null ? 0 : dat.result[0].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_142, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e1 == null ? 0 : dat.result[2].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_143, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e1 == null ? 0 : dat.result[3].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_144, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e1 == null ? 0 : dat.result[4].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_145, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e1 == null ? 0 : dat.result[5].e1), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_146, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_147, [_hoisted_148, dat.efficiency2 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_149, [].concat(_hoisted_151))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_152, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_153, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e2 == null ? 0 : dat.result[1].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_154, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e2 == null ? 0 : dat.result[0].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_155, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e2 == null ? 0 : dat.result[2].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_156, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e2 == null ? 0 : dat.result[3].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_157, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e2 == null ? 0 : dat.result[4].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_158, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e2 == null ? 0 : dat.result[5].e2), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_159, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_160, [_hoisted_161, dat.efficiency3 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_162, [].concat(_hoisted_164))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_165, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_166, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e3 == null ? 0 : dat.result[1].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_167, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e3 == null ? 0 : dat.result[0].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_168, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e3 == null ? 0 : dat.result[2].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_169, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e3 == null ? 0 : dat.result[3].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_170, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e3 == null ? 0 : dat.result[4].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_171, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e3 == null ? 0 : dat.result[5].e3), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_172, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_173, [_hoisted_174, dat.timeliness === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_175, [].concat(_hoisted_177))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_178, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_179, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].time == null ? 0 : dat.result[1].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_180, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].time == null ? 0 : dat.result[0].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_181, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].time == null ? 0 : dat.result[2].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_182, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].time == null ? 0 : dat.result[3].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_183, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].time == null ? 0 : dat.result[4].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_184, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].time == null ? 0 : dat.result[5].time), 1 /* TEXT */)]))])])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
          }),
          _: 2 /* DYNAMIC */
        }, 1024 /* DYNAMIC_SLOTS */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 64 /* STABLE_FRAGMENT */);
      }), 128 /* KEYED_FRAGMENT */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_185, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.Average_Point_Core), 1 /* TEXT */)]), _hoisted_186, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_187, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(($data.Average_Point_Core * .70).toFixed(2)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" //SUPPORT "), _hoisted_188, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.ipcr_accomplishments_review.data, function (dat, index) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
          key: index
        }, [dat.ipcr_type === 'Support Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
          key: 0,
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
            opened: $data.opened.includes(dat.individual_output)
          }, "text-center"])
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
          onClick: function onClick($event) {
            return $options.toggle(dat.individual_output, index);
          },
          style: {
            "cursor": "pointer",
            "background-color": "lightblue"
          }
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.individual_output), 9 /* TEXT, PROPS */, _hoisted_189), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.efficiency1 == "Yes" ? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.AverageComputationSem(_ctx.QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), _ctx.EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1)), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
          innerHTML: dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks
        }, null, 8 /* PROPS */, _hoisted_190), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [dat.remarks == '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
          key: 0,
          "class": "btn btn-primary btn-sm mL-2 text-white",
          onClick: function onClick($event) {
            return $options.showModal2(dat.ipcr_code, dat.sem_id, dat.result[0].year);
          }
        }, "Add Remarks", 8 /* PROPS */, _hoisted_191)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
          key: 1,
          "class": "btn btn-primary btn-sm mL-2 text-white",
          onClick: function onClick($event) {
            return $options.showModal3(dat.ipcr_code, dat.sem_id, dat.remarks, dat.remarks_id);
          }
        }, "Edit/Delete Remarks", 8 /* PROPS */, _hoisted_192))])], 2 /* CLASS */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.opened.includes(dat.individual_output) && dat.ipcr_type === 'Support Function' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_193, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_194, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(vue__WEBPACK_IMPORTED_MODULE_0__.Transition, {
          name: "bounce"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [$data.show[index] ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", _hoisted_195, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_196, [_hoisted_197, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [_hoisted_198, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_199, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_200, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_201, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality1), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_202, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q1 == null ? 0 : dat.result[0].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_203, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q1 == null ? 0 : dat.result[1].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_204, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q1 == null ? 0 : dat.result[2].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_205, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q1 == null ? 0 : dat.result[3].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_206, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q1 == null ? 0 : dat.result[4].q1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_207, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q1 == null ? 0 : dat.result[5].q1), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_208, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_209, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_210, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality2), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_211, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q2 == null ? 0 : dat.result[0].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_212, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q2 == null ? 0 : dat.result[1].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_213, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q2 == null ? 0 : dat.result[2].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_214, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q2 == null ? 0 : dat.result[3].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_215, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q2 == null ? 0 : dat.result[4].q2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_216, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q2 == null ? 0 : dat.result[5].q2), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_217, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_218, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_219, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.quality3), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_220, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].q3 == null ? 0 : dat.result[0].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_221, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].q3 == null ? 0 : dat.result[1].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_222, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].q3 == null ? 0 : dat.result[2].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_223, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].q3 == null ? 0 : dat.result[3].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_224, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].q3 == null ? 0 : dat.result[4].q3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_225, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].q3 == null ? 0 : dat.result[5].q3), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_226, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_227, [_hoisted_228, dat.efficiency1 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_229, [].concat(_hoisted_231))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_232, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_233, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e1 == null ? 0 : dat.result[1].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_234, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e1 == null ? 0 : dat.result[0].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_235, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e1 == null ? 0 : dat.result[2].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_236, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e1 == null ? 0 : dat.result[3].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_237, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e1 == null ? 0 : dat.result[4].e1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_238, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e1 == null ? 0 : dat.result[5].e1), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_239, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_240, [_hoisted_241, dat.efficiency2 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_242, [].concat(_hoisted_244))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_245, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_246, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e2 == null ? 0 : dat.result[1].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_247, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e2 == null ? 0 : dat.result[0].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_248, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e2 == null ? 0 : dat.result[2].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_249, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e2 == null ? 0 : dat.result[3].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_250, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e2 == null ? 0 : dat.result[4].e2), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_251, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e2 == null ? 0 : dat.result[5].e2), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_252, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_253, [_hoisted_254, dat.efficiency3 === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_255, [].concat(_hoisted_257))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_258, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_259, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].e3 == null ? 0 : dat.result[1].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_260, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].e3 == null ? 0 : dat.result[0].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_261, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].e3 == null ? 0 : dat.result[2].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_262, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].e3 == null ? 0 : dat.result[3].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_263, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].e3 == null ? 0 : dat.result[4].e3), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_264, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].e3 == null ? 0 : dat.result[5].e3), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_265, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_266, [_hoisted_267, dat.timeliness === 'No' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_268, [].concat(_hoisted_270))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_271, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_272, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[1].time == null ? 0 : dat.result[1].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_273, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[0].time == null ? 0 : dat.result[0].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_274, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[2].time == null ? 0 : dat.result[2].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_275, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[3].time == null ? 0 : dat.result[3].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_276, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[4].time == null ? 0 : dat.result[4].time), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_277, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(dat.result[5].time == null ? 0 : dat.result[5].time), 1 /* TEXT */)]))])])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
          }),
          _: 2 /* DYNAMIC */
        }, 1024 /* DYNAMIC_SLOTS */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 64 /* STABLE_FRAGMENT */);
      }), 128 /* KEYED_FRAGMENT */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_278, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.Average_Point_Support), 1 /* TEXT */)]), _hoisted_279, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_280, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(($data.Average_Point_Support * .30).toFixed(2)), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_281, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.getAdjectivalScoreSemestral($data.Average_Point_Core * 0.70, $data.Average_Point_Support * 0.30)), 1 /* TEXT */)]), _hoisted_282, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_283, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_284, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.getAdjectivalScoreSemestral($data.Average_Point_Core * 0.70, $data.Average_Point_Support * 0.30)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_285, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_286, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.getAdjectivalRatingSem(_ctx.getAdjectivalScoreSemestral($data.Average_Point_Core * 0.70, $data.Average_Point_Support * 0.30))), 1 /* TEXT */)])]), _hoisted_287, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_288, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.sem_data.remarks), 1 /* TEXT */), _hoisted_289, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.sem_data.remarkshigher), 1 /* TEXT */)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_290, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "text",
        "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
          return $data.form.remarks = $event;
        }),
        "class": "form-control",
        autocomplete: "chrome-off"
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.remarks]]), _hoisted_291]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_292, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" imm_id_loc\n                            nxt_id_loc "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ imm_id_loc }} - {{ nxt_id_loc }} "), $data.imm_id_loc === $data.nxt_id_loc ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_293, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[14] || (_cache[14] = function ($event) {
          return $options.submitAction('2');
        })
      }, " Approve "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ")])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_294, [$data.emp_status.toString() === '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 0,
        "class": "btn btn-primary text-white",
        onClick: _cache[15] || (_cache[15] = function ($event) {
          return $options.submitAction('1');
        })
      }, " Review ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.emp_status.toString() === '1' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 1,
        "class": "btn btn-primary text-white",
        onClick: _cache[16] || (_cache[16] = function ($event) {
          return $options.submitAction('2');
        })
      }, " Approve ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  "), $data.emp_status.toString() === '2' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
        key: 2,
        "class": "btn btn-primary text-white",
        onClick: _cache[17] || (_cache[17] = function ($event) {
          return $options.submitAction('3');
        })
      }, " Final Approve ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  ")])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        style: {
          "float": "right"
        },
        "class": "btn btn-danger text-white",
        onClick: _cache[18] || (_cache[18] = function ($event) {
          return $options.submitAction('-2');
        })
      }, " Return ")])])])])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])], 64 /* STABLE_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58 ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  id: "sidebar-wrapper",
  "class": "sidebar-nav nav navbar-inverse"
};
var _hoisted_2 = {
  "class": "row",
  style: {
    "width": "380px"
  }
};
var _hoisted_3 = {
  "class": "bgc-white"
};
var _hoisted_4 = {
  "class": "modal-header"
};
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "modal-title",
  id: "exampleModalLiveLabel"
}, "Filtering", -1 /* HOISTED */);
var _hoisted_6 = {
  "class": "modal-body"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn-close",
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('closeFilter');
    })
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default")])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "pagination"
};
var _hoisted_2 = {
  "class": "page-item"
};
var _hoisted_3 = {
  "class": "page-item"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n            I intend to recreate a simple pagination [simplePaginate()] for performance purpose\r\n            read https://laravel.com/docs/8.x/pagination#simple-pagination\r\n\r\n            If you think you will not have huge dataset in the future you can use\r\n            the paginate() by uncommenting below and in the actual component.\r\n        "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Component\r\n            :is=\"link.url ? 'Link' : 'span'\"\r\n            v-for=\"link in links\"\r\n            :href=\"link.url\"\r\n            v-html=\"link.label\"\r\n            class=\"p-3 text-decoration-none\"\r\n            :class=\"{'text-muted' : !link.url, 'fw-bold' : link.active}\"\r\n        /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_2, [$props.prev ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": "page-link",
    href: $props.prev,
    "preserve-scroll": ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Previous")];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["href"])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
    key: 1,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["page-link", {
      'text-muted': !$props.prev
    }])
  }, "Previous", 2 /* CLASS */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_3, [$props.next ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": "page-link",
    href: $props.next,
    "preserve-scroll": ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Next")];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["href"])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
    key: 1,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["page-link", {
      'text-muted': !$props.next
    }])
  }, "Next", 2 /* CLASS */))])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-e8c5b748"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};
var _hoisted_1 = {
  "class": "permissions-modal"
};
var _hoisted_2 = {
  "class": "modal",
  tabindex: "-1",
  role: "dialog"
};
var _hoisted_3 = {
  "class": "modal-dialog modal-xl"
};
var _hoisted_4 = {
  "class": "d-flex justify-content-center"
};
var _hoisted_5 = {
  "class": "modal-content",
  style: {
    "width": "100% !important",
    "height": "40% !important"
  }
};
var _hoisted_6 = {
  "class": "modal-header",
  style: {
    "background-color": "#030014"
  }
};
var _hoisted_7 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
    "class": "modal-title",
    style: {
      "color": "#ffe819",
      "text-align": "center !important"
    }
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "PRINT PREVIEW")], -1 /* HOISTED */);
});
var _hoisted_8 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "aria-hidden": "true"
  }, "×", -1 /* HOISTED */);
});
var _hoisted_9 = [_hoisted_8];
var _hoisted_10 = {
  "class": "modal-body"
};
var _hoisted_11 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "modal-footer",
    style: {
      "background-color": "#090137"
    }
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<button type=\"button\" class=\"btn btn-primary\" @click=\"saveChanges\">Save changes</button>\r\n                        <button type=\"button\" class=\"btn btn-secondary\" @click=\"closeModal\">Close</button>")], -1 /* HOISTED */);
});
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [_hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-danger",
    style: {
      "font-weight": "bold",
      "color": "white"
    },
    "data-dismiss": "modal",
    "aria-label": "Close",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.closeModal && $options.closeModal.apply($options, arguments);
    })
  }, [].concat(_hoisted_9))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<p>Modal body text goes here.</p>\r\n                        <multiselect v-model=\"value\" :options=\"options\" mode=\"tags\"/>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default", {}, undefined, true)]), _hoisted_11])])])])]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.row-centered {\n    text-align: center;\n}\n.col-centered {\n    display: inline-block;\n    float: none;\n    text-align: left;\n    margin-right: -4px;\n}\n.pos {\n    position: top;\n    top: 240px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n#sidebar-wrapper {\r\n        width: auto;\r\n        margin-top: -9px;\r\n        z-index: 1000;\r\n        position: fixed;\r\n        right: 250px;\r\n        height: 100%;\r\n        margin-right: -250px;\r\n        overflow-y: auto;\r\n        transition: all 0.5s ease;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\r\n    /* Override default value of 'none' */\n.modal[data-v-e8c5b748] {\r\n      display: block;\n}\r\n  ", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_style_index_0_id_5a00a0f5_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_style_index_0_id_5a00a0f5_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_style_index_0_id_5a00a0f5_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_style_index_0_id_e8c5b748_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_style_index_0_id_e8c5b748_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_style_index_0_id_e8c5b748_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/Pages/Semestral_Accomplishment/Approve.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Approve_vue_vue_type_template_id_5a00a0f5__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Approve.vue?vue&type=template&id=5a00a0f5 */ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5");
/* harmony import */ var _Approve_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Approve.vue?vue&type=script&lang=js */ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js");
/* harmony import */ var _Approve_vue_vue_type_style_index_0_id_5a00a0f5_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css */ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css");
/* harmony import */ var C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Approve_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Approve_vue_vue_type_template_id_5a00a0f5__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Semestral_Accomplishment/Approve.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Filter.vue":
/*!****************************************!*\
  !*** ./resources/js/Shared/Filter.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Filter.vue?vue&type=template&id=09f80c58 */ "./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58");
/* harmony import */ var _Filter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Filter.vue?vue&type=script&lang=js */ "./resources/js/Shared/Filter.vue?vue&type=script&lang=js");
/* harmony import */ var _Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css */ "./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css");
/* harmony import */ var C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Filter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Filter.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Pagination.vue":
/*!********************************************!*\
  !*** ./resources/js/Shared/Pagination.vue ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.vue?vue&type=template&id=7ed7fa14 */ "./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14");
/* harmony import */ var _Pagination_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Pagination.vue?vue&type=script&lang=js */ "./resources/js/Shared/Pagination.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Pagination_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Pagination.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/PrintModal.vue":
/*!********************************************!*\
  !*** ./resources/js/Shared/PrintModal.vue ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PrintModal_vue_vue_type_template_id_e8c5b748_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true */ "./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true");
/* harmony import */ var _PrintModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PrintModal.vue?vue&type=script&lang=js */ "./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js");
/* harmony import */ var _PrintModal_vue_vue_type_style_index_0_id_e8c5b748_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css */ "./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css");
/* harmony import */ var C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_PrintModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PrintModal_vue_vue_type_template_id_e8c5b748_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-e8c5b748"],['__file',"resources/js/Shared/PrintModal.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js":
/*!*****************************************************************************************!*\
  !*** ./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Approve.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Filter.vue?vue&type=script&lang=js":
/*!****************************************************************!*\
  !*** ./resources/js/Shared/Filter.vue?vue&type=script&lang=js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Pagination.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/Shared/Pagination.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Pagination.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PrintModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5":
/*!***********************************************************************************************!*\
  !*** ./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5 ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_template_id_5a00a0f5__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_template_id_5a00a0f5__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Approve.vue?vue&type=template&id=5a00a0f5 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=template&id=5a00a0f5");


/***/ }),

/***/ "./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=template&id=09f80c58 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58");


/***/ }),

/***/ "./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14":
/*!**************************************************************************!*\
  !*** ./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14 ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Pagination.vue?vue&type=template&id=7ed7fa14 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14");


/***/ }),

/***/ "./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true":
/*!**************************************************************************************!*\
  !*** ./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_template_id_e8c5b748_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_template_id_e8c5b748_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=template&id=e8c5b748&scoped=true");


/***/ }),

/***/ "./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Approve_vue_vue_type_style_index_0_id_5a00a0f5_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Semestral_Accomplishment/Approve.vue?vue&type=style&index=0&id=5a00a0f5&lang=css");


/***/ }),

/***/ "./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css":
/*!************************************************************************************!*\
  !*** ./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css");


/***/ }),

/***/ "./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css":
/*!****************************************************************************************************!*\
  !*** ./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PrintModal_vue_vue_type_style_index_0_id_e8c5b748_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PrintModal.vue?vue&type=style&index=0&id=e8c5b748&scoped=true&lang=css");


/***/ })

}]);