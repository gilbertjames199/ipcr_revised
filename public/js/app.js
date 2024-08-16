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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Nav: _Shared_Nav__WEBPACK_IMPORTED_MODULE_0__["default"],
    Footer: _Shared_Footer__WEBPACK_IMPORTED_MODULE_1__["default"],
    Sidebar: _Shared_Sidebar_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  }
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
      if (confirm("Are you sure you want to leave?")) {
        this.$inertia.get("/impersonate/leave", {}, {
          onSuccess: function onSuccess() {
            // Redirect or handle success response as needed
            window.location.reload(); // Optional: reload to apply changes
          },
          onError: function onError(errors) {
            console.error('Error during impersonation:', errors);
          }
        });
      }
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
      }); // Sidebar Activity Class

      var sidebarLinks = $(".sidebar").find(".sidebar-link");
      sidebarLinks.each(function (index, el) {
        $(el).removeClass("active");
      }).filter(function () {
        var href = $(this).attr("href");
        var pattern = href[0] === "/" ? href.substr(1) : href;
        return pattern === window.location.pathname.substr(1);
      }).addClass("active"); // ٍSidebar Toggle

      $(".sidebar-toggle").on("click", function (e) {
        $("body").toggleClass("is-collapsed");
        e.preventDefault();
      });
    });
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
/* harmony export */   "render": () => (/* binding */ render)
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
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("footer", {
  "class": "bdT ta-c p-30 lh-0 fsz-sm c-grey-600"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Developed by "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "https://davaodeoro.gov.ph/"
}, "PICTO")])], -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $App Screen Footer ### "), _hoisted_1], 2112
  /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */
  );
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
/* harmony export */   "render": () => (/* binding */ render)
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

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Sidebar), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Notification), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Nav), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default")])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Footer)])]);
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
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "header navbar"
};
var _hoisted_2 = {
  "class": "header-container",
  id: "sidebar-toggle",
  href: "javascript:void(0);"
};
var _hoisted_3 = {
  "class": "nav-left"
};

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "20",
  height: "20",
  fill: "black",
  "class": "bi bi-list",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
})], -1
/* HOISTED */
);

var _hoisted_5 = [_hoisted_4];

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
  "class": "search-input"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
  "class": "form-control",
  type: "text",
  placeholder: "Search..."
})], -1
/* HOISTED */
);

var _hoisted_7 = {
  key: 0,
  "class": "nav-left"
};
var _hoisted_8 = {
  id: "sidebar-toggle",
  "class": "sidebar-toggle"
};
var _hoisted_9 = {
  "class": "text-danger"
};

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("You are impersonating ");

var _hoisted_11 = {
  "class": "nav-right"
};
var _hoisted_12 = {
  "class": "dropdown"
};
var _hoisted_13 = {
  href: "",
  "class": "dropdown-toggle no-after peers fxw-nw ai-c lh-1",
  "data-bs-toggle": "dropdown"
};
var _hoisted_14 = {
  "class": "peer mR-10"
};
var _hoisted_15 = ["src"];
var _hoisted_16 = {
  "class": "peer"
};
var _hoisted_17 = {
  "class": "fsz-sm c-grey-900"
};

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "12",
  height: "12",
  fill: "currentColor",
  "class": "bi bi-caret-down-fill mL-5",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"
})], -1
/* HOISTED */
);

var _hoisted_19 = {
  "class": "dropdown-menu fsz-sm dropdown-menu-c"
};

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "14",
  height: "14",
  fill: "currentColor",
  "class": "bi bi-sliders2 mR-10",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"
})], -1
/* HOISTED */
);

var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Setting", -1
/* HOISTED */
);

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "14",
  height: "14",
  fill: "currentColor",
  "class": "bi bi-person-bounding-box mR-10",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
})], -1
/* HOISTED */
);

var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Change Password", -1
/* HOISTED */
);

var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "14",
  height: "14",
  fill: "currentColor",
  "class": "bi bi-envelope-at-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"
})], -1
/* HOISTED */
);

var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   ");

var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Change Email", -1
/* HOISTED */
);

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
  role: "separator",
  "class": "divider"
}, null, -1
/* HOISTED */
);

var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "14",
  height: "14",
  fill: "currentColor",
  "class": "bi bi-box-arrow-right mR-10",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"
})], -1
/* HOISTED */
);

var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, " Logout", -1
/* HOISTED */
);

var _hoisted_30 = [_hoisted_28, _hoisted_29];
var _hoisted_31 = {
  key: 1,
  "class": "nav-right"
};

var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "btn btn-danger text-white"
}, "LEAVE", -1
/* HOISTED */
);

