(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", , "CorePluginsAdmin"], factory);
	else if(typeof exports === 'object')
		exports["CrashAnalytics"] = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else
		root["CrashAnalytics"] = factory(root["CoreHome"], root["Vue"], root["CorePluginsAdmin"]);
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
/******/ 	__webpack_require__.p = "plugins/CrashAnalytics/vue/dist/";
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
__webpack_require__.d(__webpack_exports__, "CrashDetails", function() { return /* reexport */ CrashDetails; });
__webpack_require__.d(__webpack_exports__, "ManageIgnoredCrashes", function() { return /* reexport */ ManageIgnoredCrashes; });
__webpack_require__.d(__webpack_exports__, "ManageCrashGroups", function() { return /* reexport */ MergeCrashes; });
__webpack_require__.d(__webpack_exports__, "UnmergeCrashes", function() { return /* reexport */ UnmergeCrashes; });

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

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/visitorActions.ts
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

external_CoreHome_["Matomo"].on('Live.initializeVisitorActions', function (elem) {
  var _window = window,
      $ = _window.$;

  function setLastActionClass($list) {
    $list.children(':not(.actionsForPageExpander):not(.duplicate)').removeClass('last-action').last().addClass('last-action');
  } // event handler for content expander/collapser


  $(elem).on('click', '.collapsed-crashes', function onClickCollapsedCrashes() {
    $(this).nextUntil(':not(.crash-action)').toggleClass('duplicate');
    setLastActionClass($(this).closest('ol.actionList'));
  });

  function makeCollapsedCrashes() {
    var $li = $('<li/>').attr('class', 'crash-action collapsed-crashes').attr('title', Object(external_CoreHome_["translate"])('CrashAnalytics_ClickToSeeAllCrashes'));
    var xCrashes = Object(external_CoreHome_["translate"])('CrashAnalytics_XCrashes', '<span class="crashes">0</span>');
    $('<div>').html("<img src=\"plugins/CrashAnalytics/images/crash.png\" class=\"action-list-action-icon\"/>".concat(xCrashes)).appendTo($li);
    return $li;
  }

  function addCrashItem($collapsedCrashes, $otherLi) {
    if ($collapsedCrashes.find('.crashes').length) {
      var $crashes = $collapsedCrashes.find('.crashes');
      $crashes.text(parseInt($crashes.text(), 10) + 1);
    }

    $otherLi.addClass('duplicate').addClass('collapsed-crash-item').val('').attr('style', '');
  } // collapse adjacent crashes


  $('ol.visitorLog', elem).each(function (ignore, visitorLogElem) {
    var $actions = $(visitorLogElem).find('li');
    $actions.each(function (index, actionElem) {
      var $li = $(actionElem);

      if (!$li.is('.crash-action')) {
        return;
      }

      if (!$actions[index - 1] || !$($actions[index - 1]).is('.crash-action') || !$actions[index - 2] || !$($actions[index - 2]).is('.crash-action')) {
        return;
      }

      var $collapsedCrashes = $li;

      while ($collapsedCrashes.prev().is('.crash-action')) {
        $collapsedCrashes = $collapsedCrashes.prev();
      }

      if (!$collapsedCrashes.is('.collapsed-crashes')) {
        $collapsedCrashes = makeCollapsedCrashes();
        $collapsedCrashes.insertBefore($($actions[index - 2]));
        addCrashItem($collapsedCrashes, $($actions[index - 2]));
        addCrashItem($collapsedCrashes, $($actions[index - 1]));
      }

      addCrashItem($collapsedCrashes, $li);
    });
  });
});
// EXTERNAL MODULE: external {"commonjs":"vue","commonjs2":"vue","root":"Vue"}
var external_commonjs_vue_commonjs2_vue_root_Vue_ = __webpack_require__("8bbf");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.vue?vue&type=template&id=7c684082

var _hoisted_1 = {
  class: "crashDetails",
  ref: "root"
};
var _hoisted_2 = {
  class: "summary",
  ref: "summary"
};
var _hoisted_3 = {
  class: "label"
};
var _hoisted_4 = {
  class: "label"
};
var _hoisted_5 = {
  class: "label"
};
var _hoisted_6 = {
  class: "label"
};
var _hoisted_7 = {
  class: "label"
};
var _hoisted_8 = {
  key: 0
};
var _hoisted_9 = {
  key: 1
};
var _hoisted_10 = ["href"];
var _hoisted_11 = {
  class: "label"
};
var _hoisted_12 = {
  class: "crashFirstSeen"
};
var _hoisted_13 = {
  class: "label"
};
var _hoisted_14 = {
  class: "crashLastSeen"
};
var _hoisted_15 = {
  class: "label"
};
var _hoisted_16 = {
  key: 0
};
var _hoisted_17 = {
  class: "label"
};
var _hoisted_18 = {
  class: "actions"
};

var _hoisted_19 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-document"
}, null, -1);

var _hoisted_20 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-email"
}, null, -1);

var _hoisted_21 = ["title"];

var _hoisted_22 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-hide"
}, null, -1);

var _hoisted_23 = ["value"];
var _hoisted_24 = ["href"];
var _hoisted_25 = ["innerHTML"];

var _hoisted_26 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_27 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_28 = ["innerHTML"];
var _hoisted_29 = {
  class: "ui-confirm confirmSetIgnoreContainer",
  ref: "confirmSetIgnoreContainer"
};
var _hoisted_30 = ["value"];
var _hoisted_31 = ["value"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_NotificationGroup = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("NotificationGroup");

  var _component_CrashSourceLink = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("CrashSourceLink");

  var _component_ActivityIndicator = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ActivityIndicator");

  var _component_CrashLog = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("CrashLog");

  var _component_Notification = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Notification");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_NotificationGroup, {
    group: "CrashAnalytics_CrashDetails"
  }), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Summary')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Message')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.message), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Type')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.crash_type), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Category')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.category || '-'), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Source')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_CrashSourceLink, {
    uri: _ctx.crash.resource_uri,
    line: _ctx.crash.resource_line,
    column: _ctx.crash.resource_column,
    "page-url": _ctx.crash.crash_page_url,
    "do-not-link-inline": true
  }, null, 8, ["uri", "line", "column", "page-url"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_RecentPageUrl')) + ":", 1), _ctx.crash.crash_page_url && !/^https?:/.test(_ctx.crash.crash_page_url) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.crash_page_url), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.crash.crash_page_url ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NotFound')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.crash.crash_page_url && /^https?:/.test(_ctx.crash.crash_page_url) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 2,
    class: "recentPageUrlLink",
    href: _ctx.crash.crash_page_url,
    target: "_blank",
    rel: "noreferrer noopener"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.crash_page_url), 9, _hoisted_10)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_RecentStackTrace')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crashStackTrace), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_FirstSeen')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.datetime_first_seen_pretty), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_LastSeen')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.datetime_last_seen_pretty), 1)]), _ctx.crash.datetime_last_reappeared ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_16, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_LastReappeared')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.datetime_last_reappeared_pretty), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_18, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
    class: "btn-flat btn-large copyCrashInfo",
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.copyCrashInfo();
    })
  }, [_hoisted_19, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_CopyCrashInformation')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
    class: "btn-flat btn-large",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$refs.emailError.click();
    })
  }, [_hoisted_20, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_EmailCrashInformation')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    title: _ctx.crash.datetime_ignored_error ? _ctx.translate('CrashAnalytics_ThisCrashIgnoredOn', _ctx.crash.datetime_ignored_error_pretty) : undefined
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["btn-flat btn-large ignoreCrash", {
      disabled: _ctx.crash.datetime_ignored_error || _ctx.ignored || _ctx.isIgnoring
    }]),
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return _ctx.ignoreCrash();
    })
  }, [_hoisted_22, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_IgnoreThisCrash')) + " ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ActivityIndicator, {
    loading: _ctx.isIgnoring
  }, null, 8, ["loading"])], 2)], 8, _hoisted_21)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("textarea", {
    ref: "copyText",
    value: _ctx.errorSummaryText,
    style: {
      "position": "absolute",
      "left": "-1000px",
      "height": "0",
      "padding": "0",
      "width": "0",
      "line-height": "0"
    }
  }, null, 8, _hoisted_23), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    rel: "noreferrer noopener",
    target: "_blank",
    href: _ctx.emailErrorLink,
    ref: "emailError",
    style: {
      "display": "none"
    }
  }, null, 8, _hoisted_24)], 512), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Context')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_CrashLog, {
    crash: _ctx.crash,
    "extra-request-params": _ctx.extraRequestParams,
    onContextDisabled: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.isContextDisabled = $event;
    })
  }, null, 8, ["crash", "extra-request-params"]), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isContextDisabled !== null && !_ctx.isContextDisabled]]), _ctx.isContextDisabled !== null && _ctx.isContextDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Notification, {
    key: 0,
    context: "info"
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.crashContextDisabledMessage1)
      }, null, 8, _hoisted_25), _hoisted_26, _hoisted_27, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.crashContextDisabledMessage2)
      }, null, 8, _hoisted_28)];
    }),
    _: 1
  })) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_29, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ConfirmIgnore')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, _hoisted_30), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, _hoisted_31)], 512)], 512);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.vue?vue&type=template&id=7c684082

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.vue?vue&type=template&id=395ccda0

