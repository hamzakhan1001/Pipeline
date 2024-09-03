(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", ], factory);
	else if(typeof exports === 'object')
		exports["ActivityLog"] = factory(require("CoreHome"), require("vue"));
	else
		root["ActivityLog"] = factory(root["CoreHome"], root["Vue"]);
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE__19dc__, __WEBPACK_EXTERNAL_MODULE__8bbf__) {
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
/******/ 	__webpack_require__.p = "plugins/ActivityLog/vue/dist/";
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

/***/ "fae3":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "ActivityLog", function() { return /* reexport */ ActivityLog; });
__webpack_require__.d(__webpack_exports__, "ActivityLogPage", function() { return /* reexport */ ActivityLogPage; });

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

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.vue?vue&type=template&id=5951c47a

var _hoisted_1 = {
  class: "ActivityLog"
};
var _hoisted_2 = {
  class: "paging-wrapper"
};
var _hoisted_3 = {
  class: "activity-list"
};
var _hoisted_4 = ["onMouseleave"];
var _hoisted_5 = ["src", "onClick"];
var _hoisted_6 = ["src", "title"];
var _hoisted_7 = ["onMouseover", "onMouseleave", "data-timestamp"];

var _hoisted_8 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, "(UTC)", -1);

var _hoisted_9 = ["onMouseover", "onMouseleave", "data-timestamp"];
var _hoisted_10 = {
  class: "activity-action"
};
var _hoisted_11 = ["onClick"];
var _hoisted_12 = {
  key: 0
};
var _hoisted_13 = {
  key: 1
};
var _hoisted_14 = {
  key: 2
};
var _hoisted_15 = {
  key: 0
};
var _hoisted_16 = ["onMouseleave"];
var _hoisted_17 = {
  key: 0,
  class: "paging-wrapper"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Paging = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Paging");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Paging)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_3, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.activities, function (activity) {
    var _activity$parameters;

    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
      class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["activity row", {
        loading: _ctx.busy
      }]),
      key: activity.id
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
      class: "col m6",
      onMouseleave: function onMouseleave($event) {
        return _ctx.showTimezone[activity.id] = false;
      }
    }, [activity.avatar ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
      key: 0,
      width: "40",
      class: "activity-avatar",
      src: activity.avatar,
      onClick: function onClick($event) {
        return _ctx.applyFilter(activity.user_login);
      }
    }, null, 8, _hoisted_5)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), activity.ip || activity.country ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("img", {
      key: 1,
      class: "activity-country",
      src: activity.country_flag,
      title: _ctx.getActivityCountryTooltip(activity)
    }, null, 8, _hoisted_6)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
      class: "activity-time",
      onMouseover: function onMouseover($event) {
        return _ctx.showTimezone[activity.id] = true;
      },
      onMouseleave: function onMouseleave($event) {
        return _ctx.showTimezone[activity.id] = false;
      },
      "data-timestamp": activity.datetime
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(activity.datetime_pretty) + " ", 1), _hoisted_8], 40, _hoisted_7), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.showTimezone[activity.id] || !activity.time_relative_pretty]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
      class: "activity-time",
      onMouseover: function onMouseover($event) {
        return _ctx.showTimezone[activity.id] = true;
      },
      onMouseleave: function onMouseleave($event) {
        return _ctx.showTimezone[activity.id] = false;
      },
      "data-timestamp": activity.datetime
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(activity.time_relative_pretty), 41, _hoisted_9), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.showTimezone[activity.id] && activity.time_relative_pretty]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
      class: "activity-action-login",
      onClick: function onClick($event) {
        return _ctx.applyFilter(activity.user_login);
      }
    }, [activity.user_login === 'Console Command' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ConsoleCommand')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), activity.user_login === 'Matomo System' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_System')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), activity.user_login !== 'Console Command' && activity.user_login !== 'Matomo System' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("strong", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(activity.user_login), 1), !_ctx.availableUsers.find(function (u) {
      return u.key === activity.user_login;
    }) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_15, " (" + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CorePluginsAdmin_Inactive')) + ") ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 8, _hoisted_11), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(activity.description), 1)])], 40, _hoisted_4), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
      class: "activity-items col m6",
      onMouseleave: function onMouseleave($event) {
        return _ctx.showTimezone[activity.id] = false;
      }
    }, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(((_activity$parameters = activity.parameters) === null || _activity$parameters === void 0 ? void 0 : _activity$parameters.items) || [], function (item, index) {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
        class: "activity-item",
        key: index
      }, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDynamicComponent"])(_ctx.itemToComponent[item.type]), {
        item: item
      }, null, 8, ["item"]))]);
    }), 128))], 40, _hoisted_16)], 2);
  }), 128)), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "no-entries activity"
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_NoActivities')), 513), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.activities.length && !_ctx.busy]])]), _ctx.showPagingBottom ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_17, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Paging)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.vue?vue&type=template&id=5951c47a

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemAccess.vue?vue&type=template&id=65eb7844


var ItemAccessvue_type_template_id_65eb7844_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-admin-settings"
}, null, -1);

var ItemAccessvue_type_template_id_65eb7844_hoisted_2 = {
  class: "item-name"
};
var ItemAccessvue_type_template_id_65eb7844_hoisted_3 = {
  class: "item-data-text"
};
var ItemAccessvue_type_template_id_65eb7844_hoisted_4 = {
  key: 0
};
var ItemAccessvue_type_template_id_65eb7844_hoisted_5 = {
  key: 1
};
var ItemAccessvue_type_template_id_65eb7844_hoisted_6 = {
  key: 2
};
function ItemAccessvue_type_template_id_65eb7844_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemAccessvue_type_template_id_65eb7844_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemAccessvue_type_template_id_65eb7844_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Access')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemAccessvue_type_template_id_65eb7844_hoisted_3, [_ctx.item.data.access === 'view' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemAccessvue_type_template_id_65eb7844_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('UsersManager_PrivView')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.access === 'admin' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemAccessvue_type_template_id_65eb7844_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('UsersManager_PrivAdmin')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.access !== 'admin' && _ctx.item.data.access !== 'view' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemAccessvue_type_template_id_65eb7844_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('UsersManager_PrivNone')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAccess.vue?vue&type=template&id=65eb7844

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemAccess.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemAccessvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAccess.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAccess.vue



