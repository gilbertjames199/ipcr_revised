"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Employees_All_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_Filter__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/Shared/Filter */ "./resources/js/Shared/Filter.vue");
/* harmony import */ var _Shared_Pagination__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/Shared/Pagination */ "./resources/js/Shared/Pagination.vue");
/* harmony import */ var _Shared_ModalSmall__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/Shared/ModalSmall */ "./resources/js/Shared/ModalSmall.vue");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_5__);
var _methods;



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }








 //import PermissionsModal from './PermissionsModal.vue'

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Pagination: _Shared_Pagination__WEBPACK_IMPORTED_MODULE_3__["default"],
    Filtering: _Shared_Filter__WEBPACK_IMPORTED_MODULE_2__["default"],
    Modal: _Shared_ModalSmall__WEBPACK_IMPORTED_MODULE_4__["default"],
    Swal: (sweetalert2__WEBPACK_IMPORTED_MODULE_5___default()),
    ModalPass: _Shared_ModalSmall__WEBPACK_IMPORTED_MODULE_4__["default"],
    ModalStatus: _Shared_ModalSmall__WEBPACK_IMPORTED_MODULE_4__["default"],
    ModalSync: _Shared_ModalSmall__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: {
    auth: Object,
    users: Object,
    filters: Object,
    can: Object,
    permissions_all: Object,
    offices: Object // divisions: Object,

  },
  mounted: function mounted() {
    this.getPermissionAll();
  },
  data: function data() {
    var _ref;

    return _ref = {
      selected_permissions: [],
      permission_index: [],
      permission_particular: [],
      permission_option: [],
      // form: useForm({
      //     ipaddress: 0,
      //     value: [],
      // }),
      my_name: '',
      selected_user_id: null,
      permissions_selected_user: [],
      displayModal: false,
      search: this.$props.filters.search,
      confirm: false,
      filter: false,
      my_email: '',
      my_id: ''
    }, _defineProperty(_ref, "my_name", ""), _defineProperty(_ref, "my_office", ""), _defineProperty(_ref, "reset_name", ""), _defineProperty(_ref, "reset_id", ""), _defineProperty(_ref, "requestor_name", ""), _defineProperty(_ref, "active_status", ""), _defineProperty(_ref, "form", (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.useForm)({
      email: "",
      id: "",
      requestor_id: "",
      password_change_remarks: "",
      ipaddress: ""
    })), _defineProperty(_ref, "divisions", []), _defineProperty(_ref, "displayModalPass", false), _defineProperty(_ref, "displayStatusModal", false), _defineProperty(_ref, "displaySyncModal", false), _defineProperty(_ref, "disp_active_stat", ""), _defineProperty(_ref, "cats_num", null), _ref;
  },
  computed: {
    requestor_sel: function requestor_sel() {
      var users1 = this.users;
      return users1.map(function (user) {
        return {
          value: user.empl_id,
          label: user.employee_name + (user.office ? ' - ' + user.office : '') // FFUNCCOD: ipcr.FFUNCCOD,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,
          // department_code: ipcr.department_code,

        };
      });
    }
  },
  watch: {
    search: _.debounce(function (value) {
      this.$inertia.get("/employees/all", {
        search: value,
        EmploymentStatus: this.EmploymentStatus,
        office: this.office_selected,
        division: this.division_selected,
        active_status: this.active_status
      }, {
        preserveScroll: true,
        preserveState: true,
        replace: true
      }); // this.filterData();
    }, 300)
  },
  methods: (_methods = {
    deleteUser: function deleteUser(id) {
      var text = "WARNING!\nAre you sure you want to delete the record?";

      if (confirm(text) == true) {
        this.$inertia["delete"]("/users/" + id);
      }
    },
    resetPass: function resetPass(uid, name, requestor_name) {
      var _this = this;

      var text = "WARNING!\nAre you sure you want to reset password of the employee ( " + name + ") as requested by " + requestor_name + "?";

      if (confirm(text) == true) {
        // this.$inertia.delete("/users/" + id);
        this.form.post("/employees/all/reset/passwpord/" + uid);
        setTimeout(function () {
          // this.displayModal = false;
          _this.cancelReset();
        }, 1000);
      }
    },
    getPermissionAll: function getPermissionAll() {// this.permission_particular =[];
      // this.permissions_all.forEach(i=>{
      //     //alert(i.permission);
      //     this.permission_particular.push({
      //         'id': i.id,
      //         'value': i.id,
      //         'label': i.permission,
      //     });
      // });
    },
    showFilter: function showFilter() {
      //alert("show filter");
      this.filter = !this.filter;
    },
    clearFilter: function clearFilter() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.EmploymentStatus = "";
                _this2.office_selected = "";
                _this2.division_selected = "";
                _this2.active_status = "";
                _this2.divisions = []; // this.search_text="";

                _this2.filterData();

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    filterData: function filterData() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                //alert(this.mfosel);
                _this3.$inertia.get("/employees/all", {
                  EmploymentStatus: _this3.EmploymentStatus,
                  office: _this3.office_selected,
                  division: _this3.division_selected,
                  active_status: _this3.active_status // search: this.search_text

                }, {
                  preserveScroll: true,
                  preserveState: true,
                  replace: true
                });

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getDivision: function getDivision() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var url;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // await axios.get('/division')
                // alert(this.office_selected);
                _this4.divisions = [];
                _this4.division_selected = "";
                url = '/employees/division/' + _this4.office_selected;
                _context3.next = 5;
                return axios.get(url).then(function (response) {
                  // this.core_support = response.data;
                  _this4.divisions = response.data;
                  console.log(response.data);
                });

              case 5:
                _this4.filterData();

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getPermInd: function getPermInd() {//
    },
    verifyPermissions: function verifyPermissions(ed, del, perm) {
      if (ed === true || del === true || perm === true) {
        alert("dropdown will show!");
        return true;
      } else {
        return false;
      }
    }
  }, _defineProperty(_methods, "showFilter", function showFilter() {
    this.filter = !this.filter;
  }), _defineProperty(_methods, "showModal", function showModal(id, name) {
    this.fetchingUserPermissions(id, name);
    this.my_name = name;
    this.displayModal = true;
  }), _defineProperty(_methods, "showModalEmail", function showModalEmail(u_id, u_email, u_name) {
    this.my_email = u_email;
    this.my_id = u_id;
    this.my_name = u_name;
    this.displayModal = true;
  }), _defineProperty(_methods, "hideModal", function hideModal() {
    this.displayModal = false;
  }), _defineProperty(_methods, "hideModalDisplay", function hideModalDisplay() {
    this.displayModal = false;
    this.my_email = "";
    this.my_id = "";
    this.my_name = "";
  }), _defineProperty(_methods, "hideModalStat", function hideModalStat() {
    this.displayStatusModal = false;
  }), _defineProperty(_methods, "hideModalSync", function hideModalSync() {
    this.displaySyncModal = false;
    this.cats_num = null;
  }), _defineProperty(_methods, "updateEmail", function updateEmail(name) {
    var _this5 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
      var text;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              text = "WARNING!\nAre you sure you want to update the email of the employee ( " + name + ")?";

              if (confirm(text) == true) {
                try {
                  _this5.form.email = _this5.my_email;
                  _this5.form.id = _this5.my_id;

                  _this5.form.post('/employees/updateEmail'); // console.log('Email updated successfully:', response.data);


                  if (_this5.search == '') {
                    _this5.search = _this5.my_name;
                    window.location.reload();
                  } else {
                    _this5.retypeSearchValue();
                  }
                } catch (error) {
                  console.error('There was an error updating the email:', error);
                }
              }

            case 2:
            case "end":
              return _context4.stop();
          }
        }
      }, _callee4);
    }))();
  }), _defineProperty(_methods, "retypeSearchValue", function retypeSearchValue() {
    var _this6 = this;

    var searchValue = this.search;
    this.search = ''; // Clear the search input
    // Retype the search value letter by letter

    var _loop = function _loop(i) {
      setTimeout(function () {
        _this6.search += searchValue[i];
      }, i * 5); // Adjust the delay as needed
    };

    for (var i = 0; i < searchValue.length; i++) {
      _loop(i);
    }
  }), _defineProperty(_methods, "impersonate", function impersonate(userId, empl_id, current_user, emp_name) {
    var _this7 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              if (empl_id == current_user) {
                // alert("You can't impersonate yourself!")
                _this7.$swal({
                  icon: 'error',
                  title: 'You can\'t impersonate yourself!',
                  timer: 5000,
                  // Set duration
                  timerProgressBar: true,
                  // showCancelButton: true,
                  customClass: {
                    popup: "bg-gradient-danger"
                  }
                });
              } else {
                _this7.$swal({
                  title: "Are you sure?",
                  text: "Do you want to impersonate " + emp_name + "?",
                  type: "warning",
                  // buttons: true,
                  // dangerMode: true,
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Yes",
                  cancelButtonText: "No",
                  closeOnConfirm: false,
                  closeOnCancel: false
                }).then(function (result) {
                  if (result.isConfirmed) {
                    _this7.$inertia.get("/impersonate/take/".concat(userId), {}, {
                      onSuccess: function onSuccess() {
                        // Redirect or handle success response as needed
                        window.location.reload(); // Optional: reload to apply changes
                      },
                      onError: function onError(errors) {
                        console.error('Error during impersonation:', errors);
                      }
                    });
                  } else {// this.$swal("Impersonation cancelled!", {
                    //     title: "Impersonation cancelled",
                    //     icon: "info",
                    // });
                  }
                }); // if (confirm("Are you sure you want to impersonate this user?")) {
                //     this.$inertia.get(`/impersonate/take/${userId}`, {}, {
                //         onSuccess: () => {
                //             // Redirect or handle success response as needed
                //             window.location.reload(); // Optional: reload to apply changes
                //         },
                //         onError: (errors) => {
                //             console.error('Error during impersonation:', errors);
                //         }
                //     });
                // }

              }
              /*
              if (confirm("Are you sure you want to impersonate this user?")) {
                  await this.$inertia.get(`/impersonate/take/${userId}`)
                      .then(() => {
                          // Redirect or handle success response as needed
                          window.location.reload(); // Optional: reload to apply changes
                      })
                      .catch(error => {
                          console.error('Error during impersonation:', error);
                      });
              }*/


            case 1:
            case "end":
              return _context5.stop();
          }
        }
      }, _callee5);
    }))();
  }), _defineProperty(_methods, "showModalPass", function showModalPass(uid, name) {
    this.displayModalPass = true;
    this.form.id = uid;
    this.reset_id = uid;
    this.reset_name = name;
  }), _defineProperty(_methods, "showModalSync", function showModalSync() {
    this.displaySyncModal = true;
  }), _defineProperty(_methods, "hideModalPass", function hideModalPass() {
    this.displayModalPass = false;
  }), _defineProperty(_methods, "SelectEmployee", function SelectEmployee(id, name, is_admin) {
    // alert(id+' '+name)
    this.form.requestor_id = id;
    this.requestor_name = name;

    if (is_admin == 0) {
      alert(is_admin); // this.form.password_change_remarks='password change request '

      if (this.form.id == id) {} else {
        if (this.is_admin == '0') {
          this.form.password_change_remarks;
        }
      }
    }
  }), _defineProperty(_methods, "cancelReset", function cancelReset() {
    var _this8 = this;

    this.reset_name = null;
    this.requestor_name = null;
    this.reset_name = null;
    this.requestor_name = null;
    this.form.email = null;
    this.id = null;
    this.requestor_id = null;
    this.disp_active_stat = null;
    setTimeout(function () {
      // this.displayModal = false;
      _this8.hideModalPass();

      _this8.hideModalStat();
    }, 1000);
  }), _defineProperty(_methods, "updateStatus", function updateStatus(u_id, name, active_stat) {
    // user.credential.id, user.employee_name, user.active_status
    this.id = u_id;
    this.reset_name = name;
    this.displayStatusModal = true;
    this.disp_active_stat = active_stat;
  }), _defineProperty(_methods, "syncEmployeeData", function syncEmployeeData() {
    var _this9 = this;

    if (this.cats_num) {
      // alert('naay cats')
      var text = "WARNING!\nAre you sure you want to sync data of  employee with CATS number " + this.cats_num + "?";

      if (confirm(text) == true) {
        // this.$inertia.delete("/users/" + id);
        this.form.get("/employees/s/y/n/c/all/employees/selected?employee_code=" + this.cats_num);
        setTimeout(function () {
          // this.displayModal = false;
          // this.cancelReset()
          _this9.cancelSync();
        }, 1000);
      }
    } else {
      // alert('walay cats')
      var _text = "WARNING!\nAre you sure you want to sync data of all employees?";

      if (confirm(_text) == true) {
        // this.$inertia.delete("/users/" + id);
        this.form.get("/employees/s/y/n/c/all/employees/selected");
        setTimeout(function () {
          // this.displayModal = false;
          // this.cancelReset()
          _this9.cancelSync();
        }, 1000);
      }
    }
  }), _defineProperty(_methods, "cancelSync", function cancelSync() {
    var _this10 = this;

    setTimeout(function () {
      // this.displayModal = false;
      _this10.hideModalSync(); // this.hideModalStat()

    }, 1000);
  }), _defineProperty(_methods, "updateStatusSave", function updateStatusSave() {
    var _this11 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
      var response, data, ipAddress, text;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
        while (1) {
          switch (_context6.prev = _context6.next) {
            case 0:
              _context6.next = 2;
              return fetch('https://api.ipify.org?format=json');

            case 2:
              response = _context6.sent;
              _context6.next = 5;
              return response.json();

            case 5:
              data = _context6.sent;
              ipAddress = data.ip; // alert(ipAddress);

              text = "WARNING!\nAre you sure you want to update status of  " + _this11.reset_name + "?";

              if (confirm(text) == true) {
                // this.$inertia.delete("/users/" + id);
                _this11.form.post("/employees/all/update/status/" + _this11.id + "/" + _this11.disp_active_stat);

                setTimeout(function () {
                  // this.displayModal = false;
                  _this11.cancelReset();
                }, 1000);
              }

            case 9:
            case "end":
              return _context6.stop();
          }
        }
      }, _callee6);
    }))();
  }), _methods)
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    //userId: Object,
    title: {
      type: String,
      required: true
    }
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("title", null, "Users", -1
/* HOISTED */
);

