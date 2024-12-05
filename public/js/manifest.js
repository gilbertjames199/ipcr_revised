<<<<<<< HEAD
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			loaded: false,
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/ensure chunk */
/******/ 	(() => {
/******/ 		__webpack_require__.f = {};
/******/ 		// This file contains only the entry chunk.
/******/ 		// The chunk loading function for additional chunks
/******/ 		__webpack_require__.e = (chunkId) => {
/******/ 			return Promise.all(Object.keys(__webpack_require__.f).reduce((promises, key) => {
/******/ 				__webpack_require__.f[key](chunkId, promises);
/******/ 				return promises;
/******/ 			}, []));
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/get javascript chunk filename */
/******/ 	(() => {
/******/ 		// This function allow to reference async chunks
/******/ 		__webpack_require__.u = (chunkId) => {
/******/ 			// return url for filenames not based on template
/******/ 			if ({"resources_js_Pages_Acted_Review_Accomplishments_vue":1,"resources_js_Pages_Acted_Review_AccomplishmentsMonthly_vue":1,"resources_js_Pages_Acted_Review_Index_vue":1,"resources_js_Pages_Acted_Review_Targets_vue":1,"resources_js_Pages_Charts_LinearChart_vue":1,"resources_js_Pages_Charts_LinearChart1_vue":1,"resources_js_Pages_Daily_Accomplishment_Create_vue":1,"resources_js_Pages_Daily_Accomplishment_Index_vue":1,"resources_js_Pages_Dashboard_Index_vue":1,"resources_js_Pages_EmployeeSpecialDepartment_Create_vue":1,"resources_js_Pages_EmployeeSpecialDepartment_Index_vue":1,"resources_js_Pages_Employees_All_Index_vue":1,"resources_js_Pages_Employees_Email_Index_vue":1,"resources_js_Pages_Employees_EmailChangeLog_Index_vue":1,"resources_js_Pages_Employees_Index_vue":1,"resources_js_Pages_Employees_PasswordChangeLog_Email_vue":1,"resources_js_Pages_Employees_PasswordChangeLog_Index_vue":1,"resources_js_Pages_Employees_Probationary_Create_vue":1,"resources_js_Pages_Employees_Probationary_Index_vue":1,"resources_js_Pages_Employees_Probationary_Targets_Create_vue":1,"resources_js_Pages_Employees_Probationary_Targets_Index_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Create_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Index_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Individual_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Targets_Create_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Targets_Index_vue":1,"resources_js_Pages_FAOs_Create_vue":1,"resources_js_Pages_FAOs_Index_vue":1,"resources_js_Pages_Forbidden_Index_vue":1,"resources_js_Pages_Home_vue":1,"resources_js_Pages_IPCR_Accomplishment_Index_vue":1,"resources_js_Pages_IPCR_IndividualOutput_Create_vue":1,"resources_js_Pages_IPCR_IndividualOutput_Index_vue":1,"resources_js_Pages_IPCR_Review_Index_vue":1,"resources_js_Pages_IPCR_Review_Accomplishments_Index_vue":1,"resources_js_Pages_IPCR_Score_Index_vue":1,"resources_js_Pages_IPCR_Semestral_Create_vue":1,"resources_js_Pages_IPCR_Semestral_Index_vue":1,"resources_js_Pages_IPCR_Targets_Create_vue":1,"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Create_vue":1,"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Index_vue":1,"resources_js_Pages_IPCR_Targets_Index_vue":1,"resources_js_Pages_IPCR_Tracking_Index_vue":1,"resources_js_Pages_IndividualOutputs_Index_vue":1,"resources_js_Pages_Monthly_Accomplishment_Index_vue":1,"resources_js_Pages_Offices_Index_vue":1,"resources_js_Pages_Offices_SummaryOfRating_Index_vue":1,"resources_js_Pages_Offices_SummaryOfRating_MonthlyRating_vue":1,"resources_js_Pages_Offices_SummaryOfRating_SemestralRating_vue":1,"resources_js_Pages_PerformanceStandard_Index_vue":1,"resources_js_Pages_Poles_Index_vue":1,"resources_js_Pages_Posts_Index_vue":1,"resources_js_Pages_Semestral_Accomplishment_Approve_vue":1,"resources_js_Pages_Semestral_Accomplishment_Index_vue":1,"resources_js_Pages_SummaryOfRating_Index_vue":1,"resources_js_Pages_SummaryOfRating_MonthlyRating_vue":1,"resources_js_Pages_SummaryOfRating_SemestralRating_vue":1,"resources_js_Pages_Users_BootstrapModalNoJquery_vue":1,"resources_js_Pages_Users_ChangeEmail_vue":1,"resources_js_Pages_Users_ChangePassword_vue":1,"resources_js_Pages_Users_Create_vue":1,"resources_js_Pages_Users_Index_vue":1,"resources_js_Pages_Users_PermissionsModal_vue":1,"resources_js_Pages_Users_Settings_vue":1}[chunkId]) return "js/" + chunkId + ".js";
/******/ 			// return url for filenames based on template
/******/ 			return undefined;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/get mini-css chunk filename */
/******/ 	(() => {
/******/ 		// This function allow to reference all chunks
/******/ 		__webpack_require__.miniCssF = (chunkId) => {
/******/ 			// return url for filenames based on template
/******/ 			return "" + chunkId + ".css";
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/load script */
/******/ 	(() => {
/******/ 		var inProgress = {};
/******/ 		// data-webpack is not used as build has no uniqueName
/******/ 		// loadScript function to load a script via script tag
/******/ 		__webpack_require__.l = (url, done, key, chunkId) => {
/******/ 			if(inProgress[url]) { inProgress[url].push(done); return; }
/******/ 			var script, needAttach;
/******/ 			if(key !== undefined) {
/******/ 				var scripts = document.getElementsByTagName("script");
/******/ 				for(var i = 0; i < scripts.length; i++) {
/******/ 					var s = scripts[i];
/******/ 					if(s.getAttribute("src") == url) { script = s; break; }
/******/ 				}
/******/ 			}
/******/ 			if(!script) {
/******/ 				needAttach = true;
/******/ 				script = document.createElement('script');
/******/ 		
/******/ 				script.charset = 'utf-8';
/******/ 				script.timeout = 120;
/******/ 				if (__webpack_require__.nc) {
/******/ 					script.setAttribute("nonce", __webpack_require__.nc);
/******/ 				}
/******/ 		
/******/ 				script.src = url;
/******/ 			}
/******/ 			inProgress[url] = [done];
/******/ 			var onScriptComplete = (prev, event) => {
/******/ 				// avoid mem leaks in IE.
/******/ 				script.onerror = script.onload = null;
/******/ 				clearTimeout(timeout);
/******/ 				var doneFns = inProgress[url];
/******/ 				delete inProgress[url];
/******/ 				script.parentNode && script.parentNode.removeChild(script);
/******/ 				doneFns && doneFns.forEach((fn) => (fn(event)));
/******/ 				if(prev) return prev(event);
/******/ 			}
/******/ 			;
/******/ 			var timeout = setTimeout(onScriptComplete.bind(null, undefined, { type: 'timeout', target: script }), 120000);
/******/ 			script.onerror = onScriptComplete.bind(null, script.onerror);
/******/ 			script.onload = onScriptComplete.bind(null, script.onload);
/******/ 			needAttach && document.head.appendChild(script);
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/node module decorator */
/******/ 	(() => {
/******/ 		__webpack_require__.nmd = (module) => {
/******/ 			module.paths = [];
/******/ 			if (!module.children) module.children = [];
/******/ 			return module;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		__webpack_require__.p = "/";
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/manifest": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		__webpack_require__.f.j = (chunkId, promises) => {
/******/ 				// JSONP chunk loading for javascript
/******/ 				var installedChunkData = __webpack_require__.o(installedChunks, chunkId) ? installedChunks[chunkId] : undefined;
/******/ 				if(installedChunkData !== 0) { // 0 means "already installed".
/******/ 		
/******/ 					// a Promise means "currently loading".
/******/ 					if(installedChunkData) {
/******/ 						promises.push(installedChunkData[2]);
/******/ 					} else {
/******/ 						if(!/^(\/js\/manifest|css\/app)$/.test(chunkId)) {
/******/ 							// setup Promise in chunk cache
/******/ 							var promise = new Promise((resolve, reject) => (installedChunkData = installedChunks[chunkId] = [resolve, reject]));
/******/ 							promises.push(installedChunkData[2] = promise);
/******/ 		
/******/ 							// start chunk loading
/******/ 							var url = __webpack_require__.p + __webpack_require__.u(chunkId);
/******/ 							// create error before stack unwound to get useful stacktrace later
/******/ 							var error = new Error();
/******/ 							var loadingEnded = (event) => {
/******/ 								if(__webpack_require__.o(installedChunks, chunkId)) {
/******/ 									installedChunkData = installedChunks[chunkId];
/******/ 									if(installedChunkData !== 0) installedChunks[chunkId] = undefined;
/******/ 									if(installedChunkData) {
/******/ 										var errorType = event && (event.type === 'load' ? 'missing' : event.type);
/******/ 										var realSrc = event && event.target && event.target.src;
/******/ 										error.message = 'Loading chunk ' + chunkId + ' failed.\n(' + errorType + ': ' + realSrc + ')';
/******/ 										error.name = 'ChunkLoadError';
/******/ 										error.type = errorType;
/******/ 										error.request = realSrc;
/******/ 										installedChunkData[1](error);
/******/ 									}
/******/ 								}
/******/ 							};
/******/ 							__webpack_require__.l(url, loadingEnded, "chunk-" + chunkId, chunkId);
/******/ 						} else installedChunks[chunkId] = 0;
/******/ 					}
/******/ 				}
/******/ 		};
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	
/******/ })()
;
=======
(()=>{"use strict";var s,e,j={},r={};function t(s){var e=r[s];if(void 0!==e)return e.exports;var o=r[s]={id:s,loaded:!1,exports:{}};return j[s].call(o.exports,o,o.exports,t),o.loaded=!0,o.exports}t.m=j,s=[],t.O=(e,j,r,o)=>{if(!j){var n=1/0;for(d=0;d<s.length;d++){for(var[j,r,o]=s[d],i=!0,a=0;a<j.length;a++)(!1&o||n>=o)&&Object.keys(t.O).every((s=>t.O[s](j[a])))?j.splice(a--,1):(i=!1,o<n&&(n=o));if(i){s.splice(d--,1);var l=r();void 0!==l&&(e=l)}}return e}o=o||0;for(var d=s.length;d>0&&s[d-1][2]>o;d--)s[d]=s[d-1];s[d]=[j,r,o]},t.n=s=>{var e=s&&s.__esModule?()=>s.default:()=>s;return t.d(e,{a:e}),e},t.d=(s,e)=>{for(var j in e)t.o(e,j)&&!t.o(s,j)&&Object.defineProperty(s,j,{enumerable:!0,get:e[j]})},t.f={},t.e=s=>Promise.all(Object.keys(t.f).reduce(((e,j)=>(t.f[j](s,e),e)),[])),t.u=s=>768===s?"js/768.js":3691===s?"js/3691.js":2241===s?"js/2241.js":5112===s?"js/5112.js":2115===s?"js/2115.js":5172===s?"js/5172.js":6723===s?"js/6723.js":674===s?"js/674.js":7447===s?"js/7447.js":626===s?"js/626.js":8073===s?"js/8073.js":3855===s?"js/3855.js":1837===s?"js/1837.js":584===s?"js/584.js":2364===s?"js/2364.js":7031===s?"js/7031.js":5159===s?"js/5159.js":1664===s?"js/1664.js":5931===s?"js/5931.js":2657===s?"js/2657.js":5919===s?"js/5919.js":4107===s?"js/4107.js":8474===s?"js/8474.js":8700===s?"js/8700.js":2006===s?"js/2006.js":634===s?"js/634.js":7725===s?"js/7725.js":6582===s?"js/6582.js":1111===s?"js/1111.js":1093===s?"js/1093.js":5662===s?"js/5662.js":1390===s?"js/1390.js":4909===s?"js/4909.js":6365===s?"js/6365.js":5164===s?"js/5164.js":1777===s?"js/1777.js":6461===s?"js/6461.js":7781===s?"js/7781.js":9292===s?"js/9292.js":1346===s?"js/1346.js":9959===s?"js/9959.js":6178===s?"js/6178.js":3264===s?"js/3264.js":7196===s?"js/7196.js":5150===s?"js/5150.js":3253===s?"js/3253.js":3546===s?"js/3546.js":583===s?"js/583.js":6127===s?"js/6127.js":1683===s?"js/1683.js":1009===s?"js/1009.js":751===s?"js/751.js":2057===s?"js/2057.js":1754===s?"js/1754.js":5372===s?"js/5372.js":4625===s?"js/4625.js":7178===s?"js/7178.js":4399===s?"js/4399.js":9554===s?"js/9554.js":7542===s?"js/7542.js":7073===s?"js/7073.js":9508===s?"js/9508.js":2783===s?"js/2783.js":2071===s?"js/2071.js":void 0,t.miniCssF=s=>"css/app.css",t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(s){if("object"==typeof window)return window}}(),t.o=(s,e)=>Object.prototype.hasOwnProperty.call(s,e),e={},t.l=(s,j,r,o)=>{if(e[s])e[s].push(j);else{var n,i;if(void 0!==r)for(var a=document.getElementsByTagName("script"),l=0;l<a.length;l++){var d=a[l];if(d.getAttribute("src")==s){n=d;break}}n||(i=!0,(n=document.createElement("script")).charset="utf-8",n.timeout=120,t.nc&&n.setAttribute("nonce",t.nc),n.src=s),e[s]=[j];var u=(j,r)=>{n.onerror=n.onload=null,clearTimeout(c);var t=e[s];if(delete e[s],n.parentNode&&n.parentNode.removeChild(n),t&&t.forEach((s=>s(r))),j)return j(r)},c=setTimeout(u.bind(null,void 0,{type:"timeout",target:n}),12e4);n.onerror=u.bind(null,n.onerror),n.onload=u.bind(null,n.onload),i&&document.head.appendChild(n)}},t.r=s=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(s,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(s,"__esModule",{value:!0})},t.nmd=s=>(s.paths=[],s.children||(s.children=[]),s),t.p="/",(()=>{var s={8929:0,6170:0};t.f.j=(e,j)=>{var r=t.o(s,e)?s[e]:void 0;if(0!==r)if(r)j.push(r[2]);else if(/^(6170|8929)$/.test(e))s[e]=0;else{var o=new Promise(((j,t)=>r=s[e]=[j,t]));j.push(r[2]=o);var n=t.p+t.u(e),i=new Error;t.l(n,(j=>{if(t.o(s,e)&&(0!==(r=s[e])&&(s[e]=void 0),r)){var o=j&&("load"===j.type?"missing":j.type),n=j&&j.target&&j.target.src;i.message="Loading chunk "+e+" failed.\n("+o+": "+n+")",i.name="ChunkLoadError",i.type=o,i.request=n,r[1](i)}}),"chunk-"+e,e)}},t.O.j=e=>0===s[e];var e=(e,j)=>{var r,o,[n,i,a]=j,l=0;if(n.some((e=>0!==s[e]))){for(r in i)t.o(i,r)&&(t.m[r]=i[r]);if(a)var d=a(t)}for(e&&e(j);l<n.length;l++)o=n[l],t.o(s,o)&&s[o]&&s[o][0](),s[o]=0;return t.O(d)},j=self.webpackChunk=self.webpackChunk||[];j.forEach(e.bind(null,0)),j.push=e.bind(null,j.push.bind(j))})()})();
>>>>>>> 25656290d69e5bcdffeb26896fca2edac3554dfd