ItemAccessvue_type_script_lang_ts.render = ItemAccessvue_type_template_id_65eb7844_render

/* harmony default export */ var ItemAccess = (ItemAccessvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemAnnotation.vue?vue&type=template&id=5a6ad4ae


var ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-calendar"
}, null, -1);

var ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_2 = {
  class: "item-data-text"
};

var ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-annotation"
}, null, -1);

var ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_4 = {
  class: "item-name"
};
function ItemAnnotationvue_type_template_id_5a6ad4ae_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.date) + ":", 1), ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemAnnotationvue_type_template_id_5a6ad4ae_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.text), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAnnotation.vue?vue&type=template&id=5a6ad4ae

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemAnnotation.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemAnnotationvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAnnotation.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemAnnotation.vue



ItemAnnotationvue_type_script_lang_ts.render = ItemAnnotationvue_type_template_id_5a6ad4ae_render

/* harmony default export */ var ItemAnnotation = (ItemAnnotationvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCapability.vue?vue&type=template&id=7d9dde52


var ItemCapabilityvue_type_template_id_7d9dde52_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-admin-settings"
}, null, -1);

var ItemCapabilityvue_type_template_id_7d9dde52_hoisted_2 = {
  class: "item-name"
};
var ItemCapabilityvue_type_template_id_7d9dde52_hoisted_3 = ["title"];
function ItemCapabilityvue_type_template_id_7d9dde52_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemCapabilityvue_type_template_id_7d9dde52_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCapabilityvue_type_template_id_7d9dde52_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Capability')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    class: "item-data-text",
    title: _ctx.item.data.description
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.category) + " > " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 9, ItemCapabilityvue_type_template_id_7d9dde52_hoisted_3)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCapability.vue?vue&type=template&id=7d9dde52

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCapability.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemCapabilityvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCapability.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCapability.vue



ItemCapabilityvue_type_script_lang_ts.render = ItemCapabilityvue_type_template_id_7d9dde52_render

/* harmony default export */ var ItemCapability = (ItemCapabilityvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomAlert.vue?vue&type=template&id=5360b462


var ItemCustomAlertvue_type_template_id_5360b462_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-table"
}, null, -1);

var ItemCustomAlertvue_type_template_id_5360b462_hoisted_2 = {
  class: "item-name"
};
var ItemCustomAlertvue_type_template_id_5360b462_hoisted_3 = {
  class: "item-data-title"
};
var ItemCustomAlertvue_type_template_id_5360b462_hoisted_4 = {
  class: "item-data-text"
};
var ItemCustomAlertvue_type_template_id_5360b462_hoisted_5 = {
  class: "item-data-title"
};
var ItemCustomAlertvue_type_template_id_5360b462_hoisted_6 = {
  class: "item-data-text"
};
function ItemCustomAlertvue_type_template_id_5360b462_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemCustomAlertvue_type_template_id_5360b462_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomAlertvue_type_template_id_5360b462_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomAlertvue_type_template_id_5360b462_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Period')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomAlertvue_type_template_id_5360b462_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.period), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomAlertvue_type_template_id_5360b462_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Report')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomAlertvue_type_template_id_5360b462_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.report), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomAlert.vue?vue&type=template&id=5360b462

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomAlert.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemCustomAlertvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomAlert.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomAlert.vue



ItemCustomAlertvue_type_script_lang_ts.render = ItemCustomAlertvue_type_template_id_5360b462_render

/* harmony default export */ var ItemCustomAlert = (ItemCustomAlertvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomDimension.vue?vue&type=template&id=6f969bd2


var ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-segment"
}, null, -1);

var ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_2 = {
  class: "item-name"
};

var ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title"
}, null, -1);

var ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_4 = {
  class: "item-data-text"
};
function ItemCustomDimensionvue_type_template_id_6f969bd2_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1), ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemCustomDimensionvue_type_template_id_6f969bd2_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.trackingScopeText), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomDimension.vue?vue&type=template&id=6f969bd2

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomDimension.vue?vue&type=script&lang=ts


/* harmony default export */ var ItemCustomDimensionvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  computed: {
    trackingScopeText: function trackingScopeText() {
      var scope = this.item.data.scope;
      scope = "".concat(scope.substr(0, 1).toUpperCase()).concat(scope.substr(1));
      return Object(external_CoreHome_["translate"])("General_TrackingScope".concat(scope));
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomDimension.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemCustomDimension.vue



ItemCustomDimensionvue_type_script_lang_ts.render = ItemCustomDimensionvue_type_template_id_6f969bd2_render

/* harmony default export */ var ItemCustomDimension = (ItemCustomDimensionvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoal.vue?vue&type=template&id=09d19654


var ItemGoalvue_type_template_id_09d19654_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-reporting-goal"
}, null, -1);

var ItemGoalvue_type_template_id_09d19654_hoisted_2 = {
  class: "item-name"
};
var ItemGoalvue_type_template_id_09d19654_hoisted_3 = {
  key: 0
};
var ItemGoalvue_type_template_id_09d19654_hoisted_4 = {
  class: "item-data-title"
};
var ItemGoalvue_type_template_id_09d19654_hoisted_5 = {
  class: "item-data-text"
};
function ItemGoalvue_type_template_id_09d19654_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemGoalvue_type_template_id_09d19654_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoalvue_type_template_id_09d19654_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1), _ctx.item.data.revenue && _ctx.item.data.revenue !== '0' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoalvue_type_template_id_09d19654_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoalvue_type_template_id_09d19654_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_ColumnRevenue')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoalvue_type_template_id_09d19654_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.revenue), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoal.vue?vue&type=template&id=09d19654

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoal.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemGoalvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoal.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoal.vue



ItemGoalvue_type_script_lang_ts.render = ItemGoalvue_type_template_id_09d19654_render

/* harmony default export */ var ItemGoal = (ItemGoalvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemMeasurable.vue?vue&type=template&id=e7df0fd0

var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_1 = {
  class: "item-name"
};

var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-icon icon-open-source"
}, null, -1);