var _hoisted_2 = {
  "class": "row gap-10 masonry pos-r"
};
var _hoisted_3 = {
  "class": "peers fxw-nw jc-sb ai-c"
};

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, "Employees", -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "peers"
};
var _hoisted_6 = {
  "class": "peer mR-10"
};
var _hoisted_7 = {
  "class": "peer"
};

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Filter by Employement Status", -1
/* HOISTED */
);

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, null, -1
/* HOISTED */
);

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Job Order"
}, "Job Order", -1
/* HOISTED */
);

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Casual"
}, "Casual", -1
/* HOISTED */
);

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "Regular"
}, "Regular", -1
/* HOISTED */
);

var _hoisted_13 = [_hoisted_9, _hoisted_10, _hoisted_11, _hoisted_12];

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Filter by Department", -1
/* HOISTED */
);

var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, null, -1
/* HOISTED */
);

var _hoisted_16 = ["value"];

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Filter by Division", -1
/* HOISTED */
);

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, null, -1
/* HOISTED */
);

var _hoisted_19 = ["value"];

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Filter by Active Status", -1
/* HOISTED */
);

var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, null, -1
/* HOISTED */
);

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "ACTIVE"
}, "Active", -1
/* HOISTED */
);

var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "IN-ACTIVE"
}, "Inactive", -1
/* HOISTED */
);

