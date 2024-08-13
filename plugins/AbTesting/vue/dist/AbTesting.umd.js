(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", , "CorePluginsAdmin"], factory);
	else if(typeof exports === 'object')
		exports["AbTesting"] = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else
		root["AbTesting"] = factory(root["CoreHome"], root["Vue"], root["CorePluginsAdmin"]);
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE__19dc__, __WEBPACK_EXTERNAL_MODULE__8bbf__, __WEBPACK_EXTERNAL_MODULE_a5a2__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "plugins/AbTesting/vue/dist/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "fae3");
/******/ })
/************************************************************************/
/******/ ({

/***/ "19dc":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE__19dc__;

/***/ }),

/***/ "8bbf":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE__8bbf__;

/***/ }),

/***/ "a5a2":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_a5a2__;

/***/ }),

/***/ "fae3":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "toLocalTime", function() { return /* reexport */ toLocalTime; });
__webpack_require__.d(__webpack_exports__, "TargetTest", function() { return /* reexport */ TargetTest; });
__webpack_require__.d(__webpack_exports__, "ExperimentUrlTarget", function() { return /* reexport */ ExperimentUrlTarget; });
__webpack_require__.d(__webpack_exports__, "ExperimentsStore", function() { return /* reexport */ Experiments_store; });
__webpack_require__.d(__webpack_exports__, "ExperimentEdit", function() { return /* reexport */ Edit; });
__webpack_require__.d(__webpack_exports__, "ExperimentsList", function() { return /* reexport */ List; });
__webpack_require__.d(__webpack_exports__, "ExperimentsManage", function() { return /* reexport */ Manage; });
__webpack_require__.d(__webpack_exports__, "checkForActiveExperiments", function() { return /* reexport */ checkForActiveExperiments; });
__webpack_require__.d(__webpack_exports__, "ExperimentPageLink", function() { return /* reexport */ ExperimentPageLink_ExperimentPageLink; });
__webpack_require__.d(__webpack_exports__, "Summary", function() { return /* reexport */ Summary; });
__webpack_require__.d(__webpack_exports__, "SummaryPage", function() { return /* reexport */ SummaryPage; });

// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/setPublicPath.js
// This file is imported into lib/wc client bundles.

if (typeof window !== 'undefined') {
  var currentScript = window.document.currentScript
  if (false) { var getCurrentScript; }

  var src = currentScript && currentScript.src.match(/(.+\/)[^/]+\.js(\?.*)?$/)
  if (src) {
    __webpack_require__.p = src[1] // eslint-disable-line
  }
}

// Indicate to webpack that this file can be concatenated
/* harmony default export */ var setPublicPath = (null);

// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/toLocalTime.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */
function toLocalTime(dateTime, format) {
  if (!dateTime) {
    return undefined;
  }

  var isoDate = dateTime;

  if (isoDate) {
    isoDate = "".concat(isoDate).replace(/-/g, '/');

    try {
      var result = new Date("".concat(isoDate, " UTC"));

      if (format) {
        return result.toLocaleString();
      }

      return result;
    } catch (e) {
      try {
        var result2 = new Date(Date.parse("".concat(isoDate, " UTC")));

        if (format) {
          return result2.toLocaleString();
        }

        return result2;
      } catch (ex) {
        // eg phantomjs etc
        var datePart = isoDate.substr(0, 10);
        var timePart = isoDate.substr(11);
        var dateParts = datePart.split('/');
        var timeParts = timePart.split(':');

        if (dateParts.length === 3 && timeParts.length === 3) {
          var result3 = new Date(parseInt(dateParts[0], 10), parseInt(dateParts[1], 10) - 1, parseInt(dateParts[2], 10), parseInt(timeParts[0], 10), parseInt(timeParts[1], 10), parseInt(timeParts[2], 10));
          var newTime = result3.getTime() + result3.getTimezoneOffset() * 60000;
          result3 = new Date(newTime);

          if (format) {
            return result3.toLocaleString();
          }

          return result3;
        }
      }
    }
  }

  if (format) {
    return '';
  }

  return undefined;
}
// EXTERNAL MODULE: external {"commonjs":"vue","commonjs2":"vue","root":"Vue"}
var external_commonjs_vue_commonjs2_vue_root_Vue_ = __webpack_require__("8bbf");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/TargetTest/TargetTest.vue?vue&type=template&id=e7548f52

var _hoisted_1 = {
  class: "form-group targetTest"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPageTestTitle')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPageTestLabel')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    id: "urltargettest",
    placeholder: "http://www.example.com/",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.url = $event;
    }),
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])({
      invalid: _ctx.url && !_ctx.matches && _ctx.isValid
    })
  }, null, 2), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vModelText"], _ctx.url]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "testInfo"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPageTestErrorInvalidUrl')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.url && !_ctx.isValid]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "testInfo matches"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPageTestUrlMatches')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.url && _ctx.matches && _ctx.isValid]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "testInfo notMatches"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPageTestUrlNotMatches')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.url && !_ctx.matches && _ctx.isValid]])])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/TargetTest/TargetTest.vue?vue&type=template&id=e7548f52

// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/types.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/TargetTest/TargetTest.vue?vue&type=script&lang=ts



function isValidUrl(url) {
  try {
    new URL(url); // eslint-disable-line no-new

    return true;
  } catch (e) {
    return false;
  }
}

function filterTargetsWithEmptyValue(targets) {
  return (targets || []).filter(function (t) {
    return t && t.value;
  });
}

/* harmony default export */ var TargetTestvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    includedTargets: Array,
    excludedTargets: Array
  },
  data: function data() {
    return {
      url: '',
      matches: false,
      isLoadingTestMatchPage: false
    };
  },
  watch: {
    isValid: function isValid(newVal) {
      if (!newVal) {
        this.matches = false;
      }
    },
    includedTargets: function includedTargets() {
      this.runTest();
    },
    excludedTargets: function excludedTargets() {
      this.runTest();
    },
    url: function url() {
      this.runTest();
    }
  },
  methods: {
    runTest: function runTest() {
      if (!this.isValid) {
        return;
      }

      var locationBackup = window.piwikAbTestingTarget.location;
      window.piwikAbTestingTarget.location = new URL(this.targetUrl);
      var included = filterTargetsWithEmptyValue(this.includedTargets);
      var excluded = filterTargetsWithEmptyValue(this.excludedTargets);
      this.matches = window.piwikAbTestingTarget.matchesTargets(included, excluded);
      window.piwikAbTestingTarget.location = locationBackup;
    }
  },
  computed: {
    targetUrl: function targetUrl() {
      return (this.url || '').trim();
    },
    isValid: function isValid() {
      return this.targetUrl && isValidUrl(this.targetUrl);
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/TargetTest/TargetTest.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/TargetTest/TargetTest.vue



TargetTestvue_type_script_lang_ts.render = render

/* harmony default export */ var TargetTest = (TargetTestvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.vue?vue&type=template&id=f38c40b4

var ExperimentUrlTargetvue_type_template_id_f38c40b4_hoisted_1 = {
  style: {
    "width": "100%"
  }
};
var _hoisted_2 = {
  name: "targetAttribute"
};
var _hoisted_3 = {
  name: "targetType"
};
var _hoisted_4 = {
  name: "targetValue"
};
var _hoisted_5 = {
  name: "targetValue2"
};
var _hoisted_6 = ["title"];
var _hoisted_7 = ["title"];
function ExperimentUrlTargetvue_type_template_id_f38c40b4_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["form-group urltarget valign-wrapper", {
      'disabled': _ctx.disableIfNoValue && !_ctx.modelValue.value
    }])
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ExperimentUrlTargetvue_type_template_id_f38c40b4_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "targetAttribute",
    "model-value": _ctx.modelValue.attribute,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('update:modelValue', Object.assign(Object.assign({}, _ctx.modelValue), {}, {
        attribute: $event
      }));
    }),
    title: _ctx.translate('AbTesting_Rule'),
    options: _ctx.targetAttributes,
    "full-width": true
  }, null, 8, ["model-value", "title", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "targetType",
    "model-value": _ctx.pattern_type,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      _ctx.onTypeChange($event);
    }),
    options: _ctx.targetOptions[_ctx.modelValue.attribute],
    "full-width": true
  }, null, 8, ["model-value", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "targetValue",
    placeholder: "eg. ".concat(_ctx.targetExamples[_ctx.modelValue.attribute]),
    "model-value": _ctx.modelValue.value,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.$emit('update:modelValue', Object.assign(Object.assign({}, _ctx.modelValue), {}, {
        value: $event.trim()
      }));
    }),
    "full-width": true
  }, null, 8, ["placeholder", "model-value"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.pattern_type !== 'any']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "targetValue2",
    "model-value": _ctx.modelValue.value2,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.$emit('update:modelValue', Object.assign(Object.assign({}, _ctx.modelValue), {}, {
        value2: $event.trim()
      }));
    }),
    "full-width": true,
    placeholder: _ctx.translate('AbTesting_UrlParameterValueToMatchPlaceholder')
  }, null, 8, ["model-value", "placeholder"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.modelValue.attribute === 'urlparam' && _ctx.pattern_type && _ctx.pattern_type !== 'exists' && _ctx.pattern_type !== 'not_exists']])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "icon-plus valign",
    title: _ctx.translate('General_Add'),
    onClick: _cache[4] || (_cache[4] = function ($event) {
      return _ctx.$emit('addUrl');
    })
  }, null, 8, _hoisted_6), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.showAddUrl]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "icon-minus valign",
    title: _ctx.translate('General_Remove'),
    onClick: _cache[5] || (_cache[5] = function ($event) {
      return _ctx.$emit('removeUrl');
    })
  }, null, 8, _hoisted_7), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.canBeRemoved]])], 2);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.vue?vue&type=template&id=f38c40b4

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/AvailableTargetAttributes.store.ts
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */



var AvailableTargetAttributes_store_AvailableTargetAttributesStore = /*#__PURE__*/function () {
  function AvailableTargetAttributesStore() {
    var _this = this;

    _classCallCheck(this, AvailableTargetAttributesStore);

    _defineProperty(this, "privateState", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["reactive"])({
      attributes: []
    }));

    _defineProperty(this, "state", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState);
    }));

    _defineProperty(this, "attributes", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return _this.state.value.attributes;
    }));

    _defineProperty(this, "initPromise", null);
  }

  _createClass(AvailableTargetAttributesStore, [{
    key: "init",
    value: function init() {
      var _this2 = this;

      if (this.initPromise) {
        return this.initPromise;
      }

      this.initPromise = external_CoreHome_["AjaxHelper"].fetch({
        method: 'AbTesting.getAvailableTargetAttributes',
        filter_limit: '-1'
      }).then(function (response) {
        _this2.privateState.attributes = response;
        return _this2.attributes.value;
      });
      return this.initPromise;
    }
  }]);

  return AvailableTargetAttributesStore;
}();

/* harmony default export */ var AvailableTargetAttributes_store = (new AvailableTargetAttributes_store_AvailableTargetAttributesStore());
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.vue?vue&type=script&lang=ts




/* harmony default export */ var ExperimentUrlTargetvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    modelValue: {
      type: Object,
      required: true
    },
    canBeRemoved: Boolean,
    disableIfNoValue: Boolean,
    allowAny: Boolean,
    showAddUrl: Boolean
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  created: function created() {
    AvailableTargetAttributes_store.init();
  },
  emits: ['addUrl', 'removeUrl', 'update:modelValue'],
  watch: {
    modelValue: function modelValue(newValue) {
      var _this = this;

      if (!newValue.attribute) {
        return;
      }

      var types = this.targetOptions[newValue.attribute];
      var found = types.find(function (t) {
        return t.key === _this.pattern_type;
      });

      if (!found && types[0]) {
        this.onTypeChange(types[0].key);
      }
    }
  },
  methods: {
    onTypeChange: function onTypeChange(newType) {
      var inverted = 0;
      var type = newType;

      if (newType.indexOf('not_') === 0) {
        type = newType.substring('not_'.length);
        inverted = 1;
      }

      this.$emit('update:modelValue', Object.assign(Object.assign({}, this.modelValue), {}, {
        type: type,
        inverted: inverted
      }));
    }
  },
  computed: {
    pattern_type: function pattern_type() {
      var result = this.modelValue.type;

      if (this.modelValue.inverted && this.modelValue.inverted !== '0') {
        result = "not_".concat(this.modelValue.type);
      }

      return result;
    },
    targetAttributes: function targetAttributes() {
      return AvailableTargetAttributes_store.attributes.value.map(function (attr) {
        return {
          key: attr.value,
          value: attr.name
        };
      });
    },
    targetOptions: function targetOptions() {
      var _this2 = this;

      var result = {};
      AvailableTargetAttributes_store.attributes.value.forEach(function (attr) {
        result[attr.value] = [];

        if (_this2.allowAny && attr.value === 'url') {
          result[attr.value].push({
            value: Object(external_CoreHome_["translate"])('AbTesting_TargetTypeIsAny'),
            key: 'any'
          });
        }

        attr.types.forEach(function (type) {
          result[attr.value].push({
            value: type.name,
            key: type.value
          });
          result[attr.value].push({
            value: Object(external_CoreHome_["translate"])('AbTesting_TargetTypeIsNot', type.name),
            key: "not_".concat(type.value)
          });
        });
      });
      return result;
    },
    targetExamples: function targetExamples() {
      var result = {};
      AvailableTargetAttributes_store.attributes.value.forEach(function (attr) {
        result[attr.value] = attr.example;
      });
      return result;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.vue



ExperimentUrlTargetvue_type_script_lang_ts.render = ExperimentUrlTargetvue_type_template_id_f38c40b4_render

/* harmony default export */ var ExperimentUrlTarget = (ExperimentUrlTargetvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Experiments.store.ts
function Experiments_store_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function Experiments_store_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function Experiments_store_createClass(Constructor, protoProps, staticProps) { if (protoProps) Experiments_store_defineProperties(Constructor.prototype, protoProps); if (staticProps) Experiments_store_defineProperties(Constructor, staticProps); return Constructor; }

function Experiments_store_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */



var Experiments_store_ExperimentsStore = /*#__PURE__*/function () {
  function ExperimentsStore() {
    var _this = this;

    Experiments_store_classCallCheck(this, ExperimentsStore);

    Experiments_store_defineProperty(this, "privateState", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["reactive"])({
      experiments: [],
      isLoading: false,
      isUpdating: false,
      filterStatus: ''
    }));

    Experiments_store_defineProperty(this, "state", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState);
    }));

    Experiments_store_defineProperty(this, "fetchPromise", {});
  }

  Experiments_store_createClass(ExperimentsStore, [{
    key: "reload",
    value: function reload() {
      this.privateState.experiments = [];
      this.fetchPromise = {};
      return this.fetchExperiments();
    }
  }, {
    key: "fetchExperiments",
    value: function fetchExperiments() {
      var _this2 = this;

      var method = this.privateState.filterStatus ? 'AbTesting.getExperimentsByStatuses' : 'AbTesting.getActiveExperiments';
      var statuses = this.privateState.filterStatus || undefined;
      var key = "".concat(method).concat(statuses || '');

      if (!this.fetchPromise[key]) {
        this.fetchPromise[key] = external_CoreHome_["AjaxHelper"].fetch({
          method: method,
          filter_limit: '-1',
          statuses: statuses
        });
      }

      this.privateState.isLoading = true;
      this.privateState.experiments = [];
      return this.fetchPromise[key].then(function (experiments) {
        _this2.privateState.experiments = experiments;
        return _this2.state.value.experiments;
      }).finally(function () {
        _this2.privateState.isLoading = false;
      });
    }
  }, {
    key: "fetchAvailableSuccessMetrics",
    value: function fetchAvailableSuccessMetrics() {
      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'AbTesting.getAvailableSuccessMetrics',
        filter_limit: '-1'
      });
    }
  }, {
    key: "fetchAvailableStatuses",
    value: function fetchAvailableStatuses() {
      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'AbTesting.getAvailableStatuses',
        filter_limit: '-1'
      });
    }
  }, {
    key: "fetchJsExperimentTemplate",
    value: function fetchJsExperimentTemplate(idExperiment) {
      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'AbTesting.getJsExperimentTemplate',
        idExperiment: idExperiment
      });
    }
  }, {
    key: "fetchJsIncludeTemplate",
    value: function fetchJsIncludeTemplate() {
      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'AbTesting.getJsIncludeTemplate'
      });
    }
  }, {
    key: "findExperiment",
    value: function findExperiment(idExperiment) {
      var _this3 = this;

      // before going through an API request we first try to find it in loaded experiments
      var found = this.state.value.experiments.find(function (e) {
        return "".concat(e.idexperiment) === "".concat(idExperiment);
      });

      if (found) {
        return Promise.resolve(found);
      } // otherwise we fetch it via API


      this.privateState.isLoading = true;
      return external_CoreHome_["AjaxHelper"].fetch({
        idExperiment: idExperiment,
        method: 'AbTesting.getExperiment'
      }).finally(function () {
        _this3.privateState.isLoading = false;
      });
    }
  }, {
    key: "deleteExperiment",
    value: function deleteExperiment(idExperiment) {
      var _this4 = this;

      this.privateState.isUpdating = true;
      this.privateState.experiments = [];
      return external_CoreHome_["AjaxHelper"].fetch({
        idExperiment: idExperiment,
        method: 'AbTesting.deleteExperiment'
      }, {
        withTokenInUrl: true
      }).then(function () {
        return {
          type: 'success'
        };
      }).catch(function (error) {
        return {
          type: 'error',
          message: error.message || error
        };
      }).finally(function () {
        _this4.privateState.isUpdating = false;
      });
    }
  }, {
    key: "archiveExperiment",
    value: function archiveExperiment(idExperiment) {
      var _this5 = this;

      this.privateState.isUpdating = true;
      return external_CoreHome_["AjaxHelper"].fetch({
        idExperiment: idExperiment,
        method: 'AbTesting.archiveExperiment'
      }).then(function () {
        return {
          type: 'success'
        };
      }).catch(function (error) {
        return {
          type: 'error',
          message: error.message || error
        };
      }).finally(function () {
        _this5.privateState.isUpdating = false;
      });
    }
  }, {
    key: "createOrUpdateExperiment",
    value: function createOrUpdateExperiment(experiment, method) {
      var _this6 = this;

      var variations = (experiment.variations || []).filter(function (v) {
        return v === null || v === void 0 ? void 0 : v.name;
      });

      if (experiment.original_redirect_url) {
        variations.push({
          name: 'original',
          redirect_url: experiment.original_redirect_url
        });
      }

      this.privateState.isUpdating = true;
      return external_CoreHome_["AjaxHelper"].post({
        method: method,
        name: experiment.name.trim(),
        description: experiment.description.trim(),
        hypothesis: experiment.hypothesis.trim(),
        idExperiment: experiment.idexperiment,
        confidenceThreshold: experiment.confidence_threshold,
        startDate: experiment.start_date,
        endDate: experiment.end_date,
        percentageParticipants: experiment.percentage_participants,
        mdeRelative: experiment.mde_relative,
        forwardUtmParams: experiment.forward_utm_params
      }, {
        successMetrics: (experiment.success_metrics || []).filter(function (m) {
          return m === null || m === void 0 ? void 0 : m.metric;
        }),
        includedTargets: (experiment.included_targets || []).filter(function (t) {
          return t && (t.value || t.type === 'any');
        }),
        excludedTargets: (experiment.excluded_targets || []).filter(function (t) {
          return t === null || t === void 0 ? void 0 : t.value;
        }),
        variations: variations
      }, {
        withTokenInUrl: true
      }).then(function (response) {
        return {
          type: 'success',
          response: response
        };
      }).catch(function (error) {
        return {
          type: 'error',
          message: error.message || error
        };
      }).finally(function () {
        _this6.privateState.isUpdating = false;
      });
    }
  }, {
    key: "finishExperiment",
    value: function finishExperiment(idExperiment) {
      var _this7 = this;

      this.privateState.isUpdating = true;
      return external_CoreHome_["AjaxHelper"].fetch({
        idExperiment: idExperiment,
        method: 'AbTesting.finishExperiment'
      }, {
        withTokenInUrl: true
      }).then(function () {
        return {
          type: 'success'
        };
      }).catch(function (error) {
        return {
          type: 'error',
          message: error.message || error
        };
      }).finally(function () {
        _this7.privateState.isUpdating = false;
      });
    }
  }, {
    key: "setFilterStatus",
    value: function setFilterStatus(value) {
      this.privateState.filterStatus = value;
    }
  }]);

  return ExperimentsStore;
}();