var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_3 = {
  class: "item-data-title"
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_4 = {
  class: "item-data-text"
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_5 = {
  class: "item-data-title"
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_6 = {
  class: "item-data-text"
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_7 = {
  key: 0
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_8 = {
  class: "item-data-title"
};
var ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_9 = {
  class: "item-data-text"
};
function ItemMeasurablevue_type_template_id_e7df0fd0_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_1, [ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('SitesManager_Type')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.type), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_SiteID')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.id), 1), _ctx.item.data.urls.length > 0 && _ctx.item.data.urls.join('') !== '' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('SitesManager_Urls')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemMeasurablevue_type_template_id_e7df0fd0_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.urls.join(', ')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemMeasurable.vue?vue&type=template&id=e7df0fd0

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemMeasurable.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemMeasurablevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemMeasurable.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemMeasurable.vue



ItemMeasurablevue_type_script_lang_ts.render = ItemMeasurablevue_type_template_id_e7df0fd0_render

/* harmony default export */ var ItemMeasurable = (ItemMeasurablevue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemPlugin.vue?vue&type=template&id=52ec04d2


var ItemPluginvue_type_template_id_52ec04d2_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-admin-development"
}, null, -1);

var ItemPluginvue_type_template_id_52ec04d2_hoisted_2 = {
  class: "item-name"
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_3 = {
  class: "item-data-text"
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_4 = {
  key: 0
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_5 = {
  key: 1
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_6 = {
  key: 2
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_7 = {
  key: 3
};
var ItemPluginvue_type_template_id_52ec04d2_hoisted_8 = {
  key: 4
};
function ItemPluginvue_type_template_id_52ec04d2_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemPluginvue_type_template_id_52ec04d2_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Plugin')) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_3, [_ctx.item.data.active === true ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CorePluginsAdmin_Active')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.active === false ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CorePluginsAdmin_Inactive')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.installed === true ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Installed')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.installed === false ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_NotInstalled')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.version ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPluginvue_type_template_id_52ec04d2_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CorePluginsAdmin_Version')) + " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.version), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPlugin.vue?vue&type=template&id=52ec04d2

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemPlugin.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemPluginvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPlugin.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPlugin.vue



ItemPluginvue_type_script_lang_ts.render = ItemPluginvue_type_template_id_52ec04d2_render

/* harmony default export */ var ItemPlugin = (ItemPluginvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemScheduledReport.vue?vue&type=template&id=08335c81


var ItemScheduledReportvue_type_template_id_08335c81_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-table"
}, null, -1);

var ItemScheduledReportvue_type_template_id_08335c81_hoisted_2 = {
  class: "item-name"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_3 = {
  class: "item-data-title"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_4 = {
  class: "item-data-text"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_5 = {
  class: "item-data-title"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_6 = {
  class: "item-data-text"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_7 = {
  class: "item-data-title"
};
var ItemScheduledReportvue_type_template_id_08335c81_hoisted_8 = {
  class: "item-data-text"
};
function ItemScheduledReportvue_type_template_id_08335c81_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemScheduledReportvue_type_template_id_08335c81_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.description), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('Live_GoalType')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.type), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ScheduledReports_ReportFormat')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.format), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Period')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemScheduledReportvue_type_template_id_08335c81_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.period), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemScheduledReport.vue?vue&type=template&id=08335c81

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemScheduledReport.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemScheduledReportvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemScheduledReport.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemScheduledReport.vue



ItemScheduledReportvue_type_script_lang_ts.render = ItemScheduledReportvue_type_template_id_08335c81_render

/* harmony default export */ var ItemScheduledReport = (ItemScheduledReportvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSearchEngine.vue?vue&type=template&id=31ba2b5a

var ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_1 = {
  class: "item-name"
};

var ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-icon icon-open-source"
}, null, -1);

var ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_3 = {
  class: "item-data-title"
};
var ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_4 = {
  class: "item-data-text"
};
function ItemSearchEnginevue_type_template_id_31ba2b5a_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_1, [ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ReferrersManager_Hostname')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSearchEnginevue_type_template_id_31ba2b5a_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.host), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSearchEngine.vue?vue&type=template&id=31ba2b5a

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSearchEngine.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemSearchEnginevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSearchEngine.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSearchEngine.vue



ItemSearchEnginevue_type_script_lang_ts.render = ItemSearchEnginevue_type_template_id_31ba2b5a_render

/* harmony default export */ var ItemSearchEngine = (ItemSearchEnginevue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSegment.vue?vue&type=template&id=790bd958


var ItemSegmentvue_type_template_id_790bd958_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-segment"
}, null, -1);

var ItemSegmentvue_type_template_id_790bd958_hoisted_2 = {
  class: "item-name"
};
var ItemSegmentvue_type_template_id_790bd958_hoisted_3 = {
  class: "item-data-title"
};
var ItemSegmentvue_type_template_id_790bd958_hoisted_4 = {
  class: "item-data-text"
};
function ItemSegmentvue_type_template_id_790bd958_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemSegmentvue_type_template_id_790bd958_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSegmentvue_type_template_id_790bd958_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSegmentvue_type_template_id_790bd958_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Segment')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSegmentvue_type_template_id_790bd958_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.definition), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSegment.vue?vue&type=template&id=790bd958

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSegment.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemSegmentvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSegment.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSegment.vue



ItemSegmentvue_type_script_lang_ts.render = ItemSegmentvue_type_template_id_790bd958_render

/* harmony default export */ var ItemSegment = (ItemSegmentvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSetting.vue?vue&type=template&id=1b6615b1


var ItemSettingvue_type_template_id_1b6615b1_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-admin-settings"
}, null, -1);

var ItemSettingvue_type_template_id_1b6615b1_hoisted_2 = {
  class: "item-name"
};
var ItemSettingvue_type_template_id_1b6615b1_hoisted_3 = {
  class: "item-data-text"
};
var ItemSettingvue_type_template_id_1b6615b1_hoisted_4 = {
  key: 0
};
var ItemSettingvue_type_template_id_1b6615b1_hoisted_5 = {
  key: 1
};
var ItemSettingvue_type_template_id_1b6615b1_hoisted_6 = {
  key: 2
};
var ItemSettingvue_type_template_id_1b6615b1_hoisted_7 = {
  key: 3
};
function ItemSettingvue_type_template_id_1b6615b1_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemSettingvue_type_template_id_1b6615b1_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_3, [_ctx.item.data.value === true ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Yes')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.value === false ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_No')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.item.data.value && _ctx.item.data.value !== 0 && _ctx.item.data.value !== false ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_NoValueSet')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemValue ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemSettingvue_type_template_id_1b6615b1_hoisted_7, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.value), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSetting.vue?vue&type=template&id=1b6615b1

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSetting.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemSettingvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  computed: {
    showItemValue: function showItemValue() {
      return !!this.item.data.value !== this.item.data.value && (this.item.data.value || this.item.data.value === 0);
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSetting.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSetting.vue



ItemSettingvue_type_script_lang_ts.render = ItemSettingvue_type_template_id_1b6615b1_render

/* harmony default export */ var ItemSetting = (ItemSettingvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSocial.vue?vue&type=template&id=41bb7497

var ItemSocialvue_type_template_id_41bb7497_hoisted_1 = {
  class: "item-name"
};

var ItemSocialvue_type_template_id_41bb7497_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-icon icon-open-source"
}, null, -1);

var ItemSocialvue_type_template_id_41bb7497_hoisted_3 = {
  class: "item-data-title"
};
var ItemSocialvue_type_template_id_41bb7497_hoisted_4 = {
  class: "item-data-text"
};
function ItemSocialvue_type_template_id_41bb7497_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSocialvue_type_template_id_41bb7497_hoisted_1, [ItemSocialvue_type_template_id_41bb7497_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.name), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSocialvue_type_template_id_41bb7497_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ReferrersManager_Hostname')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemSocialvue_type_template_id_41bb7497_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.host), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSocial.vue?vue&type=template&id=41bb7497

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemSocial.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemSocialvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSocial.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemSocial.vue



ItemSocialvue_type_script_lang_ts.render = ItemSocialvue_type_template_id_41bb7497_render

/* harmony default export */ var ItemSocial = (ItemSocialvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemUser.vue?vue&type=template&id=382fc072

var ItemUservue_type_template_id_382fc072_hoisted_1 = {
  class: "item-name"
};

var ItemUservue_type_template_id_382fc072_hoisted_2 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-icon icon-user-personal"
}, null, -1);

var ItemUservue_type_template_id_382fc072_hoisted_3 = {
  class: "item-data-title"
};
var ItemUservue_type_template_id_382fc072_hoisted_4 = {
  class: "item-data-text"
};
function ItemUservue_type_template_id_382fc072_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemUservue_type_template_id_382fc072_hoisted_1, [ItemUservue_type_template_id_382fc072_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.login), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemUservue_type_template_id_382fc072_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('UsersManager_Email')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemUservue_type_template_id_382fc072_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.email), 1)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemUser.vue?vue&type=template&id=382fc072

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemUser.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemUservue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemUser.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemUser.vue



ItemUservue_type_script_lang_ts.render = ItemUservue_type_template_id_382fc072_render

/* harmony default export */ var ItemUser = (ItemUservue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemReportsInvalidated.vue?vue&type=template&id=4e52380a


var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-table"
}, null, -1);