var _hoisted_33 = [_hoisted_32];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    id: "sidebar-toggle",
    "class": "sidebar-toggle",
    href: "javascript:void(0);",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.toggleSidebar && $options.toggleSidebar.apply($options, arguments);
    })
  }, _hoisted_5), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ isActive }} ")]), _hoisted_6]), _ctx.$page.props.auth.impersonating === 'yes' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("ul", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_9, [_hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("u", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.user.name.employee_name), 1
  /* TEXT */
  )])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"notifications dropdown\">\r\n                    <span class=\"counter bgc-blue\">3</span>\r\n                    <a href=\"\" class=\"dropdown-toggle no-after\" data-bs-toggle=\"dropdown\"><svg\r\n                            xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-bell\"\r\n                            viewBox=\"0 0 16 16\">\r\n                            <path\r\n                                d=\"M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z\" />\r\n                        </svg></a>\r\n                    <ul class=\"dropdown-menu\">\r\n                        <li class=\"pX-20 pY-15 bdB\">\r\n                            <i class=\"ti-email pR-10\"></i>\r\n                            <span class=\"fsz-sm fw-600 c-grey-900\">Emails</span>\r\n                        </li>\r\n                        <li>\r\n                            <ul class=\"\r\n                                    ovY-a\r\n                                    pos-r\r\n                                    scrollable\r\n                                    lis-n\r\n                                    p-0\r\n                                    m-0\r\n                                    fsz-sm\r\n                                \">\r\n                                <li>\r\n                                    <a href=\"\" class=\"\r\n                                            peers\r\n                                            fxw-nw\r\n                                            td-n\r\n                                            p-20\r\n                                            bdB\r\n                                            c-grey-800\r\n                                            cH-blue\r\n                                            bgcH-grey-100\r\n                                        \">\r\n                                        <div class=\"peer mR-15\">\r\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/1.jpg\"\r\n                                                alt=\"\" />\r\n                                        </div>\r\n                                        <div class=\"peer peer-greed\">\r\n                                            <div>\r\n                                                <div class=\"\r\n                                                        peers\r\n                                                        jc-sb\r\n                                                        fxw-nw\r\n                                                        mB-5\r\n                                                    \">\r\n                                                    <div class=\"peer\">\r\n                                                        <p class=\"\r\n                                                                fw-500\r\n                                                                mB-0\r\n                                                            \">\r\n                                                            John Doe\r\n                                                        </p>\r\n                                                    </div>\r\n                                                    <div class=\"peer\">\r\n                                                        <small class=\"\r\n                                                                fsz-xs\r\n                                                            \">5 mins\r\n                                                            ago</small>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <span class=\"\r\n                                                        c-grey-600\r\n                                                        fsz-sm\r\n                                                    \">Want to create your\r\n                                                    own customized data\r\n                                                    generator for your\r\n                                                    app...</span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </a>\r\n                                </li>\r\n                                <li>\r\n                                    <a href=\"\" class=\"\r\n                                            peers\r\n                                            fxw-nw\r\n                                            td-n\r\n                                            p-20\r\n                                            bdB\r\n                                            c-grey-800\r\n                                            cH-blue\r\n                                            bgcH-grey-100\r\n                                        \">\r\n                                        <div class=\"peer mR-15\">\r\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/2.jpg\"\r\n                                                alt=\"\" />\r\n                                        </div>\r\n                                        <div class=\"peer peer-greed\">\r\n                                            <div>\r\n                                                <div class=\"\r\n                                                        peers\r\n                                                        jc-sb\r\n                                                        fxw-nw\r\n                                                        mB-5\r\n                                                    \">\r\n                                                    <div class=\"peer\">\r\n                                                        <p class=\"\r\n                                                                fw-500\r\n                                                                mB-0\r\n                                                            \">\r\n                                                            Moo Doe\r\n                                                        </p>\r\n                                                    </div>\r\n                                                    <div class=\"peer\">\r\n                                                        <small class=\"\r\n                                                                fsz-xs\r\n                                                            \">15 mins\r\n                                                            ago</small>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <span class=\"\r\n                                                        c-grey-600\r\n                                                        fsz-sm\r\n                                                    \">Want to create your\r\n                                                    own customized data\r\n                                                    generator for your\r\n                                                    app...</span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </a>\r\n                                </li>\r\n                                <li>\r\n                                    <a href=\"\" class=\"\r\n                                            peers\r\n                                            fxw-nw\r\n                                            td-n\r\n                                            p-20\r\n                                            bdB\r\n                                            c-grey-800\r\n                                            cH-blue\r\n                                            bgcH-grey-100\r\n                                        \">\r\n                                        <div class=\"peer mR-15\">\r\n                                            <img class=\"w-3r bdrs-50p\" src=\"https://randomuser.me/api/portraits/men/3.jpg\"\r\n                                                alt=\"\" />\r\n                                        </div>\r\n                                        <div class=\"peer peer-greed\">\r\n                                            <div>\r\n                                                <div class=\"\r\n                                                        peers\r\n                                                        jc-sb\r\n                                                        fxw-nw\r\n                                                        mB-5\r\n                                                    \">\r\n                                                    <div class=\"peer\">\r\n                                                        <p class=\"\r\n                                                                fw-500\r\n                                                                mB-0\r\n                                                            \">\r\n                                                            Lee Doe\r\n                                                        </p>\r\n                                                    </div>\r\n                                                    <div class=\"peer\">\r\n                                                        <small class=\"\r\n                                                                fsz-xs\r\n                                                            \">25 mins\r\n                                                            ago</small>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <span class=\"\r\n                                                        c-grey-600\r\n                                                        fsz-sm\r\n                                                    \">Want to create your\r\n                                                    own customized data\r\n                                                    generator for your\r\n                                                    app...</span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </a>\r\n                                </li>\r\n                            </ul>\r\n                        </li>\r\n                        <li class=\"pX-20 pY-15 ta-c bdT\">\r\n                            <span><a href=\"email.html\" class=\"\r\n                                        c-grey-600\r\n                                        cH-blue\r\n                                        fsz-sm\r\n                                        td-n\r\n                                    \">View All Email\r\n                                    <i class=\"\r\n                                            fs-xs\r\n                                            ti-angle-right\r\n                                            mL-10\r\n                                        \"></i></a></span>\r\n                        </li>\r\n                    </ul>\r\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("*********************************************"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"dropdown\">\r\n                    <a href=\"\" class=\"\r\n                            dropdown-toggle\r\n                            no-after\r\n                            peers\r\n                            fxw-nw\r\n                            ai-c\r\n                            lh-1\r\n                        \" data-bs-toggle=\"dropdown\">\r\n                        <div class=\"peer mR-10\">\r\n\r\n                            <img class=\"w-2r bdrs-50p\" :src=\"$page.props.auth.user.photo\" alt=\"\" />\r\n                        </div>\r\n                        <div class=\"peer\">\r\n                            <span class=\"fsz-sm c-grey-900\">{{ $page.props.auth.user.name.employee_name }}</span>\r\n                        </div>\r\n                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\"\r\n                            class=\"bi bi-caret-down-fill mL-5\" viewBox=\"0 0 16 16\">\r\n                            <path\r\n                                d=\"M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z\" />\r\n                        </svg>\r\n                    </a>\r\n                    <ul class=\"dropdown-menu fsz-sm dropdown-menu-c\">\r\n                        <li>\r\n                            <Link href=\"/users/settings\" class=\"\r\n                                    d-b\r\n                                    td-n\r\n                                    pY-5\r\n                                    bgcH-grey-100\r\n                                    c-grey-700\r\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\r\n                                class=\"bi bi-sliders2 mR-10\" viewBox=\"0 0 16 16\">\r\n                                <path fill-rule=\"evenodd\"\r\n                                    d=\"M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z\" />\r\n                            </svg>\r\n                            <span>Setting</span></Link>\r\n                        </li>\r\n                        <li>\r\n                            <Link href=\"/users/change-password\" class=\"\r\n                                    d-b\r\n                                    td-n\r\n                                    pY-5\r\n                                    bgcH-grey-100\r\n                                    c-grey-700\r\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\r\n                                class=\"bi bi-person-bounding-box mR-10\" viewBox=\"0 0 16 16\">\r\n                                <path\r\n                                    d=\"M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z\" />\r\n                                <path d=\"M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z\" />\r\n                            </svg>\r\n                            <span> Change Password</span></Link>\r\n                        </li>\r\n                        <li role=\"separator\" class=\"divider\"></li>\r\n                        <li>\r\n                            <a @click=\"logout()\" href=\"\" class=\"\r\n                                    d-b\r\n                                    td-n\r\n                                    pY-5\r\n                                    bgcH-grey-100\r\n                                    c-grey-700\r\n                                \"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" fill=\"currentColor\"\r\n                                    class=\"bi bi-box-arrow-right mR-10\" viewBox=\"0 0 16 16\">\r\n                                    <path fill-rule=\"evenodd\"\r\n                                        d=\"M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z\" />\r\n                                    <path fill-rule=\"evenodd\"\r\n                                        d=\"M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z\" />\r\n                                </svg>\r\n                                <span> Logout</span></a>\r\n                        </li>\r\n                    </ul>\r\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("*********************************************"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li v-if=\"$page.props.auth.impersonating === 'yes'\" class=\"dropdown\">\r\n\r\n                    <a href=\"/impersonate/leave\" class=\"\r\n                            dropdown-toggle\r\n                            no-after\r\n                            peers\r\n                            fxw-nw\r\n                            ai-c\r\n                            lh-1\r\n                        \" data-bs-toggle=\"dropdown\">\r\n\r\n                        <h5>Leave</h5>\r\n\r\n                    </a>\r\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    "class": "w-2r bdrs-50p",
    src: _ctx.$page.props.auth.user.photo,
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_15)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.user.name.employee_name), 1
  /* TEXT */
  )]), _hoisted_18]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/users/settings",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_20, _hoisted_21];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/users/change-password",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_22, _hoisted_23];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    href: "/email/change",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_24, _hoisted_25, _hoisted_26];
    }),
    _: 1
    /* STABLE */

  })]), _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return $options.logout();
    }),
    href: "",
    "class": "d-b td-n pY-5 bgcH-grey-100 c-grey-700"
  }, _hoisted_30)])])])]), _ctx.$page.props.auth.impersonating === 'yes' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("u", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    id: "sidebar-toggle",
    "class": "sidebar-toggled",
    href: "javascript:void(0);",
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.impersonateLeave && $options.impersonateLeave.apply($options, arguments);
    })
  }, _hoisted_33), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ isActive }} ")])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
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
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "position-fixed top-0 end-0 p-3",
  style: {
    "z-index": "1000"
  }
};

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "toast align-items-center",
  role: "alert",
  "aria-atomic": "true",
  "aria-live": "polite",
  "data-bs-autohide": "true",
  "data-bs-delay": "5000"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-success\" v-if=\"$page.props.flash.message !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #94ffb0;\">\r\n                        <path\r\n                            d=\"M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223Z\" />\r\n                        <path\r\n                            d=\"M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                        <path\r\n                            d=\"M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                        <path\r\n                            d=\"M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.message }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-danger\" v-if=\"$page.props.flash.error !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #FF5733;\">\r\n                        <path\r\n                            d=\"M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z\" />\r\n                        <path\r\n                            d=\"M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z\" />\r\n                    </svg>\r\n                    &nbsp;<b>{{ $page.props.flash.error }}</b>\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-info\" v-if=\"$page.props.flash.info !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #b8f8ff;\">\r\n                        <path\r\n                            d=\"M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Zm3.631-4.538c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.info }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-gradient-deleted\" v-if=\"$page.props.flash.deleted !== null\">\r\n                <div class=\"toast-body\">\r\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" class=\"bi bi-backspace-fill\"\r\n                        viewBox=\"0 0 16 16\" style=\"fill: #f46c89;\">\r\n                        <path\r\n                            d=\"M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z\" />\r\n                        <path\r\n                            d=\"M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z\" />\r\n                    </svg>\r\n                    {{ $page.props.flash.deleted }}\r\n                </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("**********************"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"d-flex text-white bg-success\" v-if=\"$page.props.flash.message !== null\">\r\n                <div class=\"toast-body\">\r\n                    {{$page.props.flash.message}}\r\n            </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div>\r\n\r\n            <div class=\"d-flex text-white bg-danger\" v-if=\"$page.props.flash.error !== null\">\r\n                <div class=\"toast-body\">\r\n                    {{$page.props.flash.error}}\r\n            </div>\r\n                <button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>\r\n            </div> ")], -1
