<<<<<<< HEAD
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/app"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    showing: {
      required: true,
      type: Boolean
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Shared_Nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/Shared/Nav */ "./resources/js/Shared/Nav.vue");
/* harmony import */ var _Shared_Footer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/Shared/Footer */ "./resources/js/Shared/Footer.vue");
/* harmony import */ var _Shared_Sidebar_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/Shared/Sidebar.vue */ "./resources/js/Shared/Sidebar.vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Nav: _Shared_Nav__WEBPACK_IMPORTED_MODULE_0__["default"],
    Footer: _Shared_Footer__WEBPACK_IMPORTED_MODULE_1__["default"],
    Sidebar: _Shared_Sidebar_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      // loading: false
    };
  } // setup() {
  //     const isLoading = inject('isLoading')
  //     return { isLoading }
  // }
  // provide() {
  //     // Allow child components to access a global loading toggle
  //     return {
  //     showLoading: () => this.loading = true,
  //     hideLoading: () => this.loading = false
  //     }
  // }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia */ "./node_modules/@inertiajs/inertia/dist/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      isActive: true
    };
  },
  methods: {
    logout: function logout() {
      // this.update_verified();
      // this.$inertia.post('/logout')
      // location.href = '/'
      this.$inertia.post('/logout').then(function (response) {
        console.log(response.data.message); // Should log "Logged out"
        location.href = '/';
      })["catch"](function (error) {
        console.error('Logout failed:', error);
      });
    },
    // this.$inertia.post('/logout', {}, {
    //     onFinish: () => {
    //         // Redirect to the homepage after the logout request completes
    //         window.location.href = '/';
    //     }
    // });
    update_verified: function update_verified() {
      //alert(auth.user.name);
      axios.patch('/users/update_verified_at');
    },
    toggleSidebar: function toggleSidebar() {
      this.isActive = !this.isActive;
    },
    impersonateLeave: function impersonateLeave() {
      var _this = this;
      // if (confirm("Are you sure you want to leave?")) {
      //     this.$inertia.get(`/impersonate/leave`)
      //         .then(() => {
      //             // Redirect or handle success response as needed
      //             window.location.reload(); // Optional: reload to apply changes
      //         })
      //         .catch(error => {
      //             console.error('Error during impersonation:', error);
      //         });
      // }
      this.$swal({
        title: "Leave impersonation",
        text: "Are you sure you want to leave?",
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
          _this.$inertia.get("/impersonate/leave", {}, {
            onSuccess: function onSuccess() {
              // Redirect or handle success response as needed
              window.location.reload(); // Optional: reload to apply changes
            },
            onError: function onError(errors) {
              console.error('Error during impersonation:', errors);
            }
          });
        } else {
          // this.$swal("Impersonation cancelled!", {
          //     title: "Impersonation cancelled",
          //     icon: "info",
          // });
        }
      });
      // if (confirm("Are you sure you want to leave?")) {
      //     this.$inertia.get(`/impersonate/leave`, {}, {
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
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  watch: {
    '$page.props.flash': {
      handler: function handler(value) {
        if (value.message) {
          this.$swal({
            icon: 'success',
            title: value.message,
            timer: 5000,
            // Set duration
            timerProgressBar: true,
            customClass: {
              popup: "bg-gradient-success"
            }
          });
        } else if (value.error) {
          this.$swal({
            icon: 'error',
            title: value.error,
            timer: 5000,
            // Set duration
            timerProgressBar: true,
            customClass: {
              popup: "bg-gradient-danger"
            }
          });
        } else if (value.info) {
          this.$swal({
            icon: 'info',
            title: value.info,
            timer: 5000,
            // Set duration
            timerProgressBar: true,
            customClass: {
              popup: "bg-gradient-info"
            }
          });
        } else if (value.deleted) {
          this.$swal({
            icon: 'warning',
            title: value.deleted,
            timer: 5000,
            // Set duration
            timerProgressBar: true,
            customClass: {
              popup: "bg-gradient-deleted"
            }
          });
        }
      },
      deep: true
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia */ "./node_modules/@inertiajs/inertia/dist/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mounted: function mounted() {
    $(function () {
      $(".sidebar .sidebar-menu li a").on("click", function () {
        var $this = $(this);
        if ($this.parent().hasClass("open")) {
          $this.parent().children(".dropdown-menu").slideUp(200, function () {
            $this.parent().removeClass("open");
          });
        } else {
          $this.parent().parent().children("li.open").children(".dropdown-menu").slideUp(200);
          $this.parent().parent().children("li.open").children("a").removeClass("open");
          $this.parent().parent().children("li.open").removeClass("open");
          $this.parent().children(".dropdown-menu").slideDown(200, function () {
            $this.parent().addClass("open");
          });
        }
      });

      // Sidebar Activity Class
      var sidebarLinks = $(".sidebar").find(".sidebar-link");
      sidebarLinks.each(function (index, el) {
        $(el).removeClass("active");
      }).filter(function () {
        var href = $(this).attr("href");
        var pattern = href[0] === "/" ? href.substr(1) : href;
        return pattern === window.location.pathname.substr(1);
      }).addClass("active");

      // ٍSidebar Toggle
      $(".sidebar-toggle").on("click", function (e) {
        $("body").toggleClass("is-collapsed");
        e.preventDefault();
      });
    });
  },
  methods: {
    gotoemp: function gotoemp() {
      // alert('my_id: '+my_id+" "+empl_id);
      // alert("go to")
      _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_0__.Inertia.get("/employees/a/l/l");
      // {
      // params: {
      //     sem_id: my_id,
      //     empl_id: empl_id
      // }
      // }).then((response) => {
      //     // this.ipcr_targets = response.data;
      // }).catch((error) => {
      //     // console.error(error);
      // });
      // this.displayModal = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  key: 0,
  "class": "fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-75"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return $props.showing ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, " The modal will go here. ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12 ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "bdT ta-c p-30 lh-0 fsz-sm",
  style: {
    "background-color": "#4d3102",
    "color": "#fff"
  }
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $App Screen Footer ### "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("footer", _hoisted_1, _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    style: {
      "color": "#FFD700"
    }
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Developed by "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    href: "https://davaodeoro.gov.ph/"
  }, "PICTO")], -1 /* CACHED */)]))], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086 ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "page-container"
};
var _hoisted_2 = {
  "class": "main-content bgc-grey-100"
};
var _hoisted_3 = {
  id: "mainContent"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Sidebar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Sidebar");
  var _component_Notification = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Notification");
  var _component_Nav = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Nav");
  var _component_Footer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Footer");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Sidebar), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Notification), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Nav), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Loading :active=\"$isLoading\" :is-full-page=\"true\" /> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default")])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Footer)])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7 ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "header navbar"
};
var _hoisted_2 = {
  "class": "header-container",
  id: "sidebar-toggle",
  href: "javascript:void(0);",
  style: {
    "min-width": "320px",
    "background-color": "#452b02",
    "color": "black"
  }
};
var _hoisted_3 = {
  "class": "nav-left"
};
var _hoisted_4 = {
  key: 0,
  "class": "nav-left"
};
var _hoisted_5 = {
  id: "sidebar-toggle",
  "class": "sidebar-toggle"
};
var _hoisted_6 = {
  "class": "text-danger"
};
var _hoisted_7 = {
  "class": "nav-right"
};
var _hoisted_8 = {
  "class": "dropdown"
};
var _hoisted_9 = {
  href: "",
  "class": "dropdown-toggle no-after peers fxw-nw ai-c lh-1",
  "data-bs-toggle": "dropdown"
};
var _hoisted_10 = {
  "class": "peer mR-10"
};
var _hoisted_11 = ["src"];
var _hoisted_12 = {
  "class": "peer"
};
var _hoisted_13 = {
  "class": "fsz-sm",
  style: {
    "color": "#FFD700",
    "font-weight": "bold"
  }
};
var _hoisted_14 = {
  "class": "dropdown-menu fsz-sm dropdown-menu-c"
};
var _hoisted_15 = {
  key: 1,
  "class": "nav-right"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    id: "sidebar-toggle",
    "class": "sidebar-toggle",
    href: "javascript:void(0);",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.toggleSidebar && $options.toggleSidebar.apply($options, arguments);
    })
  }, _cache[3] || (_cache[3] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "20",
    height: "20",
    fill: "#FFD700",
    "class": "bi bi-list",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
  })], -1 /* CACHED */)])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ isActive }} ")]), _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
    "class": "search-input"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "form-control",
    type: "text",
    placeholder: "Search..."
  })], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" dsdasdasd {{ $page.props.auth.impersonating }} "), _ctx.$page.props.auth.impersonating === 'yes' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("ul", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_6, [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("You are impersonating ")), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.user.name.employee_name), 1 /* TEXT */)])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <ul class=\"nav-left\" v-if=\"$page.props.auth.shoud_update_password === 'yes'\">\n                <li>\n                    <a id=\"sidebar-toggle\" class=\"sidebar-toggle\">\n                        <span class=\"text-danger\">You are required update your password every six months.\n                            <b>\n                                <u>\n                                    {{\n                        $page.props.auth.user.name.shoud_update_password\n                    }}\n                                </u>\n                            </b>\n                            Type your current password as the \"old password\"\n                        </span>\n                    </a>\n\n                </li>\n            </ul> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"notifications dropdown\">\n                    <span class=\"counter bgc-blue\">3</span>\n                    <a href=\"\" class=\"dropdown-toggle no-after\" data-bs-toggle=\"dropdown\"><svg\n                            xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-bell\"\n                            viewBox=\"0 0 16 16\">\n                            <path\n                                d=\"M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z\" />\n                        </svg></a>\n                    <ul class=\"dropdown-menu\">\n                        <li class=\"pX-20 pY-15 bdB\">\n                            <i class=\"ti-email pR-10\"></i>\n                            <span class=\"fsz-sm fw-600 c-grey-900\">Emails</span>\n                        </li>\n                        <li>\n                            <ul class=\"\n                                    ovY-a\n                                    pos-r\n                                    scrollable\n                                    lis-n\n                                    p-0\n                                    m-0\n                                    fsz-sm\n                                \">\n                                <li>\n                                    <a href=\"\" class=\"\n                                            peers\n                                            fxw-nw\n                                            td-n\n                                            p-20\n                                            bdB\n                                            c-grey-800\n                                            cH-blue\n                                            bgcH-grey-100\n                                        \">\n                                        <div class=\"peer mR-15\">\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/1.jpg\"\n                                                alt=\"\" />\n                                        </div>\n                                        <div class=\"peer peer-greed\">\n                                            <div>\n                                                <div class=\"\n                                                        peers\n                                                        jc-sb\n                                                        fxw-nw\n                                                        mB-5\n                                                    \">\n                                                    <div class=\"peer\">\n                                                        <p class=\"\n                                                                fw-500\n                                                                mB-0\n                                                            \">\n                                                            John Doe\n                                                        </p>\n                                                    </div>\n                                                    <div class=\"peer\">\n                                                        <small class=\"\n                                                                fsz-xs\n                                                            \">5 mins\n                                                            ago</small>\n                                                    </div>\n                                                </div>\n                                                <span class=\"\n                                                        c-grey-600\n                                                        fsz-sm\n                                                    \">Want to create your\n                                                    own customized data\n                                                    generator for your\n                                                    app...</span>\n                                            </div>\n                                        </div>\n                                    </a>\n                                </li>\n                                <li>\n                                    <a href=\"\" class=\"\n                                            peers\n                                            fxw-nw\n                                            td-n\n                                            p-20\n                                            bdB\n                                            c-grey-800\n                                            cH-blue\n                                            bgcH-grey-100\n                                        \">\n                                        <div class=\"peer mR-15\">\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/2.jpg\"\n                                                alt=\"\" />\n                                        </div>\n                                        <div class=\"peer peer-greed\">\n                                            <div>\n                                                <div class=\"\n                                                        peers\n                                                        jc-sb\n                                                        fxw-nw\n                                                        mB-5\n                                                    \">\n                                                    <div class=\"peer\">\n                                                        <p class=\"\n                                                                fw-500\n                                                                mB-0\n                                                            \">\n                                                            Moo Doe\n                                                        </p>\n                                                    </div>\n                                                    <div class=\"peer\">\n                                                        <small class=\"\n                                                                fsz-xs\n                                                            \">15 mins\n                                                            ago</small>\n                                                    </div>\n                                                </div>\n                                                <span class=\"\n                                                        c-grey-600\n                                                        fsz-sm\n                                                    \">Want to create your\n                                                    own customized data\n                                                    generator for your\n                                                    app...</span>\n                                            </div>\n                                        </div>\n                                    </a>\n                                </li>\n                                <li>\n                                    <a href=\"\" class=\"\n                                            peers\n                                            fxw-nw\n                                            td-n\n                                            p-20\n                                            bdB\n                                            c-grey-800\n                                            cH-blue\n                                            bgcH-grey-100\n                                        \">\n                                        <div class=\"peer mR-15\">\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/3.jpg\"\n                                                alt=\"\" />\n                                        </div>\n                                        <div class=\"peer peer-greed\">\n                                            <div>\n                                                <div class=\"\n                                                        peers\n                                                        jc-sb\n                                                        fxw-nw\n                                                        mB-5\n                                                    \">\n                                                    <div class=\"peer\">\n                                                        <p class=\"\n                                                                fw-500\n                                                                mB-0\n                                                            \">\n                                                            Lee Doe\n                                                        </p>\n                                                    </div>\n                                                    <div class=\"peer\">\n                                                        <small class=\"\n                                                                fsz-xs\n                                                            \">25 mins\n                                                            ago</small>\n                                                    </div>\n                                                </div>\n                                                <span class=\"\n                                                        c-grey-600\n                                                        fsz-sm\n                                                    \">Want to create your\n                                                    own customized data\n                                                    generator for your\n                                                    app...</span>\n                                            </div>\n                                        </div>\n                                    </a>\n                                </li>\n                            </ul>\n                        </li>\n                        <li class=\"pX-20 pY-15 ta-c bdT\">\n                            <span><a href=\"email.html\" class=\"\n                                        c-grey-600\n                                        cH-blue\n                                        fsz-sm\n                                        td-n\n                                    \">View All Email\n                                    <i class=\"\n                                            fs-xs\n                                            ti-angle-right\n                                            mL-10\n                                        \"></i></a></span>\n                        </li>\n                    </ul>\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("*********************************************"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"dropdown\">\n                    <a href=\"\" class=\"\n                            dropdown-toggle\n                            no-after\n                            peers\n                            fxw-nw\n                            ai-c\n                            lh-1\n                        \" data-bs-toggle=\"dropdown\">\n                        <div class=\"peer mR-10\">\n\n                            <img class=\"w-2r bdrs-50p\" :src=\"$page.props.auth.user.photo\" alt=\"\" />\n                        </div>\n                        <div class=\"peer\">\n                            <span class=\"fsz-sm c-grey-900\">{{ $page.props.auth.user.name.employee_name }}</span>\n                        </div>\n                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\"\n                            class=\"bi bi-caret-down-fill mL-5\" viewBox=\"0 0 16 16\">\n                            <path\n                                d=\"M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z\" />\n                        </svg>\n                    </a>\n                    <ul class=\"dropdown-menu fsz-sm dropdown-menu-c\">\n                        <li>\n                            <Link href=\"/users/settings\" class=\"\n                                    d-b\n                                    td-n\n                                    pY-5\n                                    bgcH-grey-100\n                                    c-grey-700\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\n                                class=\"bi bi-sliders2 mR-10\" viewBox=\"0 0 16 16\">\n                                <path fill-rule=\"evenodd\"\n                                    d=\"M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z\" />\n                            </svg>\n                            <span>Setting</span></Link>\n                        </li>\n                        <li>\n                            <Link href=\"/users/change-password\" class=\"\n                                    d-b\n                                    td-n\n                                    pY-5\n                                    bgcH-grey-100\n                                    c-grey-700\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\n                                class=\"bi bi-person-bounding-box mR-10\" viewBox=\"0 0 16 16\">\n                                <path\n                                    d=\"M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z\" />\n                                <path d=\"M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z\" />\n                            </svg>\n                            <span> Change Password</span></Link>\n                        </li>\n                        <li role=\"separator\" class=\"divider\"></li>\n                        <li>\n                            <a @click=\"logout()\" href=\"\" class=\"\n                                    d-b\n                                    td-n\n                                    pY-5\n                                    bgcH-grey-100\n                                    c-grey-700\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\n                                    class=\"bi bi-box-arrow-right mR-10\" viewBox=\"0 0 16 16\">\n                                    <path fill-rule=\"evenodd\"\n                                        d=\"M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z\" />\n                                    <path fill-rule=\"evenodd\"\n                                        d=\"M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z\" />\n                                </svg>\n                                <span> Logout</span></a>\n                        </li>\n                    </ul>\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("*********************************************"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li v-if=\"$page.props.auth.impersonating === 'yes'\" class=\"dropdown\">\n\n                    <a href=\"/impersonate/leave\" class=\"\n                            dropdown-toggle\n                            no-after\n                            peers\n                            fxw-nw\n                            ai-c\n                            lh-1\n                        \" data-bs-toggle=\"dropdown\">\n\n                        <h5>Leave</h5>\n\n                    </a>\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    "class": "w-2r bdrs-50p",
    src: _ctx.$page.props.auth.user.photo,
    alt: ""
  }, null, 8 /* PROPS */, _hoisted_11)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.user.name.employee_name), 1 /* TEXT */)]), _cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "12",
    height: "12",
    fill: "currentColor",
    "class": "bi bi-caret-down-fill mL-5",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    d: "M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"
  })], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/users/settings",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[7] || (_cache[7] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "14",
        height: "14",
        fill: "currentColor",
        "class": "bi bi-sliders2 mR-10",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "fill-rule": "evenodd",
        d: "M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"
      })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Setting", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [7]
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/users/change-password",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "14",
        height: "14",
        fill: "currentColor",
        "class": "bi bi-person-bounding-box mR-10",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
      })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Change Password", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [8]
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/email/change",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[9] || (_cache[9] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "14",
        height: "14",
        fill: "currentColor",
        "class": "bi bi-envelope-at-fill",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"
      })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Change Email", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [9]
  })]), _cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
    role: "separator",
    "class": "divider"
  }, null, -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return $options.logout();
    }),
    href: "",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, _cache[10] || (_cache[10] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "14",
    height: "14",
    fill: "currentColor",
    "class": "bi bi-box-arrow-right mR-10",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"
  })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Logout", -1 /* CACHED */)]))])])])]), _ctx.$page.props.auth.impersonating === 'yes' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("u", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    id: "sidebar-toggle",
    "class": "sidebar-toggled",
    href: "javascript:void(0);",
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.impersonateLeave && $options.impersonateLeave.apply($options, arguments);
    })
  }, _cache[12] || (_cache[12] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "btn btn-danger text-white"
  }, "LEAVE", -1 /* CACHED */)])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ isActive }} ")])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "position-fixed top-0 end-0 p-3",
  style: {
    "z-index": "1000"
  }
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "toast align-items-center",
    role: "alert",
    "aria-atomic": "true",
    "aria-live": "polite",
    "data-bs-autohide": "true",
    "data-bs-delay": "5000"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-success\" v-if=\"$page.props.flash.message !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #94ffb0;\">\r\n                        <path\r\n                            d=\"M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223Z\" />\r\n                        <path\r\n                            d=\"M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                        <path\r\n                            d=\"M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                        <path\r\n                            d=\"M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.message }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-danger\" v-if=\"$page.props.flash.error !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #FF5733;\">\r\n                        <path\r\n                            d=\"M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z\" />\r\n                        <path\r\n                            d=\"M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z\" />\r\n                    </svg>\r\n                    &nbsp;<b>{{ $page.props.flash.error }}</b>\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-info\" v-if=\"$page.props.flash.info !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #b8f8ff;\">\r\n                        <path\r\n                            d=\"M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Zm3.631-4.538c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.info }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-deleted\" v-if=\"$page.props.flash.deleted !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #f46c89;\">\r\n                        <path\r\n                            d=\"M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.deleted }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("**********************"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-success\" v-if=\"$page.props.flash.message !== null\">\r\n                <div class=\"toast-body\">\r\n                    {{$page.props.flash.message}}\r\n            </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div>\r\n\r\n            <div class=\"d-flex text-white bg-danger\" v-if=\"$page.props.flash.error !== null\">\r\n                <div class=\"toast-body\">\r\n                    {{$page.props.flash.error}}\r\n            </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> ")], -1 /* CACHED */)]));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "sidebar"
};
var _hoisted_2 = {
  "class": "sidebar-inner"
};
var _hoisted_3 = {
  "class": "sidebar-menu scrollable pos-r"
};
var _hoisted_4 = {
  "class": "nav-item mT-30 actived"
};
var _hoisted_5 = {
  "class": "nav-item dropdown"
};
var _hoisted_6 = {
  "class": "dropdown-menu"
};
var _hoisted_7 = {
  "class": "title"
};
var _hoisted_8 = {
  key: 0
};
var _hoisted_9 = {
  key: 1
};
var _hoisted_10 = {
  key: 2
};
var _hoisted_11 = {
  key: 3
};
var _hoisted_12 = {
  key: 4
};
var _hoisted_13 = {
  key: 5
};
var _hoisted_14 = {
  key: 6
};
var _hoisted_15 = {
  "class": "nav-item"
};
var _hoisted_16 = {
  "class": "nav-item"
};
var _hoisted_17 = {
  key: 0,
  "class": "nav-item"
};
var _hoisted_18 = {
  key: 1,
  "class": "nav-item"
};
var _hoisted_19 = {
  key: 2,
  "class": "nav-item"
};
var _hoisted_20 = {
  key: 3,
  "class": "nav-item"
};
var _hoisted_21 = {
  "class": "nav-item dropdown"
};
var _hoisted_22 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};
var _hoisted_23 = {
  key: 0,
  "class": "text-danger strong"
};
var _hoisted_24 = {
  "class": "dropdown-menu"
};
var _hoisted_25 = {
  "class": "nav-item dropdown"
};
var _hoisted_26 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};
var _hoisted_27 = {
  "class": "title"
};
var _hoisted_28 = {
  key: 0,
  "class": "text-danger strong"
};
var _hoisted_29 = {
  "class": "dropdown-menu"
};
var _hoisted_30 = {
  "class": "nav-item dropdown"
};
var _hoisted_31 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};
var _hoisted_32 = {
  "class": "title"
};
var _hoisted_33 = {
  key: 0,
  "class": "text-danger strong"
};
var _hoisted_34 = {
  "class": "dropdown-menu"
};
var _hoisted_35 = {
  "class": "title"
};
var _hoisted_36 = {
  key: 0,
  "class": "text-danger strong"
};
var _hoisted_37 = {
  "class": "title"
};
var _hoisted_38 = {
  key: 0,
  "class": "text-danger strong"
};
var _hoisted_39 = {
  key: 4,
  "class": "nav-item dropdown"
};
var _hoisted_40 = {
  "class": "dropdown-menu"
};
var _hoisted_41 = {
  key: 0
};
var _hoisted_42 = {
  key: 1
};
var _hoisted_43 = {
  key: 2
};
var _hoisted_44 = {
  key: 3
};
var _hoisted_45 = {
  key: 4
};
var _hoisted_46 = {
  key: 5
};
var _hoisted_47 = {
  key: 6
};
var _hoisted_48 = {
  "class": "nav-item"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $Sidebar Header ### "), _cache[35] || (_cache[35] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"sidebar-logo\" data-v-f6a89ea0><div class=\"peers ai-c fxw-nw\" data-v-f6a89ea0><div class=\"peer peer-greed\" data-v-f6a89ea0><a class=\"sidebar-link td-n\" href=\"/\" data-v-f6a89ea0><div class=\"peers ai-c fxw-nw\" data-v-f6a89ea0><div class=\"peer\" data-v-f6a89ea0><div class=\"logo\" data-v-f6a89ea0><img src=\"/images/logo.png\" alt=\"\" class=\"img-fluid p-5\" data-v-f6a89ea0></div></div><div class=\"peer peer-greed\" data-v-f6a89ea0><h5 class=\"lh-1 mB-0 logo-text\" data-v-f6a89ea0><span style=\"color:#FFD700;font-size:medium;\" data-v-f6a89ea0>  Performance Management <!-- {{ $page.props.auth.user.name.position_long_title }} --></span></h5></div></div></a></div><div class=\"peer\" data-v-f6a89ea0><div class=\"mobile-toggle sidebar-toggle\" data-v-f6a89ea0><a href=\"\" class=\"td-n\" data-v-f6a89ea0><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"black\" class=\"bi bi-list\" viewBox=\"0 0 16 16\" data-v-f6a89ea0><path fill-rule=\"evenodd\" d=\"M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z\" data-v-f6a89ea0></path></svg></a><!-- &lt;div class=&quot;text-white&quot;&gt;gfgdgdfg&lt;/div&gt; --></div></div></div></div>", 1)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $Sidebar Menu ### "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": "sidebar-link",
    href: "/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "20",
        height: "20",
        fill: "currentColor",
        "class": "bi bi-house-door",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Dashboard", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [0]
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("TARGETS"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_5, [_cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<a class=\"dropdown-toggle\" href=\"javascript:void(0);\" data-v-f6a89ea0><span class=\"icon-holder\" data-v-f6a89ea0><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-bullseye\" viewBox=\"0 0 16 16\" data-v-f6a89ea0><path d=\"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16\" data-v-f6a89ea0></path><path d=\"M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10m0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12\" data-v-f6a89ea0></path><path d=\"M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8\" data-v-f6a89ea0></path><path d=\"M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0\" data-v-f6a89ea0></path></svg></span><span class=\"title\" data-v-f6a89ea0>Targets</span><span class=\"arrow\" data-v-f6a89ea0><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-right\" viewBox=\"0 0 16 16\" data-v-f6a89ea0><path fill-rule=\"evenodd\" d=\"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z\" data-v-f6a89ea0></path></svg></span></a>", 1)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/ipcrsemestral/".concat(_ctx.$page.props.auth.user.name.id, "/direct")
    }]),
    href: "/ipcrsemestral/".concat(_ctx.$page.props.auth.user.name.id, "/direct")
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" IPCR Targets {{$page.props.auth.pcr_type}} "), _ctx.$page.props.auth.pcr_type === 'div' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_8, "DPCR Targets")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'hdiv' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_9, "DPCR Targets (Hospital)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'emp' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, "IPCR Targets")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'hemp' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_11, "IPCR Targets (Hospital)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'sec' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_12, "SPCR Targets")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'hsec' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, "SPCR Targets (Hospital)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.pcr_type === 'hos' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_14, "HPCR Targets (Hospital)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["href", "class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/probationary/temporary/individual/targets/list'
    }]),
    href: "/probationary/temporary/individual/targets/list"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[1] || (_cache[1] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Probationary/Temporary", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [1]
  }, 8 /* PROPS */, ["class"])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/Daily_Accomplishment"
    }]),
    href: "/Daily_Accomplishment"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[3] || (_cache[3] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-calendar-event-fill",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Daily Accomplishment", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [3]
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/monthly-accomplishment"
    }]),
    href: "/monthly-accomplishment/r"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[4] || (_cache[4] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-clipboard-check-fill",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Accomplishment", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [4]
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" /monthly-accomplishment/r "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" $page.props.auth.user.salary_grade >= 18 "), _ctx.$page.props.auth.user.ao_status == '1' || _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' || _ctx.$page.props.auth.user.name.empl_id == '11159' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/summary-rating"
    }]),
    href: "/summary-rating"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[5] || (_cache[5] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-bar-chart-line-fill",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Summary of Ratings", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [5]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/offices"
    }]),
    href: "/offices"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[6] || (_cache[6] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-bank2",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Offices", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [6]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"nav-item\">\r\n                    <Link class=\"sidebar-link\" :href=\"`/probationary/temporary`\">\r\n                        <span></span>\r\n                        <span class=\"icon-holder\">\r\n                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-clipboard-check-fill\" viewBox=\"0 0 16 16\">\r\n                            <path d=\"M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z\"/>\r\n                            <path d=\"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z\"/>\r\n                            </svg>\r\n                        </span>\r\n                        <span class=\"title\">Probationary/Temporary</span>\r\n                    </Link>\r\n                </li> "), _ctx.$page.props.auth.user.name.department_code == '26' || _ctx.$page.props.auth.user.name.department_code == '03' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/probationary/'
    }]),
    href: "/probationary/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[7] || (_cache[7] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-send-check-fill",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, " Probationary/Temporary ", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [7]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n                <li class=\"nav-item mT-30 actived\">\r\n                    <Link class=\"sidebar-link\" href=\"/\"\r\n                        ><span class=\"icon-holder\">\r\n\r\n                        </span\r\n                        >\r\n                        <span class=\"title\">Personnel</span></Link\r\n                    >\r\n                </li>\r\n                "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n                <li class=\"nav-item\">\r\n                    <Link class=\"sidebar-link\" href=\"/posts\"\r\n                        ><span class=\"icon-holder\"\r\n                            ><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-file-earmark-post\" viewBox=\"0 0 16 16\">\r\n                              <path d=\"M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z\"/>\r\n                              <path d=\"M4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7zm0-3a.5.5 0 0 1 .5-.5H7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5z\"/>\r\n                            </svg>\r\n                        </span\r\n                        ><span class=\"title\">Posts</span></Link\r\n                    >\r\n                </li>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("ALL REPORTS"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("Users  "), _ctx.$page.props.auth.user.salary_grade >= 18 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/employees'
    }]),
    href: "/employees"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */)), _cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "20",
        height: "20",
        fill: "currentColor",
        "class": "bi bi-people",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        d: "M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
      })])], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ $page.props.auth.user.salary_grade }} "), _cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Employees ", -1 /* CACHED */))];
    }),
    _: 1 /* STABLE */,
    __: [8, 9, 10]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("Review/Approve"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_22, [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "icon-holder"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "20",
    height: "20",
    fill: "currentColor",
    "class": "bi bi-hand-thumbs-up-fill",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    d: "M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"
  })])], -1 /* CACHED */)), _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "title"
  }, "Review/Approve", -1 /* CACHED */)), _ctx.$page.props.auth.targets >= 1 || _ctx.$page.props.auth.sem >= 1 || _ctx.$page.props.auth.month >= 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, " (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.targets + _ctx.$page.props.auth.sem + _ctx.$page.props.auth.month) + ")", 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "arrow"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "16",
    height: "16",
    fill: "currentColor",
    "class": "bi bi-chevron-right",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
  })])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_27, [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Targets ")), _ctx.$page.props.auth.targets ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.targets) + ")", 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "arrow"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "16",
    height: "16",
    fill: "currentColor",
    "class": "bi bi-chevron-right",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
  })])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/review/approve"
    }]),
    href: "/review/approve"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[16] || (_cache[16] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "  For Approval", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [16]
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/targets"
    }]),
    href: "/acted/particulars/targets"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[17] || (_cache[17] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "  Acted Target", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [17]
  }, 8 /* PROPS */, ["class"])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_32, [_cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Accomplishment ")), _ctx.$page.props.auth.sem >= 1 || _ctx.$page.props.auth.month >= 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, " (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.sem + _ctx.$page.props.auth.month) + ")", 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _cache[19] || (_cache[19] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "arrow"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "16",
    height: "16",
    fill: "currentColor",
    "class": "bi bi-chevron-right",
    viewBox: "0 0 16 16"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "fill-rule": "evenodd",
    d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
  })])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li>\r\n                                    <Link class=\"sidebar-link\" :href=\"`/approve/accomplishments`\"\r\n                                        :class=\"{ 'active': $page.url === `/approve/accomplishments` }\">\r\n                                    <span class=\"title\">&nbsp;&nbsp;Monthly\r\n                                        <span v-if=\"$page.props.auth.month\" class=\"text-danger strong\"> <b>({{\r\n                                $page.props.auth.month }})</b> </span>\r\n                                    </span>\r\n                                    </Link>\r\n                                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/ipcr-app/accomplishments"
    }]),
    href: "/ipcr-app/accomplishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_35, [_cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  Monthly ")), _ctx.$page.props.auth.month ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.month) + ")", 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/accomp/lishments/monthly"
    }]),
    href: "/acted/particulars/accomp/lishments/monthly"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[21] || (_cache[21] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "  Acted (monthly)", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [21]
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/approve/semestral-accomplishments"
    }]),
    href: "/approve/semestral-accomplishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_37, [_cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  Semestral ")), _ctx.$page.props.auth.sem ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.sem) + ")", 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/accomp/lishments"
    }]),
    href: "/acted/particulars/accomp/lishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[23] || (_cache[23] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "  Acted (semestral)", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [23]
  }, 8 /* PROPS */, ["class"])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("PERFORMANCE STANDARD"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    "), _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' || _ctx.$page.props.auth.user.name.empl_id == '2089' || _ctx.$page.props.auth.user.name.empl_id == '8749' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_39, [_cache[33] || (_cache[33] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<a class=\"dropdown-toggle\" href=\"javascript:void(0);\" data-v-f6a89ea0><span class=\"icon-holder\" data-v-f6a89ea0><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-menu-button-wide-fill\" viewBox=\"0 0 16 16\" data-v-f6a89ea0><path d=\"M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h13A1.5 1.5 0 0 0 16 3.5v-2A1.5 1.5 0 0 0 14.5 0zm1 2h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m9.927.427A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5\" data-v-f6a89ea0></path></svg></span><span class=\"title\" data-v-f6a89ea0>Utilities</span><span class=\"arrow\" data-v-f6a89ea0><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-right\" viewBox=\"0 0 16 16\" data-v-f6a89ea0><path fill-rule=\"evenodd\" d=\"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z\" data-v-f6a89ea0></path></svg></span></a>", 1)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" v-if=\"$page.props.auth.user.name.empl_id==='2960' || $page.props.auth.user.name.empl_id==='2730'\r\n                            $page.props.auth.user.name.empl_id==='8510' || $page.props.auth.user.name.empl_id==='8354'\" "), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/imports/performance/standard"
    }]),
    href: "/imports/performance/standard"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[24] || (_cache[24] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Performance Standard ", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [24]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_42, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/ipcr/score"
    }]),
    href: "/ipcr/score"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[25] || (_cache[25] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Ratings", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [25]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_43, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/individual-final-output-crud"
    }]),
    href: "/individual-final-output-crud"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[26] || (_cache[26] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Individual Final Outputs", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [26]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" $usn = '2960' || $usn = '2730' "), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/employee/special/department"
    }]),
    href: "/employee/special/department"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[27] || (_cache[27] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Employees Special Department", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [27]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' || _ctx.$page.props.auth.user.name.empl_id == '2089' || _ctx.$page.props.auth.user.name.empl_id == '8749' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/employees/all"
    }]),
    href: "/employees/all"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[28] || (_cache[28] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Employees", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [28]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li v-if=\"$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354' ||\r\n                        $page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730'\r\n                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753' || $page.props.auth.user.name.empl_id == '2089'\r\n                                \">\r\n                            <Link @click=\"gotoemp\" class=\"sidebar-link clickable\" :href=\"`/employees/all`\"\r\n                                :class=\"{ 'active': $page.url === `/employees/all` }\"\r\n                                ><span class=\"title\">Employees</span></Link>\r\n                        </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [_ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/password/change/log"
    }]),
    href: "/password/change/log"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" '8447' || $page.props.auth.user.name.empl_id == '8753' "), _cache[29] || (_cache[29] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Password Change Log", -1 /* CACHED */))];
    }),
    _: 1 /* STABLE */,
    __: [29]
  }, 8 /* PROPS */, ["class"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [_ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/email/log"
    }]),
    href: "/email/log"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" '8447' || $page.props.auth.user.name.empl_id == '8753' "), _cache[30] || (_cache[30] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Email Change Log", -1 /* CACHED */))];
    }),
    _: 1 /* STABLE */,
    __: [30]
  }, 8 /* PROPS */, ["class"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/offices"
    }]),
    href: "/offices"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[31] || (_cache[31] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Offices", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [31]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2013' || _ctx.$page.props.auth.user.name.empl_id == '9985' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/designated-division-head"
    }]),
    href: "/designated-division-head"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[32] || (_cache[32] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "Designated Heads", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [32]
  }, 8 /* PROPS */, ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/IPCR_Tracking"
    }]),
    href: "/IPCR_Tracking"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _cache[34] || (_cache[34] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "icon-holder"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        "class": "bi bi-list-check",
        viewBox: "0 0 16 16"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
        "fill-rule": "evenodd",
        d: "M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"
      })])], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
        "class": "title"
      }, "IPCR Tracking", -1 /* CACHED */)]);
    }),
    _: 1 /* STABLE */,
    __: [34]
  }, 8 /* PROPS */, ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("************")])])]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\r\n/* .bg-gradient-success {\r\n    background: linear-gradient(to right, #036219, #80f541);\r\n    /* border-radius: 10px;\r\n    /* Dark to light shade\r\n}\r\n\r\n.bg-gradient-danger {\r\n    background: linear-gradient(to right, #62030d, #ffb82a);\r\n    /* border-radius: 10px;\r\n    /* Dark to light shade\r\n}\r\n\r\n.bg-gradient-info {\r\n    background: linear-gradient(to right, #0031f7, #4cdfe7);\r\n    /* border-radius: 10px;\r\n}\r\n\r\n.bg-gradient-deleted {\r\n    background: linear-gradient(to right, #860202, #fb7676);\r\n    /* border-radius: 10px;\r\n} */\r\n\r\n/* Define corresponding classes for SweetAlert backgrounds */\n.bg-gradient-success.swal2-popup {\r\n    background: linear-gradient(to right, #036219, #80f541) !important;\n}\n.bg-gradient-danger.swal2-popup {\r\n    background: linear-gradient(to right, #62030d, #ffb82a) !important;\n}\n.bg-gradient-info.swal2-popup {\r\n    background: linear-gradient(to right, #0031f7, #4cdfe7) !important;\n}\n.bg-gradient-deleted.swal2-popup {\r\n    background: linear-gradient(to right, #860202, #fb7676) !important;\n}\r\n\r\n/* Define the text color class for SweetAlert dialogs */\n.swal2-title {\r\n    color: white !important;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.clickable[data-v-f6a89ea0] {\r\n  display: inline-block;\r\n  padding: 10px 20px;\r\n  background-color: #007bff;\r\n  color: white;\r\n  text-align: center;\r\n  border-radius: 5px;\r\n  cursor: pointer;\r\n  -webkit-user-select: none;\r\n     -moz-user-select: none;\r\n          user-select: none; /* Prevent text selection */\n}\r\n/* .clickable:hover {\r\n  background-color: #0056b3;\r\n} */\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_style_index_0_id_f2d83a72_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_style_index_0_id_f2d83a72_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_style_index_0_id_f2d83a72_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_f6a89ea0_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_f6a89ea0_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_f6a89ea0_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/Pages lazy recursive ^\\.\\/.*$":
/*!************************************************************!*\
  !*** ./resources/js/Pages/ lazy ^\.\/.*$ namespace object ***!
  \************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./Acted_Review/Accomplishments": [
		"./resources/js/Pages/Acted_Review/Accomplishments.vue",
		"resources_js_Pages_Acted_Review_Accomplishments_vue"
	],
	"./Acted_Review/Accomplishments.vue": [
		"./resources/js/Pages/Acted_Review/Accomplishments.vue",
		"resources_js_Pages_Acted_Review_Accomplishments_vue"
	],
	"./Acted_Review/AccomplishmentsMonthly": [
		"./resources/js/Pages/Acted_Review/AccomplishmentsMonthly.vue",
		"resources_js_Pages_Acted_Review_AccomplishmentsMonthly_vue"
	],
	"./Acted_Review/AccomplishmentsMonthly.vue": [
		"./resources/js/Pages/Acted_Review/AccomplishmentsMonthly.vue",
		"resources_js_Pages_Acted_Review_AccomplishmentsMonthly_vue"
	],
	"./Acted_Review/Index": [
		"./resources/js/Pages/Acted_Review/Index.vue",
		"resources_js_Pages_Acted_Review_Index_vue"
	],
	"./Acted_Review/Index.vue": [
		"./resources/js/Pages/Acted_Review/Index.vue",
		"resources_js_Pages_Acted_Review_Index_vue"
	],
	"./Acted_Review/Targets": [
		"./resources/js/Pages/Acted_Review/Targets.vue",
		"resources_js_Pages_Acted_Review_Targets_vue"
	],
	"./Acted_Review/Targets.vue": [
		"./resources/js/Pages/Acted_Review/Targets.vue",
		"resources_js_Pages_Acted_Review_Targets_vue"
	],
	"./Charts/LinearChart": [
		"./resources/js/Pages/Charts/LinearChart.vue",
		"/js/vendor",
		"resources_js_Pages_Charts_LinearChart_vue"
	],
	"./Charts/LinearChart.vue": [
		"./resources/js/Pages/Charts/LinearChart.vue",
		"/js/vendor",
		"resources_js_Pages_Charts_LinearChart_vue"
	],
	"./Charts/LinearChart1": [
		"./resources/js/Pages/Charts/LinearChart1.vue",
		"/js/vendor",
		"resources_js_Pages_Charts_LinearChart1_vue"
	],
	"./Charts/LinearChart1.vue": [
		"./resources/js/Pages/Charts/LinearChart1.vue",
		"/js/vendor",
		"resources_js_Pages_Charts_LinearChart1_vue"
	],
	"./Daily_Accomplishment/Create": [
		"./resources/js/Pages/Daily_Accomplishment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Daily_Accomplishment_Create_vue"
	],
	"./Daily_Accomplishment/Create.vue": [
		"./resources/js/Pages/Daily_Accomplishment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Daily_Accomplishment_Create_vue"
	],
	"./Daily_Accomplishment/Index": [
		"./resources/js/Pages/Daily_Accomplishment/Index.vue",
		"resources_js_Pages_Daily_Accomplishment_Index_vue"
	],
	"./Daily_Accomplishment/Index.vue": [
		"./resources/js/Pages/Daily_Accomplishment/Index.vue",
		"resources_js_Pages_Daily_Accomplishment_Index_vue"
	],
	"./Dashboard/Index": [
		"./resources/js/Pages/Dashboard/Index.vue",
		"/js/vendor",
		"resources_js_Pages_Dashboard_Index_vue"
	],
	"./Dashboard/Index.vue": [
		"./resources/js/Pages/Dashboard/Index.vue",
		"/js/vendor",
		"resources_js_Pages_Dashboard_Index_vue"
	],
	"./DesignatedDivisionHeads/Create": [
		"./resources/js/Pages/DesignatedDivisionHeads/Create.vue",
		"/js/vendor",
		"resources_js_Pages_DesignatedDivisionHeads_Create_vue"
	],
	"./DesignatedDivisionHeads/Create.vue": [
		"./resources/js/Pages/DesignatedDivisionHeads/Create.vue",
		"/js/vendor",
		"resources_js_Pages_DesignatedDivisionHeads_Create_vue"
	],
	"./DesignatedDivisionHeads/Index": [
		"./resources/js/Pages/DesignatedDivisionHeads/Index.vue",
		"resources_js_Pages_DesignatedDivisionHeads_Index_vue"
	],
	"./DesignatedDivisionHeads/Index.vue": [
		"./resources/js/Pages/DesignatedDivisionHeads/Index.vue",
		"resources_js_Pages_DesignatedDivisionHeads_Index_vue"
	],
	"./EmployeeSpecialDepartment/Create": [
		"./resources/js/Pages/EmployeeSpecialDepartment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_EmployeeSpecialDepartment_Create_vue"
	],
	"./EmployeeSpecialDepartment/Create.vue": [
		"./resources/js/Pages/EmployeeSpecialDepartment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_EmployeeSpecialDepartment_Create_vue"
	],
	"./EmployeeSpecialDepartment/Index": [
		"./resources/js/Pages/EmployeeSpecialDepartment/Index.vue",
		"resources_js_Pages_EmployeeSpecialDepartment_Index_vue"
	],
	"./EmployeeSpecialDepartment/Index.vue": [
		"./resources/js/Pages/EmployeeSpecialDepartment/Index.vue",
		"resources_js_Pages_EmployeeSpecialDepartment_Index_vue"
	],
	"./Employees/All/Index": [
		"./resources/js/Pages/Employees/All/Index.vue",
		"resources_js_Pages_Employees_All_Index_vue"
	],
	"./Employees/All/Index.vue": [
		"./resources/js/Pages/Employees/All/Index.vue",
		"resources_js_Pages_Employees_All_Index_vue"
	],
	"./Employees/Email/Index": [
		"./resources/js/Pages/Employees/Email/Index.vue",
		"resources_js_Pages_Employees_Email_Index_vue"
	],
	"./Employees/Email/Index.vue": [
		"./resources/js/Pages/Employees/Email/Index.vue",
		"resources_js_Pages_Employees_Email_Index_vue"
	],
	"./Employees/EmailChangeLog/Index": [
		"./resources/js/Pages/Employees/EmailChangeLog/Index.vue",
		"resources_js_Pages_Employees_EmailChangeLog_Index_vue"
	],
	"./Employees/EmailChangeLog/Index.vue": [
		"./resources/js/Pages/Employees/EmailChangeLog/Index.vue",
		"resources_js_Pages_Employees_EmailChangeLog_Index_vue"
	],
	"./Employees/Index": [
		"./resources/js/Pages/Employees/Index.vue",
		"resources_js_Pages_Employees_Index_vue"
	],
	"./Employees/Index.vue": [
		"./resources/js/Pages/Employees/Index.vue",
		"resources_js_Pages_Employees_Index_vue"
	],
	"./Employees/PasswordChangeLog/Email": [
		"./resources/js/Pages/Employees/PasswordChangeLog/Email.vue",
		"resources_js_Pages_Employees_PasswordChangeLog_Email_vue"
	],
	"./Employees/PasswordChangeLog/Email.vue": [
		"./resources/js/Pages/Employees/PasswordChangeLog/Email.vue",
		"resources_js_Pages_Employees_PasswordChangeLog_Email_vue"
	],
	"./Employees/PasswordChangeLog/Index": [
		"./resources/js/Pages/Employees/PasswordChangeLog/Index.vue",
		"resources_js_Pages_Employees_PasswordChangeLog_Index_vue"
	],
	"./Employees/PasswordChangeLog/Index.vue": [
		"./resources/js/Pages/Employees/PasswordChangeLog/Index.vue",
		"resources_js_Pages_Employees_PasswordChangeLog_Index_vue"
	],
	"./Employees/Probationary/Create": [
		"./resources/js/Pages/Employees/Probationary/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_Probationary_Create_vue"
	],
	"./Employees/Probationary/Create.vue": [
		"./resources/js/Pages/Employees/Probationary/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_Probationary_Create_vue"
	],
	"./Employees/Probationary/Index": [
		"./resources/js/Pages/Employees/Probationary/Index.vue",
		"resources_js_Pages_Employees_Probationary_Index_vue"
	],
	"./Employees/Probationary/Index.vue": [
		"./resources/js/Pages/Employees/Probationary/Index.vue",
		"resources_js_Pages_Employees_Probationary_Index_vue"
	],
	"./Employees/Probationary/Targets/Create": [
		"./resources/js/Pages/Employees/Probationary/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_Probationary_Targets_Create_vue"
	],
	"./Employees/Probationary/Targets/Create.vue": [
		"./resources/js/Pages/Employees/Probationary/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_Probationary_Targets_Create_vue"
	],
	"./Employees/Probationary/Targets/Index": [
		"./resources/js/Pages/Employees/Probationary/Targets/Index.vue",
		"resources_js_Pages_Employees_Probationary_Targets_Index_vue"
	],
	"./Employees/Probationary/Targets/Index.vue": [
		"./resources/js/Pages/Employees/Probationary/Targets/Index.vue",
		"resources_js_Pages_Employees_Probationary_Targets_Index_vue"
	],
	"./Employees/ProbationaryFlex/Create": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_ProbationaryFlex_Create_vue"
	],
	"./Employees/ProbationaryFlex/Create.vue": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_ProbationaryFlex_Create_vue"
	],
	"./Employees/ProbationaryFlex/Index": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Index.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Index_vue"
	],
	"./Employees/ProbationaryFlex/Index.vue": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Index.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Index_vue"
	],
	"./Employees/ProbationaryFlex/Individual": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Individual.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Individual_vue"
	],
	"./Employees/ProbationaryFlex/Individual.vue": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Individual.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Individual_vue"
	],
	"./Employees/ProbationaryFlex/Targets/Create": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_ProbationaryFlex_Targets_Create_vue"
	],
	"./Employees/ProbationaryFlex/Targets/Create.vue": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Employees_ProbationaryFlex_Targets_Create_vue"
	],
	"./Employees/ProbationaryFlex/Targets/Index": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Targets/Index.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Targets_Index_vue"
	],
	"./Employees/ProbationaryFlex/Targets/Index.vue": [
		"./resources/js/Pages/Employees/ProbationaryFlex/Targets/Index.vue",
		"resources_js_Pages_Employees_ProbationaryFlex_Targets_Index_vue"
	],
	"./FAOs/Create": [
		"./resources/js/Pages/FAOs/Create.vue",
		"/js/vendor",
		"resources_js_Pages_FAOs_Create_vue"
	],
	"./FAOs/Create.vue": [
		"./resources/js/Pages/FAOs/Create.vue",
		"/js/vendor",
		"resources_js_Pages_FAOs_Create_vue"
	],
	"./FAOs/Index": [
		"./resources/js/Pages/FAOs/Index.vue",
		"resources_js_Pages_FAOs_Index_vue"
	],
	"./FAOs/Index.vue": [
		"./resources/js/Pages/FAOs/Index.vue",
		"resources_js_Pages_FAOs_Index_vue"
	],
	"./Forbidden/Index": [
		"./resources/js/Pages/Forbidden/Index.vue",
		"resources_js_Pages_Forbidden_Index_vue"
	],
	"./Forbidden/Index.vue": [
		"./resources/js/Pages/Forbidden/Index.vue",
		"resources_js_Pages_Forbidden_Index_vue"
	],
	"./Home": [
		"./resources/js/Pages/Home.vue",
		"/js/vendor",
		"resources_js_Pages_Home_vue"
	],
	"./Home.vue": [
		"./resources/js/Pages/Home.vue",
		"/js/vendor",
		"resources_js_Pages_Home_vue"
	],
	"./IPCR/Accomplishment/Index": [
		"./resources/js/Pages/IPCR/Accomplishment/Index.vue",
		"resources_js_Pages_IPCR_Accomplishment_Index_vue"
	],
	"./IPCR/Accomplishment/Index.vue": [
		"./resources/js/Pages/IPCR/Accomplishment/Index.vue",
		"resources_js_Pages_IPCR_Accomplishment_Index_vue"
	],
	"./IPCR/AccomplishmentRevised/Index": [
		"./resources/js/Pages/IPCR/AccomplishmentRevised/Index.vue",
		"resources_js_Pages_IPCR_AccomplishmentRevised_Index_vue"
	],
	"./IPCR/AccomplishmentRevised/Index.vue": [
		"./resources/js/Pages/IPCR/AccomplishmentRevised/Index.vue",
		"resources_js_Pages_IPCR_AccomplishmentRevised_Index_vue"
	],
	"./IPCR/IndividualOutput/Create": [
		"./resources/js/Pages/IPCR/IndividualOutput/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_IndividualOutput_Create_vue"
	],
	"./IPCR/IndividualOutput/Create.vue": [
		"./resources/js/Pages/IPCR/IndividualOutput/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_IndividualOutput_Create_vue"
	],
	"./IPCR/IndividualOutput/Index": [
		"./resources/js/Pages/IPCR/IndividualOutput/Index.vue",
		"resources_js_Pages_IPCR_IndividualOutput_Index_vue"
	],
	"./IPCR/IndividualOutput/Index.vue": [
		"./resources/js/Pages/IPCR/IndividualOutput/Index.vue",
		"resources_js_Pages_IPCR_IndividualOutput_Index_vue"
	],
	"./IPCR/Review/Index": [
		"./resources/js/Pages/IPCR/Review/Index.vue",
		"resources_js_Pages_IPCR_Review_Index_vue"
	],
	"./IPCR/Review/Index.vue": [
		"./resources/js/Pages/IPCR/Review/Index.vue",
		"resources_js_Pages_IPCR_Review_Index_vue"
	],
	"./IPCR/Review_Accomplishments/Index": [
		"./resources/js/Pages/IPCR/Review_Accomplishments/Index.vue",
		"resources_js_Pages_IPCR_Review_Accomplishments_Index_vue"
	],
	"./IPCR/Review_Accomplishments/Index.vue": [
		"./resources/js/Pages/IPCR/Review_Accomplishments/Index.vue",
		"resources_js_Pages_IPCR_Review_Accomplishments_Index_vue"
	],
	"./IPCR/Score/Index": [
		"./resources/js/Pages/IPCR/Score/Index.vue",
		"resources_js_Pages_IPCR_Score_Index_vue"
	],
	"./IPCR/Score/Index.vue": [
		"./resources/js/Pages/IPCR/Score/Index.vue",
		"resources_js_Pages_IPCR_Score_Index_vue"
	],
	"./IPCR/Semestral/Create": [
		"./resources/js/Pages/IPCR/Semestral/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Semestral_Create_vue"
	],
	"./IPCR/Semestral/Create.vue": [
		"./resources/js/Pages/IPCR/Semestral/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Semestral_Create_vue"
	],
	"./IPCR/Semestral/Index": [
		"./resources/js/Pages/IPCR/Semestral/Index.vue",
		"resources_js_Pages_IPCR_Semestral_Index_vue"
	],
	"./IPCR/Semestral/Index.vue": [
		"./resources/js/Pages/IPCR/Semestral/Index.vue",
		"resources_js_Pages_IPCR_Semestral_Index_vue"
	],
	"./IPCR/Semestral2/Create": [
		"./resources/js/Pages/IPCR/Semestral2/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Semestral2_Create_vue"
	],
	"./IPCR/Semestral2/Create.vue": [
		"./resources/js/Pages/IPCR/Semestral2/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Semestral2_Create_vue"
	],
	"./IPCR/Semestral2/Index": [
		"./resources/js/Pages/IPCR/Semestral2/Index.vue",
		"resources_js_Pages_IPCR_Semestral2_Index_vue"
	],
	"./IPCR/Semestral2/Index.vue": [
		"./resources/js/Pages/IPCR/Semestral2/Index.vue",
		"resources_js_Pages_IPCR_Semestral2_Index_vue"
	],
	"./IPCR/Targets/Create": [
		"./resources/js/Pages/IPCR/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Targets_Create_vue"
	],
	"./IPCR/Targets/Create.vue": [
		"./resources/js/Pages/IPCR/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Targets_Create_vue"
	],
	"./IPCR/Targets/Daily_Accomplishment/Create": [
		"./resources/js/Pages/IPCR/Targets/Daily_Accomplishment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Create_vue"
	],
	"./IPCR/Targets/Daily_Accomplishment/Create.vue": [
		"./resources/js/Pages/IPCR/Targets/Daily_Accomplishment/Create.vue",
		"/js/vendor",
		"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Create_vue"
	],
	"./IPCR/Targets/Daily_Accomplishment/Index": [
		"./resources/js/Pages/IPCR/Targets/Daily_Accomplishment/Index.vue",
		"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Index_vue"
	],
	"./IPCR/Targets/Daily_Accomplishment/Index.vue": [
		"./resources/js/Pages/IPCR/Targets/Daily_Accomplishment/Index.vue",
		"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Index_vue"
	],
	"./IPCR/Targets/Index": [
		"./resources/js/Pages/IPCR/Targets/Index.vue",
		"resources_js_Pages_IPCR_Targets_Index_vue"
	],
	"./IPCR/Targets/Index.vue": [
		"./resources/js/Pages/IPCR/Targets/Index.vue",
		"resources_js_Pages_IPCR_Targets_Index_vue"
	],
	"./IPCR_Tracking/Index": [
		"./resources/js/Pages/IPCR_Tracking/Index.vue",
		"resources_js_Pages_IPCR_Tracking_Index_vue"
	],
	"./IPCR_Tracking/Index.vue": [
		"./resources/js/Pages/IPCR_Tracking/Index.vue",
		"resources_js_Pages_IPCR_Tracking_Index_vue"
	],
	"./IndividualOutputs/Index": [
		"./resources/js/Pages/IndividualOutputs/Index.vue",
		"resources_js_Pages_IndividualOutputs_Index_vue"
	],
	"./IndividualOutputs/Index.vue": [
		"./resources/js/Pages/IndividualOutputs/Index.vue",
		"resources_js_Pages_IndividualOutputs_Index_vue"
	],
	"./Monthly_Accomplishment/Index": [
		"./resources/js/Pages/Monthly_Accomplishment/Index.vue",
		"resources_js_Pages_Monthly_Accomplishment_Index_vue"
	],
	"./Monthly_Accomplishment/Index.vue": [
		"./resources/js/Pages/Monthly_Accomplishment/Index.vue",
		"resources_js_Pages_Monthly_Accomplishment_Index_vue"
	],
	"./Offices/Create": [
		"./resources/js/Pages/Offices/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Offices_Create_vue"
	],
	"./Offices/Create.vue": [
		"./resources/js/Pages/Offices/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Offices_Create_vue"
	],
	"./Offices/Index": [
		"./resources/js/Pages/Offices/Index.vue",
		"resources_js_Pages_Offices_Index_vue"
	],
	"./Offices/Index.vue": [
		"./resources/js/Pages/Offices/Index.vue",
		"resources_js_Pages_Offices_Index_vue"
	],
	"./Offices/SummaryOfRating/Index": [
		"./resources/js/Pages/Offices/SummaryOfRating/Index.vue",
		"resources_js_Pages_Offices_SummaryOfRating_Index_vue"
	],
	"./Offices/SummaryOfRating/Index.vue": [
		"./resources/js/Pages/Offices/SummaryOfRating/Index.vue",
		"resources_js_Pages_Offices_SummaryOfRating_Index_vue"
	],
	"./Offices/SummaryOfRating/MonthlyRating": [
		"./resources/js/Pages/Offices/SummaryOfRating/MonthlyRating.vue",
		"resources_js_Pages_Offices_SummaryOfRating_MonthlyRating_vue"
	],
	"./Offices/SummaryOfRating/MonthlyRating.vue": [
		"./resources/js/Pages/Offices/SummaryOfRating/MonthlyRating.vue",
		"resources_js_Pages_Offices_SummaryOfRating_MonthlyRating_vue"
	],
	"./Offices/SummaryOfRating/SemestralRating": [
		"./resources/js/Pages/Offices/SummaryOfRating/SemestralRating.vue",
		"resources_js_Pages_Offices_SummaryOfRating_SemestralRating_vue"
	],
	"./Offices/SummaryOfRating/SemestralRating.vue": [
		"./resources/js/Pages/Offices/SummaryOfRating/SemestralRating.vue",
		"resources_js_Pages_Offices_SummaryOfRating_SemestralRating_vue"
	],
	"./PerformanceStandard/Index": [
		"./resources/js/Pages/PerformanceStandard/Index.vue",
		"resources_js_Pages_PerformanceStandard_Index_vue"
	],
	"./PerformanceStandard/Index.vue": [
		"./resources/js/Pages/PerformanceStandard/Index.vue",
		"resources_js_Pages_PerformanceStandard_Index_vue"
	],
	"./Poles/Index": [
		"./resources/js/Pages/Poles/Index.vue",
		"resources_js_Pages_Poles_Index_vue"
	],
	"./Poles/Index.vue": [
		"./resources/js/Pages/Poles/Index.vue",
		"resources_js_Pages_Poles_Index_vue"
	],
	"./Posts/Index": [
		"./resources/js/Pages/Posts/Index.vue",
		"resources_js_Pages_Posts_Index_vue"
	],
	"./Posts/Index.vue": [
		"./resources/js/Pages/Posts/Index.vue",
		"resources_js_Pages_Posts_Index_vue"
	],
	"./Semestral_Accomplishment/Approve": [
		"./resources/js/Pages/Semestral_Accomplishment/Approve.vue",
		"resources_js_Pages_Semestral_Accomplishment_Approve_vue"
	],
	"./Semestral_Accomplishment/Approve.vue": [
		"./resources/js/Pages/Semestral_Accomplishment/Approve.vue",
		"resources_js_Pages_Semestral_Accomplishment_Approve_vue"
	],
	"./Semestral_Accomplishment/Index": [
		"./resources/js/Pages/Semestral_Accomplishment/Index.vue",
		"resources_js_Pages_Semestral_Accomplishment_Index_vue"
	],
	"./Semestral_Accomplishment/Index.vue": [
		"./resources/js/Pages/Semestral_Accomplishment/Index.vue",
		"resources_js_Pages_Semestral_Accomplishment_Index_vue"
	],
	"./SummaryOfRating/Index": [
		"./resources/js/Pages/SummaryOfRating/Index.vue",
		"resources_js_Pages_SummaryOfRating_Index_vue"
	],
	"./SummaryOfRating/Index.vue": [
		"./resources/js/Pages/SummaryOfRating/Index.vue",
		"resources_js_Pages_SummaryOfRating_Index_vue"
	],
	"./SummaryOfRating/MonthlyRating": [
		"./resources/js/Pages/SummaryOfRating/MonthlyRating.vue",
		"resources_js_Pages_SummaryOfRating_MonthlyRating_vue"
	],
	"./SummaryOfRating/MonthlyRating.vue": [
		"./resources/js/Pages/SummaryOfRating/MonthlyRating.vue",
		"resources_js_Pages_SummaryOfRating_MonthlyRating_vue"
	],
	"./SummaryOfRating/SemestralRating": [
		"./resources/js/Pages/SummaryOfRating/SemestralRating.vue",
		"resources_js_Pages_SummaryOfRating_SemestralRating_vue"
	],
	"./SummaryOfRating/SemestralRating.vue": [
		"./resources/js/Pages/SummaryOfRating/SemestralRating.vue",
		"resources_js_Pages_SummaryOfRating_SemestralRating_vue"
	],
	"./Targets/Create": [
		"./resources/js/Pages/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_Create_vue"
	],
	"./Targets/Create.vue": [
		"./resources/js/Pages/Targets/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_Create_vue"
	],
	"./Targets/DPCR/Create": [
		"./resources/js/Pages/Targets/DPCR/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_DPCR_Create_vue"
	],
	"./Targets/DPCR/Create.vue": [
		"./resources/js/Pages/Targets/DPCR/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_DPCR_Create_vue"
	],
	"./Targets/Hospital/Create": [
		"./resources/js/Pages/Targets/Hospital/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_Hospital_Create_vue"
	],
	"./Targets/Hospital/Create.vue": [
		"./resources/js/Pages/Targets/Hospital/Create.vue",
		"/js/vendor",
		"resources_js_Pages_Targets_Hospital_Create_vue"
	],
	"./Targets/Hospital/Index": [
		"./resources/js/Pages/Targets/Hospital/Index.vue",
		"resources_js_Pages_Targets_Hospital_Index_vue"
	],
	"./Targets/Hospital/Index.vue": [
		"./resources/js/Pages/Targets/Hospital/Index.vue",
		"resources_js_Pages_Targets_Hospital_Index_vue"
	],
	"./Targets/Index": [
		"./resources/js/Pages/Targets/Index.vue",
		"resources_js_Pages_Targets_Index_vue"
	],
	"./Targets/Index.vue": [
		"./resources/js/Pages/Targets/Index.vue",
		"resources_js_Pages_Targets_Index_vue"
	],
	"./Users/BootstrapModalNoJquery": [
		"./resources/js/Pages/Users/BootstrapModalNoJquery.vue",
		"resources_js_Pages_Users_BootstrapModalNoJquery_vue"
	],
	"./Users/BootstrapModalNoJquery.vue": [
		"./resources/js/Pages/Users/BootstrapModalNoJquery.vue",
		"resources_js_Pages_Users_BootstrapModalNoJquery_vue"
	],
	"./Users/ChangeEmail": [
		"./resources/js/Pages/Users/ChangeEmail.vue",
		"resources_js_Pages_Users_ChangeEmail_vue"
	],
	"./Users/ChangeEmail.vue": [
		"./resources/js/Pages/Users/ChangeEmail.vue",
		"resources_js_Pages_Users_ChangeEmail_vue"
	],
	"./Users/ChangePassword": [
		"./resources/js/Pages/Users/ChangePassword.vue",
		"resources_js_Pages_Users_ChangePassword_vue"
	],
	"./Users/ChangePassword.vue": [
		"./resources/js/Pages/Users/ChangePassword.vue",
		"resources_js_Pages_Users_ChangePassword_vue"
	],
	"./Users/Create": [
		"./resources/js/Pages/Users/Create.vue",
		"resources_js_Pages_Users_Create_vue"
	],
	"./Users/Create.vue": [
		"./resources/js/Pages/Users/Create.vue",
		"resources_js_Pages_Users_Create_vue"
	],
	"./Users/Index": [
		"./resources/js/Pages/Users/Index.vue",
		"resources_js_Pages_Users_Index_vue"
	],
	"./Users/Index.vue": [
		"./resources/js/Pages/Users/Index.vue",
		"resources_js_Pages_Users_Index_vue"
	],
	"./Users/PermissionsModal": [
		"./resources/js/Pages/Users/PermissionsModal.vue",
		"resources_js_Pages_Users_PermissionsModal_vue"
	],
	"./Users/PermissionsModal.vue": [
		"./resources/js/Pages/Users/PermissionsModal.vue",
		"resources_js_Pages_Users_PermissionsModal_vue"
	],
	"./Users/Settings": [
		"./resources/js/Pages/Users/Settings.vue",
		"resources_js_Pages_Users_Settings_vue"
	],
	"./Users/Settings.vue": [
		"./resources/js/Pages/Users/Settings.vue",
		"resources_js_Pages_Users_Settings_vue"
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(() => {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(() => {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = () => (Object.keys(map));
webpackAsyncContext.id = "./resources/js/Pages lazy recursive ^\\.\\/.*$";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "./resources/js/Shared/CardModal.vue":
/*!*******************************************!*\
  !*** ./resources/js/Shared/CardModal.vue ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CardModal.vue?vue&type=template&id=09736751 */ "./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751");
/* harmony import */ var _CardModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CardModal.vue?vue&type=script&lang=js */ "./resources/js/Shared/CardModal.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_CardModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/CardModal.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/CardModal.vue?vue&type=script&lang=js":
/*!*******************************************************************!*\
  !*** ./resources/js/Shared/CardModal.vue?vue&type=script&lang=js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CardModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751":
/*!*************************************************************************!*\
  !*** ./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751 ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CardModal.vue?vue&type=template&id=09736751 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751");


/***/ }),