var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_2 = {
  class: "item-name"
};

var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_4 = {
  class: "item-data-text"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_5 = {
  key: 0,
  class: "item-data-title"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_6 = {
  key: 1,
  class: "item-data-text"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_7 = {
  key: 2
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_8 = {
  key: 3,
  class: "item-data-title"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_9 = {
  key: 4,
  class: "item-data-text"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_10 = {
  key: 5
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_11 = {
  key: 6,
  class: "item-data-title"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_12 = {
  key: 7,
  class: "item-data-text"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_13 = {
  key: 8
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_14 = {
  key: 9,
  class: "item-data-title"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_15 = {
  key: 10,
  class: "item-data-text"
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_16 = {
  key: 11
};
var ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_17 = {
  key: 12,
  class: "item-data-title"
};
var _hoisted_18 = {
  key: 13,
  class: "item-data-text"
};
var _hoisted_19 = {
  key: 14
};
var _hoisted_20 = {
  key: 15,
  class: "item-data-title"
};
var _hoisted_21 = {
  key: 16,
  class: "item-data-text"
};
var _hoisted_22 = {
  key: 17
};
var _hoisted_23 = {
  key: 18,
  class: "item-data-title"
};
var _hoisted_24 = {
  key: 19,
  class: "item-data-text"
};
var _hoisted_25 = {
  key: 20
};
var _hoisted_26 = {
  key: 21,
  class: "item-data-title"
};
var _hoisted_27 = {
  key: 22,
  class: "item-data-text"
};
function ItemReportsInvalidatedvue_type_template_id_4e52380a_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_InvalidateReports')) + ":", 1), ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_4, [_ctx.item.data.idSites ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_SiteIDs')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSites ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.idSites), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSites ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_7)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.dates ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Dates')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.dates ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.dates), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.dates ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_10)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.period) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Period')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.period) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.period), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.period) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_13)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.segment) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Segment')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.segment) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.segment), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.segment) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_16)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.cascadeDown) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemReportsInvalidatedvue_type_template_id_4e52380a_hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_CascadeDown')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.cascadeDown) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.cascadeDown), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.cascadeDown) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_19)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data._forceInvalidateNonexistent) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_20, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ForceInvalidate')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data._forceInvalidateNonexistent) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_21, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data._forceInvalidateNonexistent), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data._forceInvalidateNonexistent) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_22)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.plugin) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_23, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Plugin')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.plugin) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_24, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.plugin), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.plugin) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_25)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.ignoreLogDeletionLimit) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_26, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_IgnoreLogDeletionLimit')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.showItemField(_ctx.item.data.ignoreLogDeletionLimit) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_27, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.ignoreLogDeletionLimit), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemReportsInvalidated.vue?vue&type=template&id=4e52380a

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemReportsInvalidated.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemReportsInvalidatedvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    showItemField: function showItemField(fieldValue) {
      return !!fieldValue || fieldValue === false;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemReportsInvalidated.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemReportsInvalidated.vue



ItemReportsInvalidatedvue_type_script_lang_ts.render = ItemReportsInvalidatedvue_type_template_id_4e52380a_render

/* harmony default export */ var ItemReportsInvalidated = (ItemReportsInvalidatedvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleClientConfig.vue?vue&type=template&id=2d6411ce


var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-document"
}, null, -1);