var CrashLogvue_type_template_id_395ccda0_hoisted_1 = {
  class: "crashLog",
  ref: "root",
  "data-report": ""
};
var CrashLogvue_type_template_id_395ccda0_hoisted_2 = ["innerHTML"];
var CrashLogvue_type_template_id_395ccda0_hoisted_3 = {
  key: 0,
  class: "crashes"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_4 = {
  key: 0
};
var CrashLogvue_type_template_id_395ccda0_hoisted_5 = {
  key: 1,
  class: "dataTableFeatures"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_6 = {
  class: "dataTableFooterNavigation"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_7 = {
  class: "row dataTablePaginationControl"
};

var CrashLogvue_type_template_id_395ccda0_hoisted_8 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])("    ");

var CrashLogvue_type_template_id_395ccda0_hoisted_9 = {
  class: "row"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_10 = {
  class: "col s9 m9 dataTableControls"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_11 = ["title"];

var CrashLogvue_type_template_id_395ccda0_hoisted_12 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-export"
}, null, -1);

var CrashLogvue_type_template_id_395ccda0_hoisted_13 = [CrashLogvue_type_template_id_395ccda0_hoisted_12];
var CrashLogvue_type_template_id_395ccda0_hoisted_14 = {
  class: "col s3 m3 limitSelection"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_15 = {
  class: "input-field"
};
var CrashLogvue_type_template_id_395ccda0_hoisted_16 = ["value"];
var CrashLogvue_type_template_id_395ccda0_hoisted_17 = ["selected"];
function CrashLogvue_type_template_id_395ccda0_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_SimplePeriodSelector = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SimplePeriodSelector");

  var _component_Notification = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Notification");

  var _component_CrashContextCard = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("CrashContextCard");

  var _component_ActivityIndicator = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ActivityIndicator");

  var _directive_report_export = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("report-export");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_1, [!_ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_SimplePeriodSelector, {
    key: 0,
    "model-value": {
      period: _ctx.requestParams.period,
      date: _ctx.requestParams.date
    },
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.changePeriod($event);
    })
  }, null, 8, ["model-value"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Notification, {
    key: 1,
    type: "transient",
    context: "info",
    noclear: true
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.visitorLogDisabledMessage)
      }, null, 8, CrashLogvue_type_template_id_395ccda0_hoisted_2)];
    }),
    _: 1
  })) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [!_ctx.isLoading ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_3, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.crashContexts, function (context) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_CrashContextCard, {
      key: context.crashEventId,
      "crash-context": context,
      period: _ctx.requestParams.period,
      date: _ctx.requestParams.date
    }, null, 8, ["crash-context", "period", "date"]);
  }), 128)), !_ctx.crashContexts.length && _ctx.requestParams.filter_offset === 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NoVisitsFoundForThisCrash')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "dataTablePrevious",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.prevPage();
    }),
    style: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeStyle"])({
      visibility: _ctx.requestParams.filter_offset > 0 ? 'visible' : 'hidden'
    })
  }, "‹ Previous", 4), CrashLogvue_type_template_id_395ccda0_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "dataTableNext",
    style: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeStyle"])({
      visibility: this.crashContexts.length >= _ctx.requestParams.filter_limit ? 'visible' : 'hidden'
    }),
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return _ctx.nextPage();
    })
  }, "Next ›", 4)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: "dataTableAction activateExportSelection",
    title: _ctx.translate('General_ExportThisReport'),
    href: "",
    style: {
      "margin-right": "3.5px"
    },
    onClick: _cache[3] || (_cache[3] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function () {}, ["prevent"]))
  }, CrashLogvue_type_template_id_395ccda0_hoisted_13, 8, CrashLogvue_type_template_id_395ccda0_hoisted_11), [[_directive_report_export, _ctx.reportExportBinding]])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashLogvue_type_template_id_395ccda0_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("select", {
    value: _ctx.requestParams.filter_limit,
    onChange: _cache[4] || (_cache[4] = function ($event) {
      return _ctx.limitChange($event.target.value);
    })
  }, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.limitOptions, function (value) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("option", {
      key: value,
      selected: _ctx.requestParams.filter_limit === value ? 'selected' : undefined
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(value), 9, CrashLogvue_type_template_id_395ccda0_hoisted_17);
  }), 128))], 40, CrashLogvue_type_template_id_395ccda0_hoisted_16)])])])])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isLoading ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ActivityIndicator, {
    key: 2,
    loading: _ctx.isLoading
  }, null, 8, ["loading"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 512);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.vue?vue&type=template&id=395ccda0

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.vue?vue&type=template&id=46b8841e

var CrashContextCardvue_type_template_id_46b8841e_hoisted_1 = {
  class: "crashContextCard card",
  ref: "root"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_2 = {
  class: "card-content"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_3 = {
  class: "row"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_4 = {
  class: "col m6 s12 visitInfo"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_5 = {
  class: "sectionTitle"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_6 = ["src"];
var CrashContextCardvue_type_template_id_46b8841e_hoisted_7 = ["src"];
var CrashContextCardvue_type_template_id_46b8841e_hoisted_8 = ["src"];
var CrashContextCardvue_type_template_id_46b8841e_hoisted_9 = {
  key: 0
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_10 = {
  key: 1
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_11 = {
  key: 2
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_12 = {
  key: 3
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_13 = ["src", "alt", "title"];
var CrashContextCardvue_type_template_id_46b8841e_hoisted_14 = {
  key: 4
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_15 = {
  key: 5
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_16 = {
  key: 6
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_17 = ["src"];
var CrashContextCardvue_type_template_id_46b8841e_hoisted_18 = {
  key: 7,
  class: "currency"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_19 = {
  key: 0,
  class: "col m6 s12 lastActions"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_20 = {
  class: "sectionTitle"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_21 = {
  class: "visitorLog actionList"
};
var CrashContextCardvue_type_template_id_46b8841e_hoisted_22 = ["href"];

var CrashContextCardvue_type_template_id_46b8841e_hoisted_23 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-play"
}, null, -1);

var CrashContextCardvue_type_template_id_46b8841e_hoisted_24 = {
  class: "row"
};
function CrashContextCardvue_type_template_id_46b8841e_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$crashContext$vis, _ctx$crashContext$vis2, _ctx$crashContext$vis3, _ctx$crashContext$vis4, _ctx$crashContext$vis5, _ctx$crashContext$vis6, _ctx$crashContext$vis7, _ctx$crashContext$vis8, _ctx$crashContext$vis9, _ctx$crashContext$vis10, _ctx$crashContext$vis11, _ctx$crashContext$vis12, _ctx$crashContext$vis13, _ctx$crashContext$vis14, _ctx$crashContext$vis15, _ctx$crashContext$vis16, _ctx$crashContext$vis17, _ctx$crashContext$vis18, _ctx$crashContext$vis19, _ctx$crashContext$vis20, _ctx$crashContext$vis21, _ctx$crashContext$vis22, _ctx$crashContext$vis23, _ctx$crashContext$vis24, _ctx$crashContext$vis25, _ctx$crashContext$vis26, _ctx$crashContext$vis27, _ctx$crashContext$vis28;

  var _component_ActivityIndicator = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ActivityIndicator");

  var _component_SourceAndStackTrace = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SourceAndStackTrace");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", CrashContextCardvue_type_template_id_46b8841e_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crashContext.serverTimePretty), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [(_ctx$crashContext$vis = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis !== void 0 && _ctx$crashContext$vis.browserIcon ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
    key: 0,
    src: (_ctx$crashContext$vis2 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis2 === void 0 ? void 0 : _ctx$crashContext$vis2.browserIcon
  }, null, 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_6)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('DevicesDetection_ColumnBrowser')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis3 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis3 === void 0 ? void 0 : _ctx$crashContext$vis3.browser), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [(_ctx$crashContext$vis4 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis4 !== void 0 && _ctx$crashContext$vis4.operatingSystemIcon ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
    key: 0,
    src: (_ctx$crashContext$vis5 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis5 === void 0 ? void 0 : _ctx$crashContext$vis5.operatingSystemIcon
  }, null, 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_7)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('DevicesDetection_ColumnOperatingSystem')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis6 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis6 === void 0 ? void 0 : _ctx$crashContext$vis6.operatingSystem), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [(_ctx$crashContext$vis7 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis7 !== void 0 && _ctx$crashContext$vis7.deviceTypeIcon ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
    key: 0,
    src: (_ctx$crashContext$vis8 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis8 === void 0 ? void 0 : _ctx$crashContext$vis8.deviceTypeIcon
  }, null, 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_8)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('DevicesDetection_DeviceType')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis9 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis9 === void 0 ? void 0 : _ctx$crashContext$vis9.deviceType), 1)]), (_ctx$crashContext$vis10 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis10 !== void 0 && _ctx$crashContext$vis10.deviceModel ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('DevicesDetection_Device')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis11 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis11 === void 0 ? void 0 : _ctx$crashContext$vis11.deviceModel), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis12 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis12 !== void 0 && _ctx$crashContext$vis12.resolution ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('Resolution_ColumnResolution')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis13 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis13 === void 0 ? void 0 : _ctx$crashContext$vis13.resolution), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis14 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis14 !== void 0 && _ctx$crashContext$vis14.languageCode ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_BrowserLanguage')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis15 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis15 === void 0 ? void 0 : _ctx$crashContext$vis15.languageCode), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis16 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis16 !== void 0 && _ctx$crashContext$vis16.pluginsIcons ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_BrowserPlugins')) + ": ", 1), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(((_ctx$crashContext$vis17 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis17 === void 0 ? void 0 : _ctx$crashContext$vis17.pluginsIcons) || [], function (icon) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
      class: "browserPluginIcon",
      key: icon.pluginName,
      src: icon.pluginIcon,
      alt: icon.pluginName,
      title: icon.pluginName
    }, null, 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_13);
  }), 128))])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis18 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis18 !== void 0 && _ctx$crashContext$vis18.userId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('UsersManager_User')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis19 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis19 === void 0 ? void 0 : _ctx$crashContext$vis19.userId), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis20 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis20 !== void 0 && _ctx$crashContext$vis20.visitIp ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_15, " IP: " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis21 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis21 === void 0 ? void 0 : _ctx$crashContext$vis21.visitIp), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis22 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis22 !== void 0 && _ctx$crashContext$vis22.country ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_16, [(_ctx$crashContext$vis23 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis23 !== void 0 && _ctx$crashContext$vis23.countryFlag ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
    key: 0,
    src: (_ctx$crashContext$vis24 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis24 === void 0 ? void 0 : _ctx$crashContext$vis24.countryFlag
  }, null, 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_17)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crashLocation), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$crashContext$vis25 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis25 !== void 0 && _ctx$crashContext$vis25.siteCurrency ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('SitesManager_Currency')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])((_ctx$crashContext$vis26 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis26 === void 0 ? void 0 : _ctx$crashContext$vis26.siteCurrency), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]), !_ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_19, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", CrashContextCardvue_type_template_id_46b8841e_hoisted_20, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_LastNActionsBeforeCrash', 5)), 1)]), _ctx.isLoadingActions ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ActivityIndicator, {
    key: 0,
    loading: _ctx.isLoadingActions
  }, null, 8, ["loading"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ol", CrashContextCardvue_type_template_id_46b8841e_hoisted_21, null, 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoadingActions]]), (_ctx$crashContext$vis27 = _ctx.crashContext.visit) !== null && _ctx$crashContext$vis27 !== void 0 && _ctx$crashContext$vis27.sessionReplayUrl ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 1,
    href: (_ctx$crashContext$vis28 = _ctx.crashContext.visit) === null || _ctx$crashContext$vis28 === void 0 ? void 0 : _ctx$crashContext$vis28.sessionReplayUrl,
    class: "sessionReplayLink",
    target: "_blank"
  }, [CrashContextCardvue_type_template_id_46b8841e_hoisted_23, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ReplayThisSession')), 1)], 8, CrashContextCardvue_type_template_id_46b8841e_hoisted_22)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_SourceAndStackTrace, {
    key: 1,
    class: "col s12 m6",
    "crash-context": _ctx.crashContext
  }, null, 8, ["crash-context"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", CrashContextCardvue_type_template_id_46b8841e_hoisted_24, [!_ctx.isVisitorLogDisabled ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_SourceAndStackTrace, {
    key: 0,
    class: "col s12",
    "crash-context": _ctx.crashContext
  }, null, 8, ["crash-context"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])])], 512);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.vue?vue&type=template&id=46b8841e

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/SourceAndStackTrace.vue?vue&type=template&id=c66c13aa

var SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_1 = {
  class: "lastStackTrace"
};
var SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_2 = {
  class: "sectionTitle"
};

var SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(": ");

var SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_4 = {
  key: 0
};
var SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_5 = {
  key: 1,
  class: "form-description"
};
function SourceAndStackTracevue_type_template_id_c66c13aa_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_CrashSourceLink = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("CrashSourceLink");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_SourceAndStackTrace')), 1), SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_CrashSourceLink, {
    uri: _ctx.crashContext.resourceUri,
    line: _ctx.crashContext.resourceLine,
    column: _ctx.crashContext.resourceColumn,
    "page-url": _ctx.crashContext.pageUrl
  }, null, 8, ["uri", "line", "column", "page-url"])]), _ctx.crashContext.stackTrace ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("pre", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("code", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crashContext.stackTrace), 1)])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.crashContext.stackTrace ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", SourceAndStackTracevue_type_template_id_c66c13aa_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NoStackTraceFound')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SourceAndStackTrace.vue?vue&type=template&id=c66c13aa

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.vue?vue&type=template&id=576955c1

var CrashSourceLinkvue_type_template_id_576955c1_hoisted_1 = ["href"];
var CrashSourceLinkvue_type_template_id_576955c1_hoisted_2 = ["title"];
var CrashSourceLinkvue_type_template_id_576955c1_hoisted_3 = ["title"];
function CrashSourceLinkvue_type_template_id_576955c1_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [_ctx.isNetworkSource && _ctx.uri ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    class: "crashSourceLink",
    href: _ctx.crashSourceUrl,
    target: "_blank",
    rel: "noreferrer noopener"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.uriDisplay), 9, CrashSourceLinkvue_type_template_id_576955c1_hoisted_1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.isNetworkSource && _ctx.uri ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
    key: 1,
    title: _ctx.noLinkTooltip
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.uriDisplay), 9, CrashSourceLinkvue_type_template_id_576955c1_hoisted_2)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.uri ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
    key: 2,
    title: _ctx.lineColumnTooltip
  }, ":" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.line) + ":" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.column), 9, CrashSourceLinkvue_type_template_id_576955c1_hoisted_3)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 64);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.vue?vue&type=template&id=576955c1

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.vue?vue&type=script&lang=ts



function isUrl(uri) {
  if (!uri || !/^https?/.test(uri)) {
    return false;
  }

  try {
    new URL(uri); // eslint-disable-line no-new

    return true;
  } catch (e) {
    return false;
  }
}

/* harmony default export */ var CrashSourceLinkvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    uri: String,
    line: Number,
    column: Number,
    pageUrl: String,
    doNotLinkInline: Boolean
  },
  computed: {
    isGroupedHashFilename: function isGroupedHashFilename() {
      return /\/\[grouped-hash]\./.test(this.uriDisplay);
    },
    isNetworkSource: function isNetworkSource() {
      return isUrl(this.uriDisplay) && !this.isGroupedHashFilename;
    },
    uriDisplay: function uriDisplay() {
      if (this.uri === 'inline') {
        return this.doNotLinkInline ? Object(external_CoreHome_["translate"])('CrashAnalytics_Inline') : this.pageUrl;
      }

      return this.uri;
    },
    crashSourceUrl: function crashSourceUrl() {
      if (!this.uri) {
        return null;
      }

      if (this.uri === 'inline') {
        return "view-source:".concat(this.pageUrl);
      }

      if (isUrl(this.uri)) {
        return this.uri;
      }

      return null;
    },
    lineColumnTooltip: function lineColumnTooltip() {
      return Object(external_CoreHome_["translate"])('CrashAnalytics_LineColumn', this.line, this.column);
    },
    noLinkTooltip: function noLinkTooltip() {
      if (!this.isGroupedHashFilename) {
        return undefined;
      }

      return Object(external_CoreHome_["translate"])('CrashAnalytics_GroupedHashTooltipInDetails');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.vue



CrashSourceLinkvue_type_script_lang_ts.render = CrashSourceLinkvue_type_template_id_576955c1_render

/* harmony default export */ var CrashSourceLink = (CrashSourceLinkvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/SourceAndStackTrace.vue?vue&type=script&lang=ts


/* harmony default export */ var SourceAndStackTracevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    crashContext: {
      type: Object,
      required: true
    }
  },
  components: {
    CrashSourceLink: CrashSourceLink
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SourceAndStackTrace.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SourceAndStackTrace.vue



SourceAndStackTracevue_type_script_lang_ts.render = SourceAndStackTracevue_type_template_id_c66c13aa_render

/* harmony default export */ var SourceAndStackTrace = (SourceAndStackTracevue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.vue?vue&type=script&lang=ts



var CrashContextCardvue_type_script_lang_ts_window = window,
    CrashContextCardvue_type_script_lang_ts_$ = CrashContextCardvue_type_script_lang_ts_window.$;
/* harmony default export */ var CrashContextCardvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    crashContext: {
      type: Object,
      required: true
    },
    period: {
      type: String,
      required: true
    },
    date: {
      type: String,
      required: true
    }
  },
  components: {
    ActivityIndicator: external_CoreHome_["ActivityIndicator"],
    SourceAndStackTrace: SourceAndStackTrace
  },
  data: function data() {
    return {
      isLoadingActions: true,
      recentActionsHtml: ''
    };
  },
  created: function created() {
    this.fetchActionsDisplay();
  },
  watch: {
    recentActionsHtml: function recentActionsHtml() {
      var _this = this;

      Object(external_commonjs_vue_commonjs2_vue_root_Vue_["nextTick"])(function () {
        var root = CrashContextCardvue_type_script_lang_ts_$(_this.$refs.root);
        root.find('ol.visitorLog').html(window.vueSanitize(_this.recentActionsHtml)); // eslint-disable-next-line @typescript-eslint/no-explicit-any

        window.initializeVisitorActions(root);
      });
    }
  },
  computed: {
    crashLocation: function crashLocation() {
      var _crashContext$visit, _crashContext$visit3, _crashContext$visit5;

      var crashContext = this.crashContext;
      var parts = [];

      if ((_crashContext$visit = crashContext.visit) !== null && _crashContext$visit !== void 0 && _crashContext$visit.country) {
        var _crashContext$visit2;

        parts.push((_crashContext$visit2 = crashContext.visit) === null || _crashContext$visit2 === void 0 ? void 0 : _crashContext$visit2.country);
      }

      if ((_crashContext$visit3 = crashContext.visit) !== null && _crashContext$visit3 !== void 0 && _crashContext$visit3.region) {
        var _crashContext$visit4;

        parts.push((_crashContext$visit4 = crashContext.visit) === null || _crashContext$visit4 === void 0 ? void 0 : _crashContext$visit4.region);
      }

      if ((_crashContext$visit5 = crashContext.visit) !== null && _crashContext$visit5 !== void 0 && _crashContext$visit5.city) {
        var _crashContext$visit6;

        parts.push((_crashContext$visit6 = crashContext.visit) === null || _crashContext$visit6 === void 0 ? void 0 : _crashContext$visit6.city);
      }

      return parts.join(', ');
    },
    isVisitorLogDisabled: function isVisitorLogDisabled() {
      return typeof this.crashContext.actionsBeforeCrash === 'undefined';
    }
  },
  methods: {
    fetchActionsDisplay: function fetchActionsDisplay() {
      var _this2 = this;

      var crashContext = this.crashContext;
      external_CoreHome_["AjaxHelper"].fetch({
        module: 'CrashAnalytics',
        action: 'getCrashRecentActions',
        format: 'html',
        idVisit: crashContext.idVisit,
        idLogCrashEvent: crashContext.crashEventId,
        period: this.period,
        date: this.date
      }, {
        format: 'html'
      }).then(function (content) {
        _this2.recentActionsHtml = content;
      }).finally(function () {
        _this2.isLoadingActions = false;
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.vue



CrashContextCardvue_type_script_lang_ts.render = CrashContextCardvue_type_template_id_46b8841e_render

/* harmony default export */ var CrashContextCard = (CrashContextCardvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.vue?vue&type=template&id=b83d3850

var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_1 = {
  class: "simplePeriodSelector periodSelector piwikSelector borderedControl",
  ref: "root"
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_2 = ["title"];

var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon icon-calendar"
}, null, -1);

var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_4 = {
  class: "dropdown"
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_5 = {
  style: {
    "display": "flex"
  }
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_6 = {
  key: 0,
  class: "period-date"
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_7 = {
  class: "period-type"
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_8 = {
  id: "otherPeriods"
};
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_9 = ["onDblclick", "title"];
var SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_10 = ["id", "checked", "onChange", "onDblclick"];
function SimplePeriodSelectorvue_type_template_id_b83d3850_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this$modelValue,
      _this = this;

  var _component_PeriodDatePicker = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("PeriodDatePicker");

  var _directive_expand_on_click = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("expand-on-click");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])((Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    ref: "title",
    id: "date",
    class: "title",
    tabindex: "-1",
    title: _ctx.translate('General_ChooseDate', _ctx.currentlyViewingText)
  }, [SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.currentlyViewingText), 1)], 8, SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_5, [_ctx.selectedPeriod !== 'range' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_PeriodDatePicker, {
    id: "datepicker",
    period: _ctx.selectedPeriod,
    date: ((_this$modelValue = this.modelValue) === null || _this$modelValue === void 0 ? void 0 : _this$modelValue.period) === _ctx.selectedPeriod ? _ctx.dateValue : null,
    onSelect: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.setPiwikPeriodAndDate(_ctx.selectedPeriod, $event.date);
    })
  }, null, 8, ["period", "date"])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h6", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Period')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_8, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.periods, function (period) {
    var _this$modelValue2;

    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("p", {
      key: period
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])({
        'selected-period-label': period === _ctx.selectedPeriod
      }),
      onDblclick: function onDblclick($event) {
        return _ctx.changeViewedPeriod(period);
      },
      title: period === ((_this$modelValue2 = _this.modelValue) === null || _this$modelValue2 === void 0 ? void 0 : _this$modelValue2.period) ? '' : _ctx.translate('General_DoubleClickToChangePeriod')
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
      type: "radio",
      name: "period",
      id: "period_id_".concat(period),
      "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
        return _ctx.selectedPeriod = $event;
      }),
      checked: _ctx.selectedPeriod === period,
      onChange: function onChange($event) {
        return _ctx.selectedPeriod = period;
      },
      onDblclick: function onDblclick($event) {
        return _ctx.changeViewedPeriod(period);
      }
    }, null, 40, SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_10), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vModelRadio"], _ctx.selectedPeriod]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.getPeriodDisplayText(period)), 1)], 42, SimplePeriodSelectorvue_type_template_id_b83d3850_hoisted_9)]);
  }), 128))])])])])], 512)), [[_directive_expand_on_click, {
    expander: 'title'
  }]]);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.vue?vue&type=template&id=b83d3850

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.vue?vue&type=script&lang=ts