/* harmony default export */ var Experiments_store = (new Experiments_store_ExperimentsStore());
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit.vue?vue&type=template&id=11d19b81

var Editvue_type_template_id_11d19b81_hoisted_1 = {
  class: "loadingPiwik"
};

var Editvue_type_template_id_11d19b81_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var Editvue_type_template_id_11d19b81_hoisted_3 = {
  class: "loadingPiwik"
};

var Editvue_type_template_id_11d19b81_hoisted_4 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var Editvue_type_template_id_11d19b81_hoisted_5 = {
  class: "alert alert-warning"
};
var Editvue_type_template_id_11d19b81_hoisted_6 = {
  class: "alert alert-warning"
};

var Editvue_type_template_id_11d19b81_hoisted_7 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_8 = {
  class: "optionsUnconfirmedEditExperiment"
};
var _hoisted_9 = {
  class: "actionViewReport"
};
var _hoisted_10 = ["href"];

var _hoisted_11 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-show"
}, null, -1);

var _hoisted_12 = {
  class: "actionFinishExperiment"
};

var _hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "abtestingicon-stop"
}, null, -1);

var _hoisted_14 = {
  class: "actionEditAnyway"
};

var _hoisted_15 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-edit"
}, null, -1);

var _hoisted_16 = {
  class: "actionCancel"
};
var _hoisted_17 = ["innerHTML"];
var _hoisted_18 = {
  class: "alert alert-warning"
};
var _hoisted_19 = {
  key: 0
};
var _hoisted_20 = {
  class: "row"
};
var _hoisted_21 = {
  class: "col m2 entityList"
};
var _hoisted_22 = {
  class: "listCircle"
};

var _hoisted_23 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_24 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_25 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_26 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_27 = ["disabled", "value"];
var _hoisted_28 = {
  class: "entityCancel"
};
var _hoisted_29 = ["innerHTML"];
var _hoisted_30 = {
  class: "entityCancel"
};
var _hoisted_31 = {
  class: "row"
};
var _hoisted_32 = {
  class: "col-md-12"
};
var _hoisted_33 = {
  class: "ui-confirm",
  ref: "confirmUpdateStartExperiment"
};
var _hoisted_34 = ["value"];
var _hoisted_35 = ["value"];
var _hoisted_36 = {
  class: "ui-confirm",
  ref: "confirmFinishExperiment"
};
var _hoisted_37 = ["value"];
var _hoisted_38 = ["value"];
var _hoisted_39 = {
  class: "ui-confirm",
  ref: "updateExperimentNeededToEmbed"
};
var _hoisted_40 = ["value"];
function Editvue_type_template_id_11d19b81_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Basic = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Basic");

  var _component_Metrics = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Metrics");

  var _component_Conditions = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Conditions");

  var _component_Traffic = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Traffic");

  var _component_Targets = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Targets");

  var _component_Redirects = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Redirects");

  var _component_Schedule = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Schedule");

  var _component_Embed = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Embed");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    class: "editExperiment",
    "content-title": _ctx.contentTitle
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      var _ctx$experiment$varia, _ctx$experiment$varia2, _ctx$experiment;

      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FormCreateExperimentIntro')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.create]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Editvue_type_template_id_11d19b81_hoisted_1, [Editvue_type_template_id_11d19b81_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoading]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Editvue_type_template_id_11d19b81_hoisted_3, [Editvue_type_template_id_11d19b81_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_UpdatingData')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isUpdating]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Editvue_type_template_id_11d19b81_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentRunningInfo1')) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.start_date) + " (UTC)", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(" ".concat(_ctx.translate('AbTesting_ExperimentRunningInfo2'))) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.end_date) + " (UTC)", 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.end_date]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(". " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentRunningInfo3')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.edit && _ctx.experiment.status === 'running']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Editvue_type_template_id_11d19b81_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentFinishedInfo1')) + " ", 1), Editvue_type_template_id_11d19b81_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentFinishedInfo2')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.edit && _ctx.experiment.status === 'finished']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
        class: "alert alert-warning"
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ErrorExperimentCannotBeUpdatedBecauseArchived')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.edit && _ctx.experiment.status === 'archived']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_RelatedActions')) + ": ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", _hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", _hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        target: "_blank",
        href: _ctx.viewReportLink
      }, [_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ActionViewReport')), 1)], 8, _hoisted_10)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        onClick: _cache[0] || (_cache[0] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.finishExperiment();
        }, ["prevent"]))
      }, [_hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ActionFinishExperiment')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status === 'running']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", _hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        onClick: _cache[1] || (_cache[1] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.confirmedEdit = true;
        }, ["prevent"]))
      }, [_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ActionEditExperimentAnyway')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", _hoisted_16, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.translate('General_OrCancel', '<a class="cancelLink">', '</a>')),
        onClick: _cache[2] || (_cache[2] = function ($event) {
          return _ctx.onCancel($event);
        })
      }, null, 8, _hoisted_17)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.edit && _ctx.experiment.status && !_ctx.confirmedEdit]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_18, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentCreatedInfo1')) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.start_date), 1), _ctx.experiment.end_date ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_19, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(" ".concat(_ctx.translate('AbTesting_ExperimentCreatedInfo2'))) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.end_date), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(". " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentCreatedInfo3')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.confirmedEdit && _ctx.experiment.status === 'created' && _ctx.experiment.start_date]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
        onSubmit: _cache[22] || (_cache[22] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.confirmedEdit ? _ctx.updateExperiment() : _ctx.createExperiment();
        }, ["prevent"]))
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_20, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_21, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", _hoisted_22, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuDefinition", {
          active: _ctx.action === 'basic'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[3] || (_cache[3] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'basic';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Definition')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuSuccessMetric", {
          active: _ctx.action === 'metrics'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[4] || (_cache[4] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'metrics';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_SuccessMetrics')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuSuccessConditions", {
          active: _ctx.action === 'conditions'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[5] || (_cache[5] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'conditions';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_SuccessConditions')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuTargets", {
          active: _ctx.action === 'targets'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[6] || (_cache[6] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'targets';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetPages')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuTraffic", {
          'disabled': !((_ctx$experiment$varia = _ctx.experiment.variations) !== null && _ctx$experiment$varia !== void 0 && (_ctx$experiment$varia2 = _ctx$experiment$varia[0]) !== null && _ctx$experiment$varia2 !== void 0 && _ctx$experiment$varia2.name),
          active: _ctx.action === 'traffic'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[7] || (_cache[7] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          var _ctx$experiment$varia3, _ctx$experiment$varia4;

          return (_ctx$experiment$varia3 = _ctx.experiment.variations) !== null && _ctx$experiment$varia3 !== void 0 && (_ctx$experiment$varia4 = _ctx$experiment$varia3[0]) !== null && _ctx$experiment$varia4 !== void 0 && _ctx$experiment$varia4.name ? _ctx.action = 'traffic' : '';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TrafficAllocation')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuRedirects", {
          active: _ctx.action === 'redirects'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[8] || (_cache[8] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'redirects';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Redirects')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuSchedule", {
          active: _ctx.action === 'schedule'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[9] || (_cache[9] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.action = 'schedule';
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Schedule')), 1)], 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["menuEmbed", {
          active: _ctx.action === 'embed'
        }])
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        href: "",
        onClick: _cache[10] || (_cache[10] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
          return _ctx.showEmbedAction();
        }, ["prevent"]))
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_EmbedCode')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status !== 'archived']])], 2)]), _hoisted_23, _hoisted_24, _hoisted_25, _hoisted_26, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        class: "btn update",
        type: "submit",
        disabled: _ctx.isUpdating || !_ctx.isDirty,
        value: _ctx.translate('CoreUpdater_UpdateTitle')
      }, null, 8, _hoisted_27), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_28, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.translate('General_OrCancel', '<a class="cancelLink">', '</a>')),
        onClick: _cache[11] || (_cache[11] = function ($event) {
          return _ctx.onCancel($event);
        })
      }, null, 8, _hoisted_29)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status !== 'archived']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_30, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        class: "btn",
        onClick: _cache[12] || (_cache[12] = function ($event) {
          return _ctx.cancel();
        })
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_NavigationBack')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status === 'archived']])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.confirmedEdit]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])({
          'col m10 editExperimentArea': _ctx.confirmedEdit,
          'col m12 createExperimentArea': _ctx.create
        })
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_31, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_32, [_ctx.action === 'basic' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Basic, {
        key: 0,
        experiment: _ctx.experiment,
        onUpdateProperty: _cache[13] || (_cache[13] = function ($event) {
          _ctx.experiment[$event.prop] = $event.value;

          _ctx.setValueHasChanged();
        }),
        create: _ctx.create,
        "create-experiment-target-types": _ctx.createExperimentTargetTypes,
        onCancel: _cache[14] || (_cache[14] = function ($event) {
          return _ctx.cancel();
        }),
        onSave: _cache[15] || (_cache[15] = function ($event) {
          return _ctx.confirmedEdit ? _ctx.updateExperiment() : _ctx.createExperiment();
        })
      }, null, 8, ["experiment", "create", "create-experiment-target-types"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.action === 'metrics' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Metrics, {
        key: 1,
        "model-value": _ctx.experiment.success_metrics,
        "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
          _ctx.experiment = Object.assign(Object.assign({}, _ctx.experiment), {}, {
            success_metrics: $event
          });

          _ctx.setValueHasChanged();
        }),
        "experiment-id-site": _ctx.experiment.idsite,
        "success-metric-options": _ctx.successMetricOptions
      }, null, 8, ["model-value", "experiment-id-site", "success-metric-options"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.action === 'conditions' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Conditions, {
        key: 2,
        experiment: _ctx.experiment,
        onUpdateProperty: _cache[17] || (_cache[17] = function ($event) {
          _ctx.experiment[$event.prop] = $event.value;

          _ctx.setValueHasChanged();
        }),
        "confidence-threshold-options": _ctx.confidenceThresholdOptions,
        "mde-relative-options": _ctx.mdeRelativeOptions
      }, null, 8, ["experiment", "confidence-threshold-options", "mde-relative-options"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.action === 'traffic' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Traffic, {
        key: 3,
        experiment: _ctx.experiment,
        onUpdateProperty: _cache[18] || (_cache[18] = function ($event) {
          _ctx.experiment[$event.prop] = $event.value;

          _ctx.setValueHasChanged();
        }),
        "percentage-participants-options": _ctx.percentageParticipantsOptions
      }, null, 8, ["experiment", "percentage-participants-options"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Targets, {
        experiment: _ctx.experiment,
        onUpdateProperty: _cache[19] || (_cache[19] = function ($event) {
          _ctx.experiment[$event.prop] = $event.value;

          _ctx.setValueHasChanged();
        })
      }, null, 8, ["experiment"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.action === 'targets']]), _ctx.action === 'redirects' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Redirects, {
        key: 4,
        "model-value": _ctx.experiment.variations,
        "forward-utm-params": ((_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.forward_utm_params) === 1,
        "onUpdate:modelValue": _cache[20] || (_cache[20] = function ($event) {
          _ctx.experiment.variations = $event;

          _ctx.setValueHasChanged();
        }),
        "onUpdate:forwardUtmParams": _ctx.setForwardUtmParams
      }, null, 8, ["model-value", "forward-utm-params", "onUpdate:forwardUtmParams"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.action === 'schedule' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Schedule, {
        key: 5,
        experiment: _ctx.experiment,
        onUpdateProperty: _cache[21] || (_cache[21] = function ($event) {
          _ctx.experiment[$event.prop] = $event.value;

          _ctx.setValueHasChanged();
        }),
        "utc-time": _ctx.utcTime
      }, null, 8, ["experiment", "utc-time"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.action === 'embed' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Embed, {
        key: 6,
        experiment: _ctx.experiment,
        "js-experiment-template-code": _ctx.jsTemplateCode,
        "js-include-template-code": _ctx.jsIncludeTemplateCode
      }, null, 8, ["experiment", "js-experiment-template-code", "js-include-template-code"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoading]])], 2)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoading && _ctx.confirmedEdit || _ctx.create]])], 32), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_33, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ConfirmUpdateStartsExperiment')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "yes",
        type: "button",
        value: _ctx.translate('General_Yes')
      }, null, 8, _hoisted_34), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "no",
        type: "button",
        value: _ctx.translate('General_No')
      }, null, 8, _hoisted_35)], 512), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_36, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ConfirmFinishExperiment')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "yes",
        type: "button",
        value: _ctx.translate('General_Yes')
      }, null, 8, _hoisted_37), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "no",
        type: "button",
        value: _ctx.translate('General_No')
      }, null, 8, _hoisted_38)], 512), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_39, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentRequiresUpdateBeforeViewEmbedCode')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "ok",
        type: "button",
        value: _ctx.translate('General_Ok')
      }, null, 8, _hoisted_40)], 512)];
    }),
    _: 1
  }, 8, ["content-title"]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit.vue?vue&type=template&id=11d19b81

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Basic.vue?vue&type=template&id=35ff15d3
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }


var Basicvue_type_template_id_35ff15d3_hoisted_1 = {
  class: "form-group"
};
var Basicvue_type_template_id_35ff15d3_hoisted_2 = {
  name: "name"
};
var Basicvue_type_template_id_35ff15d3_hoisted_3 = {
  class: "form-group"
};
var Basicvue_type_template_id_35ff15d3_hoisted_4 = {
  name: "hypothesis"
};
var Basicvue_type_template_id_35ff15d3_hoisted_5 = {
  class: "inline-help-node"
};
var Basicvue_type_template_id_35ff15d3_hoisted_6 = ["innerHTML"];
var Basicvue_type_template_id_35ff15d3_hoisted_7 = {
  class: "form-group"
};
var Basicvue_type_template_id_35ff15d3_hoisted_8 = {
  name: "description"
};
var Basicvue_type_template_id_35ff15d3_hoisted_9 = {
  class: "form-group row initalPageUrl"
};
var Basicvue_type_template_id_35ff15d3_hoisted_10 = {
  class: "col s12 m6"
};
var Basicvue_type_template_id_35ff15d3_hoisted_11 = {
  name: "newTargetType"
};
var Basicvue_type_template_id_35ff15d3_hoisted_12 = {
  name: "experimentUrl"
};
var Basicvue_type_template_id_35ff15d3_hoisted_13 = {
  class: "col s12 m6"
};
var Basicvue_type_template_id_35ff15d3_hoisted_14 = {
  class: "form-help"
};
var Basicvue_type_template_id_35ff15d3_hoisted_15 = {
  class: "inline-help"
};
var Basicvue_type_template_id_35ff15d3_hoisted_16 = {
  key: 1,
  class: "entityCancel"
};
var Basicvue_type_template_id_35ff15d3_hoisted_17 = ["innerHTML"];
function Basicvue_type_template_id_35ff15d3_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$experiment, _ctx$experiment2, _ctx$experiment3, _ctx$experiment4, _ctx$experiment5, _ctx$experiment5$incl, _ctx$experiment5$incl2, _ctx$experiment8, _ctx$experiment8$incl, _ctx$experiment8$incl2, _ctx$experiment9, _ctx$experiment9$incl;

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _component_Variations = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Variations");

  var _component_SaveButton = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SaveButton");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "name",
    placeholder: "eg 'BuyNowButtonColor'",
    "model-value": (_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.name,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'name',
        value: $event
      });
    }),
    title: _ctx.translate('General_Name'),
    maxlength: 50,
    "inline-help": _ctx.translate('AbTesting_FieldExperimentNameHelp', 50)
  }, null, 8, ["model-value", "title", "inline-help"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "textarea",
    name: "hypothesis",
    "model-value": (_ctx$experiment2 = _ctx.experiment) === null || _ctx$experiment2 === void 0 ? void 0 : _ctx$experiment2.hypothesis,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'hypothesis',
        value: $event
      });
    }),
    title: _ctx.translate('AbTesting_Hypothesis'),
    maxlength: 1000,
    rows: 3,
    placeholder: _ctx.translate('AbTesting_FieldHypothesisPlaceholder')
  }, {
    "inline-help": Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.fieldHypothesisHelp)
      }, null, 8, Basicvue_type_template_id_35ff15d3_hoisted_6)])];
    }),
    _: 1
  }, 8, ["model-value", "title", "placeholder"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "textarea",
    name: "description",
    "model-value": (_ctx$experiment3 = _ctx.experiment) === null || _ctx$experiment3 === void 0 ? void 0 : _ctx$experiment3.description,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'description',
        value: $event
      });
    }),
    title: _ctx.translate('General_Description'),
    maxlength: 1000,
    rows: 3,
    placeholder: _ctx.translate('AbTesting_FieldDescriptionPlaceholder'),
    "inline-help": _ctx.translate('AbTesting_FieldDescriptionHelp')
  }, null, 8, ["model-value", "title", "placeholder", "inline-help"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Variations, {
    "model-value": (_ctx$experiment4 = _ctx.experiment) === null || _ctx$experiment4 === void 0 ? void 0 : _ctx$experiment4.variations,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'variations',
        value: $event
      });
    })
  }, null, 8, ["model-value"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_11, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "newTargetType",
    title: _ctx.translate('AbTesting_TargetPages'),
    "model-value": (_ctx$experiment5 = _ctx.experiment) === null || _ctx$experiment5 === void 0 ? void 0 : (_ctx$experiment5$incl = _ctx$experiment5.included_targets) === null || _ctx$experiment5$incl === void 0 ? void 0 : (_ctx$experiment5$incl2 = _ctx$experiment5$incl[0]) === null || _ctx$experiment5$incl2 === void 0 ? void 0 : _ctx$experiment5$incl2.type,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      var _ctx$experiment6, _ctx$experiment6$incl, _ctx$experiment7;

      return _ctx.$emit('updateProperty', {
        prop: 'included_targets',
        value: [Object.assign(Object.assign({}, ((_ctx$experiment6 = _ctx.experiment) === null || _ctx$experiment6 === void 0 ? void 0 : (_ctx$experiment6$incl = _ctx$experiment6.included_targets) === null || _ctx$experiment6$incl === void 0 ? void 0 : _ctx$experiment6$incl[0]) || {}), {}, {
          type: $event
        })].concat(_toConsumableArray((((_ctx$experiment7 = _ctx.experiment) === null || _ctx$experiment7 === void 0 ? void 0 : _ctx$experiment7.included_targets) || []).slice(1)))
      });
    }),
    "full-width": true,
    options: _ctx.createExperimentTargetTypes
  }, null, 8, ["title", "model-value", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_12, [((_ctx$experiment8 = _ctx.experiment) === null || _ctx$experiment8 === void 0 ? void 0 : (_ctx$experiment8$incl = _ctx$experiment8.included_targets) === null || _ctx$experiment8$incl === void 0 ? void 0 : (_ctx$experiment8$incl2 = _ctx$experiment8$incl[0]) === null || _ctx$experiment8$incl2 === void 0 ? void 0 : _ctx$experiment8$incl2.type) === 'equals_simple' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Field, {
    key: 0,
    uicontrol: "text",
    name: "experimentUrl",
    placeholder: _ctx.experimentUrlPlaceholder,
    "model-value": (_ctx$experiment9 = _ctx.experiment) === null || _ctx$experiment9 === void 0 ? void 0 : (_ctx$experiment9$incl = _ctx$experiment9.included_targets[0]) === null || _ctx$experiment9$incl === void 0 ? void 0 : _ctx$experiment9$incl.value,
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      var _ctx$experiment10, _ctx$experiment10$inc, _ctx$experiment11;

      return _ctx.$emit('updateProperty', {
        prop: 'included_targets',
        value: [Object.assign(Object.assign({}, ((_ctx$experiment10 = _ctx.experiment) === null || _ctx$experiment10 === void 0 ? void 0 : (_ctx$experiment10$inc = _ctx$experiment10.included_targets) === null || _ctx$experiment10$inc === void 0 ? void 0 : _ctx$experiment10$inc[0]) || {}), {}, {
          value: $event
        })].concat(_toConsumableArray((((_ctx$experiment11 = _ctx.experiment) === null || _ctx$experiment11 === void 0 ? void 0 : _ctx$experiment11.included_targets) || []).slice(1)))
      });
    }),
    "full-width": true,
    maxlength: 1000
  }, null, 8, ["placeholder", "model-value"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Basicvue_type_template_id_35ff15d3_hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Basicvue_type_template_id_35ff15d3_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_NewExperimentTargetPageHelp')), 1)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.create]]), _ctx.create ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_SaveButton, {
    key: 0,
    class: "createButton",
    onConfirm: _cache[6] || (_cache[6] = function ($event) {
      return _ctx.$emit('save');
    }),
    disabled: _ctx.isUpdating,
    saving: _ctx.isUpdating,
    value: _ctx.translate('AbTesting_CreateNewExperiment')
  }, null, 8, ["disabled", "saving", "value"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.create ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Basicvue_type_template_id_35ff15d3_hoisted_16, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.translate('General_OrCancel', '<a class="cancelLink">', '</a>')),
    onClick: _cache[7] || (_cache[7] = function ($event) {
      return _ctx.onCancel($event);
    })
  }, null, 8, Basicvue_type_template_id_35ff15d3_hoisted_17)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Basic.vue?vue&type=template&id=35ff15d3

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Variations.vue?vue&type=template&id=53c26551

var Variationsvue_type_template_id_53c26551_hoisted_1 = {
  class: "form-group row expVariationsEdit"
};
var Variationsvue_type_template_id_53c26551_hoisted_2 = {
  class: "col s12 m6"
};
var Variationsvue_type_template_id_53c26551_hoisted_3 = {
  for: "variations"
};
var Variationsvue_type_template_id_53c26551_hoisted_4 = {
  class: "variation original"
};
var Variationsvue_type_template_id_53c26551_hoisted_5 = ["value"];
var Variationsvue_type_template_id_53c26551_hoisted_6 = ["value", "onKeydown", "onChange", "title"];
var Variationsvue_type_template_id_53c26551_hoisted_7 = ["title"];
var Variationsvue_type_template_id_53c26551_hoisted_8 = ["title", "onClick"];
var Variationsvue_type_template_id_53c26551_hoisted_9 = {
  class: "col s12 m6"
};
var Variationsvue_type_template_id_53c26551_hoisted_10 = {
  class: "form-help"
};
var Variationsvue_type_template_id_53c26551_hoisted_11 = {
  class: "inline-help"
};
function Variationsvue_type_template_id_53c26551_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this = this;

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Variationsvue_type_template_id_53c26551_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Variationsvue_type_template_id_53c26551_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", Variationsvue_type_template_id_53c26551_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Variations')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Variationsvue_type_template_id_53c26551_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    class: "name disabled",
    disabled: "",
    value: _ctx.translate('AbTesting_NameOriginalVariation')
  }, null, 8, Variationsvue_type_template_id_53c26551_hoisted_5)]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.modelValue || [], function (exper, index) {
    var _ctx$modelValue;

    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      key: exper.idvariation || _this.tempIds.get(exper),
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("variation ".concat(index, " multiple"))
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
      type: "text",
      class: "control_text name",
      maxlength: "50",
      value: exper.name,
      onKeydown: function onKeydown($event) {
        return _ctx.onKeydownName($event, exper, index);
      },
      onChange: function onChange($event) {
        return _ctx.onKeydownName($event, exper, index);
      },
      title: exper.idvariation ? "Variation ID ".concat(exper.idvariation) : ''
    }, null, 40, Variationsvue_type_template_id_53c26551_hoisted_6), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
      class: "icon-plus",
      title: _ctx.translate('General_Add'),
      onClick: _cache[0] || (_cache[0] = function ($event) {
        return _ctx.addVariation();
      })
    }, null, 8, Variationsvue_type_template_id_53c26551_hoisted_7), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
      class: "icon-minus",
      title: _ctx.translate('General_Remove'),
      onClick: function onClick($event) {
        return _ctx.removeVariation(index);
      }
    }, null, 8, Variationsvue_type_template_id_53c26551_hoisted_8), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], ((_ctx$modelValue = _ctx.modelValue) === null || _ctx$modelValue === void 0 ? void 0 : _ctx$modelValue.length) > 1]])], 2);
  }), 128))])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Variationsvue_type_template_id_53c26551_hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Variationsvue_type_template_id_53c26551_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Variationsvue_type_template_id_53c26551_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldVariationsHelp')), 1)])])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Variations.vue?vue&type=template&id=53c26551

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Variations.vue?vue&type=script&lang=ts
function Variationsvue_type_script_lang_ts_toConsumableArray(arr) { return Variationsvue_type_script_lang_ts_arrayWithoutHoles(arr) || Variationsvue_type_script_lang_ts_iterableToArray(arr) || Variationsvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Variationsvue_type_script_lang_ts_nonIterableSpread(); }

function Variationsvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Variationsvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Variationsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Variationsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Variationsvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Variationsvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Variationsvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Variationsvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }




function isVariationNameAlreadyUsed(variations, newName) {
  return !!variations.find(function (v) {
    return v.name === newName;
  });
}

var tempIdCount = 0;
/* harmony default export */ var Variationsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    modelValue: Array
  },
  emits: ['update:modelValue'],
  data: function data() {
    return {
      tempIds: new Map()
    };
  },
  created: function created() {
    // debounce because puppeteer types reeaally fast
    this.onKeydownName = Object(external_CoreHome_["debounce"])(this.onKeydownName.bind(this), 50);

    if (this.modelValue === null || this.modelValue === undefined) {
      this.$emit('update:modelValue', []);
    }
  },
  methods: {
    onKeydownName: function onKeydownName(event, variation, index) {
      var newName = event.target.value;

      if (variation.name !== newName) {
        var newValue = Variationsvue_type_script_lang_ts_toConsumableArray(this.modelValue || []);

        newValue[index] = Object.assign(Object.assign({}, variation), {}, {
          name: newName
        });
        this.$emit('update:modelValue', newValue);
      }
    },
    addVariation: function addVariation() {
      var newName = "Variation".concat((this.modelValue || []).length + 1);

      while (isVariationNameAlreadyUsed(this.modelValue || [], newName) && newName.length < 110) {
        newName += '_';
      }

      var newVariation = {
        name: newName,
        percentage: ''
      }; // temporary idvariation to be used as vue :key

      tempIdCount += 1;
      this.tempIds.set(newVariation, "_".concat(tempIdCount));
      this.$emit('update:modelValue', [].concat(Variationsvue_type_script_lang_ts_toConsumableArray(this.modelValue || []), [newVariation]));
    },
    removeVariation: function removeVariation(index) {
      var newValue = Variationsvue_type_script_lang_ts_toConsumableArray(this.modelValue || []);

      newValue.splice(index, 1);
      this.$emit('update:modelValue', newValue);
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Variations.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Variations.vue



Variationsvue_type_script_lang_ts.render = Variationsvue_type_template_id_53c26551_render

/* harmony default export */ var Variations = (Variationsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Basic.vue?vue&type=script&lang=ts





/* harmony default export */ var Basicvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: {
      type: Object,
      required: true
    },
    create: Boolean,
    createExperimentTargetTypes: Array
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"],
    SaveButton: external_CorePluginsAdmin_["SaveButton"],
    Variations: Variations
  },
  emits: ['updateProperty', 'save', 'cancel'],
  methods: {
    onCancel: function onCancel(event) {
      if (!event.target.classList.contains('cancelLink')) {
        return;
      }

      this.$emit('cancel');
    }
  },
  computed: {
    fieldHypothesisHelp: function fieldHypothesisHelp() {
      return Object(external_CoreHome_["translate"])('AbTesting_FieldHypothesisHelp', '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>');
    },
    experimentUrlPlaceholder: function experimentUrlPlaceholder() {
      return "eg 'http://www.example.com/".concat(Object(external_CoreHome_["translate"])('AbTesting_FilesystemDirectory'), "'");
    },
    isUpdating: function isUpdating() {
      return Experiments_store.state.value.isUpdating;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Basic.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Basic.vue



Basicvue_type_script_lang_ts.render = Basicvue_type_template_id_35ff15d3_render

/* harmony default export */ var Basic = (Basicvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Metrics.vue?vue&type=template&id=c61cd4d6
function Metricsvue_type_template_id_c61cd4d6_toConsumableArray(arr) { return Metricsvue_type_template_id_c61cd4d6_arrayWithoutHoles(arr) || Metricsvue_type_template_id_c61cd4d6_iterableToArray(arr) || Metricsvue_type_template_id_c61cd4d6_unsupportedIterableToArray(arr) || Metricsvue_type_template_id_c61cd4d6_nonIterableSpread(); }

function Metricsvue_type_template_id_c61cd4d6_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Metricsvue_type_template_id_c61cd4d6_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Metricsvue_type_template_id_c61cd4d6_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Metricsvue_type_template_id_c61cd4d6_arrayLikeToArray(o, minLen); }

function Metricsvue_type_template_id_c61cd4d6_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Metricsvue_type_template_id_c61cd4d6_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Metricsvue_type_template_id_c61cd4d6_arrayLikeToArray(arr); }

function Metricsvue_type_template_id_c61cd4d6_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }


var Metricsvue_type_template_id_c61cd4d6_hoisted_1 = {
  class: "form-group row"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_2 = {
  class: "col s12 m6"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_3 = {
  for: "variations"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_4 = {
  class: "innerFormField",
  name: "metric"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_5 = ["title"];
var Metricsvue_type_template_id_c61cd4d6_hoisted_6 = ["title", "onClick"];
var Metricsvue_type_template_id_c61cd4d6_hoisted_7 = {
  class: "col s12 m6"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_8 = {
  class: "form-help"
};
var Metricsvue_type_template_id_c61cd4d6_hoisted_9 = {
  class: "inline-help"
};

var Metricsvue_type_template_id_c61cd4d6_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Metricsvue_type_template_id_c61cd4d6_hoisted_11 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Metricsvue_type_template_id_c61cd4d6_hoisted_12 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Metricsvue_type_template_id_c61cd4d6_hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Metricsvue_type_template_id_c61cd4d6_hoisted_14 = ["href"];
function Metricsvue_type_template_id_c61cd4d6_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this = this;

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Metricsvue_type_template_id_c61cd4d6_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Metricsvue_type_template_id_c61cd4d6_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", Metricsvue_type_template_id_c61cd4d6_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldSuccessMetricsLabel')), 1), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.modelValue || [], function (metric, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("successMetric successMetric".concat(index, " multiple valign-wrapper")),
      key: index
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Metricsvue_type_template_id_c61cd4d6_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
      uicontrol: "select",
      name: "metric",
      "model-value": metric.metric,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return _ctx.setValue(index, $event);
      },
      "full-width": true,
      options: _ctx.successMetricOptions
    }, null, 8, ["model-value", "onUpdate:modelValue", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
      class: "icon-plus valign",
      title: _ctx.translate('General_Add'),
      onClick: _cache[0] || (_cache[0] = function ($event) {
        return _ctx.$emit('update:modelValue', [].concat(Metricsvue_type_template_id_c61cd4d6_toConsumableArray(_this.modelValue || []), [{
          metric: ''
        }]));
      })
    }, null, 8, Metricsvue_type_template_id_c61cd4d6_hoisted_5), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
      class: "icon-minus valign",
      title: _ctx.translate('General_Remove'),
      onClick: function onClick($event) {
        return _ctx.removeSuccessMetric(index);
      }
    }, null, 8, Metricsvue_type_template_id_c61cd4d6_hoisted_6), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], index > 0]])], 2);
  }), 128))])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Metricsvue_type_template_id_c61cd4d6_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Metricsvue_type_template_id_c61cd4d6_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Metricsvue_type_template_id_c61cd4d6_hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldSuccessMetricsHelp1')) + " ", 1), Metricsvue_type_template_id_c61cd4d6_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldSuccessMetricsHelp2')) + " ", 1), Metricsvue_type_template_id_c61cd4d6_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldSuccessMetricsHelp3')) + " ", 1), Metricsvue_type_template_id_c61cd4d6_hoisted_12, Metricsvue_type_template_id_c61cd4d6_hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    target: "_blank",
    href: _ctx.goalManageUrl
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ClickToCreateNewGoal')), 9, Metricsvue_type_template_id_c61cd4d6_hoisted_14)])])])])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Metrics.vue?vue&type=template&id=c61cd4d6

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Metrics.vue?vue&type=script&lang=ts
function Metricsvue_type_script_lang_ts_toConsumableArray(arr) { return Metricsvue_type_script_lang_ts_arrayWithoutHoles(arr) || Metricsvue_type_script_lang_ts_iterableToArray(arr) || Metricsvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Metricsvue_type_script_lang_ts_nonIterableSpread(); }

function Metricsvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Metricsvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Metricsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Metricsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Metricsvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Metricsvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Metricsvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Metricsvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



/* harmony default export */ var Metricsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    modelValue: Array,
    experimentIdSite: {
      type: [Number, String],
      required: true
    },
    successMetricOptions: {
      type: Object,
      required: true
    }
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  emits: ['update:modelValue'],
  computed: {
    goalManageUrl: function goalManageUrl() {
      var idSite = this.experimentIdSite;
      return "?module=Goals&action=manage&idSite=".concat(idSite, "&period=day&date=yesterday");
    }
  },
  methods: {
    setValue: function setValue(index, newMetric) {
      var newValue = Metricsvue_type_script_lang_ts_toConsumableArray(this.modelValue || []);

      newValue[index] = {
        metric: newMetric
      };
      this.$emit('update:modelValue', newValue);
    },
    removeSuccessMetric: function removeSuccessMetric(index) {
      var newValue = Metricsvue_type_script_lang_ts_toConsumableArray(this.modelValue || []);

      newValue.splice(index, 1);
      this.$emit('update:modelValue', newValue);
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Metrics.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Metrics.vue



Metricsvue_type_script_lang_ts.render = Metricsvue_type_template_id_c61cd4d6_render

/* harmony default export */ var Metrics = (Metricsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Conditions.vue?vue&type=template&id=45623963

var Conditionsvue_type_template_id_45623963_hoisted_1 = {
  name: "mde_relative"
};
var Conditionsvue_type_template_id_45623963_hoisted_2 = {
  class: "inline-help-node"
};

var Conditionsvue_type_template_id_45623963_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Conditionsvue_type_template_id_45623963_hoisted_4 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Conditionsvue_type_template_id_45623963_hoisted_5 = {
  name: "confidence_threshold"
};
var Conditionsvue_type_template_id_45623963_hoisted_6 = {
  class: "alert alert-info"
};
function Conditionsvue_type_template_id_45623963_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$experiment, _ctx$experiment2;

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Conditionsvue_type_template_id_45623963_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "mde_relative",
    "model-value": (_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.mde_relative,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'mde_relative',
        value: $event
      });
    }),
    title: _ctx.translate('AbTesting_MinimumDetectableEffectMDE'),
    options: _ctx.mdeRelativeOptions
  }, {
    "inline-help": Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Conditionsvue_type_template_id_45623963_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldMinimumDetectableEffectHelp1')) + " ", 1), Conditionsvue_type_template_id_45623963_hoisted_3, Conditionsvue_type_template_id_45623963_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldMinimumDetectableEffectHelp2')), 1)])];
    }),
    _: 1
  }, 8, ["model-value", "title", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Conditionsvue_type_template_id_45623963_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "confidence_threshold",
    "model-value": (_ctx$experiment2 = _ctx.experiment) === null || _ctx$experiment2 === void 0 ? void 0 : _ctx$experiment2.confidence_threshold,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'confidence_threshold',
        value: $event
      });
    }),
    title: _ctx.translate('AbTesting_ConfidenceThreshold'),
    options: _ctx.confidenceThresholdOptions,
    "inline-help": _ctx.translate('AbTesting_FieldConfidenceThresholdHelp')
  }, null, 8, ["model-value", "title", "options", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Conditionsvue_type_template_id_45623963_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldSuccessConditionsHelp')), 1)]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Conditions.vue?vue&type=template&id=45623963

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Conditions.vue?vue&type=script&lang=ts


/* harmony default export */ var Conditionsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: Object,
    mdeRelativeOptions: {
      type: Object,
      required: true
    },
    confidenceThresholdOptions: {
      type: Object,
      required: true
    }
  },
  emits: ['updateProperty'],
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Conditions.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Conditions.vue



Conditionsvue_type_script_lang_ts.render = Conditionsvue_type_template_id_45623963_render

/* harmony default export */ var Conditions = (Conditionsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Traffic.vue?vue&type=template&id=296e5a01

var Trafficvue_type_template_id_296e5a01_hoisted_1 = {
  name: "percentage_participants"
};

var Trafficvue_type_template_id_296e5a01_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Trafficvue_type_template_id_296e5a01_hoisted_3 = {
  class: "form-group row"
};
var Trafficvue_type_template_id_296e5a01_hoisted_4 = {
  class: "col s12"
};
var Trafficvue_type_template_id_296e5a01_hoisted_5 = {
  class: "form-group row",
  style: {
    "margin-top": "0"
  }
};
var Trafficvue_type_template_id_296e5a01_hoisted_6 = {
  class: "col s12 m6",
  style: {
    "padding-left": "0"
  }
};
var Trafficvue_type_template_id_296e5a01_hoisted_7 = {
  class: "valign-wrapper"
};
var Trafficvue_type_template_id_296e5a01_hoisted_8 = {
  style: {
    "display": "inline-block",
    "width": "calc(100% - 60px)"
  },
  class: "control_text percentage",
  name: "percentage"
};

var Trafficvue_type_template_id_296e5a01_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, "%", -1);

var Trafficvue_type_template_id_296e5a01_hoisted_10 = {
  style: {
    "display": "inline-block",
    "width": "calc(100% - 60px)"
  },
  class: "percentage",
  name: "percentage"
};

var Trafficvue_type_template_id_296e5a01_hoisted_11 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, "%", -1);

var Trafficvue_type_template_id_296e5a01_hoisted_12 = {
  class: "col s12 m6"
};
var Trafficvue_type_template_id_296e5a01_hoisted_13 = {
  class: "form-help"
};
var Trafficvue_type_template_id_296e5a01_hoisted_14 = {
  class: "inline-help"
};
function Trafficvue_type_template_id_296e5a01_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$experiment, _ctx$experiment2;

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "percentage_participants",
    "model-value": (_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.percentage_participants,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$emit('updateProperty', {
        prop: 'percentage_participants',
        value: $event
      });
    }),
    title: "".concat(_ctx.translate('AbTesting_FieldPercentageParticipantsLabel'), ":"),
    options: _ctx.percentageParticipantsOptions,
    "inline-help": _ctx.translate('AbTesting_FieldPercentageParticipantsHelp')
  }, null, 8, ["model-value", "title", "options", "inline-help"])]), Trafficvue_type_template_id_296e5a01_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", Trafficvue_type_template_id_296e5a01_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldPercentageVariationsLabel')) + ":", 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "alert alert-danger"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ErrorVariationAllocatedNot100Traffic')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.hasAllocated100PercentToVariations]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "alert alert-warning"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ErrorVariationAllocatedNotEnoughOriginal')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.shouldAllocateMoreTrafficToOriginalVariation && _ctx.hasAllocated100PercentToVariations]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "percentage",
    title: _ctx.translate('AbTesting_NameOriginalVariation'),
    disabled: true,
    "full-width": true,
    placeholder: "".concat(_ctx.defaultVariationPercentage)
  }, null, 8, ["title", "placeholder"])]), Trafficvue_type_template_id_296e5a01_hoisted_9]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(((_ctx$experiment2 = _ctx.experiment) === null || _ctx$experiment2 === void 0 ? void 0 : _ctx$experiment2.variations) || [], function (exper, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("valign-wrapper trafficVariation ".concat(index)),
      key: exper.idvariation
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
      uicontrol: "text",
      name: "percentage",
      "model-value": exper.percentage,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return _ctx.changePercent(index, $event);
      },
      title: "".concat(_ctx.translate('AbTesting_Variation'), " \"").concat(exper.name, "\""),
      maxlength: 3,
      "full-width": true,
      placeholder: "".concat(_ctx.defaultVariationPercentage)
    }, null, 8, ["model-value", "onUpdate:modelValue", "title", "placeholder"])]), Trafficvue_type_template_id_296e5a01_hoisted_11], 2);
  }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Trafficvue_type_template_id_296e5a01_hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Trafficvue_type_template_id_296e5a01_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldPercentageVariationsHelp')), 1)])])])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Traffic.vue?vue&type=template&id=296e5a01

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Traffic.vue?vue&type=script&lang=ts
function Trafficvue_type_script_lang_ts_toConsumableArray(arr) { return Trafficvue_type_script_lang_ts_arrayWithoutHoles(arr) || Trafficvue_type_script_lang_ts_iterableToArray(arr) || Trafficvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Trafficvue_type_script_lang_ts_nonIterableSpread(); }

function Trafficvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Trafficvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Trafficvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Trafficvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Trafficvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Trafficvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Trafficvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Trafficvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



/* harmony default export */ var Trafficvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: Object,
    percentageParticipantsOptions: {
      type: Object,
      required: true
    }
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  emits: ['updateProperty'],
  methods: {
    changePercent: function changePercent(index, percent) {
      var exp = this.experiment;
      var variations = (exp === null || exp === void 0 ? void 0 : exp.variations) || [];

      var newVariations = Trafficvue_type_script_lang_ts_toConsumableArray(variations);

      newVariations[index] = Object.assign(Object.assign({}, newVariations[index]), {}, {
        percentage: percent
      });
      this.$emit('updateProperty', {
        prop: 'variations',
        value: newVariations
      });
    }
  },
  computed: {
    hasAllocated100PercentToVariations: function hasAllocated100PercentToVariations() {
      var experiment = this.experiment;

      if (!(experiment !== null && experiment !== void 0 && experiment.variations)) {
        return false;
      }

      var percentage = ((experiment === null || experiment === void 0 ? void 0 : experiment.variations) || []).reduce(function (pv, cv) {
        if (cv !== null && cv !== void 0 && cv.percentage) {
          return pv + parseInt("".concat(cv.percentage), 10);
        }

        return pv;
      }, 0);
      return percentage < 100;
    },
    numVariations: function numVariations() {
      var _experiment$variation;

      var experiment = this.experiment;
      return ((_experiment$variation = experiment.variations) === null || _experiment$variation === void 0 ? void 0 : _experiment$variation.length) || 0;
    },
    defaultVariationPercentage: function defaultVariationPercentage() {
      var experiment = this.experiment;

      if (!experiment || !experiment.variations) {
        return 0;
      }

      var percentageUsed = 100;
      var numberOfOriginalVariations = 1;
      var numVariations = this.numVariations + numberOfOriginalVariations;
      experiment.variations.forEach(function (variation) {
        if (variation && variation.percentage) {
          percentageUsed -= parseInt("".concat(variation.percentage), 10);
          numVariations -= 1;
        }
      });

      if (numVariations > 0) {
        var result = Math.round(percentageUsed / numVariations);

        if (result > 100) {
          result = 100;
        }

        if (result < 0) {
          result = 0;
        }

        return result;
      }

      return 0;
    },
    shouldAllocateMoreTrafficToOriginalVariation: function shouldAllocateMoreTrafficToOriginalVariation() {
      // eg 20% when there are 4 variations + 1 original by default
      var original = this.defaultVariationPercentage;
      var numVariations = this.numVariations + 1; // eg 20% when there are 4 variations + 1 original by default

      var defaultPercentageWhenNotCustomizedTraffic = Math.round(100 / numVariations); // eg 10%

      var halfNeededTraffic = Math.floor(defaultPercentageWhenNotCustomizedTraffic / 2); // has allocated eg less than 10% to original, we recommend to allocate more

      return halfNeededTraffic > original;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Traffic.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Traffic.vue



Trafficvue_type_script_lang_ts.render = Trafficvue_type_template_id_296e5a01_render

/* harmony default export */ var Traffic = (Trafficvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Targets.vue?vue&type=template&id=34b9bb30

var Targetsvue_type_template_id_34b9bb30_hoisted_1 = {
  class: "row"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_2 = {
  class: "col s12"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_3 = {
  class: "form-group row"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_4 = {
  class: "col s12"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_5 = {
  class: "col s12 m6",
  style: {
    "padding-left": "0"
  }
};

var Targetsvue_type_template_id_34b9bb30_hoisted_6 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("hr", null, null, -1);

var Targetsvue_type_template_id_34b9bb30_hoisted_7 = {
  class: "col s12 m6"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_8 = {
  class: "form-help"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_9 = {
  class: "inline-help"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_10 = {
  class: "form-group row"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_11 = {
  class: "col s12"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_12 = {
  class: "col s12 m6",
  style: {
    "padding-left": "0"
  }
};

var Targetsvue_type_template_id_34b9bb30_hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("hr", null, null, -1);

var Targetsvue_type_template_id_34b9bb30_hoisted_14 = {
  class: "col s12 m6"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_15 = {
  class: "form-help"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_16 = {
  class: "inline-help"
};
var Targetsvue_type_template_id_34b9bb30_hoisted_17 = {
  class: "alert alert-info"
};

var Targetsvue_type_template_id_34b9bb30_hoisted_18 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Targetsvue_type_template_id_34b9bb30_hoisted_19 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

function Targetsvue_type_template_id_34b9bb30_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$experiment, _ctx$experiment2, _ctx$experiment3, _ctx$experiment4;

  var _component_TargetTest = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("TargetTest");

  var _component_ExperimentUrlTarget = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ExperimentUrlTarget");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_TargetTest, {
    "included-targets": (_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.included_targets,
    "excluded-targets": (_ctx$experiment2 = _ctx.experiment) === null || _ctx$experiment2 === void 0 ? void 0 : _ctx$experiment2.excluded_targets
  }, null, 8, ["included-targets", "excluded-targets"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldIncludedTargetsLabel')) + ":", 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_5, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(((_ctx$experiment3 = _ctx.experiment) === null || _ctx$experiment3 === void 0 ? void 0 : _ctx$experiment3.included_targets) || [], function (url, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      key: index,
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("includedTargets ".concat(index, " multiple"))
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ExperimentUrlTarget, {
      "model-value": url,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return _ctx.setTarget('included_targets', index, $event);
      },
      onAddUrl: _cache[0] || (_cache[0] = function ($event) {
        return _ctx.addTarget('included_targets');
      }),
      onRemoveUrl: function onRemoveUrl($event) {
        return _ctx.removeTarget('included_targets', index);
      },
      "allow-any": true,
      "disable-if-no-value": index > 0,
      "can-be-removed": index > 0,
      "show-add-url": true
    }, null, 8, ["model-value", "onUpdate:modelValue", "onRemoveUrl", "disable-if-no-value", "can-be-removed"]), Targetsvue_type_template_id_34b9bb30_hoisted_6], 2);
  }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Targetsvue_type_template_id_34b9bb30_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldIncludedTargetsHelp2')), 1)])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_11, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldExcludedTargetsLabel')) + ":", 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_12, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])((_ctx$experiment4 = _ctx.experiment) === null || _ctx$experiment4 === void 0 ? void 0 : _ctx$experiment4.excluded_targets, function (url, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("excludedTargets ".concat(index, " multiple")),
      key: index
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ExperimentUrlTarget, {
      "disable-if-no-value": true,
      "allow-any": false,
      "model-value": url,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return _ctx.setTarget('excluded_targets', index, $event);
      },
      onAddUrl: _cache[1] || (_cache[1] = function ($event) {
        return _ctx.addTarget('excluded_targets');
      }),
      onRemoveUrl: function onRemoveUrl($event) {
        return _ctx.removeTarget('excluded_targets', index);
      },
      "can-be-removed": index > 0,
      "show-add-url": true
    }, null, 8, ["model-value", "onUpdate:modelValue", "onRemoveUrl", "can-be-removed"]), Targetsvue_type_template_id_34b9bb30_hoisted_13], 2);
  }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Targetsvue_type_template_id_34b9bb30_hoisted_16, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldExcludedTargetsHelp')), 1)])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Targetsvue_type_template_id_34b9bb30_hoisted_17, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetComparisons')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeEqualsSimple')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeEqualsSimpleInfo')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeEqualsExactly')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeEqualsExactlyInfo')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeRegExp')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetTypeRegExpInfo')), 1)])]), Targetsvue_type_template_id_34b9bb30_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TargetComparisionsCaseInsensitive')), 1), Targetsvue_type_template_id_34b9bb30_hoisted_19])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Targets.vue?vue&type=template&id=34b9bb30

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Targets.vue?vue&type=script&lang=ts
function Targetsvue_type_script_lang_ts_toConsumableArray(arr) { return Targetsvue_type_script_lang_ts_arrayWithoutHoles(arr) || Targetsvue_type_script_lang_ts_iterableToArray(arr) || Targetsvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Targetsvue_type_script_lang_ts_nonIterableSpread(); }

function Targetsvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Targetsvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Targetsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Targetsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Targetsvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Targetsvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Targetsvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Targetsvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }




/* harmony default export */ var Targetsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: Object
  },
  components: {
    TargetTest: TargetTest,
    ExperimentUrlTarget: ExperimentUrlTarget
  },
  emits: ['updateProperty'],
  methods: {
    addTarget: function addTarget(propName) {
      var experiment = this.experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      this.$emit('updateProperty', {
        prop: propName,
        value: [].concat(Targetsvue_type_script_lang_ts_toConsumableArray((experiment === null || experiment === void 0 ? void 0 : experiment[propName]) || []), [{
          attribute: 'url',
          type: 'equals_simple',
          value: '',
          inverted: 0
        }])
      });
    },
    setTarget: function setTarget(propName, index, newValue) {
      var experiment = this.experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      var newTargets = Targetsvue_type_script_lang_ts_toConsumableArray((experiment === null || experiment === void 0 ? void 0 : experiment[propName]) || []);

      newTargets[index] = newValue;
      this.$emit('updateProperty', {
        prop: propName,
        value: newTargets
      });
    },
    removeTarget: function removeTarget(propName, index) {
      var experiment = this.experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      var newTargets = Targetsvue_type_script_lang_ts_toConsumableArray((experiment === null || experiment === void 0 ? void 0 : experiment[propName]) || []);

      newTargets.splice(index, 1);
      this.$emit('updateProperty', {
        prop: propName,
        value: newTargets
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Targets.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Targets.vue



Targetsvue_type_script_lang_ts.render = Targetsvue_type_template_id_34b9bb30_render

/* harmony default export */ var Targets = (Targetsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Redirects.vue?vue&type=template&id=f2e43e56

var Redirectsvue_type_template_id_f2e43e56_hoisted_1 = {
  class: "form-group row"
};
var Redirectsvue_type_template_id_f2e43e56_hoisted_2 = {
  class: "col s12 m6",
  style: {
    "padding-left": "0"
  }
};
var Redirectsvue_type_template_id_f2e43e56_hoisted_3 = {
  class: "redirects",
  name: "redirects"
};
var Redirectsvue_type_template_id_f2e43e56_hoisted_4 = {
  class: "col s12 m6"
};
var Redirectsvue_type_template_id_f2e43e56_hoisted_5 = {
  class: "form-help"
};
var Redirectsvue_type_template_id_f2e43e56_hoisted_6 = {
  class: "inline-help"
};

var Redirectsvue_type_template_id_f2e43e56_hoisted_7 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Redirectsvue_type_template_id_f2e43e56_hoisted_8 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Redirectsvue_type_template_id_f2e43e56_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Redirectsvue_type_template_id_f2e43e56_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Redirectsvue_type_template_id_f2e43e56_hoisted_11 = ["innerHTML"];
function Redirectsvue_type_template_id_f2e43e56_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Redirectsvue_type_template_id_f2e43e56_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Redirectsvue_type_template_id_f2e43e56_hoisted_2, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.modelValue, function (exper, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("redirectsAllocation ".concat(index)),
      key: exper.idvariation
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Redirectsvue_type_template_id_f2e43e56_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
      uicontrol: "text",
      name: "redirects",
      placeholder: "eg http://www.example.com",
      "model-value": exper.redirect_url,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return _ctx.setRedirectUrl(index, $event);
      },
      title: "".concat(_ctx.translate('AbTesting_Variation'), " \"").concat(_ctx.htmlEntities(exper.name), "\""),
      maxlength: 1000,
      "full-width": true
    }, null, 8, ["model-value", "onUpdate:modelValue", "title"])])], 2);
  }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Redirectsvue_type_template_id_f2e43e56_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Redirectsvue_type_template_id_f2e43e56_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Redirectsvue_type_template_id_f2e43e56_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldRedirectHelp1')) + " ", 1), Redirectsvue_type_template_id_f2e43e56_hoisted_7, Redirectsvue_type_template_id_f2e43e56_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldRedirectHelp2')) + " ", 1), Redirectsvue_type_template_id_f2e43e56_hoisted_9, Redirectsvue_type_template_id_f2e43e56_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.formHelp)
  }, null, 8, Redirectsvue_type_template_id_f2e43e56_hoisted_11)])])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "checkbox",
    name: "forwardUtmParams",
    "model-value": _ctx.forwardUtmParams,
    title: _ctx.translate('AbTesting_ForwardUtmParams'),
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.setForwardUtmParams($event);
    }),
    "inline-help": _ctx.getForwardUtmParamsHelpText
  }, null, 8, ["model-value", "title", "inline-help"])])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Redirects.vue?vue&type=template&id=f2e43e56

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Redirects.vue?vue&type=script&lang=ts
function Redirectsvue_type_script_lang_ts_toConsumableArray(arr) { return Redirectsvue_type_script_lang_ts_arrayWithoutHoles(arr) || Redirectsvue_type_script_lang_ts_iterableToArray(arr) || Redirectsvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Redirectsvue_type_script_lang_ts_nonIterableSpread(); }

function Redirectsvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Redirectsvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Redirectsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Redirectsvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Redirectsvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Redirectsvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Redirectsvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Redirectsvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }




/* harmony default export */ var Redirectsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    modelValue: Array,
    forwardUtmParams: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  emits: ['update:modelValue', 'update:forwardUtmParams'],
  computed: {
    formHelp: function formHelp() {
      var link = 'https://github.com/innocraft/php-experiments';
      return Object(external_CoreHome_["translate"])('AbTesting_FieldRedirectHelp3', "<a target=\"blank\" rel=\"noreferrer\" href=\"".concat(link, "\">"), '</a>');
    },
    getForwardUtmParamsHelpText: function getForwardUtmParamsHelpText() {
      var helpText1 = Object(external_CoreHome_["translate"])('AbTesting_ForwardUtmParamsHelpText');
      var link = 'https://developer.matomo.org/guides/ab-tests/browser#can-i-use-redirects-in-ab-tests-to-test-entirely-different-pages-or-layouts';
      var helpText2 = Object(external_CoreHome_["translate"])('AbTesting_ForwardUtmParamsHelpTextNote', '<strong>', '</strong>', '<a href="javascript:void(0);" id="viewEmbedCodeTabLink">', '</a>', "<a target=\"blank\" rel=\"noreferrer\" href=\"".concat(link, "\">"), '</a>');
      return "".concat(helpText1, "</br></br>").concat(helpText2);
    }
  },
  methods: {
    setRedirectUrl: function setRedirectUrl(index, newRedirectUrl) {
      var variations = this.modelValue || [];

      var newValue = Redirectsvue_type_script_lang_ts_toConsumableArray(variations);

      newValue[index] = Object.assign(Object.assign({}, variations[index]), {}, {
        redirect_url: newRedirectUrl
      });
      this.$emit('update:modelValue', newValue);
    },
    setForwardUtmParams: function setForwardUtmParams(forwardUtmParams) {
      this.$emit('update:forwardUtmParams', forwardUtmParams);
    },
    htmlEntities: function htmlEntities(v) {
      return external_CoreHome_["Matomo"].helper.htmlEntities(v);
    },
    clickEmbedTab: function clickEmbedTab() {
      var element = window.document.querySelectorAll('li.menuEmbed a');
      var htmlElement = element[0];
      htmlElement.click();
    }
  },
  mounted: function mounted() {
    var clickEmbedTabFunction = this.clickEmbedTab;
    var htmlElement = window.document.getElementById('viewEmbedCodeTabLink');

    if (!htmlElement) {
      return;
    }

    htmlElement.addEventListener('click', function () {
      clickEmbedTabFunction();
    });
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Redirects.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Redirects.vue



Redirectsvue_type_script_lang_ts.render = Redirectsvue_type_template_id_f2e43e56_render

/* harmony default export */ var Redirects = (Redirectsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Schedule.vue?vue&type=template&id=071cb135

var Schedulevue_type_template_id_071cb135_hoisted_1 = {
  ref: "root"
};
var Schedulevue_type_template_id_071cb135_hoisted_2 = {
  class: "form-group"
};
var Schedulevue_type_template_id_071cb135_hoisted_3 = {
  class: "form-group row scheduleExperiment"
};
var Schedulevue_type_template_id_071cb135_hoisted_4 = {
  class: "col s12 m6"
};
var Schedulevue_type_template_id_071cb135_hoisted_5 = {
  class: "row"
};
var Schedulevue_type_template_id_071cb135_hoisted_6 = {
  class: "col s12"
};
var Schedulevue_type_template_id_071cb135_hoisted_7 = {
  for: "start_date_date",
  class: "active"
};
var Schedulevue_type_template_id_071cb135_hoisted_8 = {
  class: "col s12 m6 input-field"
};
var Schedulevue_type_template_id_071cb135_hoisted_9 = ["value", "disabled"];
var Schedulevue_type_template_id_071cb135_hoisted_10 = {
  class: "col s12 m6 input-field"
};
var Schedulevue_type_template_id_071cb135_hoisted_11 = ["value", "disabled"];
var Schedulevue_type_template_id_071cb135_hoisted_12 = {
  class: "col s12"
};

var Schedulevue_type_template_id_071cb135_hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Schedulevue_type_template_id_071cb135_hoisted_14 = {
  class: "col s12 m6 "
};
var Schedulevue_type_template_id_071cb135_hoisted_15 = {
  class: "form-help"
};
var Schedulevue_type_template_id_071cb135_hoisted_16 = {
  class: "inline-help"
};
var Schedulevue_type_template_id_071cb135_hoisted_17 = ["innerHTML"];

var Schedulevue_type_template_id_071cb135_hoisted_18 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Schedulevue_type_template_id_071cb135_hoisted_19 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(". ");

var Schedulevue_type_template_id_071cb135_hoisted_20 = {
  class: "form-group row scheduleExperiment"
};
var Schedulevue_type_template_id_071cb135_hoisted_21 = {
  class: "col s12 m6"
};
var Schedulevue_type_template_id_071cb135_hoisted_22 = {
  class: "row"
};
var Schedulevue_type_template_id_071cb135_hoisted_23 = {
  class: "col s12"
};
var Schedulevue_type_template_id_071cb135_hoisted_24 = {
  for: "start_date_date",
  class: "active"
};
var Schedulevue_type_template_id_071cb135_hoisted_25 = {
  class: "col s12 m6 input-field"
};
var Schedulevue_type_template_id_071cb135_hoisted_26 = ["value"];
var Schedulevue_type_template_id_071cb135_hoisted_27 = {
  class: "col s12 m6 input-field"
};
var Schedulevue_type_template_id_071cb135_hoisted_28 = ["value", "disabled"];
var Schedulevue_type_template_id_071cb135_hoisted_29 = {
  class: "col s12"
};

var Schedulevue_type_template_id_071cb135_hoisted_30 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Schedulevue_type_template_id_071cb135_hoisted_31 = {
  class: "col s12 m6"
};
var Schedulevue_type_template_id_071cb135_hoisted_32 = {
  class: "form-help"
};
var Schedulevue_type_template_id_071cb135_hoisted_33 = {
  class: "inline-help"
};
var Schedulevue_type_template_id_071cb135_hoisted_34 = ["innerHTML"];

var Schedulevue_type_template_id_071cb135_hoisted_35 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Schedulevue_type_template_id_071cb135_hoisted_36 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(". ");

function Schedulevue_type_template_id_071cb135_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$experiment, _ctx$experiment2, _ctx$experiment3, _ctx$experiment4, _ctx$experiment5, _ctx$experiment6;

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Schedulevue_type_template_id_071cb135_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FormScheduleIntroduction')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", Schedulevue_type_template_id_071cb135_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldScheduleExperimentStartLabel')) + ":", 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    name: "start_date_date",
    class: "experimentStartDateInput",
    value: _ctx.startDateDate,
    onChange: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.onKeydown('startDateDate', $event);
    }),
    onKeydown: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.onKeydown('startDateDate', $event);
    }),
    disabled: ((_ctx$experiment = _ctx.experiment) === null || _ctx$experiment === void 0 ? void 0 : _ctx$experiment.status) !== 'created'
  }, null, 40, Schedulevue_type_template_id_071cb135_hoisted_9)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    class: "experimentStartTimeInput",
    value: _ctx.startDateTime,
    onChange: _cache[2] || (_cache[2] = function ($event) {
      return _ctx.onKeydown('startDateTime', $event);
    }),
    onKeydown: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.onKeydown('startDateTime', $event);
    }),
    disabled: ((_ctx$experiment2 = _ctx.experiment) === null || _ctx$experiment2 === void 0 ? void 0 : _ctx$experiment2.status) !== 'created' || !_ctx.startDateDate
  }, null, 40, Schedulevue_type_template_id_071cb135_hoisted_11)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_EqualsDateInYourTimezone')) + " ", 1), Schedulevue_type_template_id_071cb135_hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.toLocalTime((_ctx$experiment3 = _ctx.experiment) === null || _ctx$experiment3 === void 0 ? void 0 : _ctx$experiment3.start_date, true)), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.toLocalTime((_ctx$experiment4 = _ctx.experiment) === null || _ctx$experiment4 === void 0 ? void 0 : _ctx$experiment4.start_date, true)]])])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Schedulevue_type_template_id_071cb135_hoisted_16, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.experimentStartHelp)
  }, null, 8, Schedulevue_type_template_id_071cb135_hoisted_17), Schedulevue_type_template_id_071cb135_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CurrentTimeInUTC')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", {
    class: "currentDate"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.utcTime), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.utcTime]]), Schedulevue_type_template_id_071cb135_hoisted_19])])])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_20, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_21, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_22, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_23, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", Schedulevue_type_template_id_071cb135_hoisted_24, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FieldScheduleExperimentFinishLabel')) + ":", 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_25, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    class: "experimentEndDateInput",
    value: _ctx.endDateDate,
    onChange: _cache[4] || (_cache[4] = function ($event) {
      return _ctx.onKeydown('endDateDate', $event);
    }),
    onKeydown: _cache[5] || (_cache[5] = function ($event) {
      return _ctx.onKeydown('endDateDate', $event);
    })
  }, null, 40, Schedulevue_type_template_id_071cb135_hoisted_26)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_27, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "text",
    class: "experimentEndTimeInput",
    value: _ctx.endDateTime,
    onChange: _cache[6] || (_cache[6] = function ($event) {
      return _ctx.onKeydown('endDateTime', $event);
    }),
    onKeydown: _cache[7] || (_cache[7] = function ($event) {
      return _ctx.onKeydown('endDateTime', $event);
    }),
    disabled: !_ctx.endDateDate
  }, null, 40, Schedulevue_type_template_id_071cb135_hoisted_28)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_29, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_EqualsDateInYourTimezone')) + " ", 1), Schedulevue_type_template_id_071cb135_hoisted_30, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.toLocalTime((_ctx$experiment5 = _ctx.experiment) === null || _ctx$experiment5 === void 0 ? void 0 : _ctx$experiment5.end_date, true)), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.toLocalTime((_ctx$experiment6 = _ctx.experiment) === null || _ctx$experiment6 === void 0 ? void 0 : _ctx$experiment6.end_date, true)]])])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_31, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Schedulevue_type_template_id_071cb135_hoisted_32, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Schedulevue_type_template_id_071cb135_hoisted_33, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.experimentFinishHelp)
  }, null, 8, Schedulevue_type_template_id_071cb135_hoisted_34), Schedulevue_type_template_id_071cb135_hoisted_35, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CurrentTimeInUTC')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", {
    class: "currentDate"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.utcTime), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.utcTime]]), Schedulevue_type_template_id_071cb135_hoisted_36])])])])])], 512);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Schedule.vue?vue&type=template&id=071cb135

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Schedule.vue?vue&type=script&lang=ts
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || Schedulevue_type_script_lang_ts_unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Schedulevue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Schedulevue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Schedulevue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Schedulevue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

/* eslint-disable @typescript-eslint/ban-ts-comment */



var _window = window,
    $ = _window.$;