var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_2 = {
  class: "item-name"
};

var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_4 = {
  class: "item-data-text"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_5 = {
  key: 0,
  class: "item-data-title"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_6 = {
  key: 1,
  class: "item-data-text"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_7 = {
  key: 2
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_8 = {
  key: 3,
  class: "item-data-title"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_9 = {
  key: 4,
  class: "item-data-text"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_10 = {
  key: 5
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_11 = {
  key: 6,
  class: "item-data-title"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_12 = {
  key: 7,
  class: "item-data-text"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_13 = {
  class: "browser-default"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_14 = {
  key: 8,
  class: "item-data-title"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_15 = {
  key: 9,
  class: "item-data-text"
};
var ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_16 = {
  class: "browser-default"
};
function ItemGoogleClientConfigvue_type_template_id_2d6411ce_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_GoogleClientConfig')) + ":", 1), ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_4, [_ctx.item.data.clientId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ClientId')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.clientId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.clientId), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.clientId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_7)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.projectId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ProjectId')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.projectId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.projectId), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.projectId ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_10)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.redirectUris ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_RedirectUris')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.redirectUris ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_13, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.item.data.redirectUris, function (uri) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: uri
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(uri), 1);
  }), 128))])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.javascriptOrigins ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_JavascriptOrigins')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.javascriptOrigins ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", ItemGoogleClientConfigvue_type_template_id_2d6411ce_hoisted_16, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.item.data.javascriptOrigins, function (origin) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: origin
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(origin), 1);
  }), 128))])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleClientConfig.vue?vue&type=template&id=2d6411ce

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleClientConfig.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemGoogleClientConfigvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    showItemField: function showItemField(fieldValue) {
      return !!fieldValue || fieldValue === false;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleClientConfig.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleClientConfig.vue



ItemGoogleClientConfigvue_type_script_lang_ts.render = ItemGoogleClientConfigvue_type_template_id_2d6411ce_render

/* harmony default export */ var ItemGoogleClientConfig = (ItemGoogleClientConfigvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleAnalyticsImport.vue?vue&type=template&id=759ecef9


var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-document"
}, null, -1);

var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_2 = {
  class: "item-name"
};

var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_4 = {
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_5 = {
  key: 0,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_6 = {
  key: 1,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_7 = {
  key: 2
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_8 = {
  key: 3,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_9 = {
  key: 4,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_10 = {
  key: 5
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_11 = {
  key: 6,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_12 = {
  key: 7,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_13 = {
  key: 8
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_14 = {
  key: 9,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_15 = {
  key: 10,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_16 = {
  class: "browser-default"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_17 = {
  key: 11,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_18 = {
  key: 12,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_19 = {
  key: 13
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_20 = {
  key: 14,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_21 = {
  key: 15,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_22 = {
  key: 16
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_23 = {
  key: 17,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_24 = {
  key: 18,
  class: "item-data-text"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_25 = {
  key: 19
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_26 = {
  key: 20,
  class: "item-data-title"
};
var ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_27 = {
  key: 21,
  class: "item-data-text"
};
var _hoisted_28 = {
  key: 22
};
var _hoisted_29 = {
  key: 23,
  class: "item-data-title"
};
var _hoisted_30 = {
  key: 24,
  class: "item-data-text"
};
var _hoisted_31 = {
  key: 25
};
var _hoisted_32 = {
  class: "item-data-title"
};
var _hoisted_33 = {
  key: 26,
  class: "item-data-text"
};
var _hoisted_34 = {
  key: 27,
  class: "item-data-title"
};

var _hoisted_35 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_36 = {
  key: 28,
  class: "item-data-title"
};
var _hoisted_37 = {
  key: 29,
  class: "item-data-text"
};
var _hoisted_38 = {
  key: 30
};
var _hoisted_39 = {
  key: 31,
  class: "item-data-title"
};
var _hoisted_40 = {
  key: 32,
  class: "item-data-text"
};
var _hoisted_41 = {
  class: "browser-default"
};
var _hoisted_42 = {
  key: 33
};
var _hoisted_43 = {
  key: 34,
  class: "item-data-title"
};
var _hoisted_44 = {
  key: 35,
  class: "item-data-text"
};
var _hoisted_45 = {
  class: "browser-default"
};
var _hoisted_46 = {
  class: "item-data-title"
};
var _hoisted_47 = {
  class: "item-data-text"
};
var _hoisted_48 = {
  class: "item-data-title"
};
var _hoisted_49 = {
  class: "item-data-text"
};
function ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_GoogleAnalyticsImport')) + ":", 1), ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_4, [_ctx.item.data.gaImportType ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('SitesManager_Type')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaImportType ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.gaImportType), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaImportType ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_7)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaProperty ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Property')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaProperty ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.gaProperty), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaProperty ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_10)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaAccount ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Account')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaAccount ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.gaAccount), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaAccount ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_13)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.streamIds ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_StreamIds')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.streamIds ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_16, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.item.data.streamIds, function (streamId) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: streamId
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(streamId), 1);
  }), 128))])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaView ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_17, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_View')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaView ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_18, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.gaView), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.gaView ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_19)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_20, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_SiteID')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_21, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.idSite), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_22)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.status ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_23, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('CorePluginsAdmin_Status')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.status ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_24, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.status), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.status ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_25)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeStart ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_26, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ImportStartDate')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeStart ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_hoisted_27, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.importRangeStart), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeStart ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_28)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeEnd ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_29, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ImportEndDate')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeEnd ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_30, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.importRangeEnd), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.importRangeEnd ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_31)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_32, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_LastDayImported')) + ":", 1), _ctx.item.data.lastDateImported ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_33, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.lastDateImported), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.item.data.lastDateImported ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_34, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_None')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _hoisted_35, _ctx.item.data.lastDayArchived ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_36, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_LastDayArchived')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.lastDayArchived ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_37, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.lastDayArchived), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.lastDayArchived ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_38)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.reimportRanges.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_39, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ReImports')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.reimportRanges.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_40, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", _hoisted_41, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.item.data.reimportRanges, function (range) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: range
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(range), 1);
  }), 128))])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.reimportRanges.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", _hoisted_42)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.extraCustomDimensions.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_43, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_ExtraCustomDimensions')) + ": ", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.extraCustomDimensions.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_44, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("ul", _hoisted_45, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.item.data.extraCustomDimensions, function (dimension) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: dimension
    }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_46, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Dimension')) + ": ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_47, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(dimension.gaDimension), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_48, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_Scope')) + ": ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", _hoisted_49, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(dimension.dimensionScope), 1)]);
  }), 128))])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleAnalyticsImport.vue?vue&type=template&id=759ecef9

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleAnalyticsImport.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemGoogleAnalyticsImportvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    showItemField: function showItemField(fieldValue) {
      return !!fieldValue || fieldValue === false;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleAnalyticsImport.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemGoogleAnalyticsImport.vue



ItemGoogleAnalyticsImportvue_type_script_lang_ts.render = ItemGoogleAnalyticsImportvue_type_template_id_759ecef9_render

/* harmony default export */ var ItemGoogleAnalyticsImport = (ItemGoogleAnalyticsImportvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemPrivacyFindDataSubject.vue?vue&type=template&id=53cfdb62


var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_1 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "item-data-title icon-document"
}, null, -1);