var _hoisted_24 = {
  "class": "col-12"
};
var _hoisted_25 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_26 = {
  "class": "table table-hover table-striped"
};

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", {
  style: {
    "background-color": "#b7dde8"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "CATS Number"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Employment Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Position"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Division"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Office"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Active Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col",
  style: {
    "text-align": "right"
  }
}, "Action")])], -1
/* HOISTED */
);

var _hoisted_28 = {
  key: 0
};
var _hoisted_29 = {
  key: 0
};
var _hoisted_30 = {
  key: 0
};
var _hoisted_31 = {
  key: 1
};
var _hoisted_32 = {
  style: {
    "text-align": "right"
  }
};
var _hoisted_33 = {
  "class": "dropdown dropstart"
};

var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
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
})])], -1
/* HOISTED */
);

var _hoisted_35 = {
  "class": "dropdown-menu action-dropdown",
  "aria-labelledby": "dropdownMenuButton1"
};
var _hoisted_36 = {
  key: 0
};
var _hoisted_37 = ["onClick"];
var _hoisted_38 = {
  key: 1
};
var _hoisted_39 = ["onClick"];
var _hoisted_40 = ["onClick"];
var _hoisted_41 = {
  key: 2
};
var _hoisted_42 = ["onClick"];

var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("IPCR ");