/* harmony default export */ var Schedulevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: Object,
    utcTime: [Date, String]
  },
  emits: ['updateProperty'],
  data: function data() {
    return {
      startDateDate: null,
      startDateTime: null,
      endDateDate: null,
      endDateTime: null
    };
  },
  created: function created() {
    var _this = this;

    this.setDateState();
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      var _this$experiment;

      return (_this$experiment = _this.experiment) === null || _this$experiment === void 0 ? void 0 : _this$experiment.start_date;
    }, function () {
      _this.setDateState();
    });
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      var _this$experiment2;

      return (_this$experiment2 = _this.experiment) === null || _this$experiment2 === void 0 ? void 0 : _this$experiment2.end_date;
    }, function () {
      _this.setDateState();
    }); // add watches after initial setDateState() above

    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return _this.startDateDate;
    }, function () {
      _this.onStartDateChange();
    });
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return _this.startDateTime;
    }, function () {
      _this.onStartDateChange();
    });
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return _this.endDateDate;
    }, function () {
      _this.onEndDateChange();
    });
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return _this.endDateTime;
    }, function () {
      _this.onEndDateChange();
    });
  },
  mounted: function mounted() {
    var _this2 = this;

    var options1 = external_CoreHome_["Matomo"].getBaseDatePickerOptions(null);
    delete options1.maxDate;
    options1.minDate = new Date();
    var options2 = external_CoreHome_["Matomo"].getBaseDatePickerOptions(null);
    delete options2.maxDate;
    setTimeout(function () {
      $('.experimentStartDateInput', _this2.$refs.root).datepicker(options1);
      $('.experimentEndDateInput', _this2.$refs.root).datepicker(options2); // @ts-ignore

      $('.experimentStartTimeInput', _this2.$refs.root).timepicker({
        timeFormat: 'H:i:s'
      }) // timepicker triggers a jquery event, not a addEventListener event, so vue doesn't catch
      // it
      .on('change', function (event) {
        _this2.onKeydown('startDateTime', event);
      }); // @ts-ignore

      $('.experimentEndTimeInput', _this2.$refs.root).timepicker({
        timeFormat: 'H:i:s'
      }) // timepicker triggers a jquery event, not a addEventListener event, so vue doesn't catch
      // it
      .on('change', function (event) {
        _this2.onKeydown('endDateTime', event);
      });
    });
  },
  methods: {
    toLocalTime: toLocalTime,
    setDateState: function setDateState() {
      var experiment = this.experiment;

      if (experiment !== null && experiment !== void 0 && experiment.start_date) {
        var _experiment$start_dat = experiment.start_date.split(' ');

        var _experiment$start_dat2 = _slicedToArray(_experiment$start_dat, 2);

        this.startDateDate = _experiment$start_dat2[0];
        this.startDateTime = _experiment$start_dat2[1];
        $('.experimentStartDateInput', this.$refs.root).datepicker('setDate', this.startDateDate);
      }

      if (experiment !== null && experiment !== void 0 && experiment.end_date) {
        var _experiment$end_date$ = experiment.end_date.split(' ');

        var _experiment$end_date$2 = _slicedToArray(_experiment$end_date$, 2);

        this.endDateDate = _experiment$end_date$2[0];
        this.endDateTime = _experiment$end_date$2[1];
        $('.experimentEndDateInput', this.$refs.root).datepicker('setDate', this.endDateDate);
      }
    },
    onStartDateChange: function onStartDateChange() {
      var experiment = this.experiment;
      var startDate = null;

      if (this.startDateDate) {
        var startDateTime = this.startDateTime || '00:00:00';
        startDate = "".concat(this.startDateDate, " ").concat(startDateTime);
      }

      if (experiment.start_date !== startDate) {
        this.$emit('updateProperty', {
          prop: 'start_date',
          value: startDate
        });
      }
    },
    onEndDateChange: function onEndDateChange() {
      var experiment = this.experiment;
      var endDate = null;

      if (this.endDateDate) {
        var endDateTime = this.endDateTime || '23:59:59';
        endDate = "".concat(this.endDateDate, " ").concat(endDateTime);
      }

      if (experiment.end_date !== endDate) {
        this.$emit('updateProperty', {
          prop: 'end_date',
          value: endDate
        });
      }
    },
    onKeydown: function onKeydown(propName, event) {
      var _this3 = this;

      setTimeout(function () {
        _this3[propName] = event.target.value;
      });
    }
  },
  computed: {
    experimentStartHelp: function experimentStartHelp() {
      return Object(external_CoreHome_["translate"])('AbTesting_FieldScheduleExperimentStartHelp', '<strong>', '</strong>');
    },
    experimentFinishHelp: function experimentFinishHelp() {
      return Object(external_CoreHome_["translate"])('AbTesting_FieldScheduleExperimentFinishHelp', '<strong>', '</strong>');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Schedule.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Schedule.vue



Schedulevue_type_script_lang_ts.render = Schedulevue_type_template_id_071cb135_render

/* harmony default export */ var Schedule = (Schedulevue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Embed.vue?vue&type=template&id=1926b317

var Embedvue_type_template_id_1926b317_hoisted_1 = {
  class: "alert alert-info"
};
var Embedvue_type_template_id_1926b317_hoisted_2 = {
  class: "alert alert-info"
};
var Embedvue_type_template_id_1926b317_hoisted_3 = {
  class: "secondary"
};
var Embedvue_type_template_id_1926b317_hoisted_4 = {
  class: "alert alert-warning"
};

var Embedvue_type_template_id_1926b317_hoisted_5 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_6 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_7 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, "chmod 0755 matomo.js", -1);

var Embedvue_type_template_id_1926b317_hoisted_8 = [Embedvue_type_template_id_1926b317_hoisted_7];

var Embedvue_type_template_id_1926b317_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_11 = ["innerHTML"];
var Embedvue_type_template_id_1926b317_hoisted_12 = {
  class: "alert alert-info"
};

var Embedvue_type_template_id_1926b317_hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_14 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Embedvue_type_template_id_1926b317_hoisted_15 = {
  class: "secondary"
};
var Embedvue_type_template_id_1926b317_hoisted_16 = ["innerHTML"];
var Embedvue_type_template_id_1926b317_hoisted_17 = {
  class: "secondary"
};
var Embedvue_type_template_id_1926b317_hoisted_18 = ["innerHTML"];

var Embedvue_type_template_id_1926b317_hoisted_19 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])("");

var Embedvue_type_template_id_1926b317_hoisted_20 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])("");

var Embedvue_type_template_id_1926b317_hoisted_21 = ["innerHTML"];
var Embedvue_type_template_id_1926b317_hoisted_22 = {
  class: "secondary"
};
var Embedvue_type_template_id_1926b317_hoisted_23 = ["innerHTML"];

var Embedvue_type_template_id_1926b317_hoisted_24 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])("");

var Embedvue_type_template_id_1926b317_hoisted_25 = {
  class: "secondary"
};
var Embedvue_type_template_id_1926b317_hoisted_26 = ["innerHTML"];
var Embedvue_type_template_id_1926b317_hoisted_27 = ["innerHTML"];
function Embedvue_type_template_id_1926b317_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _directive_copy_to_clipboard = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("copy-to-clipboard");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Embedvue_type_template_id_1926b317_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentIsFinishedPleaseRemoveCode')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status === 'finished']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Embedvue_type_template_id_1926b317_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_WhereToInsertCodeWarning')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExperimentWillStartFromFirstTrackingRequest')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", Embedvue_type_template_id_1926b317_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_RunExperimentWithJsClient')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Embedvue_type_template_id_1926b317_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CustomJsNotAllowedWarning')) + " ", 1), Embedvue_type_template_id_1926b317_hoisted_5, Embedvue_type_template_id_1926b317_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, Embedvue_type_template_id_1926b317_hoisted_8, 512), [[_directive_copy_to_clipboard, {}]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_IncludeAbTestingTrackerCode')) + " ", 1), Embedvue_type_template_id_1926b317_hoisted_9, Embedvue_type_template_id_1926b317_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.jsIncludeTemplateCode), 1)], 512), [[_directive_copy_to_clipboard, {}]])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.jsIncludeTemplateCode]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getRunExperimentsInJsTracker)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_11), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.jsExperimentTemplateCode), 1)], 512), [[_directive_copy_to_clipboard, {}]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Embedvue_type_template_id_1926b317_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_UpdateExperimentWarning')) + " ", 1), Embedvue_type_template_id_1926b317_hoisted_13, Embedvue_type_template_id_1926b317_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_TestVariationViaUrl')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", Embedvue_type_template_id_1926b317_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_RunExperimentWithJsTracker')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getRunningTestOnServer)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_16), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_HowToRunTestOnServer')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, "var _paq = _paq || [];\n_paq.push(['AbTesting::enter', {experiment: '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.name) + "', 'variation': 'myVariationName'}]);\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseOriginal')) + "\n_paq.push(['AbTesting::enter', {experiment: '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.name) + "', 'variation': 'original'}]);\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseExperimentId')) + "\n_paq.push(['AbTesting::enter', {experiment: '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.idExperiment) + "', 'variation': 'original'}]);\n            ", 1)], 512), [[_directive_copy_to_clipboard, {}]])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", Embedvue_type_template_id_1926b317_hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_RunExperimentWithOtherSDK')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getAppTrackingDescription)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_18), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_HeadingAppTrackingExample')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Embedvue_type_template_id_1926b317_hoisted_19, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, "_paq.push(['trackEvent', 'abtesting', '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "', 'name of variation']);\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseOriginal')) + "\n_paq.push(['trackEvent', 'abtesting', '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "', 'original']);", 1)], 512), [[_directive_copy_to_clipboard, {}]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_HeadingPhpTracker')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Embedvue_type_template_id_1926b317_hoisted_20, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, "$tracker->doTrackEvent('abtesting', '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "', 'name of variation');\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseOriginal')) + "\n$tracker->doTrackEvent('abtesting', '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "', 'original');", 1)], 512), [[_directive_copy_to_clipboard, {}]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "alert alert-info",
    innerHTML: _ctx.$sanitize(_ctx.getAppTrackingAlertText)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_21)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", Embedvue_type_template_id_1926b317_hoisted_22, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_RunExperimentWithEmailCampaign')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getRunningInCampaignDescription)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_23), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Embedvue_type_template_id_1926b317_hoisted_24, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, "&pk_abe=" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "&pk_abv=myVariationName\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseOriginal')) + "\n&pk_abe=" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.name) + "&pk_abv=original\n\n// " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CodeCommentUseExperimentIdUrl')) + "\n&pk_abe=" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.idexperiment) + "&pk_abv=myVariationName", 1)], 512), [[_directive_copy_to_clipboard, {}]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", Embedvue_type_template_id_1926b317_hoisted_25, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_NeedHelp')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getNeedHelpDevZone)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_26), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", {
    innerHTML: _ctx.$sanitize(_ctx.getNeedHelpGetInTouch)
  }, null, 8, Embedvue_type_template_id_1926b317_hoisted_27)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiment.status === 'running' || _ctx.experiment.status === 'created']])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Embed.vue?vue&type=template&id=1926b317

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit/Embed.vue?vue&type=script&lang=ts