/* HOISTED */
);

var _hoisted_3 = [_hoisted_2];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, _hoisted_3);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0":
/*!*************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "sidebar"
};
var _hoisted_2 = {
  "class": "sidebar-inner"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"sidebar-logo\"><div class=\"peers ai-c fxw-nw\"><div class=\"peer peer-greed\"><a class=\"sidebar-link td-n\" href=\"/\"><div class=\"peers ai-c fxw-nw\"><div class=\"peer\"><div class=\"logo\"><img src=\"/images/logo.png\" alt=\"\" class=\"img-fluid p-5\"></div></div><div class=\"peer peer-greed\"><h5 class=\"lh-1 mB-0 logo-text\"><span style=\"color:#FFF;font-size:medium;\">  Performance Management <!-- {{ $page.props.auth.user.name.position_long_title }} --></span></h5></div></div></a></div><div class=\"peer\"><div class=\"mobile-toggle sidebar-toggle\"><a href=\"\" class=\"td-n\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"black\" class=\"bi bi-list\" viewBox=\"0 0 16 16\"><path fill-rule=\"evenodd\" d=\"M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z\"></path></svg></a><!-- &lt;div class=&quot;text-white&quot;&gt;gfgdgdfg&lt;/div&gt; --></div></div></div></div>", 1);

var _hoisted_4 = {
  "class": "sidebar-menu scrollable pos-r"
};
var _hoisted_5 = {
  "class": "nav-item mT-30 actived"
};

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "20",
  height: "20",
  fill: "currentColor",
  "class": "bi bi-house-door",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"
})])], -1
/* HOISTED */
);

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Dashboard", -1
/* HOISTED */
);