var _hoisted_44 = {
  "class": "row justify-content-center"
};
var _hoisted_45 = {
  "class": "col-md-12"
};

var _hoisted_46 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" to ");

var _hoisted_47 = {
  key: 0
};
var _hoisted_48 = {
  key: 1
};

var _hoisted_49 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Name: ");

var _hoisted_50 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_51 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)();

var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_53 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Email: ");

var _hoisted_54 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_55 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_56 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)();

var _hoisted_57 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_58 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   ");

var _hoisted_59 = {
  "class": "peer mR-10 form-control-sm"
};

var _hoisted_60 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Reset Password of: ");

var _hoisted_61 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_62 = {
  "class": "peer mR-10 form-control-sm"
};

var _hoisted_63 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Requested by: ");

var _hoisted_64 = {
  key: 0,
  "class": "font-weight-bold text-danger"
};
var _hoisted_65 = {
  "class": "peer mR-10 form-control-sm"
};

var _hoisted_66 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Remarks: ");

var _hoisted_67 = ["disabled"];

var _hoisted_68 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_69 = ["disabled"];
var _hoisted_70 = {
  "class": "peer mR-10"
};

var _hoisted_71 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Search: ");

var _hoisted_72 = {
  "class": "col-12"
};
var _hoisted_73 = {
  "class": "bgc-white p-20 bd"
};
var _hoisted_74 = {
  "class": "table table-hover table-striped"
};

var _hoisted_75 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", {
  style: {
    "background-color": "#b7dde8"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "CATS Number"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th>Employment Status</th> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th>Office</th> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th scope=\"col\" style=\"text-align: right\">Action</th> ")])], -1
/* HOISTED */
);

var _hoisted_76 = ["onClick"];
var _hoisted_77 = {
  "class": "row justify-content-center"
};
var _hoisted_78 = {
  "class": "col-md-12"
};

var _hoisted_79 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" to ");

var _hoisted_80 = {
  key: 0
};
var _hoisted_81 = {
  key: 1
};

var _hoisted_82 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" UPDATE STATUS OF: ");

var _hoisted_83 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_84 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" EMPLOYEE STATUS: ");

var _hoisted_85 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "ACTIVE"
}, "ACTIVE", -1
/* HOISTED */
);

var _hoisted_86 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "IN-ACTIVE"
}, "INACTIVE", -1
/* HOISTED */
);

var _hoisted_87 = [_hoisted_85, _hoisted_86];
var _hoisted_88 = {
  "class": "peer mR-10 form-control-sm"
};

var _hoisted_89 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Remarks: ");

var _hoisted_90 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

var _hoisted_91 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Input CATS (leave blank if you want to sync data of all employees)", -1
/* HOISTED */
);

