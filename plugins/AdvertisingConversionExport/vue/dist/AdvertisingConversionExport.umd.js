(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"), require("SegmentEditor"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", , "CorePluginsAdmin", "SegmentEditor"], factory);
	else if(typeof exports === 'object')
		exports["AdvertisingConversionExport"] = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"), require("SegmentEditor"));
	else
		root["AdvertisingConversionExport"] = factory(root["CoreHome"], root["Vue"], root["CorePluginsAdmin"], root["SegmentEditor"]);
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE__19dc__, __WEBPACK_EXTERNAL_MODULE__8bbf__, __WEBPACK_EXTERNAL_MODULE_a5a2__, __WEBPACK_EXTERNAL_MODULE_f06f__) {
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
/******/ 	__webpack_require__.p = "plugins/AdvertisingConversionExport/vue/dist/";
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

/***/ "f06f":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_f06f__;

/***/ }),

/***/ "fae3":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "ConversionExportEdit", function() { return /* reexport */ Edit; });
__webpack_require__.d(__webpack_exports__, "ConversionExportList", function() { return /* reexport */ List; });
__webpack_require__.d(__webpack_exports__, "ConversionExportManage", function() { return /* reexport */ Manage; });

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

// EXTERNAL MODULE: external {"commonjs":"vue","commonjs2":"vue","root":"Vue"}
var external_commonjs_vue_commonjs2_vue_root_Vue_ = __webpack_require__("8bbf");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.vue?vue&type=template&id=02766cf0

var _hoisted_1 = {
  class: "loadingPiwik"
};

var _hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var _hoisted_3 = {
  class: "loadingPiwik"
};

var _hoisted_4 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var _hoisted_5 = {
  name: "name"
};
var _hoisted_6 = {
  name: "type"
};
var _hoisted_7 = {
  name: "description"
};
var _hoisted_8 = {
  class: "row accesstokenhead"
};
var _hoisted_9 = {
  class: "col s12"
};
var _hoisted_10 = {
  name: "access_token"
};
var _hoisted_11 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_12 = {
  class: "col s12"
};
var _hoisted_13 = {
  name: "directAttribution"
};
var _hoisted_14 = {
  name: "daysToLookBack"
};
var _hoisted_15 = {
  name: "clickIdAttribution"
};
var _hoisted_16 = {
  name: "externalAttributedConversion"
};
var _hoisted_17 = {
  name: "attributionModel"
};
var _hoisted_18 = {
  name: "attributedCredit"
};
var _hoisted_19 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_20 = {
  class: "col s12"
};
var _hoisted_21 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_22 = {
  class: "col s12"
};
var _hoisted_23 = ["innerHTML"];
var _hoisted_24 = {
  name: "daysToExport"
};
var _hoisted_25 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_26 = {
  class: "col s12"
};
var _hoisted_27 = ["innerHTML"];
var _hoisted_28 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_29 = {
  class: "col s12"
};
var _hoisted_30 = {
  class: "form-group row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_31 = {
  class: "col s12"
};
var _hoisted_32 = ["innerHTML"];
var _hoisted_33 = {
  class: "loadingPiwik"
};