var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_2 = {
  class: "item-name"
};

var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_3 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_4 = {
  class: "item-data-text"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_5 = {
  key: 0,
  class: "item-data-title"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_6 = {
  key: 1,
  class: "item-data-text"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_7 = {
  key: 2
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_8 = {
  key: 3,
  class: "item-data-title"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_9 = {
  key: 4,
  class: "item-data-text"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_10 = {
  key: 5
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_11 = {
  key: 6,
  class: "item-data-title"
};
var ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_12 = {
  key: 7,
  class: "item-data-text"
};
function ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_1, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('PrivacyManager_FindMatchingDataSubjects')) + ":", 1), ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_4, [_ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_SiteID')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.idSite), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.idSite ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_7)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.segment ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Segment')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.segment ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.segment), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.segment ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("br", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_10)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.count ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_TotalRecordsFound')) + ":", 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.item.data.count ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.item.data.count), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPrivacyFindDataSubject.vue?vue&type=template&id=53cfdb62

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ItemPrivacyFindDataSubject.vue?vue&type=script&lang=ts

/* harmony default export */ var ItemPrivacyFindDataSubjectvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    showItemField: function showItemField(fieldValue) {
      return !!fieldValue || fieldValue === false;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPrivacyFindDataSubject.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ItemPrivacyFindDataSubject.vue



ItemPrivacyFindDataSubjectvue_type_script_lang_ts.render = ItemPrivacyFindDataSubjectvue_type_template_id_53cfdb62_render

/* harmony default export */ var ItemPrivacyFindDataSubject = (ItemPrivacyFindDataSubjectvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.store.ts
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



var ActivityLog_store_ActivityLogStore = /*#__PURE__*/function () {
  function ActivityLogStore() {
    var _this = this;

    _classCallCheck(this, ActivityLogStore);

    _defineProperty(this, "privateState", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["reactive"])({
      activities: [],
      searchTerm: '',
      busy: false,
      pageSize: 10,
      currentPage: 0,
      offsetStart: 0,
      offsetEnd: 10,
      hasPrev: false,
      hasNext: false,
      totalNumberOfSites: 0,
      availableUsers: [],
      filter: {
        userLogin: '',
        activityType: ''
      }
    }));

    _defineProperty(this, "state", Object(external_commonjs_vue_commonjs2_vue_root_Vue_["computed"])(function () {
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["readonly"])(_this.privateState);
    }));
  }

  _createClass(ActivityLogStore, [{
    key: "init",
    value: function init() {
      var promises = [];
      promises.push(this.fetchActivityCount());

      if (external_CoreHome_["Matomo"].hasSuperUserAccess) {
        promises.push(this.fetchAvailableUsers());
      } else {
        this.privateState.availableUsers = [{
          key: external_CoreHome_["Matomo"].userLogin,
          value: external_CoreHome_["Matomo"].userLogin
        }];
      }

      return Promise.all(promises);
    }
  }, {
    key: "fetchActivityCount",
    value: function fetchActivityCount() {
      var _this2 = this;

      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'ActivityLog.getEntryCount',
        filterByUserLogin: this.state.value.filter.userLogin,
        filterByActivityType: this.state.value.filter.activityType
      }).then(function (count) {
        if (!count || !count.value) {
          return;
        }

        _this2.privateState.totalNumberOfSites = count.value;
      });
    }
  }, {
    key: "fetchAvailableUsers",
    value: function fetchAvailableUsers() {
      var _this3 = this;

      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'UsersManager.getUsersLogin',
        filter_limit: -1
      }).then(function (userLogins) {
        if (!userLogins || !Array.isArray(userLogins)) {
          return;
        }

        var availableUsers = [{
          key: '',
          value: Object(external_CoreHome_["translate"])('General_All')
        }, {
          key: 'Console Command',
          value: Object(external_CoreHome_["translate"])('ActivityLog_ConsoleCommand')
        }, {
          key: 'Matomo System',
          value: Object(external_CoreHome_["translate"])('ActivityLog_System')
        }].concat(_toConsumableArray(userLogins.map(function (login) {
          return {
            key: login,
            value: login
          };
        })));
        _this3.privateState.availableUsers = availableUsers;
      });
    }
  }, {
    key: "onError",
    value: function onError() {
      this.setActivities([]);
    }
  }, {
    key: "setActivities",
    value: function setActivities(activities) {
      this.privateState.activities = activities;
      var numSites = activities.length;
      this.privateState.offsetStart = this.state.value.currentPage * this.state.value.pageSize;
      this.privateState.offsetEnd = this.state.value.offsetStart + numSites;
      this.privateState.hasPrev = this.state.value.currentPage >= 1;
      this.privateState.hasNext = numSites === this.state.value.pageSize;
    }
  }, {
    key: "setCurrentPage",
    value: function setCurrentPage(page) {
      this.privateState.currentPage = page < 0 ? 0 : page;
    }
  }, {
    key: "previousPage",
    value: function previousPage() {
      this.setCurrentPage(this.state.value.currentPage - 1);
      this.fetchActivityLog();
    }
  }, {
    key: "nextPage",
    value: function nextPage() {
      this.setCurrentPage(this.state.value.currentPage + 1);
      this.fetchActivityLog();
    }
  }, {
    key: "applyFilter",
    value: function applyFilter(userLogin) {
      if (userLogin) {
        this.privateState.filter.userLogin = userLogin;
      }

      this.privateState.currentPage = 0;
      this.fetchActivityCount();
      this.fetchActivityLog();
    }
  }, {
    key: "fetchActivityLog",
    value: function fetchActivityLog() {
      var _this4 = this;

      if (this.privateState.busy) {
        return Promise.resolve();
      }

      this.privateState.busy = true;
      var limit = this.privateState.pageSize;
      var offset = this.privateState.currentPage * this.privateState.pageSize;
      return external_CoreHome_["AjaxHelper"].fetch({
        method: 'ActivityLog.getEntries',
        offset: offset,
        limit: limit,
        filterByUserLogin: this.privateState.filter.userLogin,
        filterByActivityType: this.privateState.filter.activityType
      }).then(function (activities) {
        if (!activities) {
          _this4.onError();

          return;
        }

        _this4.setActivities(activities);
      }).catch(function () {
        return _this4.onError();
      }).finally(function () {
        _this4.privateState.busy = false;
      });
    }
  }]);

  return ActivityLogStore;
}();