/***/ "./resources/js/Shared/Footer.vue":
/*!****************************************!*\
  !*** ./resources/js/Shared/Footer.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Footer.vue?vue&type=template&id=a77bcb12 */ "./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12");
/* harmony import */ var _Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Footer.vue?vue&type=script&lang=js */ "./resources/js/Shared/Footer.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Footer.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Footer.vue?vue&type=script&lang=js":
/*!****************************************************************!*\
  !*** ./resources/js/Shared/Footer.vue?vue&type=script&lang=js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=template&id=a77bcb12 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12");


/***/ }),

/***/ "./resources/js/Shared/Layout.vue":
/*!****************************************!*\
  !*** ./resources/js/Shared/Layout.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Layout.vue?vue&type=template&id=6bf30086 */ "./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086");
/* harmony import */ var _Layout_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Layout.vue?vue&type=script&lang=js */ "./resources/js/Shared/Layout.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Layout_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Layout.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Layout.vue?vue&type=script&lang=js":
/*!****************************************************************!*\
  !*** ./resources/js/Shared/Layout.vue?vue&type=script&lang=js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Layout.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Layout.vue?vue&type=template&id=6bf30086 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086");


/***/ }),

/***/ "./resources/js/Shared/Nav.vue":
/*!*************************************!*\
  !*** ./resources/js/Shared/Nav.vue ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Nav.vue?vue&type=template&id=42f6d0f7 */ "./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7");