var _hoisted_34 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var _hoisted_35 = {
  key: 1
};
var _hoisted_36 = {
  class: "form-group row"
};
var _hoisted_37 = {
  class: "col s12 m4"
};
var _hoisted_38 = ["name"];
var _hoisted_39 = {
  class: "col s12 m4"
};
var _hoisted_40 = ["name"];
var _hoisted_41 = {
  class: "col s12 m4"
};
var _hoisted_42 = {
  class: "row",
  style: {
    "margin-bottom": "0"
  }
};
var _hoisted_43 = ["name"];
var _hoisted_44 = ["name"];
var _hoisted_45 = ["title"];
var _hoisted_46 = ["title", "onClick"];
var _hoisted_47 = {
  class: "entityCancel"
};
var _hoisted_48 = {
  class: "ui-confirm",
  id: "confirmRegenerateAccessToken",
  ref: "confirmRegenerateAccessToken"
};
var _hoisted_49 = ["value"];
var _hoisted_50 = ["value"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _component_SegmentGenerator = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SegmentGenerator");

  var _component_Alert = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Alert");

  var _component_SaveButton = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SaveButton");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    class: "editConversionExport",
    "content-title": _ctx.contentTitle
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_1, [_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoading]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_3, [_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_UpdatingData')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isUpdating]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
        onSubmit: _cache[16] || (_cache[16] = function ($event) {
          return _ctx.edit ? _ctx.updateExport() : _ctx.createExport();
        })
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "text",
        name: "name",
        "model-value": _ctx.conversionExport.name,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          _ctx.conversionExport.name = $event;

          _ctx.setValueHasChanged();
        }),
        title: _ctx.translate('General_Name'),
        maxlength: 50,
        tabindex: 21,
        placeholder: _ctx.translate('AdvertisingConversionExport_FieldNamePlaceholder'),
        "inline-help": _ctx.translate('AdvertisingConversionExport_ExportNameHelp')
      }, null, 8, ["model-value", "title", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "radio",
        name: "type",
        "model-value": _ctx.conversionExport.type,
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          _ctx.conversionExport.type = $event;

          _ctx.setValueHasChanged();

          _ctx.showNote();
        }),
        title: _ctx.translate('AdvertisingConversionExport_ExportType'),
        tabindex: 22,
        options: _ctx.exportTypeOptions,
        "inline-help": _ctx.conversionExportHelp
      }, null, 8, ["model-value", "title", "options", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "textarea",
        name: "description",
        "model-value": _ctx.conversionExport.description,
        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
          _ctx.conversionExport.description = $event;

          _ctx.setValueHasChanged();
        }),
        title: "".concat(_ctx.translate('General_Description'), " ").concat(_ctx.translate('Goals_Optional')),
        maxlength: 1000,
        rows: 3,
        tabindex: 26,
        placeholder: _ctx.translate('AdvertisingConversionExport_ExportDescriptionPlaceHolder'),
        "inline-help": _ctx.translate('AdvertisingConversionExport_ExportDescriptionHelp')
      }, null, 8, ["model-value", "title", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", _hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_AccessToken')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        onClick: _cache[3] || (_cache[3] = function ($event) {
          return _ctx.regenerateAccessToken();
        })
      }, "(" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_Regenerate')) + ")", 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.conversionExport.idexport]])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "text",
        name: "access_token",
        title: "",
        modelValue: _ctx.conversionExport.access_token,
        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
          return _ctx.conversionExport.access_token = $event;
        }),
        maxlength: 100,
        disabled: true,
        placeholder: _ctx.translate('AdvertisingConversionExport_FieldAccessTokenPlaceholder'),
        "inline-help": _ctx.accessTokenInlineHelp
      }, null, 8, ["modelValue", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_11, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_AttributionSettings')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "checkbox",
        name: "directAttribution",
        "model-value": _ctx.conversionExport.parameters.onlyDirectAttribution,
        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
          _ctx.conversionExport.parameters.onlyDirectAttribution = $event;

          _ctx.setValueHasChanged();
        }),
        title: _ctx.translate('AdvertisingConversionExport_DirectAttributionOnly'),
        tabindex: 23,
        "inline-help": _ctx.directAttributionHelp
      }, null, 8, ["model-value", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "number",
        name: "daysToLookBack",
        "model-value": _ctx.conversionExport.parameters.daysToLookBack,
        "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
          _ctx.conversionExport.parameters.daysToLookBack = $event;

          _ctx.setValueHasChanged();
        }),
        title: _ctx.translate('AdvertisingConversionExport_DaysToLookBack'),
        min: 1,
        max: 365,
        "default-value": 30,
        tabindex: 24,
        "inline-help": _ctx.translate('AdvertisingConversionExport_DaysToLookBackDescription')
      }, null, 8, ["model-value", "title", "inline-help"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.conversionExport.parameters.onlyDirectAttribution || _ctx.conversionExport.parameters.onlyDirectAttribution === '0']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "radio",
        name: "clickIdAttribution",
        "model-value": _ctx.conversionExport.parameters.clickIdAttribution,
        "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
          _ctx.conversionExport.parameters.clickIdAttribution = $event;

          _ctx.setValueHasChanged();
        }),
        title: _ctx.translate('AdvertisingConversionExport_ClickIdAttribution'),
        tabindex: 25,
        options: _ctx.clickIdAttributionOptions,
        "inline-help": _ctx.translate('AdvertisingConversionExport_ClickIdAttributionDescription')
      }, null, 8, ["model-value", "title", "options", "inline-help"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.conversionExport.parameters.onlyDirectAttribution || _ctx.conversionExport.parameters.onlyDirectAttribution === '0']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_16, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "checkbox",
        name: "externalAttributedConversion",
        "model-value": _ctx.conversionExport.parameters.externalAttributedConversion,
        "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
          _ctx.conversionExport.parameters.externalAttributedConversion = $event;

          _ctx.setValueHasChanged();
        }),
        title: "External attributed conversion",
        tabindex: 26,
        "inline-help": _ctx.translate('AdvertisingConversionExport_ExternalAttributedConversionHelp')
      }, null, 8, ["model-value", "inline-help"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.conversionExport.type === 'GoogleAds']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_17, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "select",
        name: "attributionModel",
        "model-value": _ctx.conversionExport.parameters.attributionModel,
        "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
          _ctx.conversionExport.parameters.attributionModel = $event;

          _ctx.setValueHasChanged();
        }),
        title: "Attribution Model",
        options: _ctx.attributionModelOptions,
        tabindex: 27,
        "inline-help": _ctx.translate('AdvertisingConversionExport_AttributionModelHelp')
      }, null, 8, ["model-value", "options", "inline-help"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.conversionExport.type === 'GoogleAds' && _ctx.conversionExport.parameters.externalAttributedConversion && _ctx.conversionExport.parameters.externalAttributedConversion !== '0']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_18, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "number",
        name: "attributedCredit",
        "model-value": _ctx.conversionExport.parameters.attributedCredit,
        "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
          _ctx.conversionExport.parameters.attributedCredit = $event;

          _ctx.setValueHasChanged();
        }),
        title: "Attributed Credit",
        tabindex: 28,
        min: 0,
        max: 1,
        "inline-help": _ctx.translate('AdvertisingConversionExport_AttributedCreditHelp')
      }, null, 8, ["model-value", "inline-help"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.conversionExport.type === 'GoogleAds' && _ctx.conversionExport.parameters.externalAttributedConversion && _ctx.conversionExport.parameters.externalAttributedConversion !== '0']])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_19, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_20, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_VisitorsToExport')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_21, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_22, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.translate('AdvertisingConversionExport_VisitorsToExportHelp'))
      }, null, 8, _hoisted_23)])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_24, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "number",
        name: "daysToExport",
        "model-value": _ctx.conversionExport.parameters.daysToExport,
        "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
          _ctx.conversionExport.parameters.daysToExport = $event;

          _ctx.setValueHasChanged();
        }),
        title: _ctx.translate('AdvertisingConversionExport_DaysToExport'),
        min: 1,
        max: 100,
        "default-value": 7,
        tabindex: 35,
        "inline-help": _ctx.translate('AdvertisingConversionExport_DaysToExportHelp')
      }, null, 8, ["model-value", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_25, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_26, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", {
        innerHTML: _ctx.$sanitize(_ctx.translate('AdvertisingConversionExport_AdditionalSegment'))
      }, null, 8, _hoisted_27), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_SegmentGenerator, {
        tabindex: "36",
        "model-value": _ctx.conversionExport.parameters.segment,
        "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
          _ctx.conversionExport.parameters.segment = $event;

          _ctx.setValueHasChanged();
        }),
        "visit-segments-only": true
      }, null, 8, ["model-value"])])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_28, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_29, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_ConversionsToExport')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_30, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_31, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.translate('AdvertisingConversionExport_ConversionsToExportHelp'))
      }, null, 8, _hoisted_32)])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_33, [_hoisted_34, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoadingGoals]]), !_ctx.goals.length && !_ctx.isLoadingGoals ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Alert, {
        key: 0,
        severity: "warning"
      }, {
        default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
          return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_NoGoalsConfigured')), 1)];
        }),
        _: 1
      })) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.goals.length && !_ctx.isLoadingGoals ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_35, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.conversionExport.parameters.goals, function (goal, index) {
        var _ctx$conversionExport, _ctx$conversionExport2;

        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
          class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("exportGoals ".concat(index, " valign-wrapper")),
          key: index
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_36, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_37, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
          name: "exportGoalId".concat(index)
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
          uicontrol: "select",
          "model-value": goal.idgoal,
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            goal.idgoal = $event;

            _ctx.setValueHasChanged();
          },
          title: _ctx.translate('General_Goal'),
          name: "exportGoalId".concat(index),
          "full-width": true,
          options: _ctx.goals,
          tabindex: 37 + index * 4
        }, null, 8, ["model-value", "onUpdate:modelValue", "title", "name", "options", "tabindex"])], 8, _hoisted_38)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_39, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
          name: "exportGoalName".concat(index)
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
          uicontrol: "text",
          "model-value": goal.name,
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            goal.name = $event;

            _ctx.setValueHasChanged();
          },
          title: _ctx.translate('AdvertisingConversionExport_GoalAlias'),
          name: "exportGoalName".concat(index),
          "full-width": true,
          maxlength: 50,
          tabindex: 38 + index * 4
        }, null, 8, ["model-value", "onUpdate:modelValue", "title", "name", "tabindex"])], 8, _hoisted_40)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_41, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_42, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
          name: "exportGoalRevenue".concat(index),
          class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("col s12 ".concat(goal.revenue === 'custom' ? 'm6' : 'm12'))
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
          uicontrol: "select",
          "model-value": goal.revenue,
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            goal.revenue = $event;

            _ctx.setValueHasChanged();
          },
          title: _ctx.translate('General_ColumnRevenue'),
          name: "exportGoalRevenue".concat(index),
          class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])({
            custom: goal.revenue === 'custom'
          }),
          "full-width": true,
          options: _ctx.revenueOptions,
          tabindex: 39 + index * 4
        }, null, 8, ["model-value", "onUpdate:modelValue", "title", "name", "class", "options", "tabindex"])], 10, _hoisted_43), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
          name: "exportGoalRevenueCustom".concat(index),
          class: "col s12 m6"
        }, [goal.revenue === 'custom' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Field, {
          key: 0,
          uicontrol: "number",
          "model-value": goal.revenueValue,
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            goal.revenueValue = $event;

            _ctx.setValueHasChanged();
          },
          title: _ctx.translate('General_Value'),
          name: "exportGoalRevenueCustom".concat(index),
          "full-width": true,
          tabindex: 40 + index * 4
        }, null, 8, ["model-value", "onUpdate:modelValue", "title", "name", "tabindex"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 8, _hoisted_44)])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
          class: "icon-plus",
          title: _ctx.translate('General_Add'),
          onClick: _cache[13] || (_cache[13] = function ($event) {
            return _ctx.addExportGoal();
          })
        }, null, 8, _hoisted_45), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], ((_ctx$conversionExport = _ctx.conversionExport.parameters) === null || _ctx$conversionExport === void 0 ? void 0 : _ctx$conversionExport.goals.length) < _ctx.goals.length]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
          class: "icon-minus",
          title: _ctx.translate('General_Remove'),
          onClick: function onClick($event) {
            return _ctx.removeExportGoal(index);
          }
        }, null, 8, _hoisted_46), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], ((_ctx$conversionExport2 = _ctx.conversionExport.parameters) === null || _ctx$conversionExport2 === void 0 ? void 0 : _ctx$conversionExport2.goals.length) > 1]])])], 2);
      }), 128))])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showNoteMessage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Alert, {
        key: 2,
        severity: "info"
      }, {
        default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
          return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_ExportNote')) + ": ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.noteMessage), 1)];
        }),
        _: 1
      })) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_SaveButton, {
        class: "createButton",
        tabindex: "100",
        onConfirm: _cache[14] || (_cache[14] = function ($event) {
          return _ctx.edit ? _ctx.updateExport() : _ctx.createExport();
        }),
        disabled: _ctx.isUpdating || !_ctx.isDirty || !_ctx.goals.length,
        saving: _ctx.isUpdating,
        value: _ctx.createButtonText
      }, null, 8, ["disabled", "saving", "value"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_47, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        onClick: _cache[15] || (_cache[15] = function ($event) {
          return _ctx.cancel();
        })
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Cancel')), 1)])])], 32), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_48, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_RegenerateAccessTokenConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "yes",
        type: "button",
        value: _ctx.translate('General_Yes')
      }, null, 8, _hoisted_49), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "no",
        type: "button",
        value: _ctx.translate('General_No')
      }, null, 8, _hoisted_50)], 512)];
    }),
    _: 1
  }, 8, ["content-title"]);
}
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.vue?vue&type=template&id=02766cf0

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// EXTERNAL MODULE: external "SegmentEditor"
var external_SegmentEditor_ = __webpack_require__("f06f");

// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExportStore.store.ts
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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



var ConversionExportStore_store_ConversionExportStore = /*#__PURE__*/function () {
  function ConversionExportStore() {
    var _this = this;

    _classCallCheck(this, ConversionExportStore);

    _defineProperty(this, "privateState", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["reactive"])({
      exports: [],
      sites: [],
      goals: [],
      isLoading: false,
      isLoadingGoals: false,
      isUpdating: false
    }));

    _defineProperty(this, "state", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState);
    }));

    _defineProperty(this, "exports", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return _this.state.value.exports;
    }));

    _defineProperty(this, "isEcommerceSite", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      var loadedSite = _this.state.value.sites.find(function (s) {
        return parseInt(s.idsite, 10) === parseInt(external_CoreHome_["Matomo"].idSite, 10);
      });

      var isEcommerce = loadedSite === null || loadedSite === void 0 ? void 0 : loadedSite.ecommerce;
      return isEcommerce === 1 || isEcommerce === '1';
    }));

    _defineProperty(this, "goals", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      var result = [];

      if (_this.isEcommerceSite.value) {
        result.push({
          key: '0',
          value: Object(external_CoreHome_["translate"])('General_EcommerceOrders')
        });
      }

      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])([].concat(result, _toConsumableArray(_this.state.value.goals)));
    }));

    _defineProperty(this, "fetchPromise", null);

    _defineProperty(this, "fetchSitePromise", null);
  }

  _createClass(ConversionExportStore, [{
    key: "reload",
    value: function reload() {
      this.privateState.exports = [];
      this.fetchPromise = null;
      return this.fetchExports();
    }
  }, {
    key: "fetchExports",
    value: function fetchExports() {
      var _this2 = this;

      if (!this.fetchPromise) {
        this.fetchPromise = external_CoreHome_["AjaxHelper"].fetch({
          method: 'AdvertisingConversionExport.getConversionExports',
          idSite: external_CoreHome_["Matomo"].idSite,
          filter_limit: '-1'
        });
      }

      this.privateState.isLoading = true;
      this.privateState.exports = [];
      return Promise.all([this.fetchPromise, this.fetchSites(), this.fetchGoals()]).then(function (_ref) {
        var _ref2 = _slicedToArray(_ref, 1),
            exports = _ref2[0];

        _this2.privateState.exports = exports;
        return _this2.exports.value;
      }).finally(function () {
        _this2.privateState.isLoading = false;
      });
    }
  }, {
    key: "fetchGoals",
    value: function fetchGoals() {
      var _this3 = this;

      if (this.state.value.goals.length) {
        return Promise.resolve(this.state.value.goals);
      }

      this.privateState.isLoadingGoals = true;
      return external_CoreHome_["AjaxHelper"].fetch({
        module: 'API',
        method: 'Goals.getGoals',
        idSite: external_CoreHome_["Matomo"].idSite,
        filter_limit: '-1'
      }).then(function (goals) {
        _this3.privateState.goals = Object.values(goals).map(function (g) {
          return {
            key: "".concat(g.idgoal),
            value: g.name
          };
        });
        return _this3.goals.value;
      }).finally(function () {
        _this3.privateState.isLoadingGoals = false;
      });
    }
  }, {
    key: "fetchSites",
    value: function fetchSites() {
      var _this4 = this;

      if (this.state.value.sites.length) {
        return Promise.resolve(this.state.value.sites);
      }

      if (!this.fetchSitePromise) {
        this.fetchSitePromise = external_CoreHome_["AjaxHelper"].fetch({
          module: 'API',
          method: 'SitesManager.getSitesWithAtLeastViewAccess',
          filter_limit: '-1'
        });
      }

      return this.fetchSitePromise.then(function (sites) {
        _this4.privateState.sites = sites || [];
        return _this4.state.value.sites;
      });
    }
  }, {
    key: "findExport",
    value: function findExport(idExport) {
      var _this5 = this;

      // before going through an API request we first try to find it in loaded forms
      var found = this.state.value.exports.find(function (exp) {
        return parseInt("".concat(exp.idexport), 10) === idExport;
      });

      if (found) {
        return Promise.resolve(found);
      } // otherwise we fetch it via API


      this.privateState.isLoading = true;
      return Promise.all([external_CoreHome_["AjaxHelper"].fetch({
        idExport: idExport,
        method: 'AdvertisingConversionExport.getConversionExport'
      }), this.fetchSites()]).then(function (_ref3) {
        var _ref4 = _slicedToArray(_ref3, 1),
            exp = _ref4[0];

        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(exp);
      }).finally(function () {
        _this5.privateState.isLoading = false;
      });
    }
  }, {
    key: "deleteExport",
    value: function deleteExport(idExport) {
      var _this6 = this;

      this.privateState.isUpdating = true;
      this.privateState.exports = [];
      return external_CoreHome_["AjaxHelper"].fetch({
        idExport: idExport,
        method: 'AdvertisingConversionExport.deleteConversionExport'
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
        _this6.privateState.isUpdating = false;
      });
    }
  }, {
    key: "regenerateAccessToken",
    value: function regenerateAccessToken(idExport) {
      var _this7 = this;

      this.privateState.isUpdating = true;
      this.privateState.exports = [];
      return external_CoreHome_["AjaxHelper"].fetch({
        idExport: idExport,
        method: 'AdvertisingConversionExport.regenerateAccessToken'
      }, {
        withTokenInUrl: true
      }).finally(function () {
        _this7.privateState.isUpdating = false;
      });
    }
  }, {
    key: "createOrUpdateExport",
    value: function createOrUpdateExport(conversionExport, method) {
      var _conversionExport$par,
          _conversionExport$par2,
          _conversionExport$par3,
          _conversionExport$par4,
          _conversionExport$par5,
          _this8 = this;

      this.privateState.isUpdating = true;
      var onlyDirectAttribution = [true, 'true', 1, '1'].includes((_conversionExport$par = (_conversionExport$par2 = conversionExport.parameters) === null || _conversionExport$par2 === void 0 ? void 0 : _conversionExport$par2.onlyDirectAttribution) !== null && _conversionExport$par !== void 0 ? _conversionExport$par : false) ? 1 : 0;
      var externalAttributedConversion = [true, 'true', 1, '1'].includes((_conversionExport$par3 = (_conversionExport$par4 = conversionExport.parameters) === null || _conversionExport$par4 === void 0 ? void 0 : _conversionExport$par4.externalAttributedConversion) !== null && _conversionExport$par3 !== void 0 ? _conversionExport$par3 : false) ? 1 : 0;
      return external_CoreHome_["AjaxHelper"].post({}, {
        idExport: conversionExport.idexport,
        name: conversionExport.name.trim(),
        type: conversionExport.type,
        description: conversionExport.description.trim(),
        method: method,
        parameters: Object.assign(Object.assign({}, conversionExport.parameters || {}), {}, {
          onlyDirectAttribution: onlyDirectAttribution,
          externalAttributedConversion: externalAttributedConversion,
          // remove goal configs where no goal was chosen
          goals: (((_conversionExport$par5 = conversionExport.parameters) === null || _conversionExport$par5 === void 0 ? void 0 : _conversionExport$par5.goals) || []).filter(function (g) {
            return g.idgoal !== '' && g.idgoal >= 0;
          })
        })
      }, {
        withTokenInUrl: true
      }).then(function (response) {
        return {
          type: 'success',
          response: response
        };
      }).catch(function (e) {
        return {
          type: 'error',
          message: e.message || e
        };
      }).finally(function () {
        _this8.privateState.isUpdating = false;
      });
    }
  }]);

  return ConversionExportStore;
}();