var _hoisted_8 = {
  "class": "nav-item dropdown"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<a class=\"dropdown-toggle\" href=\"javascript:void(0);\"><span class=\"icon-holder\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-clipboard-check-fill\" viewBox=\"0 0 16 16\"><path d=\"M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z\"></path><path d=\"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z\"></path></svg></span><span class=\"title\">Targets</span><span class=\"arrow\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-right\" viewBox=\"0 0 16 16\"><path fill-rule=\"evenodd\" d=\"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z\"></path></svg></span></a>", 1);

var _hoisted_10 = {
  "class": "dropdown-menu"
};

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "IPCR Targets", -1
/* HOISTED */
);

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Probationary/Temporary", -1
/* HOISTED */
);

var _hoisted_13 = {
  "class": "nav-item"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-calendar-event-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"
})])], -1
/* HOISTED */
);

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Daily Accomplishment", -1
/* HOISTED */
);

var _hoisted_17 = {
  "class": "nav-item"
};

var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-clipboard-check-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"
})])], -1
/* HOISTED */
);

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Accomplishment", -1
/* HOISTED */
);

var _hoisted_21 = {
  key: 0,
  "class": "nav-item"
};

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-clipboard-check-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"
})])], -1
/* HOISTED */
);

var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Summary of Ratings", -1
/* HOISTED */
);