/* harmony import */ var _Nav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Nav.vue?vue&type=script&lang=js */ "./resources/js/Shared/Nav.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Nav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Nav.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Nav.vue?vue&type=script&lang=js":
/*!*************************************************************!*\
  !*** ./resources/js/Shared/Nav.vue?vue&type=script&lang=js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Nav.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7":
/*!*******************************************************************!*\
  !*** ./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7 ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Nav.vue?vue&type=template&id=42f6d0f7 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7");


/***/ }),

/***/ "./resources/js/Shared/Notification.vue":
/*!**********************************************!*\
  !*** ./resources/js/Shared/Notification.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Notification.vue?vue&type=template&id=f2d83a72 */ "./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72");
/* harmony import */ var _Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Notification.vue?vue&type=script&lang=js */ "./resources/js/Shared/Notification.vue?vue&type=script&lang=js");
/* harmony import */ var _Notification_vue_vue_type_style_index_0_id_f2d83a72_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css */ "./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Notification.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Notification.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Notification.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Notification.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css":
/*!******************************************************************************************!*\
  !*** ./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_style_index_0_id_f2d83a72_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=style&index=0&id=f2d83a72&lang=css");


/***/ }),

/***/ "./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72":
/*!****************************************************************************!*\
  !*** ./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Notification.vue?vue&type=template&id=f2d83a72 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72");


/***/ }),