/* harmony default export */ var ConversionExportStore_store = (new ConversionExportStore_store_ConversionExportStore());
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.vue?vue&type=script&lang=ts
function Editvue_type_script_lang_ts_toConsumableArray(arr) { return Editvue_type_script_lang_ts_arrayWithoutHoles(arr) || Editvue_type_script_lang_ts_iterableToArray(arr) || Editvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Editvue_type_script_lang_ts_nonIterableSpread(); }

function Editvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Editvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Editvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Editvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Editvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Editvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Editvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Editvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }






var DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION = 0;
var DEFAULT_ATTRIBUTION_MODEL = 'dataDriven';
var DEFAULT_ATTRIBUTED_CREDIT = 1;
var notificationId = 'conversionexportmanagement';
var REVENUE_OPTIONS = {
  goal: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_UseGoalRevenue'),
  custom: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_UseCustomRevenue'),
  null: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_UseEmptyRevenue')
};
var CLICK_ID_ATTRIBUTION_OPTIONS = {
  first: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_FirstClickId'),
  last: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_LastClickId'),
  all: Object(external_CoreHome_["translate"])('AdvertisingConversionExport_AllClickIds')
};
/* harmony default export */ var Editvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    idExport: Number,
    exportTypes: {
      type: Object,
      required: true
    },
    alreadyCreatedExportTypes: {
      type: Object,
      required: true
    },
    clickIdProviders: {
      type: Object,
      required: true
    },
    attributionModels: {
      type: Object,
      required: true
    }
  },
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"],
    Field: external_CorePluginsAdmin_["Field"],
    SegmentGenerator: external_SegmentEditor_["SegmentGenerator"],
    Alert: external_CoreHome_["Alert"],
    SaveButton: external_CorePluginsAdmin_["SaveButton"]
  },
  data: function data() {
    return {
      isDirty: false,
      conversionExport: {},
      showNoteMessage: false,
      noteMessage: 'test'
    };
  },
  created: function created() {
    ConversionExportStore_store.fetchExports();
    this.init();
  },
  watch: {
    idExport: function idExport(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    }
  },
  methods: {
    removeAnyNotification: function removeAnyNotification() {
      external_CoreHome_["NotificationsStore"].remove(notificationId);
      external_CoreHome_["NotificationsStore"].remove('ajaxHelper');
    },
    showNotification: function showNotification(message, context) {
      this.removeAnyNotification();
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
      var message = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    init: function init() {
      var _this = this;

      var idExport = this.idExport;
      this.conversionExport = {
        parameters: {}
      };
      external_CoreHome_["Matomo"].helper.lazyScrollToContent();

      if (this.edit && idExport) {
        ConversionExportStore_store.findExport(idExport).then(function (conversionExport) {
          if ("".concat(conversionExport === null || conversionExport === void 0 ? void 0 : conversionExport.idsite) !== "".concat(external_CoreHome_["Matomo"].idSite)) {
            setTimeout(function () {
              _this.showNotification(Object(external_CoreHome_["translate"])('AdvertisingConversionExport_UnableToLoadExport'), 'error');
            }, 200);

            _this.cancel();

            return;
          }

          _this.conversionExport = Object(external_CoreHome_["clone"])(conversionExport);

          if (_this.conversionExport.parameters) {
            var _params$externalAttri, _params$attributionMo, _params$attributedCre;

            var params = _this.conversionExport.parameters;
            params.externalAttributedConversion = (_params$externalAttri = params.externalAttributedConversion) !== null && _params$externalAttri !== void 0 ? _params$externalAttri : DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION;
            params.attributionModel = (_params$attributionMo = params.attributionModel) !== null && _params$attributionMo !== void 0 ? _params$attributionMo : DEFAULT_ATTRIBUTION_MODEL;
            params.attributedCredit = (_params$attributedCre = params.attributedCredit) !== null && _params$attributedCre !== void 0 ? _params$attributedCre : DEFAULT_ATTRIBUTED_CREDIT;
          }

          ConversionExportStore_store.fetchGoals().then(function () {
            _this.isDirty = false;

            _this.addInitialExportGoal();
          });
        });
        return;
      }

      if (this.create) {
        this.conversionExport = {
          idsite: external_CoreHome_["Matomo"].idSite,
          name: '',
          type: Object.keys(this.exportTypeOptions)[0],
          description: '',
          access_token: '',
          parameters: {
            goals: [],
            daysToExport: 7,
            segment: '',
            onlyDirectAttribution: 1,
            daysToLookBack: 30,
            clickIdAttribution: 'last',
            externalAttributedConversion: DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION,
            attributionModel: DEFAULT_ATTRIBUTION_MODEL,
            attributedCredit: DEFAULT_ATTRIBUTED_CREDIT
          }
        };
        this.isDirty = false;
        ConversionExportStore_store.fetchGoals().then(function () {
          _this.addInitialExportGoal();
        });
        this.showNote();
      }
    },
    cancel: function cancel() {
      var newParams = Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value);
      delete newParams.idExport;
      external_CoreHome_["MatomoUrl"].updateHash(newParams);
    },
    addInitialExportGoal: function addInitialExportGoal() {
      var _this$conversionExpor, _this$conversionExpor2;

      if (!this.conversionExport) {
        return;
      }

      if ((_this$conversionExpor = this.conversionExport.parameters) !== null && _this$conversionExpor !== void 0 && (_this$conversionExpor2 = _this$conversionExpor.goals) !== null && _this$conversionExpor2 !== void 0 && _this$conversionExpor2.length) {
        return;
      }

      this.addExportGoal();
    },
    addExportGoal: function addExportGoal() {
      var _this$conversionExpor3;

      if (!this.conversionExport) {
        return;
      }

      if (!this.conversionExport.parameters) {
        this.conversionExport.parameters = {};
      }

      if (!((_this$conversionExpor3 = this.conversionExport.parameters.goals) !== null && _this$conversionExpor3 !== void 0 && _this$conversionExpor3.length)) {
        this.conversionExport.parameters.goals = [];
      }

      this.conversionExport.parameters.goals = [].concat(Editvue_type_script_lang_ts_toConsumableArray(this.conversionExport.parameters.goals), [{
        idgoal: '',
        name: '',
        revenue: 'goal'
      }]);
      this.isDirty = true;
    },
    removeExportGoal: function removeExportGoal(index) {
      var _this$conversionExpor4, _this$conversionExpor5, _this$conversionExpor6;

      if ((_this$conversionExpor4 = this.conversionExport) !== null && _this$conversionExpor4 !== void 0 && (_this$conversionExpor5 = _this$conversionExpor4.parameters) !== null && _this$conversionExpor5 !== void 0 && (_this$conversionExpor6 = _this$conversionExpor5.goals) !== null && _this$conversionExpor6 !== void 0 && _this$conversionExpor6.length && index > -1) {
        this.conversionExport.parameters.goals.splice(index, 1);
        this.isDirty = true;
      }
    },
    regenerateAccessToken: function regenerateAccessToken() {
      var _this2 = this;

      var idExport = this.idExport;

      if (!idExport) {
        return;
      }

      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmRegenerateAccessToken, {
        yes: function yes() {
          ConversionExportStore_store.regenerateAccessToken(idExport).then(function (token) {
            _this2.conversionExport.access_token = token.value;
          });
        }
      });
    },
    createExport: function createExport() {
      var _this3 = this;

      var method = 'AdvertisingConversionExport.addConversionExport';
      this.removeAnyNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      ConversionExportStore_store.createOrUpdateExport(this.conversionExport, method).then(function (response) {
        _this3.isDirty = false;
        var idExport = response.response.value;
        ConversionExportStore_store.reload().then(function () {
          if (external_CoreHome_["Matomo"].helper.isReportingPage()) {
            external_CoreHome_["Matomo"].postEvent('updateReportingMenu');
          }

          external_CoreHome_["MatomoUrl"].updateHash(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
            idExport: idExport
          }));
          setTimeout(function () {
            _this3.showNotification(Object(external_CoreHome_["translate"])('AdvertisingConversionExport_ExportCreated'), response.type);
          }, 200);
        });
      });
    },
    setValueHasChanged: function setValueHasChanged() {
      var _this$conversionExpor7, _this$conversionExpor8, _this$conversionExpor9;

      this.isDirty = true;

      if ((_this$conversionExpor7 = this.conversionExport) !== null && _this$conversionExpor7 !== void 0 && (_this$conversionExpor8 = _this$conversionExpor7.parameters) !== null && _this$conversionExpor8 !== void 0 && (_this$conversionExpor9 = _this$conversionExpor8.goals) !== null && _this$conversionExpor9 !== void 0 && _this$conversionExpor9.length) {
        var configuredGoals = [];
        this.conversionExport.parameters.goals.forEach(function (goal) {
          if (configuredGoals.indexOf(goal.idgoal) >= 0) {
            goal.idgoal = null;
          }

          if (goal.idgoal || goal.idgoal === 0) {
            configuredGoals.push(goal.idgoal);
          }
        });
      }
    },
    showNote: function showNote() {
      var _this$conversionExpor10, _this$alreadyCreatedE, _this$clickIdProvider;

      this.showNoteMessage = false;
      this.noteMessage = '';

      if ((_this$conversionExpor10 = this.conversionExport) !== null && _this$conversionExpor10 !== void 0 && _this$conversionExpor10.type && !((_this$alreadyCreatedE = this.alreadyCreatedExportTypes) !== null && _this$alreadyCreatedE !== void 0 && _this$alreadyCreatedE[this.conversionExport.type]) // should be undefined
      && (_this$clickIdProvider = this.clickIdProviders) !== null && _this$clickIdProvider !== void 0 && _this$clickIdProvider[this.conversionExport.type] // should be defined
      ) {
        this.showNoteMessage = true;
        this.noteMessage = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_ExportNoteMessage', this.clickIdProviders[this.conversionExport.type].clickId, this.clickIdProviders[this.conversionExport.type].name);
      }
    },
    updateExport: function updateExport() {
      var _this4 = this;

      this.removeAnyNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      var method = 'AdvertisingConversionExport.updateConversionExport';
      ConversionExportStore_store.createOrUpdateExport(this.conversionExport, method).then(function (response) {
        if (response.type === 'error') {
          return;
        }

        _this4.isDirty = false;
        _this4.conversionExport = {
          parameters: {}
        };
        ConversionExportStore_store.reload().then(function () {
          _this4.init();
        });

        _this4.showNotification(Object(external_CoreHome_["translate"])('AdvertisingConversionExport_ExportUpdated'), response.type);
      });
    },
    checkRequiredFieldsAreSet: function checkRequiredFieldsAreSet() {
      var _this$conversionExpor11, _this$conversionExpor12;

      if (!this.conversionExport.name) {
        var title = Object(external_CoreHome_["translate"])('General_Name');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (!((_this$conversionExpor11 = this.conversionExport.parameters) !== null && _this$conversionExpor11 !== void 0 && (_this$conversionExpor12 = _this$conversionExpor11.goals) !== null && _this$conversionExpor12 !== void 0 && _this$conversionExpor12.length)) {
        var _title = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_PleaseConfigureGoals');

        this.showNotification(_title, 'error');
        return false;
      }

      var hasValidGoal = this.conversionExport.parameters.goals.some(function (g) {
        return g.idgoal !== '' && g.idgoal >= 0;
      });

      if (!hasValidGoal) {
        var _title2 = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_PleaseConfigureGoals');

        this.showNotification(_title2, 'error');
        return false;
      }

      if (!this.conversionExport.parameters.daysToExport || this.conversionExport.parameters.daysToExport === 'NaN' || this.conversionExport.parameters.daysToExport < 1) {
        var _title3 = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_PleaseConfigureDaysToExport');

        this.showNotification(_title3, 'error');
        return false;
      }

      return true;
    }
  },
  computed: {
    revenueOptions: function revenueOptions() {
      return REVENUE_OPTIONS;
    },
    clickIdAttributionOptions: function clickIdAttributionOptions() {
      return CLICK_ID_ATTRIBUTION_OPTIONS;
    },
    exportTypeOptions: function exportTypeOptions() {
      var result = {};
      Object.values(this.exportTypes).forEach(function (e) {
        result[e.id] = e.name;
      });
      return result;
    },
    exportTypeDescription: function exportTypeDescription() {
      return Object.values(this.exportTypes).map(function (e) {
        return "<br/><br/><strong>".concat(e.name, "</strong><br />").concat(e.description);
      }).join('');
    },
    attributionModelOptions: function attributionModelOptions() {
      var result = {};
      Object.values(this.attributionModels).forEach(function (e) {
        result[e.id] = e.translatedName;
      });
      return result;
    },
    create: function create() {
      return !this.idExport;
    },
    edit: function edit() {
      return !this.create;
    },
    editTitle: function editTitle() {
      return this.create ? 'AdvertisingConversionExport_CreateNewExport' : 'AdvertisingConversionExport_EditExport';
    },
    contentTitle: function contentTitle() {
      return Object(external_CoreHome_["translate"])(this.editTitle, this.conversionExport.name ? "\"".concat(this.conversionExport.name, "\"") : '');
    },
    isLoading: function isLoading() {
      return ConversionExportStore_store.state.value.isLoading;
    },
    isUpdating: function isUpdating() {
      return ConversionExportStore_store.state.value.isUpdating;
    },
    isLoadingGoals: function isLoadingGoals() {
      return ConversionExportStore_store.state.value.isLoadingGoals;
    },
    goals: function goals() {
      return ConversionExportStore_store.goals.value;
    },
    conversionExportHelp: function conversionExportHelp() {
      var help = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_ExportTypeHelp');
      return "".concat(help).concat(this.exportTypeDescription);
    },
    accessTokenInlineHelp: function accessTokenInlineHelp() {
      var help = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_AccessTokenHelp');
      var doNotShare = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_DoNotShare');
      return "".concat(help, "<br />").concat(doNotShare);
    },
    directAttributionHelp: function directAttributionHelp() {
      var desc = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_DirectAttributionOnlyDescription');
      var onlyNote = Object(external_CoreHome_["translate"])('AdvertisingConversionExport_DirectAttributionOnlyNote');
      return "".concat(desc, "<br /><br />").concat(onlyNote);
    },
    createButtonText: function createButtonText() {
      return this.edit ? Object(external_CoreHome_["translate"])('CoreUpdater_UpdateTitle') : Object(external_CoreHome_["translate"])('AdvertisingConversionExport_CreateNewExport');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.vue



Editvue_type_script_lang_ts.render = render

/* harmony default export */ var Edit = (Editvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.vue?vue&type=template&id=519bbeee

var Listvue_type_template_id_519bbeee_hoisted_1 = {
  class: "index"
};
var Listvue_type_template_id_519bbeee_hoisted_2 = {
  class: "name"
};
var Listvue_type_template_id_519bbeee_hoisted_3 = {
  class: "type"
};
var Listvue_type_template_id_519bbeee_hoisted_4 = {
  key: 0,
  class: "description"
};
var Listvue_type_template_id_519bbeee_hoisted_5 = {
  class: "goals"
};
var Listvue_type_template_id_519bbeee_hoisted_6 = ["title"];
var Listvue_type_template_id_519bbeee_hoisted_7 = {
  class: "action"
};
var Listvue_type_template_id_519bbeee_hoisted_8 = {
  colspan: "6"
};
var Listvue_type_template_id_519bbeee_hoisted_9 = {
  class: "loadingPiwik"
};

var Listvue_type_template_id_519bbeee_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var Listvue_type_template_id_519bbeee_hoisted_11 = {
  colspan: "6"
};
var Listvue_type_template_id_519bbeee_hoisted_12 = ["id"];
var Listvue_type_template_id_519bbeee_hoisted_13 = {
  class: "index"
};
var Listvue_type_template_id_519bbeee_hoisted_14 = {
  class: "name"
};
var Listvue_type_template_id_519bbeee_hoisted_15 = {
  class: "type"
};
var Listvue_type_template_id_519bbeee_hoisted_16 = ["title"];
var Listvue_type_template_id_519bbeee_hoisted_17 = ["title"];
var Listvue_type_template_id_519bbeee_hoisted_18 = {
  class: "goals"
};
var Listvue_type_template_id_519bbeee_hoisted_19 = ["innerHTML"];

var Listvue_type_template_id_519bbeee_hoisted_20 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var Listvue_type_template_id_519bbeee_hoisted_21 = {
  key: 2,
  class: "requested"
};
var Listvue_type_template_id_519bbeee_hoisted_22 = {
  key: 3,
  class: "requested"
};
var Listvue_type_template_id_519bbeee_hoisted_23 = {
  class: "action"
};
var Listvue_type_template_id_519bbeee_hoisted_24 = ["title", "onClick"];
var Listvue_type_template_id_519bbeee_hoisted_25 = ["title", "onClick"];
var Listvue_type_template_id_519bbeee_hoisted_26 = ["title", "onClick"];
var Listvue_type_template_id_519bbeee_hoisted_27 = ["title", "onClick"];
var Listvue_type_template_id_519bbeee_hoisted_28 = {
  class: "tableActionBar"
};

var Listvue_type_template_id_519bbeee_hoisted_29 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-add"
}, null, -1);

var Listvue_type_template_id_519bbeee_hoisted_30 = {
  class: "ui-confirm",
  id: "confirmDeleteExport",
  ref: "confirmDeleteExport"
};
var Listvue_type_template_id_519bbeee_hoisted_31 = ["value"];
var Listvue_type_template_id_519bbeee_hoisted_32 = ["value"];
var Listvue_type_template_id_519bbeee_hoisted_33 = {
  class: "ui-confirm",
  id: "showExportLink",
  ref: "showExportLink"
};
var Listvue_type_template_id_519bbeee_hoisted_34 = ["value"];
var Listvue_type_template_id_519bbeee_hoisted_35 = ["value"];
function Listvue_type_template_id_519bbeee_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  var _directive_content_table = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-table");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ContentBlock, {
    "content-title": _ctx.translate('AdvertisingConversionExport_ManageExports'),
    feature: _ctx.translate('AdvertisingConversionExport_ManageExports')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_ManageExportsIntroduction')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_519bbeee_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Id')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_519bbeee_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Name')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_519bbeee_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_ExportType')), 1), _ctx.atLeastOneExportWithDescription ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("th", Listvue_type_template_id_519bbeee_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Description')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_519bbeee_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_IncludedConversions')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", {
        class: "requested",
        title: _ctx.translate('AdvertisingConversionExport_LastRequestedInfo')
      }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_LastRequested')), 9, Listvue_type_template_id_519bbeee_hoisted_6), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", Listvue_type_template_id_519bbeee_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Actions')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Listvue_type_template_id_519bbeee_hoisted_9, [Listvue_type_template_id_519bbeee_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoading || _ctx.isUpdating]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_NoExportsFound')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoading && _ctx.exports.length === 0]]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.sortedExports, function (exp) {
        var _exp$parameters;

        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", {
          id: "export".concat(exp.idexport),
          class: "exports",
          key: exp.idexport
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(exp.idexport), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(exp.name), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.exportTypes[exp.type].name), 1), _ctx.atLeastOneExportWithDescription && exp.description.trim().length > 63 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("td", {
          key: 0,
          class: "description",
          title: exp.description
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(exp.description.trim().substring(0, 60)) + "...", 9, Listvue_type_template_id_519bbeee_hoisted_16)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.atLeastOneExportWithDescription && exp.description.trim().length <= 63 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("td", {
          key: 1,
          class: "description",
          title: exp.description
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(exp.description.trim()), 9, Listvue_type_template_id_519bbeee_hoisted_17)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_18, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(((_exp$parameters = exp.parameters) === null || _exp$parameters === void 0 ? void 0 : _exp$parameters.goals) || [], function (goal) {
          var _ctx$goals$find;

          return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
            key: goal.idgoal
          }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(((_ctx$goals$find = _ctx.goals.find(function (g) {
            return g.key === "".concat(goal.idgoal);
          })) === null || _ctx$goals$find === void 0 ? void 0 : _ctx$goals$find.value) || _ctx.translate('General_Unknown')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
            innerHTML: _ctx.$sanitize(_ctx.getDisplayGoalName(goal))
          }, null, 8, Listvue_type_template_id_519bbeee_hoisted_19), Listvue_type_template_id_519bbeee_hoisted_20]);
        }), 128))]), exp.ts_requested ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("td", Listvue_type_template_id_519bbeee_hoisted_21, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(exp.ts_requested_pretty), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !exp.ts_requested ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("td", Listvue_type_template_id_519bbeee_hoisted_22, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Never')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", Listvue_type_template_id_519bbeee_hoisted_23, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-download",
          title: _ctx.translate('AdvertisingConversionExport_DownloadExport'),
          onClick: function onClick($event) {
            return _ctx.openExport(exp.access_token);
          }
        }, null, 8, Listvue_type_template_id_519bbeee_hoisted_24), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-export",
          title: _ctx.translate('AdvertisingConversionExport_ShowDownloadLink'),
          onClick: function onClick($event) {
            return _ctx.showLink(exp.access_token);
          }
        }, null, 8, Listvue_type_template_id_519bbeee_hoisted_25), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-edit",
          title: _ctx.translate('AdvertisingConversionExport_EditExport'),
          onClick: function onClick($event) {
            return _ctx.editExport(exp.idexport);
          }
        }, null, 8, Listvue_type_template_id_519bbeee_hoisted_26), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-delete",
          title: _ctx.translate('AdvertisingConversionExport_DeleteExport'),
          onClick: function onClick($event) {
            return _ctx.deleteExport(exp);
          }
        }, null, 8, Listvue_type_template_id_519bbeee_hoisted_27)])], 8, Listvue_type_template_id_519bbeee_hoisted_12);
      }), 128))])], 512), [[_directive_content_table]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_519bbeee_hoisted_28, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
        class: "createNewExport",
        onClick: _cache[0] || (_cache[0] = function ($event) {
          return _ctx.createExport();
        })
      }, [Listvue_type_template_id_519bbeee_hoisted_29, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_CreateNewExport')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.hasWriteAccess]])];
    }),
    _: 1
  }, 8, ["content-title", "feature"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_519bbeee_hoisted_30, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_DeleteExportConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, Listvue_type_template_id_519bbeee_hoisted_31), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, Listvue_type_template_id_519bbeee_hoisted_32)], 512), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Listvue_type_template_id_519bbeee_hoisted_33, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_DownloadLink')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("textarea", {
    readonly: "",
    id: "exportLink",
    onclick: "this.select()",
    value: _ctx.exportLink
  }, null, 8, Listvue_type_template_id_519bbeee_hoisted_34), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('AdvertisingConversionExport_DoNotShare')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Close')
  }, null, 8, Listvue_type_template_id_519bbeee_hoisted_35)], 512)]);
}
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.vue?vue&type=template&id=519bbeee

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.vue?vue&type=script&lang=ts
function Listvue_type_script_lang_ts_toConsumableArray(arr) { return Listvue_type_script_lang_ts_arrayWithoutHoles(arr) || Listvue_type_script_lang_ts_iterableToArray(arr) || Listvue_type_script_lang_ts_unsupportedIterableToArray(arr) || Listvue_type_script_lang_ts_nonIterableSpread(); }