var _hoisted_25 = {
  "class": "nav-item"
};

var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-clipboard-check-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"
})])], -1
/* HOISTED */
);

var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Probationary/Temporary", -1
/* HOISTED */
);

var _hoisted_29 = {
  key: 1,
  "class": "nav-item"
};

var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "20",
  height: "20",
  fill: "currentColor",
  "class": "bi bi-people",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
})])], -1
/* HOISTED */
);

var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Employees ", -1
/* HOISTED */
);

var _hoisted_33 = {
  "class": "nav-item dropdown"
};
var _hoisted_34 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};

var _hoisted_35 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "20",
  height: "20",
  fill: "currentColor",
  "class": "bi bi-hand-thumbs-up-fill",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"
})])], -1
/* HOISTED */
);

var _hoisted_36 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Review/Approve", -1
/* HOISTED */
);

var _hoisted_37 = {
  key: 0,
  "class": "text-danger strong"
};

var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "arrow"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-chevron-right",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
})])], -1
/* HOISTED */
);

var _hoisted_39 = {
  "class": "dropdown-menu"
};
var _hoisted_40 = {
  "class": "nav-item dropdown"
};
var _hoisted_41 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};
var _hoisted_42 = {
  "class": "title"
};

var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Targets ");

var _hoisted_44 = {
  key: 0,
  "class": "text-danger strong"
};

var _hoisted_45 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "arrow"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-chevron-right",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
})])], -1
/* HOISTED */
);

var _hoisted_46 = {
  "class": "dropdown-menu"
};

var _hoisted_47 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "  For Approval", -1
/* HOISTED */
);

var _hoisted_48 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "  Acted Target", -1
/* HOISTED */
);

var _hoisted_49 = {
  "class": "nav-item dropdown"
};
var _hoisted_50 = {
  "class": "dropdown-toggle",
  href: "javascript:void(0);"
};
var _hoisted_51 = {
  "class": "title"
};

var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Accomplishment ");

var _hoisted_53 = {
  key: 0,
  "class": "text-danger strong"
};

var _hoisted_54 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "arrow"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-chevron-right",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
})])], -1
/* HOISTED */
);

var _hoisted_55 = {
  "class": "dropdown-menu"
};
var _hoisted_56 = {
  "class": "title"
};

var _hoisted_57 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  Monthly ");

var _hoisted_58 = {
  key: 0,
  "class": "text-danger strong"
};

var _hoisted_59 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "  Acted (monthly)", -1
/* HOISTED */
);

var _hoisted_60 = {
  "class": "title"
};

var _hoisted_61 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("  Semestral ");

var _hoisted_62 = {
  key: 0,
  "class": "text-danger strong"
};

var _hoisted_63 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "  Acted (semestral)", -1
/* HOISTED */
);

var _hoisted_64 = {
  key: 2,
  "class": "nav-item dropdown"
};

var _hoisted_65 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<a class=\"dropdown-toggle\" href=\"javascript:void(0);\"><span class=\"icon-holder\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-clipboard-check-fill\" viewBox=\"0 0 16 16\"><path d=\"M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z\"></path><path d=\"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z\"></path></svg></span><span class=\"title\">Utilities</span><span class=\"arrow\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-right\" viewBox=\"0 0 16 16\"><path fill-rule=\"evenodd\" d=\"M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z\"></path></svg></span></a>", 1);

var _hoisted_66 = {
  "class": "dropdown-menu"
};
var _hoisted_67 = {
  key: 0
};

var _hoisted_68 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Performance Standard ", -1
/* HOISTED */
);

var _hoisted_69 = {
  key: 1
};

var _hoisted_70 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Ratings", -1
/* HOISTED */
);

var _hoisted_71 = {
  key: 2
};

var _hoisted_72 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Individual Final Outputs", -1
/* HOISTED */
);

var _hoisted_73 = {
  key: 3
};

var _hoisted_74 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Employees Special Department", -1
/* HOISTED */
);

var _hoisted_75 = {
  key: 4
};

var _hoisted_76 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Employees", -1
/* HOISTED */
);

var _hoisted_77 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "Password Change Log", -1
/* HOISTED */
);

var _hoisted_78 = {
  "class": "nav-item"
};