/***/ "./resources/js/Shared/Sidebar.vue":
/*!*****************************************!*\
  !*** ./resources/js/Shared/Sidebar.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Sidebar_vue_vue_type_template_id_f6a89ea0_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true */ "./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true");
/* harmony import */ var _Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=script&lang=js */ "./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js");
/* harmony import */ var _Sidebar_vue_vue_type_style_index_0_id_f6a89ea0_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css */ "./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css");
/* harmony import */ var D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_revised_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Sidebar_vue_vue_type_template_id_f6a89ea0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-f6a89ea0"],['__file',"resources/js/Shared/Sidebar.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js":
/*!*****************************************************************!*\
  !*** ./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css":
/*!*************************************************************************************************!*\
  !*** ./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_f6a89ea0_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=style&index=0&id=f6a89ea0&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true":
/*!***********************************************************************************!*\
  !*** ./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_f6a89ea0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_f6a89ea0_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0&scoped=true");


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_Layout__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Shared/Layout */ "./resources/js/Shared/Layout.vue");
/* harmony import */ var _Shared_Notification__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Shared/Notification */ "./resources/js/Shared/Notification.vue");
/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @inertiajs/progress */ "./node_modules/@inertiajs/progress/dist/index.js");
/* harmony import */ var _Shared_CardModal__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Shared/CardModal */ "./resources/js/Shared/CardModal.vue");
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vue-filepond */ "./node_modules/vue-filepond/dist/vue-filepond.js");
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(vue_filepond__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! filepond-plugin-file-validate-type */ "./node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js");
/* harmony import */ var filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! filepond-plugin-image-preview */ "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js");
/* harmony import */ var filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! filepond-plugin-file-validate-size */ "./node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js");
/* harmony import */ var filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! filepond-plugin-image-crop */ "./node_modules/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js");
/* harmony import */ var filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! filepond-plugin-image-transform */ "./node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js");
/* harmony import */ var filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var vue_select_dist_vue_select_css__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vue-select/dist/vue-select.css */ "./node_modules/vue-select/dist/vue-select.css");
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vue-select */ "./node_modules/vue-select/dist/vue-select.es.js");
/* harmony import */ var _vueform_multiselect__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @vueform/multiselect */ "./node_modules/@vueform/multiselect/dist/multiselect.mjs");
/* harmony import */ var vue_sweetalert2__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! vue-sweetalert2 */ "./node_modules/vue-sweetalert2/dist/vue-sweetalert.mjs");
/* harmony import */ var sweetalert2_dist_sweetalert2_min_css__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! sweetalert2/dist/sweetalert2.min.css */ "./node_modules/sweetalert2/dist/sweetalert2.min.css");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/index.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_17___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_17__);
/* harmony import */ var vue_loading_overlay_dist_css_index_css__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! vue-loading-overlay/dist/css/index.css */ "./node_modules/vue-loading-overlay/dist/css/index.css");
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { if (r) i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n;else { var o = function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); }; o("next", 0), o("throw", 1), o("return", 2); } }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");






//Card modal
//.component('CardModal', CardModal)


// FileUpload







//VUe-select
//import Vue from 'vue';




//Bootstrap Vue
//import { BootstrapVue } from 'bootstrap-vue';
/*.use(BootstrapVue)
      .use(IconsPlugin) */

//Vue Multiselect 3


//Sweet Alert


//VUE-3 RICH ACCORDION
// import { useAccordion } from "vue3-rich-accordion";
// import "vue3-rich-accordion/accordion-library-styles.css";
// import "vue3-rich-accordion/accordion-library-styles.scss";
// .use(useAccordion)
// import { Inertia } from '@inertiajs/inertia';
// import router from './router';
// LOADING


 // required CSS

