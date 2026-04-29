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
/* harmony import */ var vue_search_select__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-search-select */ "./node_modules/vue-search-select/dist/VueSearchSelect.js");
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }



//import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    data: Object,
    editData: Object,
    emp_code: Object,
    sectors: Object,
    sem: Object,
    session: Object,
    print_url: String,
    emp_type: String
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
    },
    MultiSelect: vue_search_select__WEBPACK_IMPORTED_MODULE_2__.MultiSelect
  },
  data: function data() {
    return {
      my_paps: [],
      individual_final_output_id: [],
      submitted: false,
      isDisabled: false,
      success_indicator: '',
      performance_measure: '',
      quality_error: 1,
      time_range_code: 0,
      unit_of_time: '',
      prescribed_period: 0,
      form: (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
        emp_code: "",
        date: "",
        individual_final_output_id: "",
        individual_output: "",
        description: "",
        sem_id: "",
        id: null,
        type: ""
      }),
      selected_pcr_option: "",
      pageTitle: "",
      stat_accomp: "",
      disableReason: '',
      deadline_date: null
    };
  },
  mounted: function mounted() {
    this.form.emp_code = this.emp_code;
    if (this.editData !== undefined) {
      if (this.bari) {
        this.bar = this.bari;
      }
      this.pageTitle = "Edit";
      this.form.date = this.editData.date;
      this.form.individual_final_output_id = this.editData.individual_final_output_id;
      this.form.individual_output = this.editData.individual_output;
      this.form.description = this.editData.description;
      this.form.sem_id = this.editData.sem_id;
      this.form.id = this.editData.id;
      // this.selected_pcr_option = this.editData.individual_final_output_id
      // var temp_con =this.getSelectedIFO(this.editData.individual_final_output_id, this.editData.sem_id)
      //this.selected_pcr_option = temp_con.id;
      this.selected_ipcr();
    } else {
      this.pageTitle = "Create";
      this.form.date = new Date().toISOString().substr(0, 10);
      this.AutoSem();
      this.getDeadline();
      this.initializeDate();
    }
  },
  computed: {
    ipcrs: function ipcrs() {
      var _this = this;
      return _.filter(this.data, function (o) {
        return o.sem_id == _this.form.sem_id && o.status == 2;
      });
    },
    individual_final_output_id: function individual_final_output_id() {
      var ipcr = this.ipcrs;
      return ipcr.map(function (dat) {
        return {
          // value: dat.individual_final_output_id,
          // "[id: "+ dat.individual_final_output_id+ ", type: " + dat.pcr_type + "]",
          value: dat.id,
          // "[id: "+ dat.individual_final_output_id+ ", type: " + dat.pcr_type + "]",
          label: dat.MFO + " - " + dat.performance_measure + " " + dat.individual_output,
          pcr_type: dat.pcr_type,
          // include for easier access later
          original: dat // optional: include full object if needed
        };
      });
    }
  },
  methods: {
    submit: function submit() {
      if (this.form.quantity <= 0) {
        alert("Accomplishment Quantity should not be less than 1");
      } else if (this.form.quality < 0 && this.time_range_code != 3) {
        alert("Quality should not be empty");
      } else if (this.form.timeliness <= 0 && this.time_range_code != 56) {
        alert("Timeliness should not be empty");
      } else {
        this.form.target_qty = parseFloat(this.form.target_qty1) + parseFloat(this.form.target_qty2) + parseFloat(this.form.target_qty3) + parseFloat(this.form.target_qty4);
        //alert(this.form.target_qty);
        if (this.editData !== undefined) {
          this.form.patch("/Daily_Accomplishment/" + this.form.id, this.form);
        } else {
          // alert("Sample");
          var url = "/Daily_Accomplishment/store";
          // alert('for store '+url);
          this.form.post(url);
        }
      }
    },
    getSelectedIFO: function getSelectedIFO(individual_final_output_id, sem_id) {
      // Find the semester object that matches sem_id
      var semObj = this.sem.find(function (s) {
        return s.id === sem_id;
      });
      console.log("gdklfgdkfgdg");
      console.log(semObj);
      // If not found, stop early
      if (!semObj) return null;

      // Extract the semester value (e.g. "1" or "2")
      var semester = semObj.semester || semObj.sem || null;
      if (!semester) return null;

      // Find the matching record in ipcrs
      return this.ipcrs.find(function (item) {
        return item.individual_final_output_id === individual_final_output_id && item.semester === semester;
      }) || null;
    },
    selected_ipcr: function selected_ipcr() {
      var _this2 = this;
      setTimeout(function () {
        // console.log("PCCCCRRRRRRRR");
        // console.log(this.selected_pcr_option);
        // var array_string = this.parseSelectedOption(this.selected_pcr_option)
        // this.form.individual_final_output_id = array_string.id
        // this.form.type=array_string.type
        // console.log(this.form.)
        if (_this2.selected_pcr_option !== null && _this2.selected_pcr_option !== undefined) {
          // Find the index of the selected option in the array of ipcrs
          // const index = this.data.findIndex(data => String(data.individual_final_output_id) === String(this.form.individual_final_output_id));
          var index = _this2.data.findIndex(function (data) {
            return String(data.id) === String(_this2.selected_pcr_option);
          });
          // alert(index);
          console.log("pint inside selected ipcr method");
          console.log(_this2.data[index]);
          _this2.selected_value = _this2.data[index];
          _this2.form.individual_final_output_id = _this2.data[index].individual_final_output_id;
          _this2.form.individual_output = _this2.data[index].individual_output;
          _this2.form.type = _this2.data[index].pcr_type;
          // alert(this.form.type + this.form.individual_final_output_id)
          _this2.ipcr_submfo = _this2.data[index].submfo_description;
          _this2.ipcr_div_output = _this2.data[index].div_output;
          _this2.ipcr_ind_output = _this2.data[index].individual_output;
          _this2.ipcr_performance = _this2.data[index].performance_measure;
          _this2.performance_measure = _this2.data[index].performance_measure;
          _this2.success_indicator = _this2.data[index].success_indicator;
          _this2.quality = _this2.data[index].quality;
          _this2.timeliness = _this2.data[index].timeliness;
          _this2.quality_error = _this2.data[index].quality_error;
          _this2.time_range_code = _this2.data[index].time_range_code;
          _this2.unit_of_time = _this2.data[index].unit_of_time;
          _this2.prescribed_period = _this2.data[index].prescribed_period;

          //this.ipcr_success = this.ipcrs[index].s
          //alert(index);
        } else {
          // Handle case when no option is selected (form.ipcr_code is null or undefined)
          return -1; // Return -1 to indicate no option is selected
        }
      }, 300);
    },
    parseSelectedOption: function parseSelectedOption(str) {
      // Remove the square brackets
      str = str.replace(/^\[|\]$/g, '');
      var obj = {};
      var parts = str.split(',');
      parts.forEach(function (part) {
        var _part$split$map = part.split(':').map(function (s) {
            return s.trim();
          }),
          _part$split$map2 = _slicedToArray(_part$split$map, 2),
          key = _part$split$map2[0],
          value = _part$split$map2[1];

        // Convert to number if possible
        obj[key] = isNaN(value) ? value : Number(value);
      });
      return obj;
    },
    initializeDate: function initializeDate() {
      var currentDate = new Date().toISOString().substr(0, 10);
      if (this.form.date > currentDate) {
        this.isDisabled = true;
      } else {
        this.isDisabled = false;
      }
      // this.form.date = new Date().toISOString().substr(0, 10); // Set current date
    },
    moveToNextInput: function moveToNextInput(nextInput) {
      this.$refs[nextInput].focus();
    },
    //     getDeadline() {
    //          console.log('getDeadline triggered');
    //     axios.get('/Daily_Accomplishment/daily/deadline', {
    //         params: {
    //             year: this.form.date.split('-')[0],
    //             month: this.form.date.split('-')[1]
    //         }
    //     }).then(response => {
    //         this.deadline_date = response.data.deadline_date;
    //         console.log(this.deadline_date + " sample");
    //         this.AutoSem(); // run after deadline loads
    //     });
    // },
    // AutoSem() {
    //     this.$nextTick(() => {
    //         if (!this.form.date) return;
    //         let [selectedYear, selectedMonth] = this.form.date.split('-').map(Number);
    //         let selectedFullDate = new Date(this.form.date);
    //         let today = new Date();
    //         let todayOnly = new Date();
    //         todayOnly.setHours(0,0,0,0);
    //         let currentYear = today.getFullYear();
    //         let currentMonth = today.getMonth() + 1;
    //         console.log('Current:', currentYear, currentMonth);
    //         this.getDeadline(currentYear, currentMonth);
    //         let [selY, selM, selD] = this.form.date.split('-').map(Number);
    //         let t = new Date();
    //         let todayY = t.getFullYear();
    //         let todayM = t.getMonth() + 1;
    //         let todayD = t.getDate();
    //         // ================= SEMESTER CHECK =================
    //         let Semester = selectedMonth < 7 ? 1 : 2;
    //         var sem = _.find(this.sem, {
    //             sem: Semester.toString(),
    //             year: selectedYear.toString()
    //         });
    //         this.form.sem_id = sem ? sem.id : '';
    //         this.stat_accomp = sem ? sem.status_accomplishment : '';
    //         if (this.stat_accomp == '1' || this.stat_accomp == '2') {
    //             this.isDisabled = true;
    //             this.disableReason = 'SEM_LOCKED';
    //             return;
    //         }
    //         // ================= ADVANCE CHECK (CORRECT) =================
    //         if (selY > todayY || (selY === todayY && selM > todayM) || (selY === todayY && selM === todayM && selD > todayD)) {
    //         // console.log(selectedFullDate);
    //         //             console.log(todayOnly);
    //             this.isDisabled = true;
    //             this.disableReason = 'ADVANCE';
    //             return;
    //         }
    //         // ================== CHECK IF EXEMPTED ====================
    //         this.isExempted = this.checkIfExempted(this.form.date);
    //         // console.log(this.isExempted)
    //         if (this.isExempted) {
    //             // console.log("CheckIfExempted: "+this.isExempted)
    //             this.isDisabled = false;
    //             this.disableReason = '';
    //             return; // Skip the 10th weekday check for exempt positions
    //         }
    //         // console.log("Niabot diri")
    //         // ================= 10TH WEEKDAY CUT-OFF =================
    //         // let tenthWeekday = this.getAfter10thWorkingDay(currentYear, currentMonth);
    //        let cutoffDate = new Date(this.deadline_date + 'T00:00:00');
    //         console.log(cutoffDate + " Test")
    //         let prevMonth = currentMonth - 1;
    //         let prevYear = currentYear;
    //         if (prevMonth === 0) {
    //             prevMonth = 12;
    //             prevYear--;
    //         }
    //         let monthDiff = (currentYear - selectedYear) * 12 + (currentMonth - selectedMonth);
    //         // ❌ block anything older than previous month
    //         if (monthDiff >= 2) {
    //             this.isDisabled = true;
    //             this.disableReason = 'CUTOFF_10TH_WEEKDAY';
    //             return;
    //         }
    //         if (today >= cutoffDate) {
    //             if (selectedMonth === prevMonth && selectedYear === prevYear) {
    //                 this.isDisabled = true;
    //                 this.disableReason = 'CUTOFF_10TH_WEEKDAY';
    //                 return;
    //             }
    //         }
    //         // ✅ allowed
    //         this.isDisabled = false;
    //         this.disableReason = '';
    //     });
    // },
    AutoSem: function AutoSem() {
      var _this3 = this;
      this.$nextTick(function () {
        if (!_this3.form.date) return;
        var _this3$form$date$spli = _this3.form.date.split('-').map(Number),
          _this3$form$date$spli2 = _slicedToArray(_this3$form$date$spli, 2),
          selectedYear = _this3$form$date$spli2[0],
          selectedMonth = _this3$form$date$spli2[1];
        var today = new Date();
        var currentYear = today.getFullYear();
        var currentMonth = today.getMonth() + 1;
        console.log('Current:', currentYear, currentMonth);

        // 🔥 STOP HERE — wait for API first
        _this3.getDeadline(currentYear, currentMonth, selectedYear, selectedMonth);
      });
    },
    getDeadline: function getDeadline(currentYear, currentMonth, selectedYear, selectedMonth) {
      var _this4 = this;
      axios.get('/Daily_Accomplishment/daily/deadline', {
        params: {
          year: selectedYear,
          month: selectedMonth
        }
      }).then(function (response) {
        _this4.deadline_date = response.data.deadline_date;
        console.log('Deadline:', _this4.deadline_date);

        // 🔥 NOW RUN FULL LOGIC (AFTER DATA IS READY)
        _this4.runAutoSemLogic(currentYear, currentMonth, selectedYear, selectedMonth);
      })["catch"](function (error) {
        console.log('API Error:', error);
      });
    },
    getAfter10thWorkingDay: function getAfter10thWorkingDay(year, month) {
      var count = 0;
      var date = new Date(year, month - 1, 1);
      while (count < 10) {
        var day = date.getDay();

        // Working days: Monday to Thursday only
        if (day >= 1 && day <= 4) {
          count++;
        }
        if (count < 10) {
          date.setDate(date.getDate() + 1);
        }
      }

      // move to the day AFTER the 10th working day
      date.setDate(date.getDate() + 1);
      return date;
    },
    runAutoSemLogic: function runAutoSemLogic(currentYear, currentMonth, selectedYear, selectedMonth) {
      if (!this.deadline_date) {
        console.log('No deadline found');
        return;
      }
      console.log(currentYear, currentMonth, selectedYear, selectedMonth);
      var selectedFullDate = new Date(this.form.date);
      var today = new Date();
      var _this$form$date$split = this.form.date.split('-').map(Number),
        _this$form$date$split2 = _slicedToArray(_this$form$date$split, 3),
        selY = _this$form$date$split2[0],
        selM = _this$form$date$split2[1],
        selD = _this$form$date$split2[2];
      var todayY = today.getFullYear();
      var todayM = today.getMonth() + 1;
      var todayD = today.getDate();

      // ================= SEMESTER CHECK =================
      var Semester = selectedMonth < 7 ? 1 : 2;
      var sem = _.find(this.sem, {
        sem: Semester.toString(),
        year: selectedYear.toString()
      });
      this.form.sem_id = sem ? sem.id : '';
      this.stat_accomp = sem ? sem.status_accomplishment : '';
      if (this.stat_accomp == '1' || this.stat_accomp == '2') {
        this.isDisabled = true;
        this.disableReason = 'SEM_LOCKED';
        return;
      }

      // ================= ADVANCE CHECK =================
      if (selY > todayY || selY === todayY && selM > todayM || selY === todayY && selM === todayM && selD > todayD) {
        this.isDisabled = true;
        this.disableReason = 'ADVANCE';
        return;
      }

      // ================= EXEMPT CHECK =================
      this.isExempted = this.checkIfExempted(this.form.date);
      if (this.isExempted) {
        this.isDisabled = false;
        this.disableReason = '';
        return;
      }

      // ================= CUT-OFF =================
      var cutoffDate = new Date(this.deadline_date + 'T00:00:00');
      console.log('Cutoff:', cutoffDate);
      var prevMonth = currentMonth - 1;
      var prevYear = currentYear;
      if (prevMonth === 0) {
        prevMonth = 12;
        prevYear--;
      }
      var monthDiff = (currentYear - selectedYear) * 12 + (currentMonth - selectedMonth);

      // console.log(monthDiff);
      // ❌ block older than 2 months
      if (monthDiff >= 2) {
        this.isDisabled = true;
        this.disableReason = 'CUTOFF_10TH_WEEKDAY';
        return;
      }

      // ❌ cutoff check
      if (today >= cutoffDate) {
        if (selectedMonth === prevMonth && selectedYear === prevYear) {
          this.isDisabled = true;
          this.disableReason = 'CUTOFF_10TH_WEEKDAY';
          return;
        }
      }

      // ✅ allowed
      this.isDisabled = false;
      this.disableReason = '';
    },
    checkIfExempted: function checkIfExempted(date) {
      if (!date) return false;
      var selectedDate = new Date(date);
      if (isNaN(selectedDate)) return false; // invalid date safeguard

      var month = selectedDate.getMonth() + 1;
      var year = selectedDate.getFullYear();
      var sem = month >= 7 ? "2" : "1";
      var semRecord = this.sem.find(function (item) {
        return item.year == year && item.sem == sem;
      });
      if (!semRecord || !Array.isArray(semRecord.monthly_accomplishments)) {
        return false;
      }
      var monthRecord = semRecord.monthly_accomplishments.find(function (m) {
        return parseInt(m.month) === month;
      });
      if (!monthRecord) return false;
      return monthRecord.allow_month_backtrack === "1";
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
    mun: Array
    // bar: Array,
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
  mounted: function mounted() {
    //this.bar=[];
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
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "relative row gap-20 masonry pos-r"
};
var _hoisted_2 = {
  "class": "peers fxw-nw jc-sb ai-c"
};
var _hoisted_3 = {
  "class": "col-md-8"
};
var _hoisted_4 = ["disabled"];
var _hoisted_5 = {
  key: 0,
  "class": "fs-6 c-red-500"
};
var _hoisted_6 = {
  "class": "mt-2 mb-1"
};
var _hoisted_7 = {
  key: 0
};
var _hoisted_8 = {
  key: 1
};
var _hoisted_9 = {
  key: 2
};
var _hoisted_10 = {
  key: 3
};
var _hoisted_11 = {
  key: 4
};
var _hoisted_12 = {
  key: 5
};
var _hoisted_13 = {
  key: 6
};
var _hoisted_14 = {
  key: 1,
  "class": "fs-6 c-red-500"
};
var _hoisted_15 = ["disabled"];
var _hoisted_16 = {
  key: 2,
  "class": "fs-6 c-red-500"
};
var _hoisted_17 = ["disabled"];
var _hoisted_18 = ["value"];
var _hoisted_19 = {
  key: 3,
  "class": "fs-6 c-red-500"
};
var _hoisted_20 = ["disabled", "hidden"];
var _hoisted_21 = {
  key: 4,
  style: {
    "color": "red"
  }
};
var _hoisted_22 = {
  key: 0
};
var _hoisted_23 = {
  key: 1
};
var _hoisted_24 = {
  key: 2
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");
  var _component_multiselect = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("multiselect");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle) + " Accomplishment", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ data }}\r\n            {{ emp_code }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ session.previous_url }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: $props.session.previous_url
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[10] || (_cache[10] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "25",
        height: "25",
        fill: "currentColor",
        "class": "bi bi-x-lg",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "fill-rule": "evenodd",
        d: "M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "fill-rule": "evenodd",
        d: "M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"
      })], -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [10]
  }, 8 /* PROPS */, ["href"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"col-md-8\">\r\n            <button class=\"btn btn-secondary\" @click=\"showModal\" :disabled=\"submitted\">Permissions</button>\r\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.submit();
    }, ["prevent"]))
  }, [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    required: ""
  }, null, -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.form.emp_code = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.emp_code]]), _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": ""
  }, "Date", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    onInput: _cache[1] || (_cache[1] = function () {
      return $options.AutoSem && $options.AutoSem.apply($options, arguments);
    }),
    type: "date",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.form.date = $event;
    }),
    "class": "form-control",
    disabled: $data.pageTitle == 'Edit'
  }, null, 40 /* PROPS, NEED_HYDRATION */, _hoisted_4), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.date]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <input @change=\"AutoSem()\" type=\"date\" v-model=\"form.date\" class=\"form-control\"\r\n                    autocomplete=\"positionchrome-off\" :disabled=\"pageTitle == 'Edit'\"> "), $data.form.errors.date ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.date), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_6, [$props.emp_type === 'emp' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, "Individual Output")) : $props.emp_type === 'div' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_8, "Division Output")) : $props.emp_type === 'hemp' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_9, "Hospital Individual Output")) : $props.emp_type === 'hsec' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, "Hospital Section Output")) : $props.emp_type === 'hdiv' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_11, "Hospital Division Output")) : $props.emp_type === 'hos' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_12, "Hospital Output")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, "Output"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" selected_pcr_option: {{ selected_pcr_option }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_pcr_option }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_multiselect, {
    ref: "IPCRInput",
    options: $options.individual_final_output_id,
    searchable: true,
    modelValue: $data.selected_pcr_option,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.selected_pcr_option = $event;
    }),
    label: "label",
    "track-by": "label",
    onClose: $options.selected_ipcr,
    disabled: $data.pageTitle == 'Edit' || $data.isDisabled
  }, null, 8 /* PROPS */, ["options", "modelValue", "onClose", "disabled"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ data }} "), $data.form.errors.individual_final_output_id ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.individual_final_output_id), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": ""
  }, "Particulars", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <input type=\"text\" v-model=\"form.description\" class=\"form-control\" autocomplete=\"positionchrome-off\"\r\n                    @keyup.enter=\"moveToNextInput('IPCRInput')\" :disabled=\"isDisabled\"> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.form.description = $event;
    }),
    "class": "form-control",
    autocomplete: "positionchrome-off",
    onKeyup: _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function ($event) {
      return $options.moveToNextInput('IPCRInput');
    }, ["enter"])),
    disabled: $data.isDisabled,
    rows: "1"
  }, null, 40 /* PROPS, NEED_HYDRATION */, _hoisted_15), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.description]]), $data.form.errors.description ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.description), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": ""
  }, "Semester", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ sem }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    ref: "SemesterInput",
    "class": "form-control form-select",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $data.form.sem_id = $event;
    }),
    disabled: ""
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.sem, function (sem) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      value: sem.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(sem.sem_in_word + " - " + sem.year), 9 /* TEXT, PROPS */, _hoisted_18);
  }), 256 /* UNKEYED_FRAGMENT */))], 8 /* PROPS */, _hoisted_17), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.sem_id]]), $data.form.errors.sem_id ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.form.errors.sem_id), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ ipcr_codes }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <select class=\"form-control form-select\" v-model=\"form.idIPCR\"  @change=\"selected_ipcr\" :disabled=\"pageTitle=='Edit' || isDisabled\">\r\n                    <option v-for=\"dat in ipcrs\" :value=\"dat.ipcr_code\" >\r\n                        {{ dat.ipcr_code + \" - \" + dat.individual_output}}\r\n                    </option>\r\n                </select> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label for=\"\">Individual Output</label>\r\n                <input type=\"text\" v-model=\"form.individual_output\" class=\"form-control\"\r\n                    autocomplete=\"positionchrome-off\" disabled>\r\n                <div class=\"fs-6 c-red-500\" v-if=\"form.errors.individual_output\">{{ form.errors.individual_output }}\r\n                </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "hidden",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.form.id = $event;
    }),
    "class": "form-control",
    autocomplete: "chrome-off"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.id]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    ref: "Button",
    type: "button",
    "class": "btn btn-primary mt-3 text-white",
    onClick: _cache[8] || (_cache[8] = function ($event) {
      return $options.submit();
    }),
    disabled: $data.form.processing,
    hidden: $data.isDisabled
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.pageTitle != "Edit" ? "Save Accomplishment" : "Save Changes"), 9 /* TEXT, PROPS */, _hoisted_20), _cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <h5 v-if=\"isDisabled\" style=\"color: red;\">\r\n                    <span v-if=\"stat_accomp == '1' || stat_accomp == '2'\">\r\n                        The IPCR Semestral Accomplishment for this date range has already been approved or reviewed.\r\n                        Select a different date\r\n                    </span>\r\n                    <span v-else>You cannot create an advance Accomplishment</span>\r\n                </h5> "), $data.isDisabled ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("h5", _hoisted_21, [$data.disableReason === 'SEM_LOCKED' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_22, " The IPCR Semestral Accomplishment for this date range has already been approved or reviewed. Select a different date ")) : $data.disableReason === 'ADVANCE' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_23, " You cannot create an advance Accomplishment ")) : $data.disableReason === 'CUTOFF_10TH_WEEKDAY' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_24, " You cannot create accomplishment since the deadline for the approval has already passed based on MO.0028.2026. ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 32 /* NEED_HYDRATION */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ sem }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }}\r\n        -------<br> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ data }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ sem }}\r\n        {{ stat_accomp }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ this.form.sem_id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ data }}\r\n          <br>\r\n          {{ editData }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ data }}\r\n        <hr>\r\n        {{ ipcrs }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }}\r\n          <hr>\r\n          {{ ipcrs }}\r\n          <hr>\r\n          {{ data }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ selected_pcr_option }} ")]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
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
var _hoisted_9 = {
  "class": "layers bd bgc-white p-20"
};
var _hoisted_10 = {
  "class": "layer w-100"
};
var _hoisted_11 = {
  "class": "peers ai-sb fxw-nw"
};
var _hoisted_12 = {
  "class": "form-control"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", _hoisted_6, "Municipalities " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.my_mun), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "peer peer-greed"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    id: "sparklinedash"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.munsel = $event;
    }),
    onChange: _cache[1] || (_cache[1] = function () {
      return $options.loadBar && $options.loadBar.apply($options, arguments);
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.mun, function (munn) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(munn.citymunDesc), 1 /* TEXT */);
  }), 256 /* UNKEYED_FRAGMENT */))], 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.munsel]])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "layer w-100 mB-10"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", {
    "class": "lh-1"
  }, "Barangay")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "peer peer-greed"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    id: "sparklinedash"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", _hoisted_12, [_cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, null, -1 /* CACHED */)), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.bar, function (barr) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(barr.brgyDesc), 1 /* TEXT */);
  }), 256 /* UNKEYED_FRAGMENT */))])])])])])])]);
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
/* harmony import */ var C_xampp_htdocs_ipcr_revised2_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised2_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Daily_Accomplishment/Create.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


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

/***/ "./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a":
/*!******************************************************************************************!*\
  !*** ./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_a2e7602a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=a2e7602a */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Daily_Accomplishment/Create.vue?vue&type=template&id=a2e7602a");


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
/* harmony import */ var C_xampp_htdocs_ipcr_revised2_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_revised2_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PlacesShared_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/PlacesShared.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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

/***/ "./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6":
/*!****************************************************************************!*\
  !*** ./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PlacesShared_vue_vue_type_template_id_ee3222a6__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PlacesShared.vue?vue&type=template&id=ee3222a6 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/PlacesShared.vue?vue&type=template&id=ee3222a6");


/***/ })

}]);