function Listvue_type_script_lang_ts_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function Listvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return Listvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return Listvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function Listvue_type_script_lang_ts_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function Listvue_type_script_lang_ts_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return Listvue_type_script_lang_ts_arrayLikeToArray(arr); }

function Listvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }




/* harmony default export */ var Listvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    exportTypes: {
      type: Object,
      required: true
    },
    alreadyCreatedExportTypes: {
      type: Object,
      required: true
    },
    clickIdProviders: {
      type: Object,
      required: true
    },
    hasWriteAccess: Boolean
  },
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"]
  },
  directives: {
    ContentTable: external_CoreHome_["ContentTable"]
  },
  data: function data() {
    return {
      exportLink: ''
    };
  },
  created: function created() {
    ConversionExportStore_store.fetchExports();
  },
  methods: {
    getDisplayGoalName: function getDisplayGoalName(goal) {
      return goal.name ? "(&#x279C;&nbsp;".concat(external_CoreHome_["Matomo"].helper.htmlEntities(goal.name), ")") : '';
    },
    getDownloadLink: function getDownloadLink(accessToken) {
      var params = external_CoreHome_["MatomoUrl"].stringify({
        module: 'AdvertisingConversionExport',
        action: 'generateConversionExport',
        accessToken: accessToken
      });
      return "".concat(window.location.origin).concat(window.location.pathname, "?").concat(params);
    },
    createExport: function createExport() {
      this.editExport(0);
    },
    editExport: function editExport(idExport) {
      external_CoreHome_["MatomoUrl"].updateHash(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value), {}, {
        idExport: idExport
      }));
    },
    openExport: function openExport(accessToken) {
      window.open(this.getDownloadLink(accessToken));
    },
    showLink: function showLink(accessToken) {
      this.exportLink = this.getDownloadLink(accessToken);
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.showExportLink);
    },
    deleteExport: function deleteExport(conversionExport) {
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmDeleteExport, {
        yes: function yes() {
          ConversionExportStore_store.deleteExport(parseInt(conversionExport.idexport, 10)).then(function () {
            ConversionExportStore_store.reload();
          });
        }
      });
    }
  },
  computed: {
    atLeastOneExportWithDescription: function atLeastOneExportWithDescription() {
      return ConversionExportStore_store.exports.value.filter(function (e) {
        return !!e.description;
      }).length;
    },
    isLoading: function isLoading() {
      return ConversionExportStore_store.state.value.isLoading;
    },
    isUpdating: function isUpdating() {
      return ConversionExportStore_store.state.value.isUpdating;
    },
    exports: function exports() {
      return ConversionExportStore_store.exports.value;
    },
    sortedExports: function sortedExports() {
      var result = Listvue_type_script_lang_ts_toConsumableArray(this.exports);

      result.sort(function (lhs, rhs) {
        return parseInt("".concat(lhs.idexport), 10) - parseInt("".concat(rhs.idexport), 10);
      });
      return result;
    },
    goals: function goals() {
      return ConversionExportStore_store.goals.value || [];
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.vue



Listvue_type_script_lang_ts.render = Listvue_type_template_id_519bbeee_render

/* harmony default export */ var List = (Listvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Manage.vue?vue&type=template&id=2ade797a

var Managevue_type_template_id_2ade797a_hoisted_1 = {
  class: "manageConversionExport"
};
var Managevue_type_template_id_2ade797a_hoisted_2 = {
  key: 0
};
var Managevue_type_template_id_2ade797a_hoisted_3 = {
  key: 1
};
function Managevue_type_template_id_2ade797a_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ConversionExportList = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ConversionExportList");

  var _component_ConversionExportEdit = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ConversionExportEdit");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Managevue_type_template_id_2ade797a_hoisted_1, [!_ctx.editMode ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Managevue_type_template_id_2ade797a_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ConversionExportList, {
    "export-types": _ctx.exportTypes,
    "already-created-export-types": _ctx.alreadyCreatedExportTypes,
    "click-id-providers": _ctx.clickIdProviders,
    "attribution-models": _ctx.attributionModels,
    "has-write-access": _ctx.hasWriteAccess
  }, null, 8, ["export-types", "already-created-export-types", "click-id-providers", "attribution-models", "has-write-access"])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.editMode ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", Managevue_type_template_id_2ade797a_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ConversionExportEdit, {
    "id-export": _ctx.idExport,
    "export-types": _ctx.exportTypes,
    "already-created-export-types": _ctx.alreadyCreatedExportTypes,
    "click-id-providers": _ctx.clickIdProviders,
    "attribution-models": _ctx.attributionModels
  }, null, 8, ["id-export", "export-types", "already-created-export-types", "click-id-providers", "attribution-models"])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Manage.vue?vue&type=template&id=2ade797a

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Manage.vue?vue&type=script&lang=ts