var _hoisted_92 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");

  var _component_filtering = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("filtering");

  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  var _component_pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("pagination");

  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");

  var _component_ModalPass = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalPass");

  var _component_ModalStatus = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalStatus");

  var _component_ModalSync = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalSync");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_1];
    }),
    _: 1
    /* STABLE */

  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.search = $event;
    }),
    type: "text",
    "class": "form-control form-control-sm",
    placeholder: "Search..."
  }, null, 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Link v-if=\"can.canInsertUsers\" class=\"btn btn-primary btn-sm\" href=\"/users/create\">Add User</Link> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Link class=\"btn btn-primary btn-sm mL-2 text-white\" href=\"/user/employees/sync/employees/list\">Sync Employees</Link> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-primary btn-sm mL-2 text-white",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return $options.showFilter();
    })
  }, "Filter"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-primary btn-sm mL-2 text-white",
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return $options.showModalSync();
    })
  }, "Sync")])])]), $data.filter ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_filtering, {
    key: 0,
    onCloseFilter: _cache[12] || (_cache[12] = function ($event) {
      return $data.filter = false;
    })
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
          return _ctx.EmploymentStatus = $event;
        }),
        "class": "form-control",
        onChange: _cache[4] || (_cache[4] = function ($event) {
          return $options.filterData();
        })
      }, _hoisted_13, 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.EmploymentStatus]]), _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
          return _ctx.office_selected = $event;
        }),
        "class": "form-control",
        onChange: _cache[6] || (_cache[6] = function ($event) {
          return $options.getDivision();
        })
      }, [_hoisted_15, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.offices, function (office) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
          value: office.department_code
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(office.office), 9
        /* TEXT, PROPS */
        , _hoisted_16);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))], 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.office_selected]]), _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ division_selected }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
          return _ctx.division_selected = $event;
        }),
        "class": "form-control",
        onChange: _cache[8] || (_cache[8] = function ($event) {
          return $options.filterData();
        })
      }, [_hoisted_18, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.divisions, function (div) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
          value: div.division_code
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(div.division_name1), 9
        /* TEXT, PROPS */
        , _hoisted_19);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))], 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.division_selected]]), _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
          return $data.active_status = $event;
        }),
        "class": "form-control",
        onChange: _cache[10] || (_cache[10] = function ($event) {
          return $options.filterData();
        })
      }, [_hoisted_21, _hoisted_22, _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <option value=\"Regular\">Regular</option> ")], 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.active_status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ divisions }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <input type=\"text\" v-model=\"EmploymentStatus\" class=\"form-control\" @change=\"filterData()\"> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-sm btn-danger mT-5 text-white",
        onClick: _cache[11] || (_cache[11] = function () {
          return $options.clearFilter && $options.clearFilter.apply($options, arguments);
        })
      }, "Clear Filter")];
    }),
    _: 1
    /* STABLE */

  })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ auth }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_26, [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.users.data, function (user) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.empl_id), 1
    /* TEXT */
    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.employee_name), 1
    /* TEXT */
    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.employment_type_descr), 1
    /* TEXT */
    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.position_long_title), 1
    /* TEXT */
    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [user.division ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.division.division_name1), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [user.office ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_29, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.office.office), 1
    /* TEXT */
    )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" /ipcrsemestral2/{{user.empl_id_bcrypt}} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ user.credential.id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ auth.user.username }} ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [user.active_status == 'ACTIVE' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.active_status), 1
    /* TEXT */
    )) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_31, "INACTIVE"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_32, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [_hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li\n                                            v-if=\"$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'\">\n                                            <Link :href=\"`/ipcrsemestral/${user.id}/employees`\" class=\"dropdown-item\">\n                                            IPCR Targets\n                                            </Link>\n                                        </li> "), _ctx.$page.props.auth.user.name.empl_id != '2730' && _ctx.$page.props.auth.user.name.empl_id != '2960' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.showModalPass(user.credential.id, user.employee_name);
      }
    }, " Reset Password ", 8
    /* PROPS */
    , _hoisted_37)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2730' && _ctx.$page.props.auth.user.name.empl_id != '2960' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.showModalEmail(user.credential.username, user.credential.email, user.employee_name);
      }
    }, " Update email ", 8
    /* PROPS */
    , _hoisted_39)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li>\n                                            <a href=\"{{ route('impersonate', $user->id) }}\"></a>\n                                        </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" v-if=\"$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'\" "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.impersonate(user.credential.id, user.empl_id, $props.auth.user.username, user.employee_name);
      }
    }, " Impersonate ", 8
    /* PROPS */
    , _hoisted_40)]), _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '2960' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "dropdown-item",
      onClick: function onClick($event) {
        return $options.updateStatus(user.credential.id, user.employee_name, user.active_status);
      }
    }, " Update status ", 8
    /* PROPS */
    , _hoisted_42)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
      "class": "dropdown-item",
      href: "/ipcrsemestral2?value=".concat(user.empl_id_bcrypt)
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_43];
      }),
      _: 2
      /* DYNAMIC */

    }, 1032
    /* PROPS, DYNAMIC_SLOTS */
    , ["href"])])])])])]);
  }), 256
  /* UNKEYED_FRAGMENT */
  ))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" read the explanation in the Paginate.vue component "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <pagination :links=\"users.links\" /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
    next: $props.users.next_page_url,
    prev: $props.users.prev_page_url
  }, null, 8
  /* PROPS */
  , ["next", "prev"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(10 * ($props.users.current_page - 1) + 1), 1
  /* TEXT */
  ), _hoisted_46, $props.users.current_page !== $props.users.last_page ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_47, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.current_page * 10), 1
  /* TEXT */
  )) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_48, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.total), 1
  /* TEXT */
  )), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.total) + " results ", 1
  /* TEXT */
  )])])])]), $data.displayModal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Modal, {
    key: 1,
    onCloseModalEvent: $options.hideModal,
    title: "UPDATE EMAIL"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.my_name), 1
      /* TEXT */
      ), _hoisted_50, _hoisted_51, _hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Office: <u> {{ my_office }}</u><br> <br> "), _hoisted_53, _hoisted_54, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "email",
        "class": "form-class",
        "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
          return $data.my_email = $event;
        }),
        style: {
          "width": "calc(100% - 30px)",
          "/* Adjust width to match modal width with 15px padding on each side */\n    padding": "10px 15px"
        }
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.my_email]]), _hoisted_55, _hoisted_56, _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[14] || (_cache[14] = function ($event) {
          return $options.updateEmail($data.my_name);
        })
      }, "Update email"), _hoisted_58, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-danger text-white",
        onClick: _cache[15] || (_cache[15] = function () {
          return $options.hideModalDisplay && $options.hideModalDisplay.apply($options, arguments);
        })
      }, "Cancel"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex justify-content-center\">\n\n            </div> ")];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayModalPass ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_ModalPass, {
    key: 2,
    onCloseModalEvent: $options.hideModalPass,
    title: "RESET PASSWORD"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ form }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_59, [_hoisted_60, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "class": "form-control form-control-sm",
        "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
          return $data.reset_name = $event;
        }),
        disabled: ""
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.reset_name]]), _hoisted_61]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_62, [_hoisted_63, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "class": "form-control form-control-sm",
        "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
          return $data.requestor_name = $event;
        }),
        disabled: ""
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.requestor_name]]), !$data.requestor_name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_64, "Please use the search box below to select and click the requester's name.")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_65, [_hoisted_66, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "class": "form-control form-control-sm",
        "onUpdate:modelValue": _cache[18] || (_cache[18] = function ($event) {
          return $data.form.password_change_remarks = $event;
        }),
        disabled: !$data.requestor_name
      }, null, 8
      /* PROPS */
      , _hoisted_67), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.password_change_remarks]]), _hoisted_68]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-sm btn-primary mT-5 text-white",
        onClick: _cache[19] || (_cache[19] = function ($event) {
          return $options.resetPass($data.form.id, $data.reset_name, $data.requestor_name);
        }),
        disabled: !$data.requestor_name
      }, "Submit", 8
      /* PROPS */
      , _hoisted_69), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-sm btn-danger mT-5 text-white",
        onClick: _cache[20] || (_cache[20] = function () {
          return $options.cancelReset && $options.cancelReset.apply($options, arguments);
        })
      }, "Cancel"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_70, [_hoisted_71, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[21] || (_cache[21] = function ($event) {
          return $data.search = $event;
        }),
        type: "text",
        "class": "form-control form-control-sm",
        placeholder: "Search..."
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_72, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_73, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_74, [_hoisted_75, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.users.data, function (user) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
          onClick: function onClick($event) {
            return $options.SelectEmployee(user.empl_id, user.employee_name, user.is_admin);
          },
          style: {
            "cursor": "pointer"
          },
          onmouseover: "this.style.backgroundColor='gold'; this.style.color='red';",
          onmouseout: "this.style.backgroundColor=''; this.style.color='';"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.empl_id), 1
        /* TEXT */
        ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(user.employee_name), 1
        /* TEXT */
        ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td>{{ user.employment_type_descr }}</td> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td>{{ user.position_long_title }} </td> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td>\n                                    <div v-if=\"user.division\">{{ user.division.division_name1 }}</div>\n                                </td>\n                                <td>\n                                    <span v-if=\"user.office\">{{ user.office.office }}</span>\n                                    {{ user.credential.id }}\n                                    {{ user }}\n                                    {{ auth.user.username }}\n                                </td> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td style=\"text-align: right\">\n                                    <div class=\"dropdown dropstart\">\n                                        <button class=\"btn btn-secondary btn-sm action-btn\" type=\"button\"\n                                            id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">\n                                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\"\n                                                fill=\"currentColor\" class=\"bi bi-three-dots\" viewBox=\"0 0 16 16\">\n                                                <path\n                                                    d=\"M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z\" />\n                                            </svg>\n                                        </button>\n                                        <ul class=\"dropdown-menu action-dropdown\" aria-labelledby=\"dropdownMenuButton1\">\n                                            <li\n                                                v-if=\"$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'\">\n                                                <Link :href=\"`/ipcrsemestral/${user.id}/employees`\" class=\"dropdown-item\">\n                                                IPCR Targets\n                                                </Link>\n                                            </li>\n                                            <li\n                                                v-if=\"$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'\">\n\n                                                <button class=\"dropdown-item\"\n                                                    @click=\"showModalPass(user.credential.id, user.employee_name)\">\n                                                    Reset Password\n                                                </button>\n                                            </li>\n                                            <li\n                                                v-if=\"$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'\">\n                                                <button class=\"dropdown-item\"\n                                                    @click=\"showModalEmail(user.credential.username, user.credential.email, user.employee_name)\">\n                                                    Update email\n                                                </button>\n                                            </li>\n                                            <li>\n                                                <a href=\"{{ route('impersonate', $user->id) }}\"></a>\n                                            </li>\n                                            <li>\n                                                <button class=\"dropdown-item\"\n                                                    @click=\"impersonate(user.credential.id, user.empl_id, auth.user.username, user.employee_name)\">\n                                                    Impersonate\n                                                </button>\n                                            </li>\n\n                                        </ul>\n                                    </div>\n                                </td> ")], 8
        /* PROPS */
        , _hoisted_76);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_77, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_78, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" read the explanation in the Paginate.vue component "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <pagination :links=\"users.links\" /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
        next: $props.users.next_page_url,
        prev: $props.users.prev_page_url
      }, null, 8
      /* PROPS */
      , ["next", "prev"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(10 * ($props.users.current_page - 1) + 1), 1
      /* TEXT */
      ), _hoisted_79, $props.users.current_page !== $props.users.last_page ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_80, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.current_page * 10), 1
      /* TEXT */
      )) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_81, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.total), 1
      /* TEXT */
      )), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" of " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.users.total) + " results ", 1
      /* TEXT */
      )])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <multiselect :options=\"requestor_sel\" :searchable=\"true\" v-model=\"form.requestor_id\"\n                                            label=\"label\" track-by=\"label\" @close=\"selected_ipcr\">\n                                        </multiselect> ")];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displayStatusModal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_ModalStatus, {
    key: 3,
    onCloseModalEvent: $options.hideModalStat,
    title: "UPDATE EMPLOYEE STATUS"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_82, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "class": "form-control form-control-sm",
        "onUpdate:modelValue": _cache[22] || (_cache[22] = function ($event) {
          return $data.reset_name = $event;
        }),
        disabled: ""
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.reset_name]]), _hoisted_83, _hoisted_84, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "class": "form-select",
        "onUpdate:modelValue": _cache[23] || (_cache[23] = function ($event) {
          return $data.disp_active_stat = $event;
        })
      }, _hoisted_87, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.disp_active_stat]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_88, [_hoisted_89, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "class": "form-control form-control-sm",
        "onUpdate:modelValue": _cache[24] || (_cache[24] = function ($event) {
          return $data.form.password_change_remarks = $event;
        })
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.password_change_remarks]]), _hoisted_90]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[25] || (_cache[25] = function ($event) {
          return $options.updateStatusSave();
        })
      }, "UPDATE STATUS")];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.displaySyncModal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_ModalSync, {
    key: 4,
    onCloseModalEvent: $options.hideModalSync,
    title: "SYNC EMPLOYEE DATA"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_91, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ cats_num }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "text",
        "class": "form-control",
        "onUpdate:modelValue": _cache[26] || (_cache[26] = function ($event) {
          return $data.cats_num = $event;
        }),
        onInput: _cache[27] || (_cache[27] = function ($event) {
          return $data.cats_num = $event.target.value.replace(/\D/g, '');
        })
      }, null, 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.cats_num]]), _hoisted_92, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary text-white",
        onClick: _cache[28] || (_cache[28] = function ($event) {
          return $options.syncEmployeeData();
        })
      }, "SYNC"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-danger text-white",
        onClick: _cache[29] || (_cache[29] = function ($event) {
          return $options.hideModalSync();
        })
      }, "CANCEL"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" UPDATE STATUS OF: <input class=\"form-control form-control-sm\" v-model=\"reset_name\" disabled/><br>\n            EMPLOYEE STATUS:\n            <select class=\"form-select\" v-model=\"disp_active_stat\">\n                <option value=\"ACTIVE\">ACTIVE</option>\n                <option value=\"IN-ACTIVE\">INACTIVE</option>\n            </select>\n            <div class=\"peer mR-10 form-control-sm\">\n                Remarks: <input class=\"form-control form-control-sm\" v-model=\"form.password_change_remarks\" /><br>\n            </div>\n             ")];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["onCloseModalEvent"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ auth.user.name.id }} "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{  users }} ")])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58 ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
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
}, "Filtering", -1
/* HOISTED */
);

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-3ff68c94"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
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
  "class": "modal-dialog modal-l"
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
var _hoisted_7 = {
  "class": "modal-title",
  style: {
    "color": "#ffe819",
    "text-align": "center !important"
  }
};