var _hoisted_79 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, null, -1
/* HOISTED */
);

var _hoisted_80 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon-holder"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  "class": "bi bi-list-check",
  viewBox: "0 0 16 16"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "fill-rule": "evenodd",
  d: "M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"
})])], -1
/* HOISTED */
);

var _hoisted_81 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "title"
}, "IPCR Tracking", -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $Sidebar Header ### "), _hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ### $Sidebar Menu ### "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": "sidebar-link",
    href: "/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_6, _hoisted_7];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("TARGETS"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/ipcrsemestral/".concat(_ctx.$page.props.auth.user.name.id, "/direct")
    }]),
    href: "/ipcrsemestral/".concat(_ctx.$page.props.auth.user.name.id, "/direct")
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_11];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href", "class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/probationary/temporary/individual/targets/list'
    }]),
    href: "/probationary/temporary/individual/targets/list"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_12];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/Daily_Accomplishment"
    }]),
    href: "/Daily_Accomplishment"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_14, _hoisted_15, _hoisted_16];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/monthly-accomplishment"
    }]),
    href: "/monthly-accomplishment"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_18, _hoisted_19, _hoisted_20];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), _ctx.$page.props.auth.user.salary_grade >= 18 || _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/summary-rating"
    }]),
    href: "/summary-rating"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_22, _hoisted_23, _hoisted_24];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"nav-item\">\r\n                    <Link class=\"sidebar-link\" :href=\"`/probationary/temporary`\">\r\n                        <span></span>\r\n                        <span class=\"icon-holder\">\r\n                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-clipboard-check-fill\" viewBox=\"0 0 16 16\">\r\n                            <path d=\"M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z\"/>\r\n                            <path d=\"M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z\"/>\r\n                            </svg>\r\n                        </span>\r\n                        <span class=\"title\">Probationary/Temporary</span>\r\n                    </Link>\r\n                </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/probationary/'
    }]),
    href: "/probationary/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_26, _hoisted_27, _hoisted_28];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n                <li class=\"nav-item mT-30 actived\">\r\n                    <Link class=\"sidebar-link\" href=\"/\"\r\n                        ><span class=\"icon-holder\">\r\n\r\n                        </span\r\n                        >\r\n                        <span class=\"title\">Personnel</span></Link\r\n                    >\r\n                </li>\r\n                "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("\r\n                <li class=\"nav-item\">\r\n                    <Link class=\"sidebar-link\" href=\"/posts\"\r\n                        ><span class=\"icon-holder\"\r\n                            ><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-file-earmark-post\" viewBox=\"0 0 16 16\">\r\n                              <path d=\"M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z\"/>\r\n                              <path d=\"M4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7zm0-3a.5.5 0 0 1 .5-.5H7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5z\"/>\r\n                            </svg>\r\n                        </span\r\n                        ><span class=\"title\">Posts</span></Link\r\n                    >\r\n                </li>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("ALL REPORTS"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("Users  "), _ctx.$page.props.auth.user.salary_grade >= 18 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === '/employees'
    }]),
    href: "/employees"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_30, _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" {{ $page.props.auth.user.salary_grade }} "), _hoisted_32];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("Review/Approve"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_34, [_hoisted_35, _hoisted_36, _ctx.$page.props.auth.targets >= 1 || _ctx.$page.props.auth.sem >= 1 || _ctx.$page.props.auth.month >= 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, " (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.targets + _ctx.$page.props.auth.sem + _ctx.$page.props.auth.month) + ")", 1
  /* TEXT */
  )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_38]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_42, [_hoisted_43, _ctx.$page.props.auth.targets ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.targets) + ")", 1
  /* TEXT */
  )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _hoisted_45]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/review/approve"
    }]),
    href: "/review/approve"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_47];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/targets"
    }]),
    href: "/acted/particulars/targets"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_48];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_50, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_51, [_hoisted_52, _ctx.$page.props.auth.sem >= 1 || _ctx.$page.props.auth.month >= 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, " (" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.sem + _ctx.$page.props.auth.month) + ")", 1
  /* TEXT */
  )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _hoisted_54]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_55, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/approve/accomplishments"
    }]),
    href: "/approve/accomplishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_56, [_hoisted_57, _ctx.$page.props.auth.month ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.month) + ")", 1
      /* TEXT */
      )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/accomp/lishments/monthly"
    }]),
    href: "/acted/particulars/accomp/lishments/monthly"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_59];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/approve/semestral-accomplishments"
    }]),
    href: "/approve/semestral-accomplishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_60, [_hoisted_61, _ctx.$page.props.auth.sem ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_62, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "(" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$page.props.auth.sem) + ")", 1
      /* TEXT */
      )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/acted/particulars/accomp/lishments"
    }]),
    href: "/acted/particulars/accomp/lishments"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_63];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("PERFORMANCE STANDARD"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    "), _ctx.$page.props.auth.user.name.empl_id == '2960' || _ctx.$page.props.auth.user.name.empl_id == '2730' || _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_64, [_hoisted_65, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_66, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" v-if=\"$page.props.auth.user.name.empl_id==='2960' || $page.props.auth.user.name.empl_id==='2730'\r\n                            $page.props.auth.user.name.empl_id==='8510' || $page.props.auth.user.name.empl_id==='8354'\" "), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_67, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/imports/performance/standard"
    }]),
    href: "/imports/performance/standard"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_68];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_69, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/ipcr/score"
    }]),
    href: "/ipcr/score"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_70];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_71, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/individual-final-output-crud"
    }]),
    href: "/individual-final-output-crud"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_72];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id != '2003' && _ctx.$page.props.auth.user.name.empl_id != '8447' && _ctx.$page.props.auth.user.name.empl_id != '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_73, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/employee/special/department"
    }]),
    href: "/employee/special/department"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_74];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_75, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/employees/all"
    }]),
    href: "/employees/all"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_76];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [_ctx.$page.props.auth.user.name.empl_id == '8510' || _ctx.$page.props.auth.user.name.empl_id == '8354' || _ctx.$page.props.auth.user.name.empl_id == '2003' || _ctx.$page.props.auth.user.name.empl_id == '8447' || _ctx.$page.props.auth.user.name.empl_id == '8753' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
    key: 0,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/password/change/log"
    }]),
    href: "/password/change/log"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_77];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_78, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Link, {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar-link", {
      'active': _ctx.$page.url === "/IPCR_Tracking"
    }]),
    href: "/IPCR_Tracking"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_79, _hoisted_80, _hoisted_81];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["class"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("************")])])]);
}

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Shared_Layout__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Shared/Layout */ "./resources/js/Shared/Layout.vue");
/* harmony import */ var _Shared_Notification__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Shared/Notification */ "./resources/js/Shared/Notification.vue");
/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @inertiajs/progress */ "./node_modules/@inertiajs/progress/dist/index.js");
/* harmony import */ var _Shared_CardModal__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./Shared/CardModal */ "./resources/js/Shared/CardModal.vue");
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vue-filepond */ "./node_modules/vue-filepond/dist/vue-filepond.js");
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(vue_filepond__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! filepond-plugin-file-validate-type */ "./node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js");
/* harmony import */ var filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! filepond-plugin-image-preview */ "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js");
/* harmony import */ var filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! filepond-plugin-file-validate-size */ "./node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js");
/* harmony import */ var filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! filepond-plugin-image-crop */ "./node_modules/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js");
/* harmony import */ var filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! filepond-plugin-image-transform */ "./node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js");
/* harmony import */ var filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var vue_select_dist_vue_select_css__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vue-select/dist/vue-select.css */ "./node_modules/vue-select/dist/vue-select.css");
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! vue-select */ "./node_modules/vue-select/dist/vue-select.js");
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(vue_select__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var _vueform_multiselect__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @vueform/multiselect */ "./node_modules/@vueform/multiselect/dist/multiselect.js");
/* harmony import */ var vue_sweetalert2__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! vue-sweetalert2 */ "./node_modules/vue-sweetalert2/dist/vue-sweetalert.umd.js");
/* harmony import */ var vue_sweetalert2__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(vue_sweetalert2__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var sweetalert2_dist_sweetalert2_min_css__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! sweetalert2/dist/sweetalert2.min.css */ "./node_modules/sweetalert2/dist/sweetalert2.min.css");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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