var FilePond = vue_filepond__WEBPACK_IMPORTED_MODULE_6___default()((filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_7___default()), (filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_8___default()), (filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_9___default()), (filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_10___default()), (filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_11___default()));
// const isLoading = ref(false)
// const showLoading = () => { isLoading.value = true }
// const hideLoading = () => { isLoading.value = false }
(0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.createInertiaApp)({
  resolve: function () {
    var _resolve = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee(name) {
      var _page$layout;
      var page;
      return _regenerator().w(function (_context) {
        while (1) switch (_context.n) {
          case 0:
            _context.n = 1;
            return __webpack_require__("./resources/js/Pages lazy recursive ^\\.\\/.*$")("./".concat(name));
          case 1:
            page = _context.v["default"];
            (_page$layout = page.layout) !== null && _page$layout !== void 0 ? _page$layout : page.layout = _Shared_Layout__WEBPACK_IMPORTED_MODULE_2__["default"];
            return _context.a(2, page);
        }
      }, _callee);
    }));
    function resolve(_x) {
      return _resolve.apply(this, arguments);
    }
    return resolve;
  }(),
  setup: function setup(_ref) {
    var el = _ref.el,
      App = _ref.App,
      props = _ref.props,
      plugin = _ref.plugin;
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.createApp)({
      render: function render() {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.h)(App, props);
      }
    }).use(plugin).use(vue_sweetalert2__WEBPACK_IMPORTED_MODULE_15__["default"]).component("multiselect", _vueform_multiselect__WEBPACK_IMPORTED_MODULE_14__["default"]).component("Link", _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Link).component("Head", _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Head).component('CardModal', _Shared_CardModal__WEBPACK_IMPORTED_MODULE_5__["default"]).component("Notification", _Shared_Notification__WEBPACK_IMPORTED_MODULE_3__["default"]).component("FilePond", FilePond).component("v-select", vue_select__WEBPACK_IMPORTED_MODULE_13__["default"]).component('LoadingOverlay', (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_17___default())).mixin({
      data: function data() {
        return {
          get jasper_ip() {
            // var lo = "192.168.6.23:8080/";
            // var gl = "122.54.19.171:8080/";
            // var nw = "122.54.19.172:8080/";
            // var nw_loc = "192.168.6.48:8080/";
            //var nw_temp = "120.72.21.122:8080/"
            // var nw_oct = "paps.dvodeoro.ph:8080/"
            // var nw_nov = "paps.dvodeoro.ph/"
            var nw_nov = "paps.davaodeoro.gov.ph/";
            return nw_nov;
          }
        };
      },
      methods: {
        // COMPUTATION OF MONTHLYM SCORES
        // **************************************************
        QualityRateApp: function QualityRateApp(q1, q2, q3) {
          var n1 = Number(q1) || 0;
          var n2 = Number(q2) || 0;
          var n3 = Number(q3) || 0;
          var average = (n1 + n2 + n3) / 3;
          // console.log("niabot diri")
          var ave = average % 1 === 0 ? average : parseFloat(average.toFixed(2));
          return ave;
        },
        EfficiencyRateApp: function EfficiencyRateApp(e1, e2, e3) {
          var values = [e1, e2, e3];
          var validValues = values.filter(function (val) {
            return val !== 0;
          });
          if (validValues.length === 0) {
            return 0; // or handle however you want when all are 0
          }
          var sum = validValues.reduce(function (a, b) {
            return a + b;
          }, 0);
          var average = sum / validValues.length;
          return average % 1 === 0 ? average : parseFloat(average.toFixed(2));
        },
        calculateAverageCore: function calculateAverageCore(data) {
          var _this = this;
          var sum = 0;
          var num_of_data = 0;
          var average = 0;
          if (Array.isArray(data)) {
            data.forEach(function (item) {
              // console.log(item.q1 + " " + item.q2 + " " + item.q3 + " " + item.e1 + " " + item.e2 + " " + item.e3 + " " + item.time + " " + item.timeliness
              //     + " type:" + item.type + " ipcr_type: " + item.ipcr_type)
              if (item.ipcr_type === 'Core Function' || item.type === 'Core Function') {
                var q1 = Number(item.q1) || 0;
                var q2 = Number(item.q2) || 0;
                var q3 = Number(item.q3) || 0;
                var e1 = Number(item.e1) || 0;
                var e2 = Number(item.e2) || 0;
                var e3 = Number(item.e3) || 0;
                var val = _this.AverageRateApp(_this.QualityRateApp(q1, q2, q3), _this.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : e1, item.efficiency2 == "No" ? 0 : e2, item.efficiency3 == "No" ? 0 : e3), item.timeliness == "No" ? 0 : item.time);
                //var val = this.AverageRating(item.month === 0 || item.month === null ? this.QuantityRate(item.quantity_type, item.TotalQuantity, 1) : this.QuantityRate(item.quantity_type, item.TotalQuantity, item.month), this.QualityRate(item.quality_error, this.quality_score(item.total_quality,item.quality_error)), item.TimeRating == "" ? 0 : item.TimeRating);
                // alert(val);
                // console.log("ave: core: " + this.QualityRateApp(q1, q2, q3))
                // num_of_data += 1;
                // sum += parseFloat(val);
                // average = sum / num_of_data

                val = parseFloat(val);
                if (val !== 0) {
                  // Only include non-zero values
                  sum += val;
                  num_of_data += 1;
                }
                // console.log("val: " + val)
              }
            });
          }
          if (num_of_data > 0) {
            average = sum / num_of_data;
          } else {
            average = 0;
          }
          var Average_Point_Core = average.toFixed(2);
          return Average_Point_Core;
        },
        calculateAverageSupport: function calculateAverageSupport(data) {
          var _this2 = this;
          // console.log(data);
          var sum = 0;
          var num_of_data = 0;
          var average = 0;
          if (Array.isArray(data)) {
            // console.log()
            data.forEach(function (item) {
              // console.log("item: " + item.ipcr_type + " type: " + item.type)
              if (item.ipcr_type === 'Support Function' || item.type === 'Support Function') {
                var q1 = Number(item.q1) || 0;
                var q2 = Number(item.q2) || 0;
                var q3 = Number(item.q3) || 0;
                var e1 = Number(item.e1) || 0;
                var e2 = Number(item.e2) || 0;
                var e3 = Number(item.e3) || 0;
                // console.log("ave: support: " + this.QualityRateApp(q1, q2, q3))
                // console.log(item.ipcr_type)
                // console.log("item: " + item.time)
                // console.log("efficiency: " + this.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : item.e1, item.efficiency2 == "No" ? 0 : item.e2, item.efficiency3 == "No" ? 0 : item.e3))
                var val = _this2.AverageRateApp(_this2.QualityRateApp(q1, q2, q3), _this2.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : e1, item.efficiency2 == "No" ? 0 : e2, item.efficiency3 == "No" ? 0 : e3), item.timeliness == "No" ? 0 : item.time == null ? 0 : item.time);
                //var val = this.AverageRating(item.month === 0 || item.month === null ? this.QuantityRate(item.quantity_type, item.TotalQuantity, 1) : this.QuantityRate(item.quantity_type, item.TotalQuantity, item.month), this.QualityRate(item.quality_error, this.quality_score(item.total_quality,item.quality_error)), item.TimeRating == "" ? 0 : item.TimeRating);
                // alert(val);

                // num_of_data += 1;
                // sum += parseFloat(val);
                // average = sum / num_of_data

                val = parseFloat(val);
                if (val !== 0) {
                  // Only include non-zero values
                  sum += val;
                  num_of_data += 1;
                }
              }
            });
          } else {
            console.log("data is not an array");
          }
          if (num_of_data > 0) {
            average = sum / num_of_data;
          } else {
            average = 0;
          }
          var Average_Point_Core = average.toFixed(2);
          return Average_Point_Core;
        },
        AverageRateApp: function AverageRateApp(Quality, Efficiency, Timeliness) {
          var values = [Quality, Efficiency, Timeliness];
          var validValues = values.filter(function (val) {
            return val !== 0;
          });
          if (validValues.length === 0) {
            return 0; // or handle differently if needed
          }
          var sum = validValues.reduce(function (a, b) {
            return a + b;
          }, 0);
          var average = sum / validValues.length;
          return average % 1 === 0 ? average : parseFloat(average.toFixed(2));
        },
        // COMPUTATION OF SEMESTRAL SCORES
        sem: function sem(_sem) {
          var result = "";
          if (_sem == "1") {
            result = "January to June";
          } else if (_sem == 2) {
            result = "July to December";
          }
          return result;
        },
        getAdjectivalScoreSemestral: function getAdjectivalScoreSemestral(Core, Support) {
          var result = 0;
          var result = Math.round((Core + Support) * 100) / 100;
          return result;
        },
        EfficiencyRateSem: function EfficiencyRateSem(ave1, ave2, ave3) {
          var values = [ave1, ave2, ave3];
          var sum = 0;
          var count = 0;
          values.forEach(function (val) {
            if (val !== 0) {
              sum += val;
              count++;
            }
          });

          // Avoid division by zero
          if (count === 0) {
            return 0;
          }
          var result = sum / count;
          console.log(result);
          return parseFloat(result.toFixed(2));
        },
        QualityRateSem: function QualityRateSem(ave1, ave2, ave3) {
          var result = (ave1 + ave2 + ave3) / 3;
          console.log(result);
          return parseFloat(result.toFixed(2));
        },
        AverageComputationSem: function AverageComputationSem(QualityAverage, EfficiencyAverage, TimeAverage) {
          var values = [QualityAverage, EfficiencyAverage, TimeAverage];
          var sum = 0;
          var count = 0;
          values.forEach(function (val) {
            if (val !== 0) {
              sum += val;
              count++;
            }
          });
          if (count === 0) {
            return 0;
          }
          var result = sum / count;
          return parseFloat(result.toFixed(2));
        },
        SemName: function SemName(id) {
          var result;
          if (id == 1) {
            result = "January to June";
          } else {
            result = "July to December";
          }
          return result;
        },
        getAdjectivalScoreSem: function getAdjectivalScoreSem(Core, Support) {
          var result = 0;
          var result = Math.round((Core + Support) * 100) / 100;
          return result;
        },
        getAdjectivalRatingSem: function getAdjectivalRatingSem(Score) {
          var result = "";
          if (Score >= 4.51 && Score <= 5.00) {
            result = "Outstanding";
          } else if (Score >= 3.51 && Score <= 4.50) {
            result = "Very Satisfactory";
          } else if (Score >= 2.51 && Score <= 3.50) {
            result = "Satisfactory";
          } else if (Score >= 1.51 && Score <= 2.50) {
            result = "Unsatisfactory";
          } else if (Score >= 1.00 && Score <= 1.50) {
            result = "Poor";
          }
          return result;
        },
        AverageRateSem: function AverageRateSem(QuantityRating, QualityRating, TimeRating) {
          // alert(TimeRating)

          if (TimeRating == " ") {
            TimeRating = 0;
          }
          if (TimeRating == "") {
            TimeRating = 0;
          }
          if (isNaN(TimeRating)) {
            TimeRating = 0;
          }
          var ratings = [parseFloat(QuantityRating), parseFloat(QualityRating), parseFloat(TimeRating)];
          var NotZero = ratings.filter(function (rating) {
            return rating !== 0;
          });
          if (NotZero.length === 0) {
            return 0; // or any default value when all ratings are zero
          }
          var average = NotZero.reduce(function (sum, rating) {
            return sum + rating;
          }, 0) / NotZero.length;
          return this.format_number_conv(average, 2, true);
        },
        calculateAverageCoreSem: function calculateAverageCoreSem(data) {
          var _this3 = this;
          var sum = 0;
          var num_of_data = 0;
          var average = 0;
          // console.log(data);
          if (Array.isArray(data)) {
            data.forEach(function (item) {
              if (item.ipcr_type === 'Core Function') {
                var val = _this3.AverageComputationSem(_this3.QualityRateSem(item.avg_q1, item.avg_q2, item.avg_q3), _this3.EfficiencyRateSem(item.avg_e1, item.avg_e2, item.avg_e3), item.timeliness == "No" ? 0 : item.avg_t1);
                // alert(val);
                // alert(this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                if (val !== 0) {
                  num_of_data += 1;
                  sum += parseFloat(val);
                  average = sum / num_of_data;
                }
              }
              // console.log(num_of_data);
              // console.log(average)
            });
          }
          return average.toFixed(2);
        },
        calculateAverageSupportSem: function calculateAverageSupportSem(data) {
          var _this4 = this;
          var sum = 0;
          var num_of_data = 0;
          var average = 0;
          if (Array.isArray(data)) {
            data.forEach(function (item) {
              if (item.ipcr_type === 'Support Function') {
                var val = _this4.AverageComputationSem(_this4.QualityRateSem(item.avg_q1, item.avg_q2, item.avg_q3), _this4.EfficiencyRateSem(item.avg_e1, item.avg_e2, item.avg_e3), item.timeliness == "No" ? 0 : item.avg_t1);
                // alert(val);

                if (val !== 0) {
                  num_of_data += 1;
                  sum += parseFloat(val);
                  average = sum / num_of_data;
                }
              }
            });
          }
          return average.toFixed(2);
        },
        //************************************************** */
        formatDateRange: function formatDateRange(dateFrom, dateTo) {
          var fromDate = new Date(dateFrom);
          var toDate = new Date(dateTo);

          // Define formatting options for the 'from' and 'to' dates
          var options = {
            month: 'long',
            day: 'numeric'
          };

          // Format the 'from' and 'to' dates
          var formattedFromDate = fromDate.toLocaleDateString(undefined, options);
          var formattedToDate = toDate.toLocaleDateString(undefined, options);

          // Construct the date range string
          if (fromDate.getFullYear() !== toDate.getFullYear()) {
            return "".concat(formattedFromDate, ", ").concat(fromDate.getFullYear(), " to ").concat(formattedToDate, ", ").concat(toDate.getFullYear());
          } else {
            return "".concat(formattedFromDate, " to ").concat(formattedToDate, ", ").concat(fromDate.getFullYear());
          }
        },
        stringAsArray: function stringAsArray(originalString) {
          return originalString.split(this.delimiter);
        },
        format_number: function format_number(number, num_decimals, include_comma) {
          return number.toLocaleString('en-US', {
            useGrouping: include_comma,
            minimumFractionDigits: num_decimals,
            maximumFractionDigits: num_decimals
          });
        },
        format_number_conv: function format_number_conv(number, num_decimals, include_comma) {
          var numm = parseFloat(number);
          return numm.toLocaleString('en-US', {
            useGrouping: include_comma,
            minimumFractionDigits: num_decimals,
            maximumFractionDigits: num_decimals
          });
        },
        formatMonthDayYear: function formatMonthDayYear(datte) {
          var dateString = datte;
          var dateParts = dateString.split("-");
          return new Date(dateParts[0], dateParts[1] - 1, dateParts[2]).toLocaleDateString("en-US", {
            month: "long",
            day: "numeric",
            year: "numeric"
          });
        },
        getMonthName: function getMonthName(monthNumber) {
          var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          var parsedNumber = parseInt(monthNumber);
          if (!isNaN(parsedNumber) && parsedNumber >= 1 && parsedNumber <= 12) {
            return months[parsedNumber - 1];
          } else {
            return 'Invalid Month';
          }
        },
        getStatus: function getStatus(stat_num) {
          if (stat_num === '-2') {
            return 'Returned';
          } else if (stat_num === '-1') {
            return 'Saved';
          } else if (stat_num === '0') {
            return 'Submitted';
          } else if (stat_num === '1') {
            return 'Reviewed';
          } else if (stat_num === '2') {
            return 'Approved';
          } else if (stat_num === '3') {
            return 'Final Approve';
          } else {
            return 'Unknown Status';
          }
        },
        getSemester: function getSemester(sem) {
          if (sem === '1') {
            return 'First Semester';
          } else {
            return 'Second Semester';
          }
        },
        getPeriod: function getPeriod(sem, year) {
          if (sem === '1') {
            return "January to June ".concat(year);
          } else {
            return "July to December ".concat(year);
          }
        },
        getColor: function getColor(status) {
          if (status == 1) {
            return 'blue';
          } else if (status == 0) {
            return 'orange';
          } else if (status == 2) {
            return 'green';
          } else if (status == -1) {
            return 'black';
          } else if (status == -2) {
            return 'red';
          } else {
            // Default color if the status doesn't match any condition
            return 'black'; // You can set a default color here
          }
        },
        getActivityType: function getActivityType(act_type) {
          if (act_type === 'review target') {
            return 'Reviewed semestral target';
          } else if (act_type === 'approve target') {
            return 'Approved semestral target';
          } else if (act_type === 'review accomplishment') {
            return 'Reviewed monthly accomplishment';
          } else if (act_type === 'approve accomplishment') {
            return 'Approved monthly accomplishment';
          } else if (act_type === 'final approve accomplishment') {
            return 'Final approve accomplishment';
          } else if (act_type === 'return accomplishment') {
            return 'Returned monthly accomplishment';
          } else if (act_type === 'review semestral accomplishment') {
            return 'Reviewed semestral accomplishment';
          } else if (act_type === 'approve semestral accomplishment') {
            return 'Approved semestral accomplishment';
          } else if (act_type === 'return target') {
            return 'Returned target';
          } else if (act_type === 'return semestral accomplishment') {
            return 'Returned semestral accomplishment';
          } else if (act_type === 'returned additional target') {
            return 'Returned additional target';
          } else if (act_type === 'reviewed additional target') {
            return 'Reviewed additional target';
          } else if (act_type === 'approved additional target') {
            return 'Approved additional target';
          } else if (act_type === 'reviewed additional target (new)') {
            return 'Reviewed semestral target';
          } else if (act_type === 'approved additional target (new)') {
            return 'Approved semestral target';
          } else if (act_type === 'returned additional target (new)') {
            return 'Returned target';
          } else if (act_type === 'return accomplishment (for review)') {
            return 'Returned accomplishment (for review)';
          } else {
            return ''; // or any other default value you want
          }
        },
        truncatedDescription: function truncatedDescription(dat) {
          // alert(dat);
          var wordLimit = 10; // Change this to the desired word limit
          var words = dat.split(' ');
          if (words.length > wordLimit) {
            return words.slice(0, wordLimit).join(' ') + '...';
          }
          return dat;
        },
        truncatedDescriptionSpecificLength: function truncatedDescriptionSpecificLength(dat, limm) {
          var wordLimit = limm; // Change this to the desired word limit
          var words = dat.split(' ');
          if (words.length > wordLimit) {
            return words.slice(0, wordLimit).join(' ') + '...';
          }
          return dat;
        },
        formatDateTimeDTS: function formatDateTimeDTS(dateTimeStr) {
          // Parse the input date-time string to a Date object
          var dateObj = new Date(dateTimeStr);

          // Options for formatting the date part
          var dateOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          };
          var formattedDate = dateObj.toLocaleDateString('en-US', dateOptions);

          // Extract the time parts
          var hours = dateObj.getHours().toString().padStart(2, '0');
          var minutes = dateObj.getMinutes().toString().padStart(2, '0');
          // const seconds = dateObj.getSeconds().toString().padStart(2, '0');
          var mer = ' AM';
          if (hours > 12) {
            hours = hours - 12;
            mer = ' PM';
          }
          // Format the time part
          var formattedTime = "".concat(hours, ":").concat(minutes).concat(mer);

          // Combine the date and time parts
          return "".concat(formattedDate, " -").concat(formattedTime);
        },
        getRowColorActed: function getRowColorActed(type) {
          if (type === 'return target') {
            return '#faeeeb';
          } else if (type === 'review target') {
            return '#f0fafc';
          } else if (type === 'approve target') {
            return '#f7fcf8';
          }
          // else if (type === 'returned additional target (new)') {
          //     return '#a61805';
          // } else if (type === 'reviewed additional target (new)') {
          //     return '#032c69';
          // } else if (type === 'approved additional target (new)') {
          //     return '#01820c';
          // }
          else if (type === 'return accomplishment') {
            return '#faeeeb';
          } else if (type === 'review accomplishment') {
            return '#f0fafc';
          } else if (type === 'approve accomplishment') {
            return '#f7fcf8';
          } else if (type === 'return semestral accomplishment') {
            return '#faeeeb';
          } else if (type === 'review semestral accomplishment') {
            return '#f0fafc';
          } else if (type === 'approve semestral accomplishment') {
            return '#f7fcf8';
          } else if (type === 'returned additional target') {
            return '#faeeeb';
          } else if (type === 'reviewed additional target') {
            return '#f0fafc';
          } else if (type === 'approved additional target') {
            return '#f7fcf8';
          } else {
            return ''; // Default color or no color
          }
        },
        getFontColorActed: function getFontColorActed(type) {
          // alert(type);
          if (type === 'return target') {
            return '#a61805';
          } else if (type === 'review target') {
            return '#032c69';
          } else if (type === 'approve target') {
            return '#01820c';
          } else if (type === 'returned additional target (new)') {
            return '#a61805';
          } else if (type === 'reviewed additional target (new)') {
            return '#032c69';
          } else if (type === 'approved additional target (new)') {
            return '#01820c';
          } else if (type === 'return accomplishment') {
            return '#a61805';
          } else if (type === 'review accomplishment') {
            return '#032c69';
          } else if (type === 'approve accomplishment') {
            return '#01820c';
          } else if (type === 'return semestral accomplishment') {
            return '#a61805';
          } else if (type === 'review semestral accomplishment') {
            return '#032c69';
          } else if (type === 'approve semestral accomplishment') {
            return '#01820c';
          } else if (type === 'returned additional target') {
            return '#a61805';
          } else if (type === 'reviewed additional target') {
            return '#032c69';
          } else if (type === 'approved additional target') {
            return '#01820c';
          } else {
            return ''; // Default color or no color
          }
        },
        // isLastDayOfSem(semester, year) {
        //     const currentDate = new Date();
        //     return currentDate;
        // },
        isLastDayOfSem: function isLastDayOfSem(sem, year) {
          // Get the current date
          var currentDate = new Date();

          // Determine the last month and last day of the passed semester
          var lastDay, lastMonth, semester;
          semester = parseInt(sem, 10);
          if (semester === 1) {
            lastDay = 30; // June 30th for the first semester
            lastMonth = 5; // Month is 0-indexed, so 5 represents June
          } else if (semester === 2) {
            lastDay = 31; // December 31st for the second semester
            lastMonth = 11; // Month is 0-indexed, so 11 represents December
          } else {
            console.error("Invalid semester passed. Use 1 for first semester or 2 for second semester.");
            return false;
          }

          // Construct the date for the last day of the semester
          var semesterEndDate = new Date(year, lastMonth, lastDay);
          // alert(currentDate + ' semEndDate: ' + semesterEndDate)
          var dtt = currentDate + ' semEndDate: ' + semesterEndDate;
          return dtt;
          // Compare the current date with the constructed semester end date
          // return currentDate >= semesterEndDate;
        },
        isPastDate: function isPastDate(semester, monthv, yearv) {
          // Get the current date
          var currentDate = new Date();
          var sem = parseInt(semester);
          var month = parseInt(monthv);
          var year = parseInt(yearv);
          if (sem > 1) {
            month = month + 6;
          }
          // Get the last day of the passed month and year
          var lastDay = new Date(year, month, 0); // 0 will give the last day of the previous month
          // return lastDay + ' currentDay: ' + currentDate + '\nmonth: ' + month + '\nyear: ' + year
          // Compare current date with the constructed date (last day of the passed month/year)
          if (currentDate > lastDay) {
            return true; // Current date is later than or equal to the constructed date
          } else {
            return false; // Current date is earlier than the constructed date
          }
        },
        filterNumbers: function filterNumbers(event, cats_num) {
          cats_num = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
        },
        getEmpType: function getEmpType(designation_type) {
          var map = {
            hdiv: 'Hospital DPCR',
            hos: 'HPCR',
            hsec: 'Hospital SPCR'
          };
          return map[designation_type] || null;
        }
      }
    }).mount(el);
  },
  title: function title(_title) {
    return 'IPCR: ' + _title;
  }
});
_inertiajs_progress__WEBPACK_IMPORTED_MODULE_4__.InertiaProgress.init({
  delay: 250,
  color: '#29d',
  includeCSS: true,
  showSpinner: false
});

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
try {
  window.bootstrap = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.esm.js");
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening 
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "?2128":
/*!********************************!*\
  !*** ./util.inspect (ignored) ***!
  \********************************/
/***/ (() => {

/* (ignored) */

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["css/app","/js/vendor"], () => (__webpack_exec__("./resources/js/app.js"), __webpack_exec__("./resources/sass/app.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
=======
/*! For license information please see app.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[5847],{189:(e,a,t)=>{"use strict";t.d(a,{A:()=>o});var r=t(6314),n=t.n(r)()(function(e){return e[1]});n.push([e.id,".clickable[data-v-2e8af5fe]{background-color:#007bff;border-radius:5px;color:#fff;cursor:pointer;display:inline-block;padding:10px 20px;text-align:center;-webkit-user-select:none;-moz-user-select:none;user-select:none}",""]);const o=n},1015:(e,a,t)=>{"use strict";var r=t(9726),n=t(9234),o={class:"page-container"},l={class:"main-content bgc-grey-100"},s={id:"mainContent"};var i={class:"header navbar"},c={class:"header-container",id:"sidebar-toggle",href:"javascript:void(0);",style:{"min-width":"320px","background-color":"#452b02",color:"black"}},p={class:"nav-left"},d={key:0,class:"nav-left"},m={id:"sidebar-toggle",class:"sidebar-toggle"},u={class:"text-danger"},h={class:"nav-right"},g={class:"dropdown"},v={href:"",class:"dropdown-toggle no-after peers fxw-nw ai-c lh-1","data-bs-toggle":"dropdown"},f={class:"peer mR-10"},w=["src"],y={class:"peer"},N={class:"fsz-sm",style:{color:"#FFD700","font-weight":"bold"}},E={class:"dropdown-menu fsz-sm dropdown-menu-c"},C={key:1,class:"nav-right"};var V=t(8646);const b={data:function(){return{isActive:!0}},methods:{logout:function(){this.$inertia.post("/logout").then(function(e){console.log(e.data.message),location.href="/"}).catch(function(e){console.error("Logout failed:",e)})},update_verified:function(){axios.patch("/users/update_verified_at")},toggleSidebar:function(){this.isActive=!this.isActive},impersonateLeave:function(){var e=this;this.$swal({title:"Leave impersonation",text:"Are you sure you want to leave?",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes",cancelButtonText:"No",closeOnConfirm:!1,closeOnCancel:!1}).then(function(a){a.isConfirmed&&e.$inertia.get("/impersonate/leave",{},{onSuccess:function(){window.location.reload()},onError:function(e){console.error("Error during impersonation:",e)}})})}}};var _=t(6262);const x=(0,_.A)(b,[["render",function(e,a,t,n,o,l){var s=(0,r.resolveComponent)("Link");return(0,r.openBlock)(),(0,r.createElementBlock)("div",i,[(0,r.createElementVNode)("div",c,[(0,r.createElementVNode)("ul",p,[(0,r.createElementVNode)("li",null,[(0,r.createElementVNode)("a",{id:"sidebar-toggle",class:"sidebar-toggle",href:"javascript:void(0);",onClick:a[0]||(a[0]=function(){return l.toggleSidebar&&l.toggleSidebar.apply(l,arguments)})},a[3]||(a[3]=[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",fill:"#FFD700",class:"bi bi-list",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"})],-1)]))]),a[4]||(a[4]=(0,r.createElementVNode)("li",{class:"search-input"},[(0,r.createElementVNode)("input",{class:"form-control",type:"text",placeholder:"Search..."})],-1))]),"yes"===e.$page.props.auth.impersonating?((0,r.openBlock)(),(0,r.createElementBlock)("ul",d,[(0,r.createElementVNode)("li",null,[(0,r.createElementVNode)("a",m,[(0,r.createElementVNode)("span",u,[a[5]||(a[5]=(0,r.createTextVNode)("You are impersonating ")),(0,r.createElementVNode)("b",null,[(0,r.createElementVNode)("u",null,(0,r.toDisplayString)(e.$page.props.auth.user.name.employee_name),1)])])])])])):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("ul",h,[(0,r.createElementVNode)("li",g,[(0,r.createElementVNode)("a",v,[(0,r.createElementVNode)("div",f,[(0,r.createElementVNode)("img",{class:"w-2r bdrs-50p",src:e.$page.props.auth.user.photo,alt:""},null,8,w)]),(0,r.createElementVNode)("div",y,[(0,r.createElementVNode)("span",N,(0,r.toDisplayString)(e.$page.props.auth.user.name.employee_name),1)]),a[6]||(a[6]=(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"12",height:"12",fill:"currentColor",class:"bi bi-caret-down-fill mL-5",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"})],-1))]),(0,r.createElementVNode)("ul",E,[(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{href:"/users/settings",class:"d-b td-n pY-5 bgcH-grey-100 c-grey-700"},{default:(0,r.withCtx)(function(){return a[7]||(a[7]=[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"14",height:"14",fill:"currentColor",class:"bi bi-sliders2 mR-10",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"})],-1),(0,r.createElementVNode)("span",null," Setting",-1)])}),_:1,__:[7]})]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{href:"/users/change-password",class:"d-b td-n pY-5 bgcH-grey-100 c-grey-700"},{default:(0,r.withCtx)(function(){return a[8]||(a[8]=[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"14",height:"14",fill:"currentColor",class:"bi bi-person-bounding-box mR-10",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"}),(0,r.createElementVNode)("path",{d:"M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"})],-1),(0,r.createElementVNode)("span",null," Change Password",-1)])}),_:1,__:[8]})]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{href:"/email/change",class:"d-b td-n pY-5 bgcH-grey-100 c-grey-700"},{default:(0,r.withCtx)(function(){return a[9]||(a[9]=[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"14",height:"14",fill:"currentColor",class:"bi bi-envelope-at-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"}),(0,r.createElementVNode)("path",{d:"M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"})],-1),(0,r.createTextVNode)("   "),(0,r.createElementVNode)("span",null," Change Email",-1)])}),_:1,__:[9]})]),a[11]||(a[11]=(0,r.createElementVNode)("li",{role:"separator",class:"divider"},null,-1)),(0,r.createElementVNode)("li",null,[(0,r.createElementVNode)("a",{onClick:a[1]||(a[1]=function(e){return l.logout()}),href:"",class:"d-b td-n pY-5 bgcH-grey-100 c-grey-700"},a[10]||(a[10]=[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"14",height:"14",fill:"currentColor",class:"bi bi-box-arrow-right mR-10",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"}),(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"})],-1),(0,r.createElementVNode)("span",null," Logout",-1)]))])])])]),"yes"===e.$page.props.auth.impersonating?((0,r.openBlock)(),(0,r.createElementBlock)("u",C,[(0,r.createElementVNode)("li",null,[(0,r.createElementVNode)("a",{id:"sidebar-toggle",class:"sidebar-toggled",href:"javascript:void(0);",onClick:a[2]||(a[2]=function(){return l.impersonateLeave&&l.impersonateLeave.apply(l,arguments)})},a[12]||(a[12]=[(0,r.createElementVNode)("span",{class:"btn btn-danger text-white"},"LEAVE",-1)]))])])):(0,r.createCommentVNode)("",!0)])])}]]);var k={class:"bdT ta-c p-30 lh-0 fsz-sm",style:{"background-color":"#4d3102",color:"#fff"}};const A={},I=(0,_.A)(A,[["render",function(e,a,t,n,o,l){return(0,r.openBlock)(),(0,r.createElementBlock)("footer",k,a[0]||(a[0]=[(0,r.createElementVNode)("span",{style:{color:"#FFD700"}},[(0,r.createTextVNode)("Developed by "),(0,r.createElementVNode)("a",{href:"https://davaodeoro.gov.ph/"},"PICTO")],-1)]))}]]);var R={class:"sidebar"},S={class:"sidebar-inner"},B={class:"sidebar-menu scrollable pos-r"},P={class:"nav-item mT-30 actived"},z={class:"nav-item dropdown"},D={class:"dropdown-menu"},F={class:"title"},M={key:0},T={key:1},O={key:2},H={key:3},L={key:4},j={key:5},U={key:6},q={class:"nav-item"},J={class:"nav-item"},Y={key:0,class:"nav-item"},Z={key:1,class:"nav-item"},G={key:2,class:"nav-item"},Q={key:3,class:"nav-item"},X={class:"nav-item dropdown"},W={class:"dropdown-toggle",href:"javascript:void(0);"},K={key:0,class:"text-danger strong"},ee={class:"dropdown-menu"},ae={class:"nav-item dropdown"},te={class:"dropdown-toggle",href:"javascript:void(0);"},re={class:"title"},ne={key:0,class:"text-danger strong"},oe={class:"dropdown-menu"},le={class:"nav-item dropdown"},se={class:"dropdown-toggle",href:"javascript:void(0);"},ie={class:"title"},ce={key:0,class:"text-danger strong"},pe={class:"dropdown-menu"},de={class:"title"},me={key:0,class:"text-danger strong"},ue={class:"title"},he={key:0,class:"text-danger strong"},ge={key:4,class:"nav-item dropdown"},ve={class:"dropdown-menu"},fe={key:0},we={key:1},ye={key:2},Ne={key:3},Ee={key:4},Ce={key:5},Ve={key:6},be={class:"nav-item"};const _e={mounted:function(){$(function(){$(".sidebar .sidebar-menu li a").on("click",function(){var e=$(this);e.parent().hasClass("open")?e.parent().children(".dropdown-menu").slideUp(200,function(){e.parent().removeClass("open")}):(e.parent().parent().children("li.open").children(".dropdown-menu").slideUp(200),e.parent().parent().children("li.open").children("a").removeClass("open"),e.parent().parent().children("li.open").removeClass("open"),e.parent().children(".dropdown-menu").slideDown(200,function(){e.parent().addClass("open")}))}),$(".sidebar").find(".sidebar-link").each(function(e,a){$(a).removeClass("active")}).filter(function(){var e=$(this).attr("href");return("/"===e[0]?e.substr(1):e)===window.location.pathname.substr(1)}).addClass("active"),$(".sidebar-toggle").on("click",function(e){$("body").toggleClass("is-collapsed"),e.preventDefault()})})},methods:{gotoemp:function(){V.Inertia.get("/employees/a/l/l")}}};var xe=t(5072),ke=t.n(xe),Ae=t(189),$e={insert:"head",singleton:!1};ke()(Ae.A,$e);Ae.A.locals;const Ie={components:{Nav:x,Footer:I,Sidebar:(0,_.A)(_e,[["render",function(e,a,t,n,o,l){var s=(0,r.resolveComponent)("Link");return(0,r.openBlock)(),(0,r.createElementBlock)("div",R,[(0,r.createElementVNode)("div",S,[a[33]||(a[33]=(0,r.createStaticVNode)('<div class="sidebar-logo" data-v-2e8af5fe><div class="peers ai-c fxw-nw" data-v-2e8af5fe><div class="peer peer-greed" data-v-2e8af5fe><a class="sidebar-link td-n" href="/" data-v-2e8af5fe><div class="peers ai-c fxw-nw" data-v-2e8af5fe><div class="peer" data-v-2e8af5fe><div class="logo" data-v-2e8af5fe><img src="/images/logo.png" alt="" class="img-fluid p-5" data-v-2e8af5fe></div></div><div class="peer peer-greed" data-v-2e8af5fe><h5 class="lh-1 mB-0 logo-text" data-v-2e8af5fe><span style="color:#FFD700;font-size:medium;" data-v-2e8af5fe>  Performance Management </span></h5></div></div></a></div><div class="peer" data-v-2e8af5fe><div class="mobile-toggle sidebar-toggle" data-v-2e8af5fe><a href="" class="td-n" data-v-2e8af5fe><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-list" viewBox="0 0 16 16" data-v-2e8af5fe><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" data-v-2e8af5fe></path></svg></a></div></div></div></div>',1)),(0,r.createElementVNode)("ul",B,[(0,r.createElementVNode)("li",P,[(0,r.createVNode)(s,{class:"sidebar-link",href:"/"},{default:(0,r.withCtx)(function(){return a[0]||(a[0]=[(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",fill:"currentColor",class:"bi bi-house-door",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Dashboard",-1)])}),_:1,__:[0]})]),(0,r.createElementVNode)("li",z,[a[2]||(a[2]=(0,r.createStaticVNode)('<a class="dropdown-toggle" href="javascript:void(0);" data-v-2e8af5fe><span class="icon-holder" data-v-2e8af5fe><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16" data-v-2e8af5fe><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" data-v-2e8af5fe></path><path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10m0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12" data-v-2e8af5fe></path><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8" data-v-2e8af5fe></path><path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" data-v-2e8af5fe></path></svg></span><span class="title" data-v-2e8af5fe>Targets</span><span class="arrow" data-v-2e8af5fe><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16" data-v-2e8af5fe><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" data-v-2e8af5fe></path></svg></span></a>',1)),(0,r.createElementVNode)("ul",D,[(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:e.$page.url==="/ipcrsemestral/".concat(e.$page.props.auth.user.name.id,"/direct")}]),href:"/ipcrsemestral/".concat(e.$page.props.auth.user.name.id,"/direct")},{default:(0,r.withCtx)(function(){return[(0,r.createElementVNode)("span",F,["div"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",M,"DPCR Targets")):(0,r.createCommentVNode)("",!0),"hdiv"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",T,"DPCR Targets (Hospital)")):(0,r.createCommentVNode)("",!0),"emp"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",O,"IPCR Targets")):(0,r.createCommentVNode)("",!0),"hemp"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",H,"IPCR Targets (Hospital)")):(0,r.createCommentVNode)("",!0),"sec"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",L,"SPCR Targets")):(0,r.createCommentVNode)("",!0),"hsec"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",j,"SPCR Targets (Hospital)")):(0,r.createCommentVNode)("",!0),"hos"===e.$page.props.auth.pcr_type?((0,r.openBlock)(),(0,r.createElementBlock)("span",U,"HPCR Targets (Hospital)")):(0,r.createCommentVNode)("",!0)])]}),_:1},8,["href","class"])]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/probationary/temporary/individual/targets/list"===e.$page.url}]),href:"/probationary/temporary/individual/targets/list"},{default:(0,r.withCtx)(function(){return a[1]||(a[1]=[(0,r.createElementVNode)("span",{class:"title"},"Probationary/Temporary",-1)])}),_:1,__:[1]},8,["class"])])])]),(0,r.createElementVNode)("li",q,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/Daily_Accomplishment"===e.$page.url}]),href:"/Daily_Accomplishment"},{default:(0,r.withCtx)(function(){return a[3]||(a[3]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-calendar-event-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Daily Accomplishment",-1)])}),_:1,__:[3]},8,["class"])]),(0,r.createElementVNode)("li",J,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/monthly-accomplishment"===e.$page.url}]),href:"/monthly-accomplishment/r"},{default:(0,r.withCtx)(function(){return a[4]||(a[4]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-clipboard-check-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"}),(0,r.createElementVNode)("path",{d:"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Accomplishment",-1)])}),_:1,__:[4]},8,["class"])]),"1"==e.$page.props.auth.user.ao_status||"2960"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id||"2730"==e.$page.props.auth.user.name.empl_id||"8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id||"2003"==e.$page.props.auth.user.name.empl_id||"8447"==e.$page.props.auth.user.name.empl_id||"8753"==e.$page.props.auth.user.name.empl_id||"11159"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Y,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/summary-rating"===e.$page.url}]),href:"/summary-rating"},{default:(0,r.withCtx)(function(){return a[5]||(a[5]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-bar-chart-line-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Summary of Ratings",-1)])}),_:1,__:[5]},8,["class"])])):(0,r.createCommentVNode)("",!0),"2960"==e.$page.props.auth.user.name.empl_id||"2730"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Z,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/offices"===e.$page.url}]),href:"/offices"},{default:(0,r.withCtx)(function(){return a[6]||(a[6]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-bank2",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Offices",-1)])}),_:1,__:[6]},8,["class"])])):(0,r.createCommentVNode)("",!0),"26"==e.$page.props.auth.user.name.department_code||"03"==e.$page.props.auth.user.name.department_code?((0,r.openBlock)(),(0,r.createElementBlock)("li",G,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/probationary/"===e.$page.url}]),href:"/probationary/"},{default:(0,r.withCtx)(function(){return a[7]||(a[7]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-send-check-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"}),(0,r.createElementVNode)("path",{d:"M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"})])],-1),(0,r.createElementVNode)("span",{class:"title"}," Probationary/Temporary ",-1)])}),_:1,__:[7]},8,["class"])])):(0,r.createCommentVNode)("",!0),e.$page.props.auth.user.salary_grade>=18?((0,r.openBlock)(),(0,r.createElementBlock)("li",Q,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/employees"===e.$page.url}]),href:"/employees"},{default:(0,r.withCtx)(function(){return a[8]||(a[8]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",fill:"currentColor",class:"bi bi-people",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"Employees ",-1)])}),_:1,__:[8]},8,["class"])])):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("li",X,[(0,r.createElementVNode)("a",W,[a[9]||(a[9]=(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",fill:"currentColor",class:"bi bi-hand-thumbs-up-fill",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{d:"M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"})])],-1)),a[10]||(a[10]=(0,r.createElementVNode)("span",{class:"title"},"Review/Approve",-1)),e.$page.props.auth.targets>=1||e.$page.props.auth.sem>=1||e.$page.props.auth.month>=1?((0,r.openBlock)(),(0,r.createElementBlock)("span",K,[(0,r.createElementVNode)("b",null," ("+(0,r.toDisplayString)(e.$page.props.auth.targets+e.$page.props.auth.sem+e.$page.props.auth.month)+")",1)])):(0,r.createCommentVNode)("",!0),a[11]||(a[11]=(0,r.createElementVNode)("span",{class:"arrow"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-chevron-right",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"})])],-1))]),(0,r.createElementVNode)("ul",ee,[(0,r.createElementVNode)("li",ae,[(0,r.createElementVNode)("a",te,[(0,r.createElementVNode)("span",re,[a[12]||(a[12]=(0,r.createTextVNode)("Targets ")),e.$page.props.auth.targets?((0,r.openBlock)(),(0,r.createElementBlock)("span",ne,[(0,r.createElementVNode)("b",null,"("+(0,r.toDisplayString)(e.$page.props.auth.targets)+")",1)])):(0,r.createCommentVNode)("",!0)]),a[13]||(a[13]=(0,r.createElementVNode)("span",{class:"arrow"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-chevron-right",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"})])],-1))]),(0,r.createElementVNode)("ul",oe,[(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/review/approve"===e.$page.url}]),href:"/review/approve"},{default:(0,r.withCtx)(function(){return a[14]||(a[14]=[(0,r.createElementVNode)("span",{class:"title"},"  For Approval",-1)])}),_:1,__:[14]},8,["class"])]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/acted/particulars/targets"===e.$page.url}]),href:"/acted/particulars/targets"},{default:(0,r.withCtx)(function(){return a[15]||(a[15]=[(0,r.createElementVNode)("span",{class:"title"},"  Acted Target",-1)])}),_:1,__:[15]},8,["class"])])])]),(0,r.createElementVNode)("li",le,[(0,r.createElementVNode)("a",se,[(0,r.createElementVNode)("span",ie,[a[16]||(a[16]=(0,r.createTextVNode)("Accomplishment ")),e.$page.props.auth.sem>=1||e.$page.props.auth.month>=1?((0,r.openBlock)(),(0,r.createElementBlock)("span",ce,[(0,r.createElementVNode)("b",null," ("+(0,r.toDisplayString)(e.$page.props.auth.sem+e.$page.props.auth.month)+")",1)])):(0,r.createCommentVNode)("",!0)]),a[17]||(a[17]=(0,r.createElementVNode)("span",{class:"arrow"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-chevron-right",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"})])],-1))]),(0,r.createElementVNode)("ul",pe,[(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/ipcr-app/accomplishments"===e.$page.url}]),href:"/ipcr-app/accomplishments"},{default:(0,r.withCtx)(function(){return[(0,r.createElementVNode)("span",de,[a[18]||(a[18]=(0,r.createTextVNode)("  Monthly ")),e.$page.props.auth.month?((0,r.openBlock)(),(0,r.createElementBlock)("span",me,[(0,r.createElementVNode)("b",null,"("+(0,r.toDisplayString)(e.$page.props.auth.month)+")",1)])):(0,r.createCommentVNode)("",!0)])]}),_:1},8,["class"])]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/acted/particulars/accomp/lishments/monthly"===e.$page.url}]),href:"/acted/particulars/accomp/lishments/monthly"},{default:(0,r.withCtx)(function(){return a[19]||(a[19]=[(0,r.createElementVNode)("span",{class:"title"},"  Acted (monthly)",-1)])}),_:1,__:[19]},8,["class"])]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/approve/semestral-accomplishments"===e.$page.url}]),href:"/approve/semestral-accomplishments"},{default:(0,r.withCtx)(function(){return[(0,r.createElementVNode)("span",ue,[a[20]||(a[20]=(0,r.createTextVNode)("  Semestral ")),e.$page.props.auth.sem?((0,r.openBlock)(),(0,r.createElementBlock)("span",he,[(0,r.createElementVNode)("b",null,"("+(0,r.toDisplayString)(e.$page.props.auth.sem)+")",1)])):(0,r.createCommentVNode)("",!0)])]}),_:1},8,["class"])]),(0,r.createElementVNode)("li",null,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/acted/particulars/accomp/lishments"===e.$page.url}]),href:"/acted/particulars/accomp/lishments"},{default:(0,r.withCtx)(function(){return a[21]||(a[21]=[(0,r.createElementVNode)("span",{class:"title"},"  Acted (semestral)",-1)])}),_:1,__:[21]},8,["class"])])])])])]),"2960"==e.$page.props.auth.user.name.empl_id||"2730"==e.$page.props.auth.user.name.empl_id||"8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id||"2003"==e.$page.props.auth.user.name.empl_id||"8447"==e.$page.props.auth.user.name.empl_id||"8753"==e.$page.props.auth.user.name.empl_id||"2089"==e.$page.props.auth.user.name.empl_id||"8749"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",ge,[a[31]||(a[31]=(0,r.createStaticVNode)('<a class="dropdown-toggle" href="javascript:void(0);" data-v-2e8af5fe><span class="icon-holder" data-v-2e8af5fe><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-button-wide-fill" viewBox="0 0 16 16" data-v-2e8af5fe><path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h13A1.5 1.5 0 0 0 16 3.5v-2A1.5 1.5 0 0 0 14.5 0zm1 2h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m9.927.427A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5" data-v-2e8af5fe></path></svg></span><span class="title" data-v-2e8af5fe>Utilities</span><span class="arrow" data-v-2e8af5fe><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16" data-v-2e8af5fe><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" data-v-2e8af5fe></path></svg></span></a>',1)),(0,r.createElementVNode)("ul",ve,["2003"!=e.$page.props.auth.user.name.empl_id&&"8447"!=e.$page.props.auth.user.name.empl_id&&"8753"!=e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",fe,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/imports/performance/standard"===e.$page.url}]),href:"/imports/performance/standard"},{default:(0,r.withCtx)(function(){return a[22]||(a[22]=[(0,r.createElementVNode)("span",{class:"title"},"Performance Standard ",-1)])}),_:1,__:[22]},8,["class"])])):(0,r.createCommentVNode)("",!0),"2003"!=e.$page.props.auth.user.name.empl_id&&"8447"!=e.$page.props.auth.user.name.empl_id&&"8753"!=e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",we,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/ipcr/score"===e.$page.url}]),href:"/ipcr/score"},{default:(0,r.withCtx)(function(){return a[23]||(a[23]=[(0,r.createElementVNode)("span",{class:"title"},"Ratings",-1)])}),_:1,__:[23]},8,["class"])])):(0,r.createCommentVNode)("",!0),"2003"!=e.$page.props.auth.user.name.empl_id&&"8447"!=e.$page.props.auth.user.name.empl_id&&"8753"!=e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",ye,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/individual-final-output-crud"===e.$page.url}]),href:"/individual-final-output-crud"},{default:(0,r.withCtx)(function(){return a[24]||(a[24]=[(0,r.createElementVNode)("span",{class:"title"},"Individual Final Outputs",-1)])}),_:1,__:[24]},8,["class"])])):(0,r.createCommentVNode)("",!0),"2003"!=e.$page.props.auth.user.name.empl_id&&"8447"!=e.$page.props.auth.user.name.empl_id&&"8753"!=e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Ne,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/employee/special/department"===e.$page.url}]),href:"/employee/special/department"},{default:(0,r.withCtx)(function(){return a[25]||(a[25]=[(0,r.createElementVNode)("span",{class:"title"},"Employees Special Department",-1)])}),_:1,__:[25]},8,["class"])])):(0,r.createCommentVNode)("",!0),"8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id||"2960"==e.$page.props.auth.user.name.empl_id||"2730"==e.$page.props.auth.user.name.empl_id||"2003"==e.$page.props.auth.user.name.empl_id||"8447"==e.$page.props.auth.user.name.empl_id||"8753"==e.$page.props.auth.user.name.empl_id||"2089"==e.$page.props.auth.user.name.empl_id||"8749"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Ee,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/employees/all"===e.$page.url}]),href:"/employees/all"},{default:(0,r.withCtx)(function(){return a[26]||(a[26]=[(0,r.createElementVNode)("span",{class:"title"},"Employees",-1)])}),_:1,__:[26]},8,["class"])])):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("li",null,["8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createBlock)(s,{key:0,class:(0,r.normalizeClass)(["sidebar-link",{active:"/password/change/log"===e.$page.url}]),href:"/password/change/log"},{default:(0,r.withCtx)(function(){return a[27]||(a[27]=[(0,r.createElementVNode)("span",{class:"title"},"Password Change Log",-1)])}),_:1,__:[27]},8,["class"])):(0,r.createCommentVNode)("",!0)]),(0,r.createElementVNode)("li",null,["8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createBlock)(s,{key:0,class:(0,r.normalizeClass)(["sidebar-link",{active:"/email/log"===e.$page.url}]),href:"/email/log"},{default:(0,r.withCtx)(function(){return a[28]||(a[28]=[(0,r.createElementVNode)("span",{class:"title"},"Email Change Log",-1)])}),_:1,__:[28]},8,["class"])):(0,r.createCommentVNode)("",!0)]),"8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id||"2003"==e.$page.props.auth.user.name.empl_id||"8447"==e.$page.props.auth.user.name.empl_id||"8753"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Ce,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/offices"===e.$page.url}]),href:"/offices"},{default:(0,r.withCtx)(function(){return a[29]||(a[29]=[(0,r.createElementVNode)("span",{class:"title"},"Offices",-1)])}),_:1,__:[29]},8,["class"])])):(0,r.createCommentVNode)("",!0),"2960"==e.$page.props.auth.user.name.empl_id||"2730"==e.$page.props.auth.user.name.empl_id||"8510"==e.$page.props.auth.user.name.empl_id||"8354"==e.$page.props.auth.user.name.empl_id||"2013"==e.$page.props.auth.user.name.empl_id||"9985"==e.$page.props.auth.user.name.empl_id?((0,r.openBlock)(),(0,r.createElementBlock)("li",Ve,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/designated-division-head"===e.$page.url}]),href:"/designated-division-head"},{default:(0,r.withCtx)(function(){return a[30]||(a[30]=[(0,r.createElementVNode)("span",{class:"title"},"Designated Heads",-1)])}),_:1,__:[30]},8,["class"])])):(0,r.createCommentVNode)("",!0)])])):(0,r.createCommentVNode)("",!0),(0,r.createElementVNode)("li",be,[(0,r.createVNode)(s,{class:(0,r.normalizeClass)(["sidebar-link",{active:"/IPCR_Tracking"===e.$page.url}]),href:"/IPCR_Tracking"},{default:(0,r.withCtx)(function(){return a[32]||(a[32]=[(0,r.createElementVNode)("span",null,null,-1),(0,r.createElementVNode)("span",{class:"icon-holder"},[(0,r.createElementVNode)("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-list-check",viewBox:"0 0 16 16"},[(0,r.createElementVNode)("path",{"fill-rule":"evenodd",d:"M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"})])],-1),(0,r.createElementVNode)("span",{class:"title"},"IPCR Tracking",-1)])}),_:1,__:[32]},8,["class"])])])])])}],["__scopeId","data-v-2e8af5fe"]])},data:function(){return{}}},Re=(0,_.A)(Ie,[["render",function(e,a,t,n,i,c){var p=(0,r.resolveComponent)("Sidebar"),d=(0,r.resolveComponent)("Notification"),m=(0,r.resolveComponent)("Nav"),u=(0,r.resolveComponent)("Footer");return(0,r.openBlock)(),(0,r.createElementBlock)("div",null,[(0,r.createVNode)(p),(0,r.createElementVNode)("div",o,[(0,r.createVNode)(d),(0,r.createVNode)(m),(0,r.createElementVNode)("main",l,[(0,r.createElementVNode)("div",s,[(0,r.renderSlot)(e.$slots,"default")])]),(0,r.createVNode)(u)])])}]]);var Se={class:"position-fixed top-0 end-0 p-3",style:{"z-index":"1000"}};t(8465);const Be={watch:{"$page.props.flash":{handler:function(e){e.message?this.$swal({icon:"success",title:e.message,timer:5e3,timerProgressBar:!0,customClass:{popup:"bg-gradient-success"}}):e.error?this.$swal({icon:"error",title:e.error,timer:5e3,timerProgressBar:!0,customClass:{popup:"bg-gradient-danger"}}):e.info?this.$swal({icon:"info",title:e.info,timer:5e3,timerProgressBar:!0,customClass:{popup:"bg-gradient-info"}}):e.deleted&&this.$swal({icon:"warning",title:e.deleted,timer:5e3,timerProgressBar:!0,customClass:{popup:"bg-gradient-deleted"}})},deep:!0}}};var Pe=t(6420),ze={insert:"head",singleton:!1};ke()(Pe.A,ze);Pe.A.locals;const De=(0,_.A)(Be,[["render",function(e,a,t,n,o,l){return(0,r.openBlock)(),(0,r.createElementBlock)("div",Se,a[0]||(a[0]=[(0,r.createElementVNode)("div",{class:"toast align-items-center",role:"alert","aria-atomic":"true","aria-live":"polite","data-bs-autohide":"true","data-bs-delay":"5000"},null,-1)]))}]]);var Fe=t(4443),Me={key:0,class:"fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-75"};const Te={props:{showing:{required:!0,type:Boolean}}},Oe=(0,_.A)(Te,[["render",function(e,a,t,n,o,l){return t.showing?((0,r.openBlock)(),(0,r.createElementBlock)("div",Me," The modal will go here. ")):(0,r.createCommentVNode)("",!0)}]]);var He=t(9092),Le=t.n(He),je=t(3424),Ue=t.n(je),qe=t(3356),Je=t.n(qe),Ye=t(8460),Ze=t.n(Ye),Ge=t(8216),Qe=t.n(Ge),Xe=t(864),We=t.n(Xe),Ke=(t(2326),t(8936)),ea=t(1743),aa=t(8640),ta=(t(3168),t(3688)),ra=t.n(ta);t(7042);function na(){var e,a,t="function"==typeof Symbol?Symbol:{},r=t.iterator||"@@iterator",n=t.toStringTag||"@@toStringTag";function o(t,r,n,o){var i=r&&r.prototype instanceof s?r:s,c=Object.create(i.prototype);return oa(c,"_invoke",function(t,r,n){var o,s,i,c=0,p=n||[],d=!1,m={p:0,n:0,v:e,a:u,f:u.bind(e,4),d:function(a,t){return o=a,s=0,i=e,m.n=t,l}};function u(t,r){for(s=t,i=r,a=0;!d&&c&&!n&&a<p.length;a++){var n,o=p[a],u=m.p,h=o[2];t>3?(n=h===r)&&(i=o[(s=o[4])?5:(s=3,3)],o[4]=o[5]=e):o[0]<=u&&((n=t<2&&u<o[1])?(s=0,m.v=r,m.n=o[1]):u<h&&(n=t<3||o[0]>r||r>h)&&(o[4]=t,o[5]=r,m.n=h,s=0))}if(n||t>1)return l;throw d=!0,r}return function(n,p,h){if(c>1)throw TypeError("Generator is already running");for(d&&1===p&&u(p,h),s=p,i=h;(a=s<2?e:i)||!d;){o||(s?s<3?(s>1&&(m.n=-1),u(s,i)):m.n=i:m.v=i);try{if(c=2,o){if(s||(n="next"),a=o[n]){if(!(a=a.call(o,i)))throw TypeError("iterator result is not an object");if(!a.done)return a;i=a.value,s<2&&(s=0)}else 1===s&&(a=o.return)&&a.call(o),s<2&&(i=TypeError("The iterator does not provide a '"+n+"' method"),s=1);o=e}else if((a=(d=m.n<0)?i:t.call(r,m))!==l)break}catch(a){o=e,s=1,i=a}finally{c=1}}return{value:a,done:d}}}(t,n,o),!0),c}var l={};function s(){}function i(){}function c(){}a=Object.getPrototypeOf;var p=[][r]?a(a([][r]())):(oa(a={},r,function(){return this}),a),d=c.prototype=s.prototype=Object.create(p);function m(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,c):(e.__proto__=c,oa(e,n,"GeneratorFunction")),e.prototype=Object.create(d),e}return i.prototype=c,oa(d,"constructor",c),oa(c,"constructor",i),i.displayName="GeneratorFunction",oa(c,n,"GeneratorFunction"),oa(d),oa(d,n,"Generator"),oa(d,r,function(){return this}),oa(d,"toString",function(){return"[object Generator]"}),(na=function(){return{w:o,m}})()}function oa(e,a,t,r){var n=Object.defineProperty;try{n({},"",{})}catch(e){n=0}oa=function(e,a,t,r){if(a)n?n(e,a,{value:t,enumerable:!r,configurable:!r,writable:!r}):e[a]=t;else{var o=function(a,t){oa(e,a,function(e){return this._invoke(a,t,e)})};o("next",0),o("throw",1),o("return",2)}},oa(e,a,t,r)}function la(e,a,t,r,n,o,l){try{var s=e[o](l),i=s.value}catch(e){return void t(e)}s.done?a(i):Promise.resolve(i).then(r,n)}t(8290);var sa,ia,ca=Le()(Ue(),Je(),Ze(),Qe(),We());(0,n.sj)({resolve:(sa=na().m(function e(a){var r,n;return na().w(function(e){for(;;)switch(e.n){case 0:return e.n=1,t(7256)("./".concat(a));case 1:return n=e.v.default,null!==(r=n.layout)&&void 0!==r||(n.layout=Re),e.a(2,n)}},e)}),ia=function(){var e=this,a=arguments;return new Promise(function(t,r){var n=sa.apply(e,a);function o(e){la(n,t,r,o,l,"next",e)}function l(e){la(n,t,r,o,l,"throw",e)}o(void 0)})},function(e){return ia.apply(this,arguments)}),setup:function(e){var a=e.el,t=e.App,o=e.props,l=e.plugin;(0,r.createApp)({render:function(){return(0,r.h)(t,o)}}).use(l).use(aa.A).component("multiselect",ea.A).component("Link",n.N_).component("Head",n.p3).component("CardModal",Oe).component("Notification",De).component("FilePond",ca).component("v-select",Ke.A).component("LoadingOverlay",ra()).mixin({data:function(){return{get jasper_ip(){return"paps.davaodeoro.gov.ph/"}}},methods:{QualityRateApp:function(e,a,t){var r=((Number(e)||0)+(Number(a)||0)+(Number(t)||0))/3;return r%1==0?r:parseFloat(r.toFixed(2))},EfficiencyRateApp:function(e,a,t){var r=[e,a,t].filter(function(e){return 0!==e});if(0===r.length)return 0;var n=r.reduce(function(e,a){return e+a},0)/r.length;return n%1==0?n:parseFloat(n.toFixed(2))},calculateAverageCore:function(e){var a=this,t=0,r=0;return Array.isArray(e)&&e.forEach(function(e){if("Core Function"===e.ipcr_type||"Core Function"===e.type){var n=Number(e.q1)||0,o=Number(e.q2)||0,l=Number(e.q3)||0,s=Number(e.e1)||0,i=Number(e.e2)||0,c=Number(e.e3)||0,p=a.AverageRateApp(a.QualityRateApp(n,o,l),a.EfficiencyRateApp("No"==e.efficiency1?0:s,"No"==e.efficiency2?0:i,"No"==e.efficiency3?0:c),"No"==e.timeliness?0:e.time);0!==(p=parseFloat(p))&&(t+=p,r+=1)}}),(r>0?t/r:0).toFixed(2)},calculateAverageSupport:function(e){var a=this,t=0,r=0;return Array.isArray(e)?e.forEach(function(e){if("Support Function"===e.ipcr_type||"Support Function"===e.type){var n=Number(e.q1)||0,o=Number(e.q2)||0,l=Number(e.q3)||0,s=Number(e.e1)||0,i=Number(e.e2)||0,c=Number(e.e3)||0,p=a.AverageRateApp(a.QualityRateApp(n,o,l),a.EfficiencyRateApp("No"==e.efficiency1?0:s,"No"==e.efficiency2?0:i,"No"==e.efficiency3?0:c),"No"==e.timeliness||null==e.time?0:e.time);0!==(p=parseFloat(p))&&(t+=p,r+=1)}}):console.log("data is not an array"),(r>0?t/r:0).toFixed(2)},AverageRateApp:function(e,a,t){var r=[e,a,t].filter(function(e){return 0!==e});if(0===r.length)return 0;var n=r.reduce(function(e,a){return e+a},0)/r.length;return n%1==0?n:parseFloat(n.toFixed(2))},sem:function(e){var a="";return"1"==e?a="January to June":2==e&&(a="July to December"),a},getAdjectivalScoreSemestral:function(e,a){return Math.round(100*(e+a))/100},EfficiencyRateSem:function(e,a,t){var r=0,n=0;if([e,a,t].forEach(function(e){0!==e&&(r+=e,n++)}),0===n)return 0;var o=r/n;return console.log(o),parseFloat(o.toFixed(2))},QualityRateSem:function(e,a,t){var r=(e+a+t)/3;return console.log(r),parseFloat(r.toFixed(2))},AverageComputationSem:function(e,a,t){var r=0,n=0;return[e,a,t].forEach(function(e){0!==e&&(r+=e,n++)}),0===n?0:parseFloat((r/n).toFixed(2))},SemName:function(e){return 1==e?"January to June":"July to December"},getAdjectivalScoreSem:function(e,a){return Math.round(100*(e+a))/100},getAdjectivalRatingSem:function(e){var a="";return e>=4.51&&e<=5?a="Outstanding":e>=3.51&&e<=4.5?a="Very Satisfactory":e>=2.51&&e<=3.5?a="Satisfactory":e>=1.51&&e<=2.5?a="Unsatisfactory":e>=1&&e<=1.5&&(a="Poor"),a},AverageRateSem:function(e,a,t){" "==t&&(t=0),""==t&&(t=0),isNaN(t)&&(t=0);var r=[parseFloat(e),parseFloat(a),parseFloat(t)].filter(function(e){return 0!==e});if(0===r.length)return 0;var n=r.reduce(function(e,a){return e+a},0)/r.length;return this.format_number_conv(n,2,!0)},calculateAverageCoreSem:function(e){var a=this,t=0,r=0,n=0;return Array.isArray(e)&&e.forEach(function(e){if("Core Function"===e.ipcr_type){var o=a.AverageComputationSem(a.QualityRateSem(e.avg_q1,e.avg_q2,e.avg_q3),a.EfficiencyRateSem(e.avg_e1,e.avg_e2,e.avg_e3),"No"==e.timeliness?0:e.avg_t1);0!==o&&(r+=1,t+=parseFloat(o),n=t/r)}}),n.toFixed(2)},calculateAverageSupportSem:function(e){var a=this,t=0,r=0,n=0;return Array.isArray(e)&&e.forEach(function(e){if("Support Function"===e.ipcr_type){var o=a.AverageComputationSem(a.QualityRateSem(e.avg_q1,e.avg_q2,e.avg_q3),a.EfficiencyRateSem(e.avg_e1,e.avg_e2,e.avg_e3),"No"==e.timeliness?0:e.avg_t1);0!==o&&(r+=1,t+=parseFloat(o),n=t/r)}}),n.toFixed(2)},formatDateRange:function(e,a){var t=new Date(e),r=new Date(a),n={month:"long",day:"numeric"},o=t.toLocaleDateString(void 0,n),l=r.toLocaleDateString(void 0,n);return t.getFullYear()!==r.getFullYear()?"".concat(o,", ").concat(t.getFullYear()," to ").concat(l,", ").concat(r.getFullYear()):"".concat(o," to ").concat(l,", ").concat(t.getFullYear())},stringAsArray:function(e){return e.split(this.delimiter)},format_number:function(e,a,t){return e.toLocaleString("en-US",{useGrouping:t,minimumFractionDigits:a,maximumFractionDigits:a})},format_number_conv:function(e,a,t){return parseFloat(e).toLocaleString("en-US",{useGrouping:t,minimumFractionDigits:a,maximumFractionDigits:a})},formatMonthDayYear:function(e){var a=e.split("-");return new Date(a[0],a[1]-1,a[2]).toLocaleDateString("en-US",{month:"long",day:"numeric",year:"numeric"})},getMonthName:function(e){var a=parseInt(e);return!isNaN(a)&&a>=1&&a<=12?["January","February","March","April","May","June","July","August","September","October","November","December"][a-1]:"Invalid Month"},getStatus:function(e){return"-2"===e?"Returned":"-1"===e?"Saved":"0"===e?"Submitted":"1"===e?"Reviewed":"2"===e?"Approved":"3"===e?"Final Approve":"Unknown Status"},getSemester:function(e){return"1"===e?"First Semester":"Second Semester"},getPeriod:function(e,a){return"1"===e?"January to June ".concat(a):"July to December ".concat(a)},getColor:function(e){return 1==e?"blue":0==e?"orange":2==e?"green":-1==e?"black":-2==e?"red":"black"},getActivityType:function(e){return"review target"===e?"Reviewed semestral target":"approve target"===e?"Approved semestral target":"review accomplishment"===e?"Reviewed monthly accomplishment":"approve accomplishment"===e?"Approved monthly accomplishment":"final approve accomplishment"===e?"Final approve accomplishment":"return accomplishment"===e?"Returned monthly accomplishment":"review semestral accomplishment"===e?"Reviewed semestral accomplishment":"approve semestral accomplishment"===e?"Approved semestral accomplishment":"return target"===e?"Returned target":"return semestral accomplishment"===e?"Returned semestral accomplishment":"returned additional target"===e?"Returned additional target":"reviewed additional target"===e?"Reviewed additional target":"approved additional target"===e?"Approved additional target":"reviewed additional target (new)"===e?"Reviewed semestral target":"approved additional target (new)"===e?"Approved semestral target":"returned additional target (new)"===e?"Returned target":"return accomplishment (for review)"===e?"Returned accomplishment (for review)":""},truncatedDescription:function(e){var a=e.split(" ");return a.length>10?a.slice(0,10).join(" ")+"...":e},truncatedDescriptionSpecificLength:function(e,a){var t=a,r=e.split(" ");return r.length>t?r.slice(0,t).join(" ")+"...":e},formatDateTimeDTS:function(e){var a=new Date(e),t=a.toLocaleDateString("en-US",{year:"numeric",month:"long",day:"numeric"}),r=a.getHours().toString().padStart(2,"0"),n=a.getMinutes().toString().padStart(2,"0"),o=" AM";r>12&&(r-=12,o=" PM");var l="".concat(r,":").concat(n).concat(o);return"".concat(t," -").concat(l)},getRowColorActed:function(e){return"return target"===e?"#faeeeb":"review target"===e?"#f0fafc":"approve target"===e?"#f7fcf8":"return accomplishment"===e?"#faeeeb":"review accomplishment"===e?"#f0fafc":"approve accomplishment"===e?"#f7fcf8":"return semestral accomplishment"===e?"#faeeeb":"review semestral accomplishment"===e?"#f0fafc":"approve semestral accomplishment"===e?"#f7fcf8":"returned additional target"===e?"#faeeeb":"reviewed additional target"===e?"#f0fafc":"approved additional target"===e?"#f7fcf8":""},getFontColorActed:function(e){return"return target"===e?"#a61805":"review target"===e?"#032c69":"approve target"===e?"#01820c":"returned additional target (new)"===e?"#a61805":"reviewed additional target (new)"===e?"#032c69":"approved additional target (new)"===e?"#01820c":"return accomplishment"===e?"#a61805":"review accomplishment"===e?"#032c69":"approve accomplishment"===e?"#01820c":"return semestral accomplishment"===e?"#a61805":"review semestral accomplishment"===e?"#032c69":"approve semestral accomplishment"===e?"#01820c":"returned additional target"===e?"#a61805":"reviewed additional target"===e?"#032c69":"approved additional target"===e?"#01820c":""},isLastDayOfSem:function(e,a){var t,r,n,o=new Date;if(1===(n=parseInt(e,10)))t=30,r=5;else{if(2!==n)return console.error("Invalid semester passed. Use 1 for first semester or 2 for second semester."),!1;t=31,r=11}return o+" semEndDate: "+new Date(a,r,t)},isPastDate:function(e,a,t){var r=new Date,n=parseInt(e),o=parseInt(a),l=parseInt(t);return n>1&&(o+=6),r>new Date(l,o,0)},filterNumbers:function(e,a){e.target.value.replace(/\D/g,"")},getEmpType:function(e){return{hdiv:"Hospital DPCR",hos:"HPCR",hsec:"Hospital SPCR"}[e]||null}}}).mount(a)},title:function(e){return"IPCR: "+e}}),Fe.y.init({delay:250,color:"#29d",includeCSS:!0,showSpinner:!1})},1688:()=>{},2634:()=>{},6420:(e,a,t)=>{"use strict";t.d(a,{A:()=>o});var r=t(6314),n=t.n(r)()(function(e){return e[1]});n.push([e.id,".bg-gradient-success.swal2-popup{background:linear-gradient(90deg,#036219,#80f541)!important}.bg-gradient-danger.swal2-popup{background:linear-gradient(90deg,#62030d,#ffb82a)!important}.bg-gradient-info.swal2-popup{background:linear-gradient(90deg,#0031f7,#4cdfe7)!important}.bg-gradient-deleted.swal2-popup{background:linear-gradient(90deg,#860202,#fb7676)!important}.swal2-title{color:#fff!important}",""]);const o=n},7256:(e,a,t)=>{var r={"./Acted_Review/Accomplishments":[7062,7062],"./Acted_Review/Accomplishments.vue":[7062,7062],"./Acted_Review/AccomplishmentsMonthly":[1689,1689],"./Acted_Review/AccomplishmentsMonthly.vue":[1689,1689],"./Acted_Review/Index":[6657,6657],"./Acted_Review/Index.vue":[6657,6657],"./Acted_Review/Targets":[296,296],"./Acted_Review/Targets.vue":[296,296],"./Charts/LinearChart":[9631,3660,2012],"./Charts/LinearChart.vue":[9631,3660,2012],"./Charts/LinearChart1":[9297,3660,9297],"./Charts/LinearChart1.vue":[9297,3660,9297],"./Daily_Accomplishment/Create":[6646,3660,6646],"./Daily_Accomplishment/Create.vue":[6646,3660,6646],"./Daily_Accomplishment/Index":[2449,2449],"./Daily_Accomplishment/Index.vue":[2449,2449],"./Dashboard/Index":[9194,3660,9194],"./Dashboard/Index.vue":[9194,3660,9194],"./DesignatedDivisionHeads/Create":[3208,3660,3208],"./DesignatedDivisionHeads/Create.vue":[3208,3660,3208],"./DesignatedDivisionHeads/Index":[2312,2312],"./DesignatedDivisionHeads/Index.vue":[2312,2312],"./EmployeeSpecialDepartment/Create":[324,3660,324],"./EmployeeSpecialDepartment/Create.vue":[324,3660,324],"./EmployeeSpecialDepartment/Index":[6679,6679],"./EmployeeSpecialDepartment/Index.vue":[6679,6679],"./Employees/All/Index":[987,987],"./Employees/All/Index.vue":[987,987],"./Employees/Email/Index":[9431,9431],"./Employees/Email/Index.vue":[9431,9431],"./Employees/EmailChangeLog/Index":[7191,7191],"./Employees/EmailChangeLog/Index.vue":[7191,7191],"./Employees/Index":[2835,2835],"./Employees/Index.vue":[2835,2835],"./Employees/PasswordChangeLog/Email":[5601,5601],"./Employees/PasswordChangeLog/Email.vue":[5601,5601],"./Employees/PasswordChangeLog/Index":[2823,2823],"./Employees/PasswordChangeLog/Index.vue":[2823,2823],"./Employees/Probationary/Create":[5341,3660,5341],"./Employees/Probationary/Create.vue":[5341,3660,5341],"./Employees/Probationary/Index":[9375,9375],"./Employees/Probationary/Index.vue":[9375,9375],"./Employees/Probationary/Targets/Create":[5720,3660,5720],"./Employees/Probationary/Targets/Create.vue":[5720,3660,5720],"./Employees/Probationary/Targets/Index":[6359,6359],"./Employees/Probationary/Targets/Index.vue":[6359,6359],"./Employees/ProbationaryFlex/Create":[2872,3660,2872],"./Employees/ProbationaryFlex/Create.vue":[2872,3660,2872],"./Employees/ProbationaryFlex/Index":[5069,5069],"./Employees/ProbationaryFlex/Index.vue":[5069,5069],"./Employees/ProbationaryFlex/Individual":[5839,5839],"./Employees/ProbationaryFlex/Individual.vue":[5839,5839],"./Employees/ProbationaryFlex/Targets/Create":[5840,3660,5840],"./Employees/ProbationaryFlex/Targets/Create.vue":[5840,3660,5840],"./Employees/ProbationaryFlex/Targets/Index":[8313,8313],"./Employees/ProbationaryFlex/Targets/Index.vue":[8313,8313],"./FAOs/Create":[8990,3660,8990],"./FAOs/Create.vue":[8990,3660,8990],"./FAOs/Index":[816,816],"./FAOs/Index.vue":[816,816],"./Forbidden/Index":[3484,3484],"./Forbidden/Index.vue":[3484,3484],"./Home":[4166,3660,4166],"./Home.vue":[4166,3660,4166],"./IPCR/Accomplishment/Index":[956,956],"./IPCR/Accomplishment/Index.vue":[956,956],"./IPCR/AccomplishmentRevised/Index":[1786,1786],"./IPCR/AccomplishmentRevised/Index.vue":[1786,1786],"./IPCR/IndividualOutput/Create":[7138,3660,7138],"./IPCR/IndividualOutput/Create.vue":[7138,3660,7138],"./IPCR/IndividualOutput/Index":[575,575],"./IPCR/IndividualOutput/Index.vue":[575,575],"./IPCR/Review/Index":[5022,5022],"./IPCR/Review/Index.vue":[5022,5022],"./IPCR/Review_Accomplishments/Index":[3630,3630],"./IPCR/Review_Accomplishments/Index.vue":[3630,3630],"./IPCR/Score/Index":[2388,2388],"./IPCR/Score/Index.vue":[2388,2388],"./IPCR/Semestral/Create":[9451,3660,9451],"./IPCR/Semestral/Create.vue":[9451,3660,9451],"./IPCR/Semestral/Index":[9497,9497],"./IPCR/Semestral/Index.vue":[9497,9497],"./IPCR/Semestral2/Create":[5954,3660,5954],"./IPCR/Semestral2/Create.vue":[5954,3660,5954],"./IPCR/Semestral2/Index":[8989,8989],"./IPCR/Semestral2/Index.vue":[8989,8989],"./IPCR/Targets/Create":[8267,3660,8267],"./IPCR/Targets/Create.vue":[8267,3660,8267],"./IPCR/Targets/Daily_Accomplishment/Create":[1288,3660,1288],"./IPCR/Targets/Daily_Accomplishment/Create.vue":[1288,3660,1288],"./IPCR/Targets/Daily_Accomplishment/Index":[1866,1866],"./IPCR/Targets/Daily_Accomplishment/Index.vue":[1866,1866],"./IPCR/Targets/Index":[6789,6789],"./IPCR/Targets/Index.vue":[6789,6789],"./IPCR_Tracking/Index":[1001,1001],"./IPCR_Tracking/Index.vue":[1001,1001],"./IndividualOutputs/Index":[6717,6717],"./IndividualOutputs/Index.vue":[6717,6717],"./Monthly_Accomplishment/Index":[4584,4584],"./Monthly_Accomplishment/Index.vue":[4584,4584],"./Offices/Create":[2122,3660,2122],"./Offices/Create.vue":[2122,3660,2122],"./Offices/Index":[4029,4029],"./Offices/Index.vue":[4029,4029],"./Offices/SummaryOfRating/Index":[2371,2371],"./Offices/SummaryOfRating/Index.vue":[2371,2371],"./Offices/SummaryOfRating/MonthlyRating":[1567,3948],"./Offices/SummaryOfRating/MonthlyRating.vue":[1567,3948],"./Offices/SummaryOfRating/SemestralRating":[8469,8469],"./Offices/SummaryOfRating/SemestralRating.vue":[8469,8469],"./PerformanceStandard/Index":[6151,6151],"./PerformanceStandard/Index.vue":[6151,6151],"./Poles/Index":[9001,9001],"./Poles/Index.vue":[9001,9001],"./Posts/Index":[1239,1239],"./Posts/Index.vue":[1239,1239],"./Semestral_Accomplishment/Approve":[2063,2063],"./Semestral_Accomplishment/Approve.vue":[2063,2063],"./Semestral_Accomplishment/Index":[963,963],"./Semestral_Accomplishment/Index.vue":[963,963],"./SummaryOfRating/Index":[7428,7428],"./SummaryOfRating/Index.vue":[7428,7428],"./SummaryOfRating/MonthlyRating":[6662,6662],"./SummaryOfRating/MonthlyRating.vue":[6662,6662],"./SummaryOfRating/SemestralRating":[1293,1293],"./SummaryOfRating/SemestralRating.vue":[1293,1293],"./Targets/Create":[5742,3660,5742],"./Targets/Create.vue":[5742,3660,5742],"./Targets/DPCR/Create":[3387,3660,3387],"./Targets/DPCR/Create.vue":[3387,3660,3387],"./Targets/Hospital/Create":[2948,3660,2948],"./Targets/Hospital/Create.vue":[2948,3660,2948],"./Targets/Hospital/Index":[4576,4576],"./Targets/Hospital/Index.vue":[4576,4576],"./Targets/Index":[5377,5377],"./Targets/Index.vue":[5377,5377],"./Users/BootstrapModalNoJquery":[1401,1401],"./Users/BootstrapModalNoJquery.vue":[1401,1401],"./Users/ChangeEmail":[4712,4712],"./Users/ChangeEmail.vue":[4712,4712],"./Users/ChangePassword":[2233,2233],"./Users/ChangePassword.vue":[2233,2233],"./Users/Create":[4199,4199],"./Users/Create.vue":[4199,4199],"./Users/Index":[1092,1092],"./Users/Index.vue":[1092,1092],"./Users/PermissionsModal":[6177,6177],"./Users/PermissionsModal.vue":[6177,6177],"./Users/Settings":[4267,4267],"./Users/Settings.vue":[4267,4267]};function n(e){if(!t.o(r,e))return Promise.resolve().then(()=>{var a=new Error("Cannot find module '"+e+"'");throw a.code="MODULE_NOT_FOUND",a});var a=r[e],n=a[0];return Promise.all(a.slice(1).map(t.e)).then(()=>t(n))}n.keys=()=>Object.keys(r),n.id=7256,e.exports=n},8290:(e,a,t)=>{window._=t(2543);try{window.bootstrap=t(454),window.$=window.jQuery=t(4692)}catch(e){}window.axios=t(2505),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"}},e=>{var a=a=>e(e.s=a);e.O(0,[8252,3660],()=>(a(1015),a(1688)));e.O()}]);
>>>>>>> 0bf1880625aceed12e45892af9083f9b0b1dad3d