/* harmony default export */ var SimplePeriodSelectorvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    modelValue: Object
  },
  components: {
    PeriodDatePicker: external_CoreHome_["PeriodDatePicker"]
  },
  directives: {
    ExpandOnClick: external_CoreHome_["ExpandOnClick"]
  },
  emits: ['update:modelValue'],
  data: function data() {
    var _this$modelValue;

    return {
      selectedPeriod: (_this$modelValue = this.modelValue) === null || _this$modelValue === void 0 ? void 0 : _this$modelValue.period
    };
  },
  computed: {
    periods: function periods() {
      return ['day', 'week', 'month', 'year'];
    },
    dateValue: function dateValue() {
      if (!this.modelValue) {
        return null;
      }

      return Object(external_CoreHome_["parseDate"])(this.modelValue.date);
    },
    currentlyViewingText: function currentlyViewingText() {
      var _this$modelValue2;

      if (!((_this$modelValue2 = this.modelValue) !== null && _this$modelValue2 !== void 0 && _this$modelValue2.period) || !this.dateValue) {
        return Object(external_CoreHome_["translate"])('General_Error');
      }

      var date = Object(external_CoreHome_["format"])(this.dateValue);

      try {
        return external_CoreHome_["Periods"].parse(this.modelValue.period, date).getPrettyString();
      } catch (e) {
        return Object(external_CoreHome_["translate"])('General_Error');
      }
    }
  },
  methods: {
    getPeriodDisplayText: function getPeriodDisplayText(periodLabel) {
      return external_CoreHome_["Periods"].get(periodLabel).getDisplayText();
    },
    changeViewedPeriod: function changeViewedPeriod(period) {
      this.$emit('update:modelValue', Object.assign(Object.assign({}, this.modelValue), {}, {
        period: period
      }));
      this.closePeriodSelector();
    },
    setPiwikPeriodAndDate: function setPiwikPeriodAndDate(period, date) {
      this.$emit('update:modelValue', {
        period: period,
        date: Object(external_CoreHome_["format"])(date)
      });
      this.closePeriodSelector();
    },
    closePeriodSelector: function closePeriodSelector() {
      this.$refs.root.classList.remove('expanded');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.vue



SimplePeriodSelectorvue_type_script_lang_ts.render = SimplePeriodSelectorvue_type_template_id_b83d3850_render

/* harmony default export */ var SimplePeriodSelector = (SimplePeriodSelectorvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashContextStore.ts
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


var DEFAULT_LIMIT = 5;

var CrashContextStore_CrashContextStore = /*#__PURE__*/function () {
  function CrashContextStore() {
    var _this = this;

    _classCallCheck(this, CrashContextStore);

    _defineProperty(this, "privateState", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["reactive"])({
      limit: DEFAULT_LIMIT,
      offset: 0,
      crashContexts: [],
      limitOptions: [5, 10, 25, 50, 100, 250, 500],
      period: external_CoreHome_["MatomoUrl"].parsed.value.period,
      date: external_CoreHome_["MatomoUrl"].parsed.value.date,
      idLogCrash: null
    }));

    _defineProperty(this, "requestParams", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])({
        method: 'CrashAnalytics.getCrashVisitContext',
        filter_limit: _this.privateState.limit,
        filter_offset: _this.privateState.offset,
        period: _this.privateState.period,
        date: _this.privateState.date,
        idSite: external_CoreHome_["MatomoUrl"].urlParsed.value.idSite,
        segment: external_CoreHome_["MatomoUrl"].parsed.value.segment
      });
    }));

    _defineProperty(this, "limitOptions", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState.limitOptions);
    }));

    _defineProperty(this, "crashContexts", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState.crashContexts);
    }));
  }

  _createClass(CrashContextStore, [{
    key: "reset",
    value: function reset(period, date) {
      this.privateState.period = period || external_CoreHome_["MatomoUrl"].parsed.value.period;
      this.privateState.date = date || external_CoreHome_["MatomoUrl"].parsed.value.date;
      this.privateState.offset = 0;
      this.privateState.limit = DEFAULT_LIMIT;
      this.privateState.crashContexts = [];
    }
  }, {
    key: "fetch",
    value: function fetch(idLogCrash) {
      var _this2 = this;

      var paramsOverride = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      if (idLogCrash) {
        this.privateState.idLogCrash = idLogCrash;
      }

      return external_CoreHome_["AjaxHelper"].fetch(Object.assign(Object.assign(Object.assign({}, this.requestParams.value), paramsOverride), {}, {
        idLogCrash: idLogCrash || this.privateState.idLogCrash
      }), {
        createErrorNotification: false
      }).then(function (contexts) {
        _this2.privateState.crashContexts = contexts;
        return _this2.crashContexts.value;
      });
    }
  }, {
    key: "prevPage",
    value: function prevPage() {
      this.privateState.offset = Math.max(0, this.privateState.offset - this.privateState.limit);
      return this.fetch();
    }
  }, {
    key: "nextPage",
    value: function nextPage() {
      this.privateState.offset += this.privateState.limit;
      return this.fetch();
    }
  }, {
    key: "setLimit",
    value: function setLimit(limit) {
      this.privateState.limit = limit;
      return this.fetch();
    }
  }, {
    key: "setPeriod",
    value: function setPeriod(period, date) {
      this.privateState.period = period;
      this.privateState.date = date;
      this.privateState.offset = 0;
      return this.fetch();
    }
  }]);

  return CrashContextStore;
}();

/* harmony default export */ var CrashLog_CrashContextStore = (new CrashContextStore_CrashContextStore());
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.vue?vue&type=script&lang=ts





var CrashLogvue_type_script_lang_ts_window = window,
    CrashLogvue_type_script_lang_ts_$ = CrashLogvue_type_script_lang_ts_window.$;