/* harmony default export */ var Managevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    exportTypes: {
      type: Object,
      required: true
    },
    alreadyCreatedExportTypes: {
      type: Object,
      required: true
    },
    clickIdProviders: {
      type: Object,
      required: true
    },
    attributionModels: {
      type: Object,
      required: true
    },
    hasWriteAccess: Boolean
  },
  components: {
    ConversionExportEdit: Edit,
    ConversionExportList: List
  },
  data: function data() {
    return {
      editMode: false,
      idExport: null
    };
  },
  created: function created() {
    var _this = this;

    // doing this in a watch because we don't want to post an event in a computed property
    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["watch"])(function () {
      return external_CoreHome_["MatomoUrl"].hashParsed.value.idExport;
    }, function (idExport) {
      _this.initState(idExport);
    });
    this.initState(external_CoreHome_["MatomoUrl"].hashParsed.value.idExport);
  },
  methods: {
    removeAnyNotification: function removeAnyNotification() {
      external_CoreHome_["NotificationsStore"].remove('conversionexportmanagement');
    },
    initState: function initState(idExport) {
      if (idExport) {
        if (idExport === '0') {
          var parameters = {
            isAllowed: true
          };
          external_CoreHome_["Matomo"].postEvent('AdvertisingConversionExport.initAddExport', parameters);

          if (parameters && !parameters.isAllowed) {
            this.editMode = false;
            this.idExport = null;
            return;
          }
        }

        this.editMode = true;
        this.idExport = parseInt(idExport, 10);
      } else {
        this.editMode = false;
        this.idExport = null;
      }

      this.removeAnyNotification();
    }
  }
}));
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Manage.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/ConversionExport/Manage.vue



Managevue_type_script_lang_ts.render = Managevue_type_template_id_2ade797a_render

/* harmony default export */ var Manage = (Managevue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/AdvertisingConversionExport/vue/src/index.ts
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
//# sourceMappingURL=AdvertisingConversionExport.umd.js.map