var _hoisted_8 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "aria-hidden": "true"
  }, "×", -1
  /* HOISTED */
  );
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
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<button type=\"button\" class=\"btn btn-primary\" @click=\"saveChanges\">Save changes</button>\n                        <button type=\"button\" class=\"btn btn-secondary\" @click=\"closeModal\">Close</button>")], -1
  /* HOISTED */
  );
});

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.title), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
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
  }, _hoisted_9)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<p>Modal body text goes here.</p>\n                        <multiselect v-model=\"value\" :options=\"options\" mode=\"tags\"/>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default", {}, undefined, true)]), _hoisted_11])])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "pagination"
};
var _hoisted_2 = {
  "class": "page-item"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Previous");

var _hoisted_4 = {
  "class": "page-item"
};

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Next");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n            I intend to recreate a simple pagination [simplePaginate()] for performance purpose\r\n            read https://laravel.com/docs/8.x/pagination#simple-pagination\r\n\r\n            If you think you will not have huge dataset in the future you can use\r\n            the paginate() by uncommenting below and in the actual component.\r\n        "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Component\r\n            :is=\"link.url ? 'Link' : 'span'\"\r\n            v-for=\"link in links\"\r\n            :href=\"link.url\"\r\n            v-html=\"link.label\"\r\n            class=\"p-3 text-decoration-none\"\r\n            :class=\"{'text-muted' : !link.url, 'fw-bold' : link.active}\"\r\n        /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_2, [$props.prev ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": "page-link",
    href: $props.prev,
    "preserve-scroll": ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
    key: 1,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["page-link", {
      'text-muted': !$props.prev
    }])
  }, "Previous", 2
  /* CLASS */
  ))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_4, [$props.next ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": "page-link",
    href: $props.next,
    "preserve-scroll": ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_5];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
    key: 1,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["page-link", {
      'text-muted': !$props.next
    }])
  }, "Next", 2
  /* CLASS */
  ))])])]);
}

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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css ***!
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
___CSS_LOADER_EXPORT___.push([module.id, "\n/* Override default value of 'none' */\n.modal[data-v-3ff68c94] {\n    display: block;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_style_index_0_id_3ff68c94_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_style_index_0_id_3ff68c94_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_style_index_0_id_3ff68c94_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/Pages/Employees/All/Index.vue":
/*!****************************************************!*\
  !*** ./resources/js/Pages/Employees/All/Index.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_fc05acfe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=fc05acfe */ "./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe");
/* harmony import */ var _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js */ "./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Index_vue_vue_type_template_id_fc05acfe__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Employees/All/Index.vue"]])
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
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Filter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Filter.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/ModalSmall.vue":
/*!********************************************!*\
  !*** ./resources/js/Shared/ModalSmall.vue ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ModalSmall_vue_vue_type_template_id_3ff68c94_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true */ "./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true");