/* harmony default export */ var Embedvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: {
      type: Object,
      required: true
    },
    jsIncludeTemplateCode: {
      type: String,
      required: true
    },
    jsExperimentTemplateCode: {
      type: String,
      required: true
    }
  },
  directives: {
    CopyToClipboard: external_CoreHome_["CopyToClipboard"]
  },
  computed: {
    name: function name() {
      return this.experiment.name;
    },
    idExperiment: function idExperiment() {
      return this.experiment.idexperiment;
    },
    getRunExperimentsInJsTracker: function getRunExperimentsInJsTracker() {
      return Object(external_CoreHome_["translate"])('AbTesting_RunExperimentsInJsTracker', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/browser">', '</a>');
    },
    getRunningTestOnServer: function getRunningTestOnServer() {
      return Object(external_CoreHome_["translate"])('AbTesting_RunningTestOnServer', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/server">', '</a>');
    },
    getAppTrackingDescription: function getAppTrackingDescription() {
      return Object(external_CoreHome_["translate"])('AbTesting_AppTrackingDescription', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/apps">', '</a>', '<a target="blank" rel="noreferrer" href="https://github.com/innocraft/php-experiments">', '</a>');
    },
    getAppTrackingAlertText: function getAppTrackingAlertText() {
      return Object(external_CoreHome_["translate"])('AbTesting_AppTrackingAlertText', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/tracking-api-clients">', '</a>', '<a target="blank" rel="noreferrer" href="https://matomo.org/integrate/">', '</a>', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/api-reference/tracking-api">', '</a>', '<code>', '</code>');
    },
    getRunningInCampaignDescription: function getRunningInCampaignDescription() {
      return Object(external_CoreHome_["translate"])('AbTesting_RunningInCampaignDescription', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/campaign">', '</a>');
    },
    getNeedHelpDevZone: function getNeedHelpDevZone() {
      return Object(external_CoreHome_["translate"])('AbTesting_NeedHelpDevZone', '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/integration">', '</a>');
    },
    getNeedHelpGetInTouch: function getNeedHelpGetInTouch() {
      return Object(external_CoreHome_["translate"])('AbTesting_NeedHelpGetInTouch', '<a target="blank" rel="noreferrer" href="https://matomo.org/contact/">', '</a>');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Embed.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit/Embed.vue



Embedvue_type_script_lang_ts.render = Embedvue_type_template_id_1926b317_render

/* harmony default export */ var Embed = (Embedvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Edit.vue?vue&type=script&lang=ts












var notificationId = 'experimentsmanagement';
/* harmony default export */ var Editvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    idExperiment: [Number, String]
  },
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"],
    Basic: Basic,
    Metrics: Metrics,
    Conditions: Conditions,
    Traffic: Traffic,
    Targets: Targets,
    Redirects: Redirects,
    Schedule: Schedule,
    Embed: Embed
  },
  data: function data() {
    return {
      isDirty: false,
      jsTemplateCode: '',
      jsIncludeTemplateCode: '',
      successMetricOptions: [],
      confirmedEdit: false,
      action: '',
      experiment: {},
      utcTime: undefined
    };
  },
  created: function created() {
    var _this = this;

    Experiments_store.fetchJsIncludeTemplate().then(function (response) {
      _this.jsIncludeTemplateCode = response.value;
    });
    this.setUtcTime();
    Experiments_store.fetchAvailableSuccessMetrics().then(function (metrics) {
      _this.successMetricOptions = (metrics || []).map(function (m) {
        return {
          key: m.value,
          value: m.name
        };
      });
    });
    this.init();
  },
  watch: {
    idExperiment: function idExperiment(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    }
  },
  methods: {
    setUtcTime: function setUtcTime() {
      var _this2 = this;

      this.utcTime = this.getUtcTime();
      setTimeout(function () {
        return _this2.setUtcTime();
      }, 10000);
    },
    getUtcTime: function getUtcTime() {
      var date = new Date();

      if (date.toUTCString) {
        return date.toUTCString();
      }

      return undefined;
    },
    removeAnyExperimentNotification: function removeAnyExperimentNotification() {
      external_CoreHome_["NotificationsStore"].remove('experimentsmanagement');
      external_CoreHome_["NotificationsStore"].remove('ajaxHelper');
    },
    showNotification: function showNotification(message, context) {
      var instanceId = external_CoreHome_["NotificationsStore"].show({
        message: message,
        context: context,
        id: notificationId,
        type: 'transient'
      });
      setTimeout(function () {
        external_CoreHome_["NotificationsStore"].scrollToNotification(instanceId);
      }, 100);
    },
    showErrorFieldNotProvidedNotification: function showErrorFieldNotProvidedNotification(title) {
      var message = Object(external_CoreHome_["translate"])('AbTesting_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    hasSuccessMetric: function hasSuccessMetric(successMetric) {
      return (this.successMetricOptions || []).some(function (m) {
        return m.key === successMetric;
      });
    },
    init: function init() {
      var _this3 = this;

      this.confirmedEdit = false;
      this.action = 'basic';
      this.experiment = {};
      this.jsTemplateCode = '';

      if (this.edit && this.idExperiment) {
        Experiments_store.findExperiment(this.idExperiment).then(function (experiment) {
          var _this3$experiment$var;

          if (!experiment) {
            return;
          }

          _this3.experiment = Object(external_CoreHome_["clone"])(experiment);
          _this3.confirmedEdit = _this3.experiment.status !== 'running' && _this3.experiment.status !== 'finished';

          if (!((_this3$experiment$var = _this3.experiment.variations) !== null && _this3$experiment$var !== void 0 && _this3$experiment$var.length)) {
            _this3.experiment.variations = [{
              name: 'Variation1',
              percentage: ''
            }];
          }

          _this3.addDefaultTargetIfNeeded();

          _this3.addDefaultSuccessMetricIfNeeded();

          Experiments_store.fetchJsExperimentTemplate(_this3.idExperiment).then(function (response) {
            _this3.jsTemplateCode = response.value;
          });
          _this3.isDirty = false;
        });
        return;
      }

      if (this.create) {
        this.experiment = {
          idSite: external_CoreHome_["Matomo"].idSite,
          name: '',
          description: '',
          hypothesis: '',
          variations: [{
            name: 'Variation1',
            percentage: ''
          }],
          confidence_threshold: '95.0'
        };
        this.addDefaultTargetIfNeeded();
        this.isDirty = false;
      }
    },
    addDefaultTargetIfNeeded: function addDefaultTargetIfNeeded() {
      var _this$experiment$incl, _this$experiment$excl;

      if (this.experiment && !((_this$experiment$incl = this.experiment.included_targets) !== null && _this$experiment$incl !== void 0 && _this$experiment$incl.length)) {
        this.experiment.included_targets = [{
          attribute: 'url',
          type: 'any',
          value: '',
          inverted: 0
        }];
      }

      if (this.experiment && !((_this$experiment$excl = this.experiment.excluded_targets) !== null && _this$experiment$excl !== void 0 && _this$experiment$excl.length)) {
        this.experiment.excluded_targets = [{
          attribute: 'url',
          type: 'equals_exactly',
          value: '',
          inverted: 0
        }];
      }
    },
    addDefaultSuccessMetricIfNeeded: function addDefaultSuccessMetricIfNeeded() {
      var _this$experiment$succ;

      if (this.experiment && !((_this$experiment$succ = this.experiment.success_metrics) !== null && _this$experiment$succ !== void 0 && _this$experiment$succ.length)) {
        this.experiment.success_metrics = [];
        var defaultMetric = 'nb_conversions';

        if (!this.hasSuccessMetric(defaultMetric)) {
          defaultMetric = 'nb_pageviews';
        }

        this.experiment.success_metrics.push({
          metric: defaultMetric
        });

        if (this.hasSuccessMetric('nb_orders')) {
          this.experiment.success_metrics.push({
            metric: 'nb_orders'
          });
        }

        if (this.hasSuccessMetric('nb_orders_revenue')) {
          this.experiment.success_metrics.push({
            metric: 'nb_orders_revenue'
          });
        }
      }
    },
    finishExperiment: function finishExperiment() {
      var _this4 = this;

      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmFinishExperiment, {
        yes: function yes() {
          Experiments_store.finishExperiment(_this4.idExperiment).then(function (response) {
            if (response.type === 'error') {
              return;
            }

            Experiments_store.reload().then(function () {
              _this4.init();
            });

            _this4.showNotification(Object(external_CoreHome_["translate"])('AbTesting_ExperimentFinished'), response.type);
          });
        }
      });
    },
    cancel: function cancel() {
      var newParams = Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value);
      delete newParams.idExperiment;
      external_CoreHome_["MatomoUrl"].updateHash(newParams);
    },
    createExperiment: function createExperiment() {
      var _this$experiment$incl2,
          _this5 = this;

      var method = 'AbTesting.addExperiment';
      this.removeAnyExperimentNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      if (((_this$experiment$incl2 = this.experiment.included_targets[0]) === null || _this$experiment$incl2 === void 0 ? void 0 : _this$experiment$incl2.type) === 'equals_simple') {
        if (!this.experiment.included_targets[0].value) {
          this.showNotification(Object(external_CoreHome_["translate"])('AbTesting_ErrorCreateNoUrlDefined'), 'error');
          return;
        }

        this.experiment.included_targets = [{
          attribute: 'url',
          inverted: '0',
          type: 'equals_simple',
          value: this.experiment.included_targets[0].value
        }];
      } else {
        this.experiment.included_targets = [{
          attribute: 'url',
          inverted: '0',
          type: 'any',
          value: ''
        }];
      }

      this.addDefaultSuccessMetricIfNeeded();
      Experiments_store.createOrUpdateExperiment(this.experiment, method).then(function (response) {
        if (response.type === 'error') {
          return;
        }

        _this5.isDirty = false;
        var idExperiment = response.response.value;
        Experiments_store.reload().then(function () {
          if (external_CoreHome_["Matomo"].helper.isReportingPage()) {
            external_CoreHome_["Matomo"].postEvent('updateReportingMenu');
          }

          external_CoreHome_["MatomoUrl"].updateHash(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
            idExperiment: idExperiment
          }));
          setTimeout(function () {
            _this5.showNotification(Object(external_CoreHome_["translate"])('AbTesting_ExperimentCreated'), response.type);
          }, 200);
        });
      });
    },
    showEmbedAction: function showEmbedAction() {
      if (!this.isDirty) {
        this.action = 'embed';
        return;
      }

      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.updateExperimentNeededToEmbed, {
        yes: function yes() {
          return null;
        }
      });
    },
    updateExperiment: function updateExperiment() {
      var _this6 = this;

      this.removeAnyExperimentNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      var method = 'AbTesting.updateExperiment';
      var willUpdateStartExperiment = false;

      if (this.experiment.start_date) {
        var startDate = toLocalTime(this.experiment.start_date, false);
        var now = new Date();

        if (startDate && startDate <= now && this.experiment.status === 'created') {
          willUpdateStartExperiment = true;
        }
      }

      var doUpdateExperiment = function doUpdateExperiment() {
        Experiments_store.createOrUpdateExperiment(_this6.experiment, method).then(function (response) {
          if (response.type === 'error') {
            return;
          }

          _this6.isDirty = false;
          Experiments_store.reload().then(function () {
            _this6.init();
          });

          _this6.showNotification(Object(external_CoreHome_["translate"])('AbTesting_ExperimentUpdated'), response.type);
        });
      };

      if (willUpdateStartExperiment) {
        external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmUpdateStartExperiment, {
          yes: doUpdateExperiment
        });
      } else {
        doUpdateExperiment();
      }
    },
    checkRequiredFieldsAreSet: function checkRequiredFieldsAreSet() {
      if (!this.experiment.name) {
        var title = Object(external_CoreHome_["translate"])('AbTesting_ExperimentName');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (!this.experiment.hypothesis) {
        var _title = Object(external_CoreHome_["translate"])('AbTesting_Hypothesis');

        this.showErrorFieldNotProvidedNotification(_title);
        return false;
      }

      if (!this.experiment.description) {
        var _title2 = Object(external_CoreHome_["translate"])('General_Description');

        this.showErrorFieldNotProvidedNotification(_title2);
        return false;
      }

      return true;
    },
    onCancel: function onCancel(event) {
      if (!event.target.classList.contains('cancelLink')) {
        return;
      }

      this.cancel();
    },
    setValueHasChanged: function setValueHasChanged() {
      this.isDirty = true;
    },
    setForwardUtmParams: function setForwardUtmParams(forwardUtmParams) {
      this.experiment.forward_utm_params = forwardUtmParams;
      this.setValueHasChanged();
    }
  },
  computed: {
    percentageParticipantsOptions: function percentageParticipantsOptions() {
      var values = [1, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100];
      return values.map(function (v) {
        return {
          key: "".concat(v),
          value: "".concat(v, "%")
        };
      });
    },
    mdeRelativeOptions: function mdeRelativeOptions() {
      var values = [1, 2, 3, 4, 5, 8, 10, 15, 20, 25, 30, 40, 50, 60, 70, 75, 80, 90, 100, 125, 150, 200, 300];
      return values.map(function (v) {
        return {
          key: "".concat(v),
          value: "".concat(v, "%")
        };
      });
    },
    trafficAllocationOptions: function trafficAllocationOptions() {
      var result = [];

      for (var i = 0; i < 101; i += 1) {
        result.push({
          key: "".concat(i),
          value: "".concat(i, "%")
        });
      }

      return result;
    },
    confidenceThresholdOptions: function confidenceThresholdOptions() {
      var values = ['90.0', '95.0', '98.0', '99.0', '99.5'];
      return values.map(function (v) {
        return {
          key: v,
          value: "".concat(v, "%")
        };
      });
    },
    createExperimentTargetTypes: function createExperimentTargetTypes() {
      return [{
        key: 'any',
        value: Object(external_CoreHome_["translate"])('AbTesting_ActivateExperimentOnAllPages')
      }, {
        key: 'equals_simple',
        value: Object(external_CoreHome_["translate"])('AbTesting_ActiveExperimentOnSomePages')
      }];
    },
    create: function create() {
      return !this.idExperiment || this.idExperiment === '0';
    },
    edit: function edit() {
      return !this.create;
    },
    editTitle: function editTitle() {
      return this.create ? 'AbTesting_CreateNewExperiment' : 'AbTesting_EditExperiment';
    },
    contentTitle: function contentTitle() {
      return Object(external_CoreHome_["translate"])(this.editTitle, this.experiment.name ? "\"".concat(this.experiment.name, "\"") : '');
    },
    isLoading: function isLoading() {
      return Experiments_store.state.value.isLoading;
    },
    isUpdating: function isUpdating() {
      return Experiments_store.state.value.isUpdating;
    },
    viewReportLink: function viewReportLink() {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify({
        module: 'CoreHome',
        action: 'index',
        idSite: this.experiment.idsite,
        period: 'range',
        date: this.experiment.date_range_string
      }), "#?").concat(external_CoreHome_["MatomoUrl"].stringify({
        category: 'AbTesting_Experiments',
        idSite: this.experiment.idsite,
        period: 'range',
        date: this.experiment.date_range_string,
        subcategory: this.experiment.idexperiment
      }));
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Edit.vue



Editvue_type_script_lang_ts.render = Editvue_type_template_id_11d19b81_render

/* harmony default export */ var Edit = (Editvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/List.vue?vue&type=template&id=e24b5932

var Listvue_type_template_id_e24b5932_hoisted_1 = {
  class: "experimentStatusFilter",
  id: "filterStatus",
  name: "filterStatus"
};
var Listvue_type_template_id_e24b5932_hoisted_2 = {
  style: {
    "margin-left": "3.5px"
  },
  class: "experimentSearchFilter",
  name: "experimentSearch"
};
var Listvue_type_template_id_e24b5932_hoisted_3 = {
  class: "index"
};
var Listvue_type_template_id_e24b5932_hoisted_4 = {
  class: "name"
};
var Listvue_type_template_id_e24b5932_hoisted_5 = {
  class: "description"
};
var Listvue_type_template_id_e24b5932_hoisted_6 = {
  class: "status"
};
var Listvue_type_template_id_e24b5932_hoisted_7 = {
  class: "startDate"
};
var Listvue_type_template_id_e24b5932_hoisted_8 = {
  class: "endDate"
};
var Listvue_type_template_id_e24b5932_hoisted_9 = {
  class: "action"
};
var Listvue_type_template_id_e24b5932_hoisted_10 = {
  colspan: "7"
};
var Listvue_type_template_id_e24b5932_hoisted_11 = {
  class: "loadingPiwik"
};

var Listvue_type_template_id_e24b5932_hoisted_12 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var Listvue_type_template_id_e24b5932_hoisted_13 = {
  colspan: "7"
};
var Listvue_type_template_id_e24b5932_hoisted_14 = ["id"];
var Listvue_type_template_id_e24b5932_hoisted_15 = {
  class: "index"
};
var Listvue_type_template_id_e24b5932_hoisted_16 = {
  class: "name"
};
var Listvue_type_template_id_e24b5932_hoisted_17 = {
  class: "description"
};
var Listvue_type_template_id_e24b5932_hoisted_18 = {
  class: "status"
};
var Listvue_type_template_id_e24b5932_hoisted_19 = ["title"];
var Listvue_type_template_id_e24b5932_hoisted_20 = ["title"];
var Listvue_type_template_id_e24b5932_hoisted_21 = {
  class: "action"
};
var Listvue_type_template_id_e24b5932_hoisted_22 = ["title", "onClick"];
var Listvue_type_template_id_e24b5932_hoisted_23 = ["title", "onClick"];
var Listvue_type_template_id_e24b5932_hoisted_24 = ["title", "href"];
var Listvue_type_template_id_e24b5932_hoisted_25 = ["title", "onClick"];
var Listvue_type_template_id_e24b5932_hoisted_26 = {
  class: "tableActionBar"
};

var Listvue_type_template_id_e24b5932_hoisted_27 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-add"
}, null, -1);

var Listvue_type_template_id_e24b5932_hoisted_28 = {
  class: "ui-confirm",
  ref: "confirmArchiveExperiment"
};
var Listvue_type_template_id_e24b5932_hoisted_29 = ["value"];
var Listvue_type_template_id_e24b5932_hoisted_30 = ["value"];
var Listvue_type_template_id_e24b5932_hoisted_31 = {
  class: "ui-confirm",
  ref: "confirmDeleteExperiment"
};
var Listvue_type_template_id_e24b5932_hoisted_32 = ["value"];
var Listvue_type_template_id_e24b5932_hoisted_33 = ["value"];
function Listvue_type_template_id_e24b5932_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  var _directive_content_table = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-table");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ContentBlock, {
    "content-title": _ctx.translate('AbTesting_ManageExperiments'),
    feature: _ctx.translate('AbTesting_ManageExperiments')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ManageExperimentsIntroduction')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_e24b5932_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "select",
        name: "filterStatus",
        "model-value": _ctx.filterStatus,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          _ctx.setFilterStatus($event);

          _ctx.onFilterStatusChange();
        }),
        title: _ctx.translate('AbTesting_Filter'),
        "full-width": true,
        options: _ctx.statusOptions
      }, null, 8, ["model-value", "title", "options"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_e24b5932_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "text",
        name: "experimentSearch",
        title: _ctx.translate('General_Search'),
        modelValue: _ctx.searchFilter,
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          return _ctx.searchFilter = $event;
        }),
        "full-width": true
      }, null, 8, ["title", "modelValue"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.experiments.length > 0]])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Id')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Name')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Description')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Status')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_StartDate')) + " (UTC)", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_FinishDate')) + " (UTC)", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_e24b5932_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Actions')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Listvue_type_template_id_e24b5932_hoisted_11, [Listvue_type_template_id_e24b5932_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoading || _ctx.isUpdating]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_NoExperimentsFound')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.filterStatus]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_NoActiveExperimentConfigured')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        onClick: _cache[2] || (_cache[2] = function ($event) {
          return _ctx.createExperiment();
        })
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CreateNewExperimentNow')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.filterStatus]])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoading && _ctx.experiments.length === 0]]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.sortedExperiments, function (experiment) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", {
          id: "experiment".concat(experiment.idexperiment),
          class: "experiments",
          key: experiment.idexperiment
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(experiment.idexperiment), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_16, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(experiment.name), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.truncateString(experiment.description.trim(), 60)), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.readableExperimentStatus(experiment.status, _ctx.statusOptions)), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", {
          class: "startDate",
          title: _ctx.dateInYourTimezoneText(experiment, experiment.start_date)
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(experiment.start_date), 9, Listvue_type_template_id_e24b5932_hoisted_19), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", {
          class: "endDate",
          title: _ctx.dateInYourTimezoneText(experiment, experiment.end_date)
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(experiment.end_date), 9, Listvue_type_template_id_e24b5932_hoisted_20), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_e24b5932_hoisted_21, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-edit",
          title: _ctx.translate('AbTesting_EditThisExperiment'),
          onClick: function onClick($event) {
            return _ctx.editExperiment(experiment.idexperiment);
          }
        }, null, 8, Listvue_type_template_id_e24b5932_hoisted_22), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-delete",
          title: _ctx.translate('AbTesting_DeleteExperimentInfo'),
          onClick: function onClick($event) {
            return _ctx.deleteExperiment(experiment);
          }
        }, null, 8, Listvue_type_template_id_e24b5932_hoisted_23), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], experiment.status === 'created']]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          target: "_blank",
          class: "table-action icon-show",
          title: _ctx.translate('AbTesting_ViewReportInfo'),
          href: _ctx.getViewReportLink(experiment)
        }, null, 8, Listvue_type_template_id_e24b5932_hoisted_24), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.showViewReportInfo(experiment)]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action abtestingicon-box-add",
          title: _ctx.translate('AbTesting_ArchiveReportInfo'),
          onClick: function onClick($event) {
            return _ctx.archiveExperiment(experiment);
          }
        }, null, 8, Listvue_type_template_id_e24b5932_hoisted_25), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], experiment.status === 'finished']])])], 8, Listvue_type_template_id_e24b5932_hoisted_14);
      }), 128))])], 512), [[_directive_content_table]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_e24b5932_hoisted_26, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        class: "createNewExperiment",
        onClick: _cache[3] || (_cache[3] = function ($event) {
          return _ctx.createExperiment();
        })
      }, [Listvue_type_template_id_e24b5932_hoisted_27, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_CreateNewExperiment')), 1)])])];
    }),
    _: 1
  }, 8, ["content-title", "feature"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_e24b5932_hoisted_28, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ArchiveReportConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, Listvue_type_template_id_e24b5932_hoisted_29), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, Listvue_type_template_id_e24b5932_hoisted_30)], 512), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_e24b5932_hoisted_31, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_DeleteExperimentConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, Listvue_type_template_id_e24b5932_hoisted_32), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, Listvue_type_template_id_e24b5932_hoisted_33)], 512)]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/List.vue?vue&type=template&id=e24b5932

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/List.vue?vue&type=script&lang=ts
function Listvue_type_script_lang_ts_toConsumableArray(arr) { return Listvue_type_script_lang_ts_arrayWithoutHoles(arr) || Listvue_type_script_lang_ts_iterableToArray(arr) || Listvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Listvue_type_script_lang_ts_nonIterableSpread(); }

function Listvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Listvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Listvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Listvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Listvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Listvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Listvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Listvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }






/* harmony default export */ var Listvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {},
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"],
    Field: external_CorePluginsAdmin_["Field"]
  },
  directives: {
    ContentTable: external_CoreHome_["ContentTable"]
  },
  data: function data() {
    return {
      searchFilter: '',
      statusOptions: []
    };
  },
  created: function created() {
    var _this = this;

    Experiments_store.fetchAvailableStatuses().then(function (statuses) {
      _this.statusOptions = [{
        key: '',
        value: Object(external_CoreHome_["translate"])('AbTesting_StatusActive')
      }].concat(Listvue_type_script_lang_ts_toConsumableArray(statuses.map(function (s) {
        return {
          key: s.value,
          value: s.name
        };
      })));
    });
    this.onFilterStatusChange();
  },
  methods: {
    createExperiment: function createExperiment() {
      this.editExperiment(0);
    },
    editExperiment: function editExperiment(idExperiment) {
      external_CoreHome_["MatomoUrl"].updateHash(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
        idExperiment: idExperiment
      }));
    },
    deleteExperiment: function deleteExperiment(experiment) {
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmDeleteExperiment, {
        yes: function yes() {
          Experiments_store.deleteExperiment(experiment.idexperiment).then(function () {
            Experiments_store.reload();
          });
        }
      });
    },
    archiveExperiment: function archiveExperiment(experiment) {
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmArchiveExperiment, {
        yes: function yes() {
          Experiments_store.archiveExperiment(experiment.idexperiment).then(function () {
            Experiments_store.reload();
          });
        }
      });
    },
    onFilterStatusChange: function onFilterStatusChange() {
      Experiments_store.fetchExperiments();
    },
    setFilterStatus: function setFilterStatus(status) {
      Experiments_store.setFilterStatus(status);
    },
    truncateString: function truncateString(text, length) {
      if (text && text.length > length) {
        return "".concat(text.substr(0, length - 3), "...");
      }

      return text;
    },
    readableExperimentStatus: function readableExperimentStatus(status, statusOptions) {
      var _statusOptions$find;

      if (!statusOptions) {
        return status;
      }

      return (_statusOptions$find = statusOptions.find(function (s) {
        return status === s.key;
      })) === null || _statusOptions$find === void 0 ? void 0 : _statusOptions$find.value;
    },
    dateInYourTimezoneText: function dateInYourTimezoneText(experiment, date) {
      var equalsDate = Object(external_CoreHome_["translate"])('AbTesting_EqualsDateInYourTimezone');
      return toLocalTime(date, true) ? "".concat(equalsDate).concat(toLocalTime(date, true)) : '';
    },
    showViewReportInfo: function showViewReportInfo(experiment) {
      return (experiment.status === 'running' || experiment.status === 'finished') && experiment.date_range_string;
    },
    getViewReportLink: function getViewReportLink(experiment) {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify({
        module: 'CoreHome',
        action: 'index',
        idSite: experiment.idsite,
        period: 'range',
        date: experiment.date_range_string
      }), "#?").concat(external_CoreHome_["MatomoUrl"].stringify({
        category: 'AbTesting_Experiments',
        idSite: experiment.idsite,
        period: 'range',
        date: experiment.date_range_string,
        subcategory: experiment.idexperiment
      }));
    }
  },
  computed: {
    siteName: function siteName() {
      return external_CoreHome_["Matomo"].siteName;
    },
    filterStatus: function filterStatus() {
      return Experiments_store.state.value.filterStatus;
    },
    experiments: function experiments() {
      return Experiments_store.state.value.experiments;
    },
    isLoading: function isLoading() {
      return Experiments_store.state.value.isLoading;
    },
    isUpdating: function isUpdating() {
      return Experiments_store.state.value.isUpdating;
    },
    sortedExperiments: function sortedExperiments() {
      var _this2 = this;

      var experiments = Listvue_type_script_lang_ts_toConsumableArray(this.experiments).filter(function (h) {
        return Object.keys(h).some(function (propName) {
          var entity = h;
          return typeof entity[propName] === 'string' && entity[propName].indexOf(_this2.searchFilter) !== -1;
        });
      });

      experiments.sort(function (lhs, rhs) {
        var lhsId = parseInt("".concat(lhs.idexperiment), 10);
        var rhsId = parseInt("".concat(rhs.idexperiment), 10);
        return lhsId - rhsId;
      });
      return experiments;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/List.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/List.vue



Listvue_type_script_lang_ts.render = Listvue_type_template_id_e24b5932_render

/* harmony default export */ var List = (Listvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Manage.vue?vue&type=template&id=0c69475a

var Managevue_type_template_id_0c69475a_hoisted_1 = {
  class: "manageExperiments"
};
function Managevue_type_template_id_0c69475a_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ListExperiments = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ListExperiments");

  var _component_EditExperiments = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("EditExperiments");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Managevue_type_template_id_0c69475a_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ListExperiments)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.editMode]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_EditExperiments, {
    "id-experiment": _ctx.idExperiment
  }, null, 8, ["id-experiment"])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.editMode]])]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Manage.vue?vue&type=template&id=0c69475a

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Experiments/Manage.vue?vue&type=script&lang=ts




/* harmony default export */ var Managevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {},
  components: {
    EditExperiments: Edit,
    ListExperiments: List
  },
  data: function data() {
    return {
      editMode: false,
      idExperiment: null
    };
  },
  created: function created() {
    var _this = this;

    // doing this in a watch because we don't want to post an event in a computed property
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return external_CoreHome_["MatomoUrl"].hashParsed.value.idExperiment;
    }, function (idExperiment) {
      _this.initState(idExperiment);
    });
    this.initState(external_CoreHome_["MatomoUrl"].hashParsed.value.idExperiment);
  },
  methods: {
    removeAnyExperimentNotification: function removeAnyExperimentNotification() {
      external_CoreHome_["NotificationsStore"].remove('experimentsmanagement');
    },
    initState: function initState(idExperiment) {
      if (idExperiment) {
        if (idExperiment === '0') {
          var parameters = {
            isAllowed: true
          };
          external_CoreHome_["Matomo"].postEvent('AbTesting.initAddExperiment', parameters);

          if (parameters && !parameters.isAllowed) {
            this.editMode = false;
            this.idExperiment = null;
            return;
          }
        }

        this.editMode = true;
        this.idExperiment = parseInt(idExperiment, 10);
      } else {
        this.editMode = false;
        this.idExperiment = null;
      }

      this.removeAnyExperimentNotification();
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Manage.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Experiments/Manage.vue



Managevue_type_script_lang_ts.render = Managevue_type_template_id_0c69475a_render

/* harmony default export */ var Manage = (Managevue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/checkForActiveExperiments.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */


function isGettingStartedPage() {
  var url = window.location.href;
  return url.indexOf('category=AbTesting_Experiments&subcategory=AbTesting_GettingStarted') !== -1;
}

function checkForExperiment() {
  if (!isGettingStartedPage()) {
    return;
  }

  external_CoreHome_["AjaxHelper"].fetch({
    method: 'AbTesting.getActiveExperiments'
  }).then(function (experiments) {
    var _experiments$;

    if (!isGettingStartedPage()) {
      return;
    }

    if (experiments !== null && experiments !== void 0 && experiments.length && experiments !== null && experiments !== void 0 && (_experiments$ = experiments[0]) !== null && _experiments$ !== void 0 && _experiments$.idexperiment) {
      external_CoreHome_["MatomoUrl"].updateUrl(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
        idSite: external_CoreHome_["Matomo"].idSite
      }), Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
        category: 'AbTesting_Experiments',
        subcategory: experiments[0].idexperiment
      }));
    }
  }).catch(function () {// we ignore errors
  });
}

function checkForActiveExperiments() {
  var msInSecond = 1000;
  setTimeout(checkForExperiment, msInSecond);
  setTimeout(checkForExperiment, 10 * msInSecond);
  setTimeout(checkForExperiment, 60 * msInSecond);
  setTimeout(checkForExperiment, 300 * msInSecond);
  setTimeout(checkForExperiment, 600 * msInSecond);
  setTimeout(checkForExperiment, 3000 * msInSecond);
  setTimeout(checkForExperiment, 6000 * msInSecond);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/ExperimentPageLink/ExperimentPageLink.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

var ExperimentPageLink_window = window,
    ExperimentPageLink_$ = ExperimentPageLink_window.$; // usage v-experiment-page-link="{ idExperiment: 5 }"

var ExperimentPageLink = {
  mounted: function mounted(el, binding) {
    if (!external_CoreHome_["Matomo"].helper.isReportingPage()) {
      return;
    }

    var link = ExperimentPageLink_$(el);

    if (el.tagName.toLowerCase() !== 'a') {
      var headline = ExperimentPageLink_$(el).text();
      ExperimentPageLink_$(el).html('<a></a>');
      link = ExperimentPageLink_$(el).find('a');
      link.text(headline);
    }

    link.css('margin-right', '3.5px').bind('click', function (e) {
      e.preventDefault();
      external_CoreHome_["MatomoUrl"].updateHash(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
        category: 'AbTesting_Experiments',
        subcategory: binding.value.idExperiment
      }));
    });
  }
};
/* harmony default export */ var ExperimentPageLink_ExperimentPageLink = (ExperimentPageLink); // manually handle occurrence of piwik-experiment-page-link on datatable html attributes since
// dataTable.js is not managed by vue.
// eslint-disable-next-line @typescript-eslint/no-explicit-any

external_CoreHome_["Matomo"].on('Matomo.processDynamicHtml', function ($element) {
  $element.find('[piwik-experiment-page-link]').each(function (i, e) {
    if (ExperimentPageLink_$(e).attr('piwik-experiment-page-link-handled')) {
      return;
    }

    var idExperiment = ExperimentPageLink_$(e).attr('piwik-experiment-page-link');

    if (idExperiment) {
      ExperimentPageLink.mounted(e, {
        instance: null,
        value: {
          idExperiment: idExperiment
        },
        oldValue: null,
        modifiers: {},
        dir: {}
      });
    }

    ExperimentPageLink_$(e).attr('piwik-experiment-page-link-handled', '1');
  });
});
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Summary/Summary.vue?vue&type=template&id=31426bb7

var Summaryvue_type_template_id_31426bb7_hoisted_1 = {
  class: "experimentSummary"
};

var Summaryvue_type_template_id_31426bb7_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_4 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_5 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_6 = {
  key: 0,
  style: {
    "margin-left": "3.5px"
  }
};
var Summaryvue_type_template_id_31426bb7_hoisted_7 = ["innerHTML"];

var Summaryvue_type_template_id_31426bb7_hoisted_8 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Summaryvue_type_template_id_31426bb7_hoisted_10 = {
  key: 1
};
var Summaryvue_type_template_id_31426bb7_hoisted_11 = ["innerHTML"];
var Summaryvue_type_template_id_31426bb7_hoisted_12 = ["title"];
function Summaryvue_type_template_id_31426bb7_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("p", Summaryvue_type_template_id_31426bb7_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Hypothesis')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.hypothesis) + " ", 1), Summaryvue_type_template_id_31426bb7_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Description')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.description) + " ", 1), Summaryvue_type_template_id_31426bb7_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ExpectedImprovement')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.mde_relative) + "% ", 1), Summaryvue_type_template_id_31426bb7_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ConfidenceThreshold')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.experiment.confidence_threshold) + "% ", 1), Summaryvue_type_template_id_31426bb7_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_Status')) + ":", 1), _ctx.experiment.status === 'running' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", Summaryvue_type_template_id_31426bb7_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.reportStatusRunning),
    style: {
      "margin-right": "3.5px"
    }
  }, null, 8, Summaryvue_type_template_id_31426bb7_hoisted_7), _ctx.isAdmin ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    class: "finishExperiment",
    onClick: _cache[0] || (_cache[0] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.finishExperiment();
    }, ["prevent"]))
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ActionFinishExperiment')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Summaryvue_type_template_id_31426bb7_hoisted_8, Summaryvue_type_template_id_31426bb7_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ReportWhenToDeclareWinner')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.experiment.status === 'finished' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", Summaryvue_type_template_id_31426bb7_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.reportStatusFinished)
  }, null, 8, Summaryvue_type_template_id_31426bb7_hoisted_11), _ctx.isAdmin ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    title: _ctx.translate('AbTesting_ArchiveReportInfo'),
    onClick: _cache[1] || (_cache[1] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.archiveExperiment();
    }, ["prevent"])),
    class: "archiveExperiment"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ActionArchiveExperiment')), 9, Summaryvue_type_template_id_31426bb7_hoisted_12)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/Summary.vue?vue&type=template&id=31426bb7

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Summary/Summary.vue?vue&type=script&lang=ts



/* harmony default export */ var Summaryvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: {
      type: Object,
      required: true
    },
    isAdmin: Boolean,
    startDateSiteTimezonePretty: String,
    endDateSiteTimezonePretty: String
  },
  computed: {
    reportStatusRunning: function reportStatusRunning() {
      return Object(external_CoreHome_["translate"])('AbTesting_ReportStatusRunning', "<span class=\"reportDuration\">".concat(this.experiment.duration, "</span>"), this.startDateSiteTimezonePretty || '');
    },
    reportStatusFinished: function reportStatusFinished() {
      return Object(external_CoreHome_["translate"])('AbTesting_ReportStatusFinished', "<span class=\"reportDuration\">".concat(this.experiment.duration, "</span>"), this.startDateSiteTimezonePretty || '', this.endDateSiteTimezonePretty || '');
    }
  },
  methods: {
    finishExperiment: function finishExperiment() {
      var _this = this;

      external_CoreHome_["Matomo"].helper.modalConfirm('#confirmFinishExperiment', {
        yes: function yes() {
          Experiments_store.finishExperiment(_this.experiment.idexperiment).then(function (response) {
            if (response.type === 'error') {
              return;
            }

            external_CoreHome_["Matomo"].helper.redirect();
          });
        }
      });
    },
    archiveExperiment: function archiveExperiment() {
      var _this2 = this;

      external_CoreHome_["Matomo"].helper.modalConfirm('#confirmArchiveExperiment', {
        yes: function yes() {
          Experiments_store.archiveExperiment(_this2.experiment.idexperiment).then(function (response) {
            if (response.type === 'error') {
              return;
            }

            external_CoreHome_["NotificationsStore"].show({
              message: Object(external_CoreHome_["translate"])('AbTesting_ActionArchiveExperimentSuccess'),
              context: 'success',
              type: 'transient'
            });
            external_CoreHome_["MatomoUrl"].updateUrl(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
              popover: '',
              idExperiment: _this2.experiment.idexperiment,
              segment: ''
            }), Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
              category: 'General_Visitors',
              subcategory: 'General_Overview'
            }));
          });
        }
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/Summary.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/Summary.vue



Summaryvue_type_script_lang_ts.render = Summaryvue_type_template_id_31426bb7_render

/* harmony default export */ var Summary = (Summaryvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Summary/SummaryPage.vue?vue&type=template&id=42789d84

var SummaryPagevue_type_template_id_42789d84_hoisted_1 = {
  class: "ui-confirm",
  id: "confirmArchiveExperiment"
};
var SummaryPagevue_type_template_id_42789d84_hoisted_2 = ["value"];
var SummaryPagevue_type_template_id_42789d84_hoisted_3 = ["value"];
var SummaryPagevue_type_template_id_42789d84_hoisted_4 = {
  class: "ui-confirm",
  id: "confirmFinishExperiment"
};
var SummaryPagevue_type_template_id_42789d84_hoisted_5 = ["value"];
var SummaryPagevue_type_template_id_42789d84_hoisted_6 = ["value"];
var SummaryPagevue_type_template_id_42789d84_hoisted_7 = {
  id: "abtestPeriod",
  class: "piwikTopControl piwikSelector borderedControl periodSelector"
};
var SummaryPagevue_type_template_id_42789d84_hoisted_8 = ["title"];

var SummaryPagevue_type_template_id_42789d84_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon icon-calendar"
}, null, -1);

function SummaryPagevue_type_template_id_42789d84_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Summary = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Summary");

  var _directive_content_intro = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-intro");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])((Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_MenuTitleExperiment', _ctx.experiment.name)), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Summary, {
    "is-admin": _ctx.isAdmin,
    experiment: _ctx.experiment,
    "start-date-site-timezone-pretty": _ctx.startDateTimezone,
    "end-date-site-timezone-pretty": _ctx.endDateTimezone
  }, null, 8, ["is-admin", "experiment", "start-date-site-timezone-pretty", "end-date-site-timezone-pretty"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SummaryPagevue_type_template_id_42789d84_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ArchiveReportConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, SummaryPagevue_type_template_id_42789d84_hoisted_2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, SummaryPagevue_type_template_id_42789d84_hoisted_3)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SummaryPagevue_type_template_id_42789d84_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AbTesting_ConfirmFinishExperiment')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, SummaryPagevue_type_template_id_42789d84_hoisted_5), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, SummaryPagevue_type_template_id_42789d84_hoisted_6)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SummaryPagevue_type_template_id_42789d84_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    id: "date",
    class: "title",
    title: _ctx.translate('AbTesting_ReportDateCannotBeChanged')
  }, [SummaryPagevue_type_template_id_42789d84_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.readablePeriod), 1)], 8, SummaryPagevue_type_template_id_42789d84_hoisted_8)])], 512)), [[_directive_content_intro]]);
}
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/SummaryPage.vue?vue&type=template&id=42789d84

// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/initAbTest.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

var abTestControlInitialized = false;
var initAbTest_window = window,
    initAbTest_$ = initAbTest_window.$,
    initTopControls = initAbTest_window.initTopControls;
function initAbTest() {
  var topControls = '.top_controls #abtestPeriod';
  var dateSelector = '#periodString';
  initAbTest_$(dateSelector).hide();
  initAbTest_$(topControls).remove();
  initAbTest_$('#abtestPeriod').insertAfter('#periodString');

  if (typeof initTopControls !== 'undefined' && initTopControls) {
    initTopControls();
  }

  if (!abTestControlInitialized) {
    abTestControlInitialized = true;
    external_CoreHome_["Matomo"].on('piwikPageChange', function () {
      var href = window.location.href;
      var subcategory = external_CoreHome_["MatomoUrl"].hashParsed.value.subcategory;
      var clickIsNotOnAbTest = !href || href.indexOf('&category=AbTesting_Experiments&subcategory=') === -1 || subcategory && !/^\d+$/.test(String(subcategory));

      if (clickIsNotOnAbTest) {
        initAbTest_$(dateSelector).show();
        initAbTest_$(topControls).remove();

        if (typeof initTopControls !== 'undefined' && initTopControls) {
          initTopControls();
        }
      }
    });
  }
}
window.initAbTest = initAbTest;
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AbTesting/vue/src/Summary/SummaryPage.vue?vue&type=script&lang=ts




/* harmony default export */ var SummaryPagevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    experiment: {
      type: Object,
      required: true
    },
    isAdmin: Boolean,
    startDateTimezone: String,
    endDateTimezone: String,
    readablePeriod: {
      type: String,
      required: true
    }
  },
  directives: {
    ContentIntro: external_CoreHome_["ContentIntro"]
  },
  components: {
    Summary: Summary
  },
  created: function created() {
    initAbTest();
  }
}));
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/SummaryPage.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/Summary/SummaryPage.vue



SummaryPagevue_type_script_lang_ts.render = SummaryPagevue_type_template_id_42789d84_render

/* harmony default export */ var SummaryPage = (SummaryPagevue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/AbTesting/vue/src/index.ts
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */











// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib-no-default.js




/***/ })

/******/ });
});
//# sourceMappingURL=AbTesting.umd.js.map