/* harmony default export */ var CrashLogvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    crash: {
      type: Object,
      required: true
    },
    extraRequestParams: {
      type: Object,
      default: function _default() {
        return {};
      }
    }
  },
  components: {
    SimplePeriodSelector: SimplePeriodSelector,
    ActivityIndicator: external_CoreHome_["ActivityIndicator"],
    CrashContextCard: CrashContextCard,
    Notification: external_CoreHome_["Notification"]
  },
  directives: {
    ReportExport: external_CoreHome_["ReportExport"]
  },
  emits: ['contextDisabled'],
  data: function data() {
    return {
      isLoading: true,
      reportExportBinding: Object.assign({}, this.reportExportParams)
    };
  },
  created: function created() {
    CrashLog_CrashContextStore.reset(this.extraRequestParams.period, this.extraRequestParams.date);
    this.fetch();
  },
  mounted: function mounted() {
    var _this = this;

    Object(external_commonjs_vue_commonjs2_vue_root_Vue_["nextTick"])(function () {
      CrashLogvue_type_script_lang_ts_$(_this.$refs.root).find('.limitSelection select').formSelect(); // added to get ReportExport to work w/ this component

      CrashLogvue_type_script_lang_ts_$(_this.$refs.root).data('uiControlObject', {
        param: _this.requestParams
      });
    });
  },
  watch: {
    requestParams: function requestParams() {
      CrashLogvue_type_script_lang_ts_$(this.$refs.root).data('uiControlObject', {
        param: this.requestParams
      });
    },
    reportExportParams: function reportExportParams() {
      // doing an in-place assign so we can change the value of the report export binding
      // after its been mounted. this way, changes to period/date are reflected in the URL.
      Object.assign(this.reportExportBinding, this.reportExportParams);
    }
  },
  methods: {
    fetch: function fetch() {
      var _this2 = this;

      var crash = this.crash;
      this.isLoading = true;
      return CrashLog_CrashContextStore.fetch(crash.idlogcrash, this.extraRequestParams).then(function () {
        _this2.$emit('contextDisabled', false);
      }).catch(function (e) {
        _this2.$emit('contextDisabled', true);

        if (e.message !== 'Crash context display is currently disabled.') {
          throw e;
        }
      }).finally(function () {
        _this2.isLoading = false;
      });
    },
    prevPage: function prevPage() {
      CrashLog_CrashContextStore.prevPage();
    },
    nextPage: function nextPage() {
      CrashLog_CrashContextStore.nextPage();
    },
    limitChange: function limitChange(limit) {
      CrashLog_CrashContextStore.setLimit(limit);
    },
    changePeriod: function changePeriod(_ref) {
      var period = _ref.period,
          date = _ref.date;
      CrashLog_CrashContextStore.setPeriod(period, date);
    }
  },
  computed: {
    crashContexts: function crashContexts() {
      return CrashLog_CrashContextStore.crashContexts.value;
    },
    limitOptions: function limitOptions() {
      return CrashLog_CrashContextStore.limitOptions.value;
    },
    reportTitle: function reportTitle() {
      return "".concat(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashContext'), ": ").concat(this.crash.message);
    },
    requestParams: function requestParams() {
      var crash = this.crash;
      return Object.assign({
        idLogCrash: crash.idlogcrash
      }, CrashLog_CrashContextStore.requestParams.value);
    },
    requestParamsJson: function requestParamsJson() {
      return JSON.stringify(this.requestParams);
    },
    reportFormats: function reportFormats() {
      var formats = {
        CSV: 'CSV',
        TSV: 'TSV (Excel)',
        XML: 'XML',
        JSON: 'Json',
        HTML: 'HTML'
      };
      formats.RSS = 'RSS';
      return formats;
    },
    reportExportParams: function reportExportParams() {
      var limitOptions = CrashLog_CrashContextStore.limitOptions.value;
      return {
        reportTitle: this.reportTitle,
        requestParams: this.requestParamsJson,
        apiMethod: 'CrashAnalytics.getCrashVisitContext',
        reportFormats: this.reportFormats,
        maxFilterLimit: limitOptions[limitOptions.length - 1]
      };
    },
    isVisitorLogDisabled: function isVisitorLogDisabled() {
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      if (external_CoreHome_["Matomo"].visitorLogEnabled === false) {
        return true;
      }

      if (!this.crashContexts.length) {
        return false;
      }

      return typeof this.crashContexts[0].actionsBeforeCrash === 'undefined';
    },
    visitorLogDisabledMessage: function visitorLogDisabledMessage() {
      var url = 'https://matomo.org/faq/how-to/how-do-i-disable-the-visits-log-or-the-visitor-profile-feature/';
      return Object(external_CoreHome_["translate"])('CrashAnalytics_CrashDetailsVisitorLogDisabledMessage', "<a rel=\"noreferrer noopener\" target=\"_blank\" href=\"".concat(url, "\">"), '</a>');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.vue



CrashLogvue_type_script_lang_ts.render = CrashLogvue_type_template_id_395ccda0_render

/* harmony default export */ var CrashLog = (CrashLogvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.vue?vue&type=script&lang=ts





var visitInfoToDisplay = [{
  label: Object(external_CoreHome_["translate"])('CrashAnalytics_Browser'),
  prop: 'browser'
}, {
  label: Object(external_CoreHome_["translate"])('CrashAnalytics_OperatingSystem'),
  prop: 'operatingSystem'
}, {
  label: Object(external_CoreHome_["translate"])('DevicesDetection_DeviceType'),
  prop: 'deviceType'
}, {
  label: Object(external_CoreHome_["translate"])('CrashAnalytics_Device'),
  prop: 'deviceModel'
}, {
  label: Object(external_CoreHome_["translate"])('Resolution_ColumnResolution'),
  prop: 'resolution'
}, {
  label: Object(external_CoreHome_["translate"])('CrashAnalytics_BrowserLanguage'),
  prop: 'languageCode'
}, {
  label: Object(external_CoreHome_["translate"])('CrashAnalytics_BrowserPlugins'),
  prop: 'plugins'
}, {
  label: Object(external_CoreHome_["translate"])('UsersManager_User'),
  prop: 'userId'
}, {
  label: 'IP',
  prop: 'visitIp'
}];
var CrashDetailsvue_type_script_lang_ts_window = window,
    CrashDetailsvue_type_script_lang_ts_$ = CrashDetailsvue_type_script_lang_ts_window.$;
/* harmony default export */ var CrashDetailsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    crash: {
      type: Object,
      required: true
    },
    extraRequestParams: {
      type: Object,
      default: function _default() {
        return {};
      }
    }
  },
  components: {
    NotificationGroup: external_CoreHome_["NotificationGroup"],
    ActivityIndicator: external_CoreHome_["ActivityIndicator"],
    CrashLog: CrashLog,
    CrashSourceLink: CrashSourceLink,
    Notification: external_CoreHome_["Notification"]
  },
  data: function data() {
    return {
      isContextDisabled: null,
      ignored: false,
      isIgnoring: false
    };
  },
  computed: {
    errorSummaryText: function errorSummaryText() {
      var crash = this.crash;
      var lineAndColumn = [];

      if (typeof crash.resource_line !== 'undefined') {
        lineAndColumn.push('', crash.resource_line);

        if (typeof crash.resource_column !== 'undefined') {
          lineAndColumn.push(crash.resource_column);
        }
      }

      return "".concat(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashSummary'), "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_Message'), ": ").concat(crash.message, "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_Type'), ": ").concat(crash.crash_type, "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_Category'), ": ").concat(crash.category || '-', "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_Source'), ": ").concat(crash.resource_uri).concat(lineAndColumn.join(':'), "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_RecentStackTrace'), ":\n").concat(crash.stack_trace || '-', "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_FirstSeen'), ": ").concat(crash.datetime_first_seen_pretty, "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_LastSeen'), ": ").concat(crash.datetime_last_seen_pretty, "\n").concat(Object(external_CoreHome_["translate"])('CrashAnalytics_LastReappeared'), ": ").concat(crash.datetime_last_reappeared_pretty, "\n").concat(this.crashContextText);
    },
    crashContextText: function crashContextText() {
      if (!CrashLog_CrashContextStore.crashContexts.value.length) {
        return '';
      }

      var crashContexts = CrashLog_CrashContextStore.crashContexts.value.map(function (context) {
        var _context$actionsBefor;

        var lines = [];

        if (context.visit) {
          var occurrenceText = Object(external_CoreHome_["translate"])('CrashAnalytics_DateCrashOccurrence');
          lines.push("".concat(occurrenceText, ": ").concat(context.visit.serverDatePretty, " ").concat(context.visit.serverTimePretty));
          visitInfoToDisplay.forEach(function (_ref) {
            var _context$visit;

            var label = _ref.label,
                prop = _ref.prop;

            if ((_context$visit = context.visit) !== null && _context$visit !== void 0 && _context$visit[prop]) {
              lines.push("".concat(label, ": ").concat(context.visit[prop]));
            }
          });

          if (context.visit.country) {
            var locationParts = [context.visit.country];

            if (context.visit.region) {
              locationParts.push(context.visit.region);
            }

            if (context.visit.city) {
              locationParts.push(context.visit.city);
            }

            var locationText = locationParts.join(', ');
            lines.push("".concat(Object(external_CoreHome_["translate"])('CrashAnalytics_Location'), ": ").concat(locationText));
          }
        }

        if ((_context$actionsBefor = context.actionsBeforeCrash) !== null && _context$actionsBefor !== void 0 && _context$actionsBefor.length) {
          lines.push(Object(external_CoreHome_["translate"])('CrashAnalytics_LastActionsBeforeTheCrash'));
          context.actionsBeforeCrash.forEach(function (action) {
            lines.push("* (".concat(action.type, ") ").concat(action.title));

            if (action.subtitle) {
              lines.push("  ".concat(action.subtitle));
            }
          });
        }

        return lines.join('\n');
      });
      return "--------\n\n".concat(Object(external_CoreHome_["translate"])('CrashAnalytics_ContextInformation'), ":\n\n").concat(crashContexts.join('\n\n'));
    },
    emailErrorLink: function emailErrorLink() {
      var crash = this.crash;
      var subject = "".concat(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashInformation'), ": ").concat(crash.message);
      var body = this.errorSummaryText;
      return "mailto:?subject=".concat(encodeURIComponent(subject), "&body=").concat(encodeURIComponent(body));
    },
    crashStackTrace: function crashStackTrace() {
      return this.crash.stack_trace || Object(external_CoreHome_["translate"])('CrashAnalytics_NoStackTraceFound');
    },
    crashContextDisabledMessage1: function crashContextDisabledMessage1() {
      return Object(external_CoreHome_["translate"])('CrashAnalytics_CrashContextDisabledMessage1', '<a href="TODO" target="_blank" rel="noreferrer noopener">', '</a>');
    },
    crashContextDisabledMessage2: function crashContextDisabledMessage2() {
      return Object(external_CoreHome_["translate"])('CrashAnalytics_CrashContextDisabledMessage2', '<em>', '</em>');
    }
  },
  methods: {
    copyCrashInfo: function copyCrashInfo() {
      var element = this.$refs.copyText;
      element.focus();
      element.select();
      document.execCommand('copy');
      CrashDetailsvue_type_script_lang_ts_$(this.$refs.summary).effect('highlight');
    },
    ignoreCrash: function ignoreCrash() {
      var _this = this;

      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmSetIgnoreContainer, {
        yes: function yes() {
          _this.isIgnoring = true;
          external_CoreHome_["AjaxHelper"].post({
            method: 'CrashAnalytics.setIgnoreCrash',
            idSite: _this.crash.idsite,
            idLogCrash: _this.crash.idlogcrash
          }).then(function () {
            _this.ignored = true;
            external_CoreHome_["NotificationsStore"].show({
              type: 'toast',
              message: Object(external_CoreHome_["translate"])('General_Done'),
              context: 'success',
              group: 'CrashAnalytics_CrashDetails',
              placeat: '-'
            });
            external_CoreHome_["Matomo"].helper.lazyScrollTo(_this.$refs.root, 0);
          }).finally(function () {
            _this.isIgnoring = false;
          });
        }
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.vue



CrashDetailsvue_type_script_lang_ts.render = render

/* harmony default export */ var CrashDetails = (CrashDetailsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashDetails/CrashStore.ts
function CrashStore_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function CrashStore_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function CrashStore_createClass(Constructor, protoProps, staticProps) { if (protoProps) CrashStore_defineProperties(Constructor.prototype, protoProps); if (staticProps) CrashStore_defineProperties(Constructor, staticProps); return Constructor; }

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


var CrashStore_CrashStore = /*#__PURE__*/function () {
  function CrashStore() {
    CrashStore_classCallCheck(this, CrashStore);
  }

  CrashStore_createClass(CrashStore, [{
    key: "fetchCrash",
    value: function fetchCrash(idLogCrash) {
      var overrideParams = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
      return external_CoreHome_["AjaxHelper"].fetch(Object.assign({
        method: 'CrashAnalytics.getCrashSummary',
        idSite: external_CoreHome_["Matomo"].idSite,
        idLogCrash: idLogCrash
      }, overrideParams));
    }
  }]);

  return CrashStore;
}();

/* harmony default export */ var CrashDetails_CrashStore = (new CrashStore_CrashStore());
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/CrashDetails/rowAction.ts
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function rowAction_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function rowAction_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function rowAction_createClass(Constructor, protoProps, staticProps) { if (protoProps) rowAction_defineProperties(Constructor.prototype, protoProps); if (staticProps) rowAction_defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

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



var rowAction_window = window,
    rowAction_$ = rowAction_window.$;
var actionName = 'CrashDetails';

function getIdLogCrashFromRow(tr) {
  try {
    var rowMetadata = JSON.parse(rowAction_$(tr).attr('data-row-metadata'));

    if (!rowMetadata.idlogcrash) {
      return 0;
    }

    return parseInt(rowMetadata.idlogcrash, 10);
  } catch (err) {
    return 0;
  }
} // eslint-disable-next-line


var DataTable_RowAction = window.DataTable_RowAction;

var rowAction_CrashDetailsRowAction = /*#__PURE__*/function (_DataTable_RowAction) {
  _inherits(CrashDetailsRowAction, _DataTable_RowAction);

  var _super = _createSuper(CrashDetailsRowAction);

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  function CrashDetailsRowAction(dataTable) {
    var _this;

    rowAction_classCallCheck(this, CrashDetailsRowAction);

    _this = _super.call(this, dataTable);
    _this.actionName = actionName;
    _this.trEventName = 'piwikTriggerCrashDetailAction';
    return _this;
  }

  rowAction_createClass(CrashDetailsRowAction, [{
    key: "openPopover",
    value: function openPopover(apiAction, idLogCrash, extraParams) {
      var urlParam = "".concat(apiAction, ":").concat(encodeURIComponent(idLogCrash), ":").concat(encodeURIComponent(JSON.stringify(extraParams)));
      broadcast.propagateNewPopoverParameter('RowAction', "".concat(actionName, ":").concat(urlParam));
    }
  }, {
    key: "trigger",
    value: function trigger(tr) {
      var idLogCrash = getIdLogCrashFromRow(tr);

      if (!idLogCrash) {
        return;
      }

      this.performAction(idLogCrash);
    }
  }, {
    key: "performAction",
    value: function performAction(idLogCrash) {
      var apiAction = this.dataTable.param.action;
      this.openPopover(apiAction, idLogCrash, {
        period: this.dataTable.param.period,
        date: this.dataTable.param.date
      });
    }
  }, {
    key: "doOpenPopover",
    value: function doOpenPopover(urlParam) {
      var popover = window.Piwik_Popover.showLoading(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashDetails'));

      var _urlParam$split = urlParam.split(':'),
          _urlParam$split2 = _slicedToArray(_urlParam$split, 3),
          idLogCrashStr = _urlParam$split2[1],
          extraParamsStr = _urlParam$split2[2];

      var idLogCrash = parseInt(idLogCrashStr, 10);

      if (!idLogCrash) {
        return;
      }

      var extraRequestParams = {};

      try {
        extraRequestParams = JSON.parse(decodeURIComponent(extraParamsStr));
      } catch (e) {// ignore
      }

      CrashDetails_CrashStore.fetchCrash(idLogCrash, extraRequestParams).then(function (crash) {
        if (!crash) {
          window.Piwik_Popover.setTitle(Object(external_CoreHome_["translate"])('CrashAnalytics_FailedToLoadCrash'));
          window.Piwik_Popover.setContent(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashDataMissing'));
          popover.dialog();
          return;
        }

        var props = {
          crash: crash,
          extraRequestParams: extraRequestParams
        };
        var app = Object(external_CoreHome_["createVueApp"])({
          template: '<popover v-bind="bind"/>',
          data: function data() {
            return {
              bind: props
            };
          }
        });
        app.component('popover', CrashDetails);
        var mountPoint = document.createElement('div');
        app.mount(mountPoint);
        window.Piwik_Popover.setTitle("\"".concat(crash.message, "\""));
        window.Piwik_Popover.setContent(mountPoint);
        popover.dialog();
      });
    }
  }]);

  return CrashDetailsRowAction;
}(DataTable_RowAction); // eslint-disable-next-line @typescript-eslint/no-explicit-any


window.DataTable_RowActions_Registry.register({
  name: actionName,
  dataTableIcon: 'icon-zoom-in',
  order: 51,
  dataTableIconTooltip: [Object(external_CoreHome_["translate"])('CrashAnalytics_SeeCrashDetails'), ''],
  isAvailableOnReport: function isAvailableOnReport(dataTableParams) {
    return dataTableParams && dataTableParams.module === 'CrashAnalytics';
  },
  isAvailableOnRow: function isAvailableOnRow(dataTableParams, tr) {
    return getIdLogCrashFromRow(tr) > 0;
  },
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  createInstance: function createInstance(dataTable) {
    if (dataTable !== null && typeof dataTable.crashDetailsInstance !== 'undefined') {
      return dataTable.crashDetailsInstance;
    }

    var instance = new rowAction_CrashDetailsRowAction(dataTable);

    if (dataTable !== null) {
      dataTable.crashDetailsInstance = instance;
    }

    return instance;
  }
});
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.vue?vue&type=template&id=66596e58

var MergeCrashesvue_type_template_id_66596e58_hoisted_1 = {
  class: "mergeCrashes"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_2 = {
  class: "intro"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_3 = {
  key: 0,
  class: "notMergable"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_4 = {
  key: 1,
  class: "notMergable"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_5 = {
  class: "searchHeader"
};

var MergeCrashesvue_type_template_id_66596e58_hoisted_6 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, null, -1);

var MergeCrashesvue_type_template_id_66596e58_hoisted_7 = {
  key: 0
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_8 = {
  colspan: "2"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_9 = ["checked", "onChange"];

var MergeCrashesvue_type_template_id_66596e58_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, null, -1);

var MergeCrashesvue_type_template_id_66596e58_hoisted_11 = {
  class: "pagination"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_12 = {
  class: "footer"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_13 = ["disabled"];
var MergeCrashesvue_type_template_id_66596e58_hoisted_14 = {
  class: "ui-confirm confirmMergeCrashes",
  id: "confirmMergeCrashes",
  ref: "confirmMergeCrashes"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_15 = {
  class: "browser-default"
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_16 = ["innerHTML"];
var MergeCrashesvue_type_template_id_66596e58_hoisted_17 = {
  key: 0,
  style: {
    "margin-left": "4px"
  }
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_18 = {
  key: 1,
  style: {
    "margin-left": "4px"
  }
};
var MergeCrashesvue_type_template_id_66596e58_hoisted_19 = ["value"];
var MergeCrashesvue_type_template_id_66596e58_hoisted_20 = ["value"];
function MergeCrashesvue_type_template_id_66596e58_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Notification = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Notification");

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _component_Alert = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Alert");

  var _directive_content_table = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-table");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Merging')) + " '" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.message) + "' @ " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.truncatedResourceUri), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_MergeCrashesIntro1')), 1)]), !_ctx.isMergable && !_ctx.isInline ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Notification, {
    type: "transient",
    context: "info",
    noclear: true
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_CrashHasAlreadyBeenMerged')), 1)];
    }),
    _: 1
  })])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isInline ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Notification, {
    type: "transient",
    context: "info",
    noclear: true
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_InlineCrashesCannotBeMerged')), 1)];
    }),
    _: 1
  })])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isMergable && !_ctx.isInline ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
    key: 2,
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["crashSearch", {
      loading: _ctx.isLoading
    }])
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    modelValue: _ctx.search,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.search = $event;
    }),
    uicontrol: "text",
    placeholder: "".concat(_ctx.translate('CrashAnalytics_EnterSearchTerm'), "...")
  }, null, 8, ["modelValue", "placeholder"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [MergeCrashesvue_type_template_id_66596e58_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_CrashMessage')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [_ctx.searchResults !== null && _ctx.searchResults.length === 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", MergeCrashesvue_type_template_id_66596e58_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", MergeCrashesvue_type_template_id_66596e58_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("em", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NoCrashesToMergeWith')), 1)])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.searchResults || [], function (row) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", {
      key: row.idlogcrash
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("label", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
      type: "checkbox",
      checked: _ctx.selectedCrashes[row.idlogcrash],
      onChange: function onChange($event) {
        return _ctx.selectedCrashes[row.idlogcrash] = _ctx.selectedCrashes[row.idlogcrash] ? undefined : row.message;
      }
    }, null, 40, MergeCrashesvue_type_template_id_66596e58_hoisted_9), MergeCrashesvue_type_template_id_66596e58_hoisted_10])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(row.message), 1)]);
  }), 128))])], 512), [[_directive_content_table]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_11, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    onClick: _cache[1] || (_cache[1] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.prev();
    }, ["prevent"])),
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])([{
      disabled: !_ctx.hasPrev
    }, "prev"])
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Previous')), 3), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["divider", {
      disabled: !_ctx.hasPrev || !_ctx.hasNext
    }])
  }, "—", 2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    onClick: _cache[2] || (_cache[2] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.next();
    }, ["prevent"])),
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])([{
      disabled: !_ctx.hasNext
    }, "next"])
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Next')), 3)])], 2)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    class: "modal-action modal-close btn mergeBtn",
    onClick: _cache[3] || (_cache[3] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.merge();
    }, ["prevent"])),
    style: {
      "margin-right": "3.5px"
    },
    disabled: _ctx.isLoading || _ctx.toMergeCrashes.length < 1 ? 'disabled' : undefined
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Merge')), 9, MergeCrashesvue_type_template_id_66596e58_hoisted_13), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    class: "modal-action modal-close modal-no",
    onClick: _cache[4] || (_cache[4] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.cancel();
    }, ["prevent"]))
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Cancel')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", MergeCrashesvue_type_template_id_66596e58_hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_AreYouSureYouWantToMerge', _ctx.truncatedResourceUri)), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", MergeCrashesvue_type_template_id_66596e58_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("li", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.crash.message), 1), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.toMergeCrashes, function (message, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: index
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(message), 1);
  }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Alert, {
    severity: "info"
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
        innerHTML: _ctx.$sanitize(_ctx.ifMergedTheseCrashesWillAppearAs)
      }, null, 8, MergeCrashesvue_type_template_id_66596e58_hoisted_16), _ctx.reArchiveLastN <= 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", MergeCrashesvue_type_template_id_66596e58_hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ThisWillOnlyApplyToFutureReports')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.reArchiveLastN > 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", MergeCrashesvue_type_template_id_66596e58_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ThisWillApplyToFutureReportsAndSomeInPast', _ctx.reArchiveLastN)), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])];
    }),
    _: 1
  }), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, MergeCrashesvue_type_template_id_66596e58_hoisted_19), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, MergeCrashesvue_type_template_id_66596e58_hoisted_20)], 512)]);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.vue?vue&type=template&id=66596e58

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.vue?vue&type=script&lang=ts
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || MergeCrashesvue_type_script_lang_ts_unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return MergeCrashesvue_type_script_lang_ts_arrayLikeToArray(arr); }