/* harmony default export */ var ActivityLog_store = (new ActivityLog_store_ActivityLogStore());
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/Paging.vue?vue&type=template&id=30a3bb28

var Pagingvue_type_template_id_30a3bb28_hoisted_1 = {
  class: "paging"
};
var Pagingvue_type_template_id_30a3bb28_hoisted_2 = ["disabled"];
var Pagingvue_type_template_id_30a3bb28_hoisted_3 = {
  style: {
    "cursor": "pointer"
  }
};
var Pagingvue_type_template_id_30a3bb28_hoisted_4 = {
  class: "counter"
};
var Pagingvue_type_template_id_30a3bb28_hoisted_5 = {
  key: 0
};
var Pagingvue_type_template_id_30a3bb28_hoisted_6 = {
  key: 1
};
var Pagingvue_type_template_id_30a3bb28_hoisted_7 = ["disabled"];
var Pagingvue_type_template_id_30a3bb28_hoisted_8 = {
  style: {
    "cursor": "pointer"
  },
  class: "pointer"
};
var Pagingvue_type_template_id_30a3bb28_hoisted_9 = {
  class: "loadingPiwik"
};
var Pagingvue_type_template_id_30a3bb28_hoisted_10 = ["alt"];

var Pagingvue_type_template_id_30a3bb28_hoisted_11 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon icon-reload"
}, null, -1);

var Pagingvue_type_template_id_30a3bb28_hoisted_12 = {
  style: {
    "margin-right": "3.5px"
  }
};
var Pagingvue_type_template_id_30a3bb28_hoisted_13 = ["value", "selected", "disabled", "label"];
function Pagingvue_type_template_id_30a3bb28_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Pagingvue_type_template_id_30a3bb28_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: "btn prev",
    disabled: !_ctx.hasPrev || undefined,
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.previousPage();
    }),
    style: {
      "margin-right": "3.5px"
    }
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_3, "« " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Previous')), 1)], 8, Pagingvue_type_template_id_30a3bb28_hoisted_2), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_4, [_ctx.searchTerm ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_PaginationWithoutTotal', _ctx.offsetStart, _ctx.offsetEnd)), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), !_ctx.searchTerm ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Pagination', _ctx.offsetStart, _ctx.offsetEnd, _ctx.totalNumberOfSites)), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.hasPrev || _ctx.hasNext]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: "btn next",
    disabled: !_ctx.hasNext || undefined,
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.nextPage();
    }),
    style: {
      "margin-left": "3.5px"
    }
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_8, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Next')) + " »", 1)], 8, Pagingvue_type_template_id_30a3bb28_hoisted_7)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.showPaging]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", Pagingvue_type_template_id_30a3bb28_hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("img", {
    src: "plugins/Morpheus/images/loading-blue.gif",
    alt: _ctx.translate('General_LoadingData')
  }, null, 8, Pagingvue_type_template_id_30a3bb28_hoisted_10), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_LoadingData')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.busy]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: "btn reload",
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return _ctx.applyFilter();
    })
  }, [Pagingvue_type_template_id_30a3bb28_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Refresh')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "user-filter",
    style: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeStyle"])({
      visibility: _ctx.hasSuperUserAccess ? 'visible' : 'hidden'
    })
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", Pagingvue_type_template_id_30a3bb28_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('ActivityLog_FilterByUser')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("select", {
    onChange: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.applyFilter($event.target.value);
    }),
    class: "browser-default"
  }, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.availableUsers, function (option) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("option", {
      key: option.key,
      value: option.key,
      selected: _ctx.userLoginFilter === option.key,
      disabled: option.disabled,
      label: option.key
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(option.value), 9, Pagingvue_type_template_id_30a3bb28_hoisted_13);
  }), 128))], 32)], 4)], 64);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/Paging.vue?vue&type=template&id=30a3bb28

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/Paging.vue?vue&type=script&lang=ts



