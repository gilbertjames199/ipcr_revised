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
/******/ 			if ({"resources_js_Pages_Acted_Review_Accomplishments_vue":1,"resources_js_Pages_Acted_Review_AccomplishmentsMonthly_vue":1,"resources_js_Pages_Acted_Review_Index_vue":1,"resources_js_Pages_Acted_Review_Targets_vue":1,"resources_js_Pages_Daily_Accomplishment_Create_vue":1,"resources_js_Pages_Daily_Accomplishment_Index_vue":1,"resources_js_Pages_Employees_All_Index_vue":1,"resources_js_Pages_Employees_Index_vue":1,"resources_js_Pages_Employees_Probationary_Create_vue":1,"resources_js_Pages_Employees_Probationary_Index_vue":1,"resources_js_Pages_Employees_Probationary_Targets_Create_vue":1,"resources_js_Pages_Employees_Probationary_Targets_Index_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Create_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Index_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Individual_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Targets_Create_vue":1,"resources_js_Pages_Employees_ProbationaryFlex_Targets_Index_vue":1,"resources_js_Pages_Forbidden_Index_vue":1,"resources_js_Pages_Home_vue":1,"resources_js_Pages_IPCR_Accomplishment_Index_vue":1,"resources_js_Pages_IPCR_IndividualOutput_Create_vue":1,"resources_js_Pages_IPCR_IndividualOutput_Index_vue":1,"resources_js_Pages_IPCR_Review_Index_vue":1,"resources_js_Pages_IPCR_Review_Accomplishments_Index_vue":1,"resources_js_Pages_IPCR_Score_Index_vue":1,"resources_js_Pages_IPCR_Semestral_Create_vue":1,"resources_js_Pages_IPCR_Semestral_Index_vue":1,"resources_js_Pages_IPCR_Targets_Create_vue":1,"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Create_vue":1,"resources_js_Pages_IPCR_Targets_Daily_Accomplishment_Index_vue":1,"resources_js_Pages_IPCR_Targets_Index_vue":1,"resources_js_Pages_IndividualOutputs_Index_vue":1,"resources_js_Pages_Monthly_Accomplishment_Index_vue":1,"resources_js_Pages_PerformanceStandard_Index_vue":1,"resources_js_Pages_Poles_Index_vue":1,"resources_js_Pages_Posts_Index_vue":1,"resources_js_Pages_Semestral_Accomplishment_Approve_vue":1,"resources_js_Pages_Semestral_Accomplishment_Index_vue":1,"resources_js_Pages_Users_BootstrapModalNoJquery_vue":1,"resources_js_Pages_Users_ChangePassword_vue":1,"resources_js_Pages_Users_Create_vue":1,"resources_js_Pages_Users_Index_vue":1,"resources_js_Pages_Users_PermissionsModal_vue":1,"resources_js_Pages_Users_Settings_vue":1}[chunkId]) return "js/" + chunkId + ".js";
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
(()=>{"use strict";var s,e,r={},j={};function t(s){var e=j[s];if(void 0!==e)return e.exports;var o=j[s]={id:s,loaded:!1,exports:{}};return r[s].call(o.exports,o,o.exports,t),o.loaded=!0,o.exports}t.m=r,s=[],t.O=(e,r,j,o)=>{if(!r){var n=1/0;for(d=0;d<s.length;d++){for(var[r,j,o]=s[d],i=!0,a=0;a<r.length;a++)(!1&o||n>=o)&&Object.keys(t.O).every((s=>t.O[s](r[a])))?r.splice(a--,1):(i=!1,o<n&&(n=o));if(i){s.splice(d--,1);var l=j();void 0!==l&&(e=l)}}return e}o=o||0;for(var d=s.length;d>0&&s[d-1][2]>o;d--)s[d]=s[d-1];s[d]=[r,j,o]},t.n=s=>{var e=s&&s.__esModule?()=>s.default:()=>s;return t.d(e,{a:e}),e},t.d=(s,e)=>{for(var r in e)t.o(e,r)&&!t.o(s,r)&&Object.defineProperty(s,r,{enumerable:!0,get:e[r]})},t.f={},t.e=s=>Promise.all(Object.keys(t.f).reduce(((e,r)=>(t.f[r](s,e),e)),[])),t.u=s=>574===s?"js/574.js":458===s?"js/458.js":241===s?"js/241.js":537===s?"js/537.js":391===s?"js/391.js":843===s?"js/843.js":833===s?"js/833.js":21===s?"js/21.js":664===s?"js/664.js":931===s?"js/931.js":657===s?"js/657.js":919===s?"js/919.js":107===s?"js/107.js":474===s?"js/474.js":264===s?"js/264.js":6===s?"js/6.js":634===s?"js/634.js":111===s?"js/111.js":228===s?"js/228.js":728===s?"js/728.js":390===s?"js/390.js":915===s?"js/915.js":757===s?"js/757.js":307===s?"js/307.js":777===s?"js/777.js":352===s?"js/352.js":862===s?"js/862.js":138===s?"js/138.js":346===s?"js/346.js":959===s?"js/959.js":178===s?"js/178.js":196===s?"js/196.js":640===s?"js/640.js":683===s?"js/683.js":9===s?"js/9.js":751===s?"js/751.js":916===s?"js/916.js":223===s?"js/223.js":399===s?"js/399.js":804===s?"js/804.js":73===s?"js/73.js":186===s?"js/186.js":783===s?"js/783.js":71===s?"js/71.js":void 0,t.miniCssF=s=>"css/app.css",t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(s){if("object"==typeof window)return window}}(),t.o=(s,e)=>Object.prototype.hasOwnProperty.call(s,e),e={},t.l=(s,r,j,o)=>{if(e[s])e[s].push(r);else{var n,i;if(void 0!==j)for(var a=document.getElementsByTagName("script"),l=0;l<a.length;l++){var d=a[l];if(d.getAttribute("src")==s){n=d;break}}n||(i=!0,(n=document.createElement("script")).charset="utf-8",n.timeout=120,t.nc&&n.setAttribute("nonce",t.nc),n.src=s),e[s]=[r];var u=(r,j)=>{n.onerror=n.onload=null,clearTimeout(c);var t=e[s];if(delete e[s],n.parentNode&&n.parentNode.removeChild(n),t&&t.forEach((s=>s(j))),r)return r(j)},c=setTimeout(u.bind(null,void 0,{type:"timeout",target:n}),12e4);n.onerror=u.bind(null,n.onerror),n.onload=u.bind(null,n.onload),i&&document.head.appendChild(n)}},t.r=s=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(s,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(s,"__esModule",{value:!0})},t.nmd=s=>(s.paths=[],s.children||(s.children=[]),s),t.p="/",(()=>{var s={929:0,170:0};t.f.j=(e,r)=>{var j=t.o(s,e)?s[e]:void 0;if(0!==j)if(j)r.push(j[2]);else if(/^(170|929)$/.test(e))s[e]=0;else{var o=new Promise(((r,t)=>j=s[e]=[r,t]));r.push(j[2]=o);var n=t.p+t.u(e),i=new Error;t.l(n,(r=>{if(t.o(s,e)&&(0!==(j=s[e])&&(s[e]=void 0),j)){var o=r&&("load"===r.type?"missing":r.type),n=r&&r.target&&r.target.src;i.message="Loading chunk "+e+" failed.\n("+o+": "+n+")",i.name="ChunkLoadError",i.type=o,i.request=n,j[1](i)}}),"chunk-"+e,e)}},t.O.j=e=>0===s[e];var e=(e,r)=>{var j,o,[n,i,a]=r,l=0;if(n.some((e=>0!==s[e]))){for(j in i)t.o(i,j)&&(t.m[j]=i[j]);if(a)var d=a(t)}for(e&&e(r);l<n.length;l++)o=n[l],t.o(s,o)&&s[o]&&s[o][0](),s[o]=0;return t.O(d)},r=self.webpackChunk=self.webpackChunk||[];r.forEach(e.bind(null,0)),r.push=e.bind(null,r.push.bind(r))})()})();
>>>>>>> 786a71cf617881a64aae2909e7f10a19253aedfe