function MergeCrashesvue_type_script_lang_ts_slicedToArray(arr, i) { return MergeCrashesvue_type_script_lang_ts_arrayWithHoles(arr) || MergeCrashesvue_type_script_lang_ts_iterableToArrayLimit(arr, i) || MergeCrashesvue_type_script_lang_ts_unsupportedIterableToArray(arr, i) || MergeCrashesvue_type_script_lang_ts_nonIterableRest(); }

function MergeCrashesvue_type_script_lang_ts_nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function MergeCrashesvue_type_script_lang_ts_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return MergeCrashesvue_type_script_lang_ts_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return MergeCrashesvue_type_script_lang_ts_arrayLikeToArray(o, minLen); }

function MergeCrashesvue_type_script_lang_ts_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function MergeCrashesvue_type_script_lang_ts_iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function MergeCrashesvue_type_script_lang_ts_arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }




var NUMBER_OF_RESULTS_TO_SHOW = 10;
/* harmony default export */ var MergeCrashesvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    crash: {
      type: Object,
      required: true
    }
  },
  directives: {
    ContentTable: external_CoreHome_["ContentTable"]
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"],
    Notification: external_CoreHome_["Notification"],
    Alert: external_CoreHome_["Alert"]
  },
  data: function data() {
    return {
      isLoading: false,
      searchResults: null,
      search: '',
      offset: 0,
      limit: NUMBER_OF_RESULTS_TO_SHOW,
      selectedCrashes: {},
      hasNext: false,
      hasPrev: false
    };
  },
  created: function created() {
    this.onSearchChanged = Object(external_CoreHome_["debounce"])(this.onSearchChanged);
    this.fetch();
  },
  watch: {
    search: function search() {
      this.onSearchChanged();
    }
  },
  methods: {
    onSearchChanged: function onSearchChanged() {
      this.fetch();
    },
    fetch: function fetch() {
      var _this = this;

      var crash = this.crash;
      this.isLoading = true;
      external_CoreHome_["AjaxHelper"].fetch({
        method: 'CrashAnalytics.searchCrashMessagesForMerge',
        searchTerm: this.search,
        resourceUri: crash.resource_uri,
        limit: this.limit + 1,
        offset: this.offset,
        excludeIdLogCrashes: [crash.idlogcrash]
      }).then(function (results) {
        _this.hasNext = results.length > _this.limit;
        _this.hasPrev = _this.offset > 0;
        _this.searchResults = results.slice(0, _this.limit);
      }).finally(function () {
        _this.isLoading = false;
      });
    },
    prev: function prev() {
      if (this.offset <= 0) {
        return;
      }

      this.offset -= this.limit;
      this.fetch();
    },
    next: function next() {
      if (!this.hasNext) {
        return;
      }

      this.offset += this.limit;
      this.fetch();
    },
    merge: function merge() {
      var _this2 = this;

      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmMergeCrashes, {
        yes: function yes() {
          var idLogCrashes = Object.entries(_this2.selectedCrashes).filter(function (_ref) {
            var _ref2 = MergeCrashesvue_type_script_lang_ts_slicedToArray(_ref, 2),
                message = _ref2[1];

            return !!message;
          }).map(function (_ref3) {
            var _ref4 = MergeCrashesvue_type_script_lang_ts_slicedToArray(_ref3, 1),
                idlogcrash = _ref4[0];

            return idlogcrash;
          }).concat([_this2.crash.idlogcrash]);
          _this2.isLoading = true;
          external_CoreHome_["AjaxHelper"].fetch({
            method: 'CrashAnalytics.mergeCrashes',
            idLogCrashes: idLogCrashes
          }).then(function () {
            window.Piwik_Popover.close();
            external_CoreHome_["NotificationsStore"].scrollToNotification(external_CoreHome_["NotificationsStore"].show({
              id: 'mergeSuccess',
              message: Object(external_CoreHome_["translate"])('CrashAnalytics_MergeSuccess'),
              context: 'success',
              type: 'toast'
            }));
          });
        }
      });
    },
    cancel: function cancel() {
      window.Piwik_Popover.close();
    }
  },
  computed: {
    isInline: function isInline() {
      var crash = this.crash;
      return crash.resource_uri === 'inline';
    },
    truncatedResourceUri: function truncatedResourceUri() {
      var crash = this.crash;
      var resourceUri = crash.resource_uri || Object(external_CoreHome_["translate"])('General_Unknown');

      if (resourceUri.length > 100) {
        return "".concat(resourceUri.substring(0, 100), "...");
      }

      return resourceUri;
    },
    toMergeCrashes: function toMergeCrashes() {
      return Object.values(this.selectedCrashes).filter(function (m) {
        return !!m;
      }).sort();
    },
    isMergable: function isMergable() {
      var crash = this.crash;
      return !crash.group_idlogcrash || crash.group_idlogcrash === crash.idlogcrash;
    },
    lowestIdlogcrashMessage: function lowestIdlogcrashMessage() {
      var crash = this.crash;
      var selectedCrashes = Object.entries(this.selectedCrashes).map(function (_ref5) {
        var _ref6 = MergeCrashesvue_type_script_lang_ts_slicedToArray(_ref5, 2),
            idlogcrash = _ref6[0],
            message = _ref6[1];

        return {
          idlogcrash: parseInt(idlogcrash, 10),
          message: message
        };
      });
      var allCrashesInMerge = [].concat(_toConsumableArray(selectedCrashes), [crash]);
      allCrashesInMerge.sort(function (lhs, rhs) {
        return lhs.idlogcrash - rhs.idlogcrash;
      });
      return "<em>\"".concat(allCrashesInMerge[0].message, "\"</em>");
    },
    ifMergedTheseCrashesWillAppearAs: function ifMergedTheseCrashesWillAppearAs() {
      return Object(external_CoreHome_["translate"])('CrashAnalytics_IfMergedTheseCrashesWillAppearAs', this.lowestIdlogcrashMessage);
    },
    reArchiveLastN: function reArchiveLastN() {
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      return external_CoreHome_["Matomo"].CrashAnalytics.reArchiveReportsLastN;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.vue



MergeCrashesvue_type_script_lang_ts.render = MergeCrashesvue_type_template_id_66596e58_render

/* harmony default export */ var MergeCrashes = (MergeCrashesvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/MergeCrashes/rowAction.ts
function rowAction_typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { rowAction_typeof = function _typeof(obj) { return typeof obj; }; } else { rowAction_typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return rowAction_typeof(obj); }

function rowAction_slicedToArray(arr, i) { return rowAction_arrayWithHoles(arr) || rowAction_iterableToArrayLimit(arr, i) || rowAction_unsupportedIterableToArray(arr, i) || rowAction_nonIterableRest(); }

function rowAction_nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function rowAction_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return rowAction_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return rowAction_arrayLikeToArray(o, minLen); }

function rowAction_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function rowAction_iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function rowAction_arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function MergeCrashes_rowAction_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function MergeCrashes_rowAction_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function MergeCrashes_rowAction_createClass(Constructor, protoProps, staticProps) { if (protoProps) MergeCrashes_rowAction_defineProperties(Constructor.prototype, protoProps); if (staticProps) MergeCrashes_rowAction_defineProperties(Constructor, staticProps); return Constructor; }

function rowAction_inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) rowAction_setPrototypeOf(subClass, superClass); }