/* harmony default export */ var Pagingvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {},
  methods: {
    previousPage: function previousPage() {
      ActivityLog_store.previousPage();
    },
    nextPage: function nextPage() {
      ActivityLog_store.nextPage();
    },
    applyFilter: function applyFilter(userLogin) {
      ActivityLog_store.applyFilter(userLogin);
    }
  },
  computed: {
    hasSuperUserAccess: function hasSuperUserAccess() {
      return external_CoreHome_["Matomo"].hasSuperUserAccess;
    },
    hasPrev: function hasPrev() {
      return ActivityLog_store.state.value.hasPrev;
    },
    hasNext: function hasNext() {
      return ActivityLog_store.state.value.hasNext;
    },
    showPaging: function showPaging() {
      return !ActivityLog_store.state.value.busy && (this.hasPrev || this.hasNext);
    },
    searchTerm: function searchTerm() {
      return ActivityLog_store.state.value.searchTerm;
    },
    offsetStart: function offsetStart() {
      return ActivityLog_store.state.value.offsetStart;
    },
    offsetEnd: function offsetEnd() {
      return ActivityLog_store.state.value.offsetEnd;
    },
    totalNumberOfSites: function totalNumberOfSites() {
      return ActivityLog_store.state.value.totalNumberOfSites;
    },
    busy: function busy() {
      return ActivityLog_store.state.value.busy;
    },
    userLoginFilter: function userLoginFilter() {
      return ActivityLog_store.state.value.filter.userLogin;
    },
    availableUsers: function availableUsers() {
      return ActivityLog_store.state.value.availableUsers;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/Paging.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/Paging.vue



Pagingvue_type_script_lang_ts.render = Pagingvue_type_template_id_30a3bb28_render

/* harmony default export */ var Paging = (Pagingvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.vue?vue&type=script&lang=ts






















var ITEM_TYPE_TO_COMPONENT = {
  access: ItemAccess,
  annotation: ItemAnnotation,
  capability: ItemCapability,
  customalert: ItemCustomAlert,
  customdimension: ItemCustomDimension,
  goal: ItemGoal,
  measurable: ItemMeasurable,
  plugin: ItemPlugin,
  scheduledreport: ItemScheduledReport,
  searchengine: ItemSearchEngine,
  segment: ItemSegment,
  setting: ItemSetting,
  social: ItemSocial,
  user: ItemUser,
  reportsinvalidated: ItemReportsInvalidated,
  googleclientconfig: ItemGoogleClientConfig,
  privacyFindDataSubject: ItemPrivacyFindDataSubject,
  googleanalyticsimport: ItemGoogleAnalyticsImport
};
/* harmony default export */ var ActivityLogvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    showPagingBottom: Boolean
  },
  components: {
    Paging: Paging
  },
  data: function data() {
    return {
      showTimezone: {}
    };
  },
  created: function created() {
    ActivityLog_store.init();
    ActivityLog_store.fetchActivityLog();
  },
  methods: {
    applyFilter: function applyFilter(userLogin) {
      ActivityLog_store.applyFilter(userLogin);
    },
    getActivityCountryTooltip: function getActivityCountryTooltip(activity) {
      return activity.ip ? Object(external_CoreHome_["translate"])('ActivityLog_UserCountryWithIP', activity.country_name, activity.ip) : Object(external_CoreHome_["translate"])('ActivityLog_UserCountry', activity.country_name);
    }
  },
  computed: {
    hasSuperUserAccess: function hasSuperUserAccess() {
      return external_CoreHome_["Matomo"].hasSuperUserAccess;
    },
    busy: function busy() {
      return ActivityLog_store.state.value.busy;
    },
    activities: function activities() {
      return ActivityLog_store.state.value.activities;
    },
    userLoginFilter: function userLoginFilter() {
      return ActivityLog_store.state.value.filter.userLogin;
    },
    availableUsers: function availableUsers() {
      return ActivityLog_store.state.value.availableUsers;
    },
    itemToComponent: function itemToComponent() {
      return ITEM_TYPE_TO_COMPONENT;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLog.vue



ActivityLogvue_type_script_lang_ts.render = render

/* harmony default export */ var ActivityLog = (ActivityLogvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ActivityLogPage.vue?vue&type=template&id=59116311

var ActivityLogPagevue_type_template_id_59116311_hoisted_1 = {
  key: 0
};
var ActivityLogPagevue_type_template_id_59116311_hoisted_2 = {
  key: 1
};
var ActivityLogPagevue_type_template_id_59116311_hoisted_3 = {
  class: "ActivityLogContainer"
};
function ActivityLogPagevue_type_template_id_59116311_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ActivityLog = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ActivityLog");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    "content-title": _ctx.translate('ActivityLog_ActivityLog'),
    feature: "true"
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [_ctx.isSuperUser ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("p", ActivityLogPagevue_type_template_id_59116311_hoisted_1, " With the Activity Log, also known as audit log or audit trail, you keep an eye on everything that is happening on your Matomo. Below you see a record of all important activities performed by your Matomo users. It helps you for example to monitor data for any potential security breach and to identify problems, why something happened and when. ")) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("p", ActivityLogPagevue_type_template_id_59116311_hoisted_2, " With the Activity Log, also known as audit log or audit trail, you keep an eye on all of your activities in Matomo. ")), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ActivityLogPagevue_type_template_id_59116311_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ActivityLog, {
        "show-paging-bottom": _ctx.showPagingBottom
      }, null, 8, ["show-paging-bottom"])])];
    }),
    _: 1
  }, 8, ["content-title"]);
}
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLogPage.vue?vue&type=template&id=59116311

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/ActivityLog/vue/src/ActivityLog/ActivityLogPage.vue?vue&type=script&lang=ts



/* harmony default export */ var ActivityLogPagevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    showPagingBottom: Boolean,
    isSuperUser: Boolean
  },
  components: {
    ActivityLog: ActivityLog,
    ContentBlock: external_CoreHome_["ContentBlock"]
  }
}));
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLogPage.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/ActivityLog/ActivityLogPage.vue



ActivityLogPagevue_type_script_lang_ts.render = ActivityLogPagevue_type_template_id_59116311_render

/* harmony default export */ var ActivityLogPage = (ActivityLogPagevue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/ActivityLog/vue/src/index.ts
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
//# sourceMappingURL=ActivityLog.umd.js.map