var FilePond = vue_filepond__WEBPACK_IMPORTED_MODULE_7___default()((filepond_plugin_file_validate_type__WEBPACK_IMPORTED_MODULE_8___default()), (filepond_plugin_image_preview__WEBPACK_IMPORTED_MODULE_9___default()), (filepond_plugin_file_validate_size__WEBPACK_IMPORTED_MODULE_10___default()), (filepond_plugin_image_crop__WEBPACK_IMPORTED_MODULE_11___default()), (filepond_plugin_image_transform__WEBPACK_IMPORTED_MODULE_12___default()));
(0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__.createInertiaApp)({
  resolve: function () {
    var _resolve = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(name) {
      var _page$layout;

      var page;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return __webpack_require__("./resources/js/Pages lazy recursive ^\\.\\/.*$")("./".concat(name));

            case 2:
              page = _context.sent["default"];
              (_page$layout = page.layout) !== null && _page$layout !== void 0 ? _page$layout : page.layout = _Shared_Layout__WEBPACK_IMPORTED_MODULE_3__["default"];
              return _context.abrupt("return", page);

            case 5:
            case "end":
              return _context.stop();
          }
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
    (0,vue__WEBPACK_IMPORTED_MODULE_1__.createApp)({
      render: function render() {
        return (0,vue__WEBPACK_IMPORTED_MODULE_1__.h)(App, props);
      }
    }).use(plugin).use((vue_sweetalert2__WEBPACK_IMPORTED_MODULE_16___default())).component("multiselect", _vueform_multiselect__WEBPACK_IMPORTED_MODULE_15__["default"]).component("Link", _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__.Link).component("Head", _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__.Head).component('CardModal', _Shared_CardModal__WEBPACK_IMPORTED_MODULE_6__["default"]).component("Notification", _Shared_Notification__WEBPACK_IMPORTED_MODULE_4__["default"]).component("FilePond", FilePond).component("v-select", (vue_select__WEBPACK_IMPORTED_MODULE_14___default())).mixin({
      data: function data() {
        return {
          get jasper_ip() {
            // var lo = "192.168.6.23:8080/";
            // var gl = "122.54.19.171:8080/";
            var nw = "122.53.120.27:8080/";
            var nw_loc = "192.168.6.48:8080/"; //var nw_temp = "120.72.21.122:8080/"

            return nw;
          }

        };
      },
      methods: {
        formatDateRange: function formatDateRange(dateFrom, dateTo) {
          var fromDate = new Date(dateFrom);
          var toDate = new Date(dateTo); // Define formatting options for the 'from' and 'to' dates

          var options = {
            month: 'long',
            day: 'numeric'
          }; // Format the 'from' and 'to' dates

          var formattedFromDate = fromDate.toLocaleDateString(undefined, options);
          var formattedToDate = toDate.toLocaleDateString(undefined, options); // Construct the date range string

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
          var dateObj = new Date(dateTimeStr); // Options for formatting the date part

          var dateOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          };
          var formattedDate = dateObj.toLocaleDateString('en-US', dateOptions); // Extract the time parts

          var hours = dateObj.getHours().toString().padStart(2, '0');
          var minutes = dateObj.getMinutes().toString().padStart(2, '0'); // const seconds = dateObj.getSeconds().toString().padStart(2, '0');

          var mer = ' AM';

          if (hours > 12) {
            hours = hours - 12;
            mer = ' PM';
          } // Format the time part


          var formattedTime = "".concat(hours, ":").concat(minutes).concat(mer); // Combine the date and time parts

          return "".concat(formattedDate, " -").concat(formattedTime);
        },
        getRowColorActed: function getRowColorActed(type) {
          if (type === 'return target') {
            return '#faeeeb';
          } else if (type === 'review target') {
            return '#f0fafc';
          } else if (type === 'approve target') {
            return '#f7fcf8';
          } else if (type === 'return accomplishment') {
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
          if (type === 'return target') {
            return '#a61805';
          } else if (type === 'review target') {
            return '#032c69';
          } else if (type === 'approve target') {
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
        }
      }
    }).mount(el);
  },
  title: function title(_title) {
    return 'IPCR: ' + _title;
  }
});
_inertiajs_progress__WEBPACK_IMPORTED_MODULE_5__.InertiaProgress.init({
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

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_CardModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/CardModal.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Footer.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Layout_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Layout.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Nav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Nav.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Notification.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

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
/* harmony import */ var _Sidebar_vue_vue_type_template_id_f6a89ea0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=template&id=f6a89ea0 */ "./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0");
/* harmony import */ var _Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=script&lang=js */ "./resources/js/Shared/Sidebar.vue?vue&type=script&lang=js");
/* harmony import */ var D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_xampp_htdocs_ipcr_ipcr_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Sidebar_vue_vue_type_template_id_f6a89ea0__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Shared/Sidebar.vue"]])
/* hot reload */
if (false) {}


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

/***/ "./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751":
/*!*************************************************************************!*\
  !*** ./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751 ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CardModal_vue_vue_type_template_id_09736751__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CardModal.vue?vue&type=template&id=09736751 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/CardModal.vue?vue&type=template&id=09736751");


/***/ }),

/***/ "./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_a77bcb12__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=template&id=a77bcb12 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Footer.vue?vue&type=template&id=a77bcb12");


/***/ }),

/***/ "./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086":
/*!**********************************************************************!*\
  !*** ./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Layout_vue_vue_type_template_id_6bf30086__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Layout.vue?vue&type=template&id=6bf30086 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Layout.vue?vue&type=template&id=6bf30086");


/***/ }),

/***/ "./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7":
/*!*******************************************************************!*\
  !*** ./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7 ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Nav_vue_vue_type_template_id_42f6d0f7__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Nav.vue?vue&type=template&id=42f6d0f7 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Nav.vue?vue&type=template&id=42f6d0f7");


/***/ }),

/***/ "./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72":
/*!****************************************************************************!*\
  !*** ./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Notification_vue_vue_type_template_id_f2d83a72__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Notification.vue?vue&type=template&id=f2d83a72 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Notification.vue?vue&type=template&id=f2d83a72");


/***/ }),

/***/ "./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0":
/*!***********************************************************************!*\
  !*** ./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0 ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_f6a89ea0__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_f6a89ea0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=template&id=f6a89ea0 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Shared/Sidebar.vue?vue&type=template&id=f6a89ea0");


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