function rowAction_setPrototypeOf(o, p) { rowAction_setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return rowAction_setPrototypeOf(o, p); }

function rowAction_createSuper(Derived) { var hasNativeReflectConstruct = rowAction_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = rowAction_getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = rowAction_getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return rowAction_possibleConstructorReturn(this, result); }; }

function rowAction_possibleConstructorReturn(self, call) { if (call && (rowAction_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return rowAction_assertThisInitialized(self); }

function rowAction_assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function rowAction_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function rowAction_getPrototypeOf(o) { rowAction_getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return rowAction_getPrototypeOf(o); }

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



var MergeCrashes_rowAction_window = window,
    MergeCrashes_rowAction_$ = MergeCrashes_rowAction_window.$;
var rowAction_actionName = 'MergeCrashes';

function rowAction_getIdLogCrashFromRow(tr) {
  try {
    var rowMetadata = JSON.parse(MergeCrashes_rowAction_$(tr).attr('data-row-metadata'));

    if (!rowMetadata.idlogcrash) {
      return 0;
    }

    return parseInt(rowMetadata.idlogcrash, 10);
  } catch (err) {
    return 0;
  }
} // eslint-disable-next-line


var rowAction_DataTable_RowAction = window.DataTable_RowAction;

var rowAction_MergeCrashesRowAction = /*#__PURE__*/function (_DataTable_RowAction) {
  rowAction_inherits(MergeCrashesRowAction, _DataTable_RowAction);

  var _super = rowAction_createSuper(MergeCrashesRowAction);

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  function MergeCrashesRowAction(dataTable) {
    var _this;

    MergeCrashes_rowAction_classCallCheck(this, MergeCrashesRowAction);

    _this = _super.call(this, dataTable);
    _this.actionName = rowAction_actionName;
    _this.trEventName = 'piwikTriggerMergeCrashesAction';
    return _this;
  }

  MergeCrashes_rowAction_createClass(MergeCrashesRowAction, [{
    key: "openPopover",
    value: function openPopover(apiAction, idLogCrash) {
      var urlParam = "".concat(apiAction, ":").concat(encodeURIComponent(idLogCrash));
      broadcast.propagateNewPopoverParameter('RowAction', "".concat(rowAction_actionName, ":").concat(urlParam));
    }
  }, {
    key: "trigger",
    value: function trigger(tr) {
      var idLogCrash = rowAction_getIdLogCrashFromRow(tr);

      if (!idLogCrash) {
        return;
      }

      this.performAction(idLogCrash);
    }
  }, {
    key: "performAction",
    value: function performAction(idLogCrash) {
      var apiAction = this.dataTable.param.action;
      this.openPopover(apiAction, idLogCrash);
    }
  }, {
    key: "doOpenPopover",
    value: function doOpenPopover(urlParam) {
      var popover = window.Piwik_Popover.showLoading(Object(external_CoreHome_["translate"])('CrashAnalytics_MergeCrashes')); // TODO translate

      var _urlParam$split = urlParam.split(':'),
          _urlParam$split2 = rowAction_slicedToArray(_urlParam$split, 2),
          idLogCrashStr = _urlParam$split2[1];

      var idLogCrash = parseInt(idLogCrashStr, 10);

      if (!idLogCrash) {
        return;
      }

      CrashDetails_CrashStore.fetchCrash(idLogCrash, {}).then(function (crash) {
        if (!crash) {
          window.Piwik_Popover.setTitle(Object(external_CoreHome_["translate"])('CrashAnalytics_FailedToLoadCrash'));
          window.Piwik_Popover.setContent(Object(external_CoreHome_["translate"])('CrashAnalytics_CrashDataMissing'));
          popover.dialog();
          return;
        }

        var props = {
          crash: crash
        };
        var app = Object(external_CoreHome_["createVueApp"])({
          template: '<popover v-bind="bind"/>',
          data: function data() {
            return {
              bind: props
            };
          }
        });
        app.component('popover', MergeCrashes);
        var mountPoint = document.createElement('div');
        app.mount(mountPoint);
        window.Piwik_Popover.setTitle(Object(external_CoreHome_["translate"])('CrashAnalytics_MergeCrashes'));
        window.Piwik_Popover.setContent(mountPoint);
        popover.dialog();
      });
    }
  }]);

  return MergeCrashesRowAction;
}(rowAction_DataTable_RowAction); // eslint-disable-next-line @typescript-eslint/no-explicit-any


window.DataTable_RowActions_Registry.register({
  name: rowAction_actionName,
  dataTableIcon: 'plugins/CrashAnalytics/images/merge.svg',
  order: 52,
  dataTableIconTooltip: [Object(external_CoreHome_["translate"])('CrashAnalytics_MergeCrashes'), ''],
  isAvailableOnReport: function isAvailableOnReport(dataTableParams) {
    return dataTableParams && dataTableParams.module === 'CrashAnalytics';
  },
  isAvailableOnRow: function isAvailableOnRow(dataTableParams, tr) {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    return external_CoreHome_["Matomo"].CrashAnalytics.hasWriteAccess && rowAction_getIdLogCrashFromRow(tr) > 0;
  },
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  createInstance: function createInstance(dataTable) {
    if (dataTable !== null && typeof dataTable.mergeCrashesInstance !== 'undefined') {
      return dataTable.mergeCrashesInstance;
    }

    var instance = new rowAction_MergeCrashesRowAction(dataTable);

    if (dataTable !== null) {
      dataTable.mergeCrashesInstance = instance;
    }

    return instance;
  }
});
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.vue?vue&type=template&id=1083fcd2

var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_1 = {
  class: "message"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_2 = {
  class: "type"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_3 = {
  class: "source"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_4 = {
  class: "ignoredSince"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_5 = {
  class: "firstSeen"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_6 = {
  class: "action"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_7 = {
  colspan: "7"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_8 = {
  class: "loadingPiwik"
};

var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_9 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/Morpheus/images/loading-blue.gif"
}, null, -1);

var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_10 = {
  colspan: "7"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_11 = ["id"];
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_12 = {
  class: "message"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_13 = {
  class: "type"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_14 = {
  class: "source"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_15 = {
  class: "ignoredSince"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_16 = {
  class: "firstSeen"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_17 = {
  class: "action"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_18 = ["title", "onClick"];
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_19 = {
  class: "ui-confirm confirmUnignoreIgnoreContainer",
  ref: "confirmUnignoreIgnoreContainer"
};
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_20 = ["value"];
var ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_21 = ["value"];
function ManageIgnoredCrashesvue_type_template_id_1083fcd2_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this = this;

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  var _directive_content_table = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-table");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    class: "manageIgnoredCrashes",
    "content-title": _ctx.translate('CrashAnalytics_IgnoredCrashesWidget'),
    feature: _ctx.translate('CrashAnalytics_IgnoredCrashesWidget')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      var _this$crashToUnignore;

      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ManageIgnoreIntro1')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ManageIgnoreIntro2')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Message')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Type')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Source')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_IgnoredSince')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_FirstSeen')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Actions')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_8, [ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)])])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isLoading || _ctx.isUpdating]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NoCrashesIgnored')), 1)])], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isLoading && _ctx.ignored.length === 0]]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.ignored, function (crash) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", {
          id: "crash".concat(crash.idlogcrash),
          class: "crashes",
          key: crash.idlogcrash
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.message), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.crash_type), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.resource_uri), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.date_ignored_error_pretty), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_16, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.date_first_seen_pretty), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_17, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          class: "table-action icon-show unignoreCrash",
          title: _ctx.translate('CrashAnalytics_UnignoreThisCrash'),
          onClick: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
            return _ctx.unignore(crash);
          }, ["prevent"])
        }, null, 8, ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_18)])], 8, ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_11);
      }), 128))])], 512), [[_directive_content_table]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_19, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_ConfirmUnignore', (_this$crashToUnignore = _this.crashToUnignore) === null || _this$crashToUnignore === void 0 ? void 0 : _this$crashToUnignore.message)), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "yes",
        type: "button",
        value: _ctx.translate('General_Yes')
      }, null, 8, ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_20), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "no",
        type: "button",
        value: _ctx.translate('General_No')
      }, null, 8, ManageIgnoredCrashesvue_type_template_id_1083fcd2_hoisted_21)], 512)];
    }),
    _: 1
  }, 8, ["content-title", "feature"]);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.vue?vue&type=template&id=1083fcd2

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.vue?vue&type=script&lang=ts