/* harmony import */ var _ModalSmall_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSmall.vue?vue&type=script&lang=js */ "./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js");
/* harmony import */ var _ModalSmall_vue_vue_type_style_index_0_id_3ff68c94_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css */ "./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css");
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_ModalSmall_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_ModalSmall_vue_vue_type_template_id_3ff68c94_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-3ff68c94"],['__file',"resources/js/Shared/ModalSmall.vue"]])
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
/* harmony import */ var C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Pagination_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Pagination.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=script&lang=js");
 

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

/***/ "./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModalSmall.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=script&lang=js");
 

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

/***/ "./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe":
/*!**********************************************************************************!*\
  !*** ./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_fc05acfe__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_fc05acfe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=template&id=fc05acfe */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Employees/All/Index.vue?vue&type=template&id=fc05acfe");


/***/ }),

/***/ "./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_template_id_09f80c58__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=template&id=09f80c58 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=template&id=09f80c58");


/***/ }),

/***/ "./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true":
/*!**************************************************************************************!*\
  !*** ./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_template_id_3ff68c94_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_template_id_3ff68c94_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=template&id=3ff68c94&scoped=true");


/***/ }),

/***/ "./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14":
/*!**************************************************************************!*\
  !*** ./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14 ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_7ed7fa14__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Pagination.vue?vue&type=template&id=7ed7fa14 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Pagination.vue?vue&type=template&id=7ed7fa14");


/***/ }),

/***/ "./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css":
/*!************************************************************************************!*\
  !*** ./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Filter_vue_vue_type_style_index_0_id_09f80c58_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Filter.vue?vue&type=style&index=0&id=09f80c58&lang=css");


/***/ }),

/***/ "./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css":
/*!****************************************************************************************************!*\
  !*** ./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModalSmall_vue_vue_type_style_index_0_id_3ff68c94_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/ModalSmall.vue?vue&type=style&index=0&id=3ff68c94&scoped=true&lang=css");


/***/ })

}]);