/* harmony default export */ var ManageIgnoredCrashesvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"]
  },
  directives: {
    ContentTable: external_CoreHome_["ContentTable"]
  },
  data: function data() {
    return {
      ignored: [],
      isLoading: false,
      isUpdating: false,
      crashToUnignore: null
    };
  },
  created: function created() {
    this.fetch();
  },
  methods: {
    fetch: function fetch() {
      var _this = this;

      this.isLoading = true;
      external_CoreHome_["AjaxHelper"].fetch({
        method: 'CrashAnalytics.getIgnoredCrashes'
      }).then(function (crashes) {
        _this.ignored = crashes;
      }).finally(function () {
        _this.isLoading = false;
      });
    },
    unignore: function unignore(crash) {
      var _this2 = this;

      this.crashToUnignore = crash;
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmUnignoreIgnoreContainer, {
        yes: function yes() {
          _this2.isUpdating = true;
          external_CoreHome_["AjaxHelper"].fetch({
            method: 'CrashAnalytics.setIgnoreCrash',
            idSite: external_CoreHome_["Matomo"].idSite,
            idLogCrash: crash.idlogcrash,
            ignore: 0
          }).then(function () {
            external_CoreHome_["NotificationsStore"].show({
              type: 'toast',
              message: Object(external_CoreHome_["translate"])('General_Done'),
              context: 'success'
            });
            external_CoreHome_["Matomo"].helper.lazyScrollTo(_this2.$refs.root, 0);
            return _this2.fetch();
          }).finally(function () {
            _this2.isUpdating = false;
            _this2.crashToUnignore = null;
          });
        }
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.vue



ManageIgnoredCrashesvue_type_script_lang_ts.render = ManageIgnoredCrashesvue_type_template_id_1083fcd2_render

/* harmony default export */ var ManageIgnoredCrashes = (ManageIgnoredCrashesvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.vue?vue&type=template&id=6365d13f

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_1 = {
  key: 0
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_2 = {
  colspan: "4"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_3 = {
  class: "groupHeader"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_4 = {
  class: "firstGroupMessage"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_5 = {
  class: "groupDetails"
};

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_6 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
  class: "leftBar"
}, null, -1);

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_7 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "dash"
}, null, -1);

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_8 = {
  class: "message"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_9 = ["title", "onClick"];

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
  src: "plugins/CrashAnalytics/images/merge_black.svg"
}, null, -1);

var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_11 = [UnmergeCrashesvue_type_template_id_6365d13f_hoisted_10];
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_12 = {
  class: "ui-confirm confirmUnmergeCrashes",
  id: "confirmUnmergeCrashes",
  ref: "confirmUnmergeCrashes"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_13 = {
  class: "browser-default"
};
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_14 = ["value"];
var UnmergeCrashesvue_type_template_id_6365d13f_hoisted_15 = ["value"];
function UnmergeCrashesvue_type_template_id_6365d13f_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Passthrough = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Passthrough");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  var _directive_content_table = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("content-table");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    "content-title": _ctx.translate('CrashAnalytics_UnmergeCrashes'),
    feature: _ctx.translate('CrashAnalytics_UnmergeCrashes'),
    class: "unmergeCrashes"
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_UnmergeCrashesIntro')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])({
          loading: _ctx.isLoading
        })
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Messages')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Type')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_Source')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Actions')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [_ctx.crashGroups !== null && _ctx.crashGroups.length === 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_NoCrashesMerged')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.crashGroups || [], function (group, key) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_Passthrough, {
          key: key
        }, {
          default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
            return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(group[0].message), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_5, [UnmergeCrashesvue_type_template_id_6365d13f_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", null, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(group.slice(1), function (crash) {
              return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
                key: crash.idlogcrash
              }, [UnmergeCrashesvue_type_template_id_6365d13f_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.message), 1)]);
            }), 128))])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(group[0].crash_type), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(group[0].resource_uri || _ctx.translate('General_Unknown')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
              class: "table-action unmerge",
              title: _ctx.translate('CrashAnalytics_UnmergeThisCrash'),
              onClick: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
                return _ctx.unmerge(group);
              }, ["prevent"])
            }, UnmergeCrashesvue_type_template_id_6365d13f_hoisted_11, 8, UnmergeCrashesvue_type_template_id_6365d13f_hoisted_9)])])];
          }),
          _: 2
        }, 1024);
      }), 128))])], 2), [[_directive_content_table]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CrashAnalytics_AreYouSureYouWantToUnmerge')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", UnmergeCrashesvue_type_template_id_6365d13f_hoisted_13, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.groupToUnmerge || [], function (crash, index) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
          key: index
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(crash.message), 1);
      }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "no",
        type: "button",
        value: _ctx.translate('General_No')
      }, null, 8, UnmergeCrashesvue_type_template_id_6365d13f_hoisted_14), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        role: "yes",
        type: "button",
        value: _ctx.translate('General_Yes')
      }, null, 8, UnmergeCrashesvue_type_template_id_6365d13f_hoisted_15)], 512)];
    }),
    _: 1
  }, 8, ["content-title", "feature"]);
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.vue?vue&type=template&id=6365d13f

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/Passthrough/Passthrough.vue?vue&type=template&id=7e964a06

function Passthroughvue_type_template_id_7e964a06_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderSlot"])(_ctx.$slots, "default");
}
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/Passthrough/Passthrough.vue?vue&type=template&id=7e964a06

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/Passthrough/Passthrough.vue?vue&type=script&lang=ts

/* harmony default export */ var Passthroughvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/Passthrough/Passthrough.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/Passthrough/Passthrough.vue



Passthroughvue_type_script_lang_ts.render = Passthroughvue_type_template_id_7e964a06_render

/* harmony default export */ var Passthrough = (Passthroughvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.vue?vue&type=script&lang=ts



/* harmony default export */ var UnmergeCrashesvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"],
    Passthrough: Passthrough
  },
  directives: {
    ContentTable: external_CoreHome_["ContentTable"]
  },
  data: function data() {
    return {
      isLoading: false,
      crashGroups: null,
      groupToUnmerge: null
    };
  },
  created: function created() {
    this.fetch();
  },
  methods: {
    fetch: function fetch() {
      var _this = this;

      this.isLoading = true;
      external_CoreHome_["AjaxHelper"].fetch({
        method: 'CrashAnalytics.getCrashGroups'
      }).then(function (crashGroups) {
        _this.crashGroups = crashGroups;
      }).finally(function () {
        _this.isLoading = false;
      });
    },
    unmerge: function unmerge(group) {
      var _this2 = this;

      this.groupToUnmerge = group;
      external_CoreHome_["Matomo"].helper.modalConfirm(this.$refs.confirmUnmergeCrashes, {
        yes: function yes() {
          _this2.isLoading = true;
          external_CoreHome_["AjaxHelper"].fetch({
            method: 'CrashAnalytics.unmergeCrashGroup',
            idLogCrash: group[0].idlogcrash
          }).then(function () {
            external_CoreHome_["NotificationsStore"].scrollToNotification(external_CoreHome_["NotificationsStore"].show({
              id: 'unmergeSuccess',
              message: Object(external_CoreHome_["translate"])('CrashAnalytics_UnmergeSuccess'),
              context: 'success',
              type: 'toast'
            }));

            _this2.fetch();
          });
        }
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.vue



UnmergeCrashesvue_type_script_lang_ts.render = UnmergeCrashesvue_type_template_id_6365d13f_render

/* harmony default export */ var UnmergeCrashes = (UnmergeCrashesvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/CrashAnalytics/vue/src/index.ts
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
//# sourceMappingURL=CrashAnalytics.umd.js.map