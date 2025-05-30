(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", , "CorePluginsAdmin"], factory);
	else if(typeof exports === 'object')
		exports["GoogleAnalyticsImporter"] = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else
		root["GoogleAnalyticsImporter"] = factory(root["CoreHome"], root["Vue"], root["CorePluginsAdmin"]);
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
/******/ 	__webpack_require__.p = "plugins/GoogleAnalyticsImporter/vue/dist/";
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
__webpack_require__.d(__webpack_exports__, "ImportSchedulerGA4", function() { return /* reexport */ ImportSchedulerGA4; });
__webpack_require__.d(__webpack_exports__, "ImportStatus", function() { return /* reexport */ ImportStatus; });
__webpack_require__.d(__webpack_exports__, "ConfigureConnection", function() { return /* reexport */ ConfigureConnection; });
__webpack_require__.d(__webpack_exports__, "ClientConfig", function() { return /* reexport */ ClientConfig; });
__webpack_require__.d(__webpack_exports__, "AdminPage", function() { return /* reexport */ AdminPage; });
__webpack_require__.d(__webpack_exports__, "Connect", function() { return /* reexport */ CommonConnect; });

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

// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/onWidgetLoaded.ts
/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

var UNSUPPORTED_REPORT_WIDGETS = ['Transitions.getTransitions', 'UsersFlow.getUsersFlow', 'UsersFlow.getUsersFlowPretty', 'UsersFlow.getInteractionActions'];
var _window = window,
    $ = _window.$;
external_CoreHome_["Matomo"].on('widget:loaded', function (_ref) {
  var parameters = _ref.parameters,
      element = _ref.element;
  var method = "".concat(parameters.module, ".").concat(parameters.action);

  if (UNSUPPORTED_REPORT_WIDGETS.indexOf(method) === -1) {
    return;
  } // eslint-disable-next-line @typescript-eslint/no-explicit-any


  var importedFromGoogleStartDate = external_CoreHome_["Matomo"].importedFromGoogleStartDate,
      importedFromGoogleEndDate = external_CoreHome_["Matomo"].importedFromGoogleEndDate;

  if (!importedFromGoogleStartDate || !importedFromGoogleEndDate) {
    return;
  }

  importedFromGoogleStartDate = Object(external_CoreHome_["parseDate"])(importedFromGoogleStartDate);
  importedFromGoogleEndDate = Object(external_CoreHome_["parseDate"])(importedFromGoogleEndDate);
  var period = external_CoreHome_["MatomoUrl"].parsed.value.period;
  var date = external_CoreHome_["MatomoUrl"].parsed.value.date;
  var currentPeriod = external_CoreHome_["Periods"].parse(period, date).getDateRange();
  var isInImportDateRange = !(importedFromGoogleStartDate.getTime() > currentPeriod[1].getTime() || importedFromGoogleEndDate.getTime() < currentPeriod[0].getTime());

  if (!isInImportDateRange) {
    return;
  }

  var logDataRequired = Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_LogDataRequiredForReport');
  var helpText = "<br/> <div class=\"alert alert-info\">".concat(logDataRequired, "</div>");
  $(element).find('.card-content>div').append(helpText);
});
// EXTERNAL MODULE: external {"commonjs":"vue","commonjs2":"vue","root":"Vue"}
var external_commonjs_vue_commonjs2_vue_root_Vue_ = __webpack_require__("8bbf");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportScheduler/ImportSchedulerGA4.vue?vue&type=template&id=8da8e6d8

var _hoisted_1 = {
  name: "startDateGA4"
};
var _hoisted_2 = {
  name: "endDateGA4"
};
var _hoisted_3 = {
  name: "propertyIdGA4"
};
var _hoisted_4 = {
  name: "streamIds"
};
var _hoisted_5 = {
  name: "isMobileAppGA4"
};
var _hoisted_6 = {
  name: "timezoneGA4"
};
var _hoisted_7 = {
  name: "extraCustomDimensionsGA4"
};
var _hoisted_8 = {
  name: "forceIgnoreOutOfCustomDimSlotErrorGA4"
};
var _hoisted_9 = {
  name: "isVerboseLoggingEnabledGA4"
};
var _hoisted_10 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ScheduleImportDescription')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "startDateGA4",
    modelValue: _ctx.startDateGA4,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.startDateGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_StartDate'),
    placeholder: "".concat(_ctx.translate('GoogleAnalyticsImporter_CreationDate'), " (YYYY-MM-DD)"),
    "inline-help": _ctx.translate('GoogleAnalyticsImporter_StartDateHelp')
  }, null, 8, ["modelValue", "title", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "endDateGA4",
    modelValue: _ctx.endDateGA4,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.endDateGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_EndDate'),
    placeholder: _ctx.translate('GoogleAnalyticsImporter_None'),
    "inline-help": _ctx.endDateHelp
  }, null, 8, ["modelValue", "title", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "propertyIdGA4",
    modelValue: _ctx.propertyIdGA4,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.propertyIdGA4 = $event;
    }),
    placeholder: "eg. properties/{PROPERTY_ID}",
    title: _ctx.translate('GoogleAnalyticsImporter_PropertyIdGA4'),
    "inline-help": _ctx.translate('GoogleAnalyticsImporter_PropertyIdGA4Help')
  }, null, 8, ["modelValue", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "multituple",
    name: "streamIds",
    modelValue: _ctx.streamIds,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.streamIds = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_StreamIdFilter'),
    "inline-help": _ctx.streamIdsFilterHelp,
    "ui-control-attributes": _ctx.streamIdsField
  }, null, 8, ["modelValue", "title", "inline-help", "ui-control-attributes"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "checkbox",
    name: "isMobileAppGA4",
    modelValue: _ctx.isMobileAppGA4,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return _ctx.isMobileAppGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_IsMobileApp'),
    "inline-help": _ctx.translate('GoogleAnalyticsImporter_IsMobileAppHelp')
  }, null, 8, ["modelValue", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "text",
    name: "timezoneGA4",
    modelValue: _ctx.timezoneGA4,
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return _ctx.timezoneGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_Timezone'),
    placeholder: _ctx.translate('GoogleAnalyticsImporter_Optional'),
    "inline-help": _ctx.timezoneHelp
  }, null, 8, ["modelValue", "title", "placeholder", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "multituple",
    name: "extraCustomDimensionsGA4",
    modelValue: _ctx.extraCustomDimensionsGA4,
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.extraCustomDimensionsGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_ExtraCustomDimensions'),
    "inline-help": _ctx.extraCustomDimensionsHelp,
    "ui-control-attributes": _ctx.extraCustomDimensionsField
  }, null, 8, ["modelValue", "title", "inline-help", "ui-control-attributes"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "checkbox",
    name: "forceIgnoreOutOfCustomDimSlotErrorGA4",
    modelValue: _ctx.ignoreCustomDimensionSlotCheckGA4,
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return _ctx.ignoreCustomDimensionSlotCheckGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_ForceCustomDimensionSlotCheck'),
    "inline-help": _ctx.forceIgnoreOutOfCustomDimSlotErrorHelp
  }, null, 8, ["modelValue", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Troubleshooting')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "checkbox",
    name: "isVerboseLoggingEnabledGA4",
    modelValue: _ctx.isVerboseLoggingEnabledGA4,
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return _ctx.isVerboseLoggingEnabledGA4 = $event;
    }),
    title: _ctx.translate('GoogleAnalyticsImporter_IsVerboseLoggingEnabled'),
    "inline-help": _ctx.isVerboseLoggingEnabledHelp
  }, null, 8, ["modelValue", "title", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
    type: "submit",
    id: "startImportSubmitGA4",
    class: "btn",
    onClick: _cache[9] || (_cache[9] = function ($event) {
      return _ctx.startImportGA4();
    }),
    disabled: _ctx.isStartingImport
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Start')), 9, _hoisted_10)]);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportScheduler/ImportSchedulerGA4.vue?vue&type=template&id=8da8e6d8

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportScheduler/ImportSchedulerGA4.vue?vue&type=script&lang=ts



/* harmony default export */ var ImportSchedulerGA4vue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    startImportNonce: {
      type: String,
      required: true
    },
    maxEndDateDesc: String,
    extraCustomDimensionsField: {
      type: Object,
      required: true
    },
    streamIdsField: {
      type: Object,
      required: true
    }
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  data: function data() {
    return {
      isStartingImport: false,
      extraCustomDimensionsGA4: [],
      streamIds: [],
      isVerboseLoggingEnabledGA4: false,
      ignoreCustomDimensionSlotCheckGA4: false,
      startDateGA4: '',
      endDateGA4: '',
      propertyIdGA4: '',
      accountId: '',
      viewId: '',
      isMobileAppGA4: false,
      timezoneGA4: ''
    };
  },
  created: function created() {
    return this;
  },
  methods: {
    startImportGA4: function startImportGA4() {
      if (this.startDateGA4) {
        try {
          Object(external_CoreHome_["parseDate"])(this.startDateGA4);
        } catch (e) {
          var instanceId = external_CoreHome_["NotificationsStore"].show({
            message: Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_InvalidDateFormat', ['YYYY-MM-DD']),
            context: 'error',
            type: 'transient'
          });
          external_CoreHome_["NotificationsStore"].scrollToNotification(instanceId);
          return undefined;
        }
      }

      this.isStartingImport = true;
      var forceCustomDimensionSlotCheck = !this.ignoreCustomDimensionSlotCheckGA4;
      return external_CoreHome_["AjaxHelper"].post({
        module: 'GoogleAnalyticsImporter',
        action: 'startImportGA4',
        startDate: this.startDateGA4,
        endDate: this.endDateGA4,
        propertyId: this.propertyIdGA4,
        viewId: this.viewId,
        nonce: this.startImportNonce,
        accountId: this.accountId,
        isMobileApp: this.isMobileAppGA4 ? '1' : '0',
        timezone: this.timezoneGA4,
        extraCustomDimensions: this.extraCustomDimensionsGA4,
        streamIds: this.streamIds,
        isVerboseLoggingEnabled: this.isVerboseLoggingEnabledGA4 ? '1' : '0',
        forceCustomDimensionSlotCheck: forceCustomDimensionSlotCheck ? '1' : '0'
      }, {}, {
        withTokenInUrl: true
      }).finally(function () {
        window.location.reload();
      });
    }
  },
  computed: {
    endDateHelp: function endDateHelp() {
      var endDateHelp = Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_EndDateHelpText');
      var maxEndDateDesc = this.maxEndDateDesc && Object(external_CoreHome_["translate"])('<br/><br/>GoogleAnalyticsImporter_MaxEndDateHelp', this.maxEndDateDesc);
      return "".concat(endDateHelp, " ").concat(maxEndDateDesc || '');
    },
    timezoneHelp: function timezoneHelp() {
      var url = 'https://www.php.net/manual/en/timezones.php';
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_TimezoneGA4Help', "<a href=\"".concat(url, "\" rel=\"noreferrer noopener\" target=\"_blank\">"), '</a>');
    },
    extraCustomDimensionsHelp: function extraCustomDimensionsHelp() {
      var link = 'https://ga-dev-tools.web.app/ga4/dimensions-metrics-explorer/';
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ExtraCustomDimensionsGA4Help', "<a href=\"".concat(link, "\" rel=\"noreferrer noopener\" target=\"_blank\">"), '</a>');
    },
    streamIdsFilterHelp: function streamIdsFilterHelp() {
      var url = 'https://matomo.org/faq/what-is-data-stream-in-google-analytics-4/';
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_StreamIdFilterHelpText', "<a href=\"".concat(url, "\" rel=\"noreferrer noopener\" target=\"_blank\">"), '</a>', '<br><br><b>', '</b>');
    },
    forceIgnoreOutOfCustomDimSlotErrorHelp: function forceIgnoreOutOfCustomDimSlotErrorHelp() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ForceCustomDimensionSlotCheckHelp', Object(external_CoreHome_["externalLink"])('https://matomo.org/docs/custom-dimensions/'), '</a>');
    },
    isVerboseLoggingEnabledHelp: function isVerboseLoggingEnabledHelp() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_IsVerboseLoggingEnabledHelp', '/path/to/matomo/tmp/logs/', 'gaimportlog.$idSite.$matomoDomain.log');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportScheduler/ImportSchedulerGA4.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportScheduler/ImportSchedulerGA4.vue



ImportSchedulerGA4vue_type_script_lang_ts.render = render

/* harmony default export */ var ImportSchedulerGA4 = (ImportSchedulerGA4vue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatus.vue?vue&type=template&id=985a7fca

var ImportStatusvue_type_template_id_985a7fca_hoisted_1 = {
  ref: "root"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_2 = {
  class: "entityTable importStatusesTable"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_3 = {
  class: "modal",
  id: "openScheduleReimportModal"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_4 = {
  class: "modal-content"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_5 = {
  class: "modal-footer"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_6 = {
  class: "modal",
  id: "editImportEndDate"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_7 = {
  class: "modal-content"
};
var ImportStatusvue_type_template_id_985a7fca_hoisted_8 = {
  class: "modal-footer"
};
function ImportStatusvue_type_template_id_985a7fca_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ImportStatusRow = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ImportStatusRow");

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _directive_tooltips = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDirective"])("tooltips");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])((Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("table", ImportStatusvue_type_template_id_985a7fca_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("thead", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tr", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_MatomoSite')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_GoogleAnalyticsInfo')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Status')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_LatestDayProcessed')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ScheduledReImports')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_StartFinishTimes')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("th", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Actions')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("tbody", null, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.statuses, function (status, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ImportStatusRow, {
      status: status,
      key: index,
      onEndImport: function onEndImport($event) {
        return _ctx.showEditImportEndDateModal(status.idSite, status.isGA4);
      },
      onReimport: function onReimport($event) {
        return _ctx.openScheduleReimportModal(status.idSite, status.isGA4);
      },
      onDelete: function onDelete($event) {
        return _ctx.deleteImportStatus(status.idSite, $event.isDone);
      },
      onManuallyResume: function onManuallyResume($event) {
        return _ctx.manuallyResume(status.idSite, status.isGA4);
      }
    }, null, 8, ["status", "onEndImport", "onReimport", "onDelete", "onManuallyResume"]);
  }), 128))])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_EnterImportDateRange')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    name: "re-import-start-date",
    uicontrol: "text",
    modelValue: _ctx.reimportStartDate,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.reimportStartDate = $event;
    }),
    placeholder: "".concat(_ctx.translate('GoogleAnalyticsImporter_StartDate'), " (YYYY-MM-DD)")
  }, null, 8, ["modelValue", "placeholder"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    name: "re-import-end-date",
    uicontrol: "text",
    modelValue: _ctx.reimportEndDate,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.reimportEndDate = $event;
    }),
    placeholder: "".concat(_ctx.translate('GoogleAnalyticsImporter_EndDate'), " (YYYY-MM-DD)")
  }, null, 8, ["modelValue", "placeholder"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    id: "scheduleReimportSubmit",
    href: "",
    class: "modal-action modal-close btn",
    onClick: _cache[2] || (_cache[2] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.scheduleReimport();
    }, ["prevent"])),
    style: {
      "margin-right": "3.5px"
    }
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Schedule')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    class: "modal-action modal-close modal-no",
    onClick: _cache[3] || (_cache[3] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function () {}, ["prevent"]))
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Cancel')), 1)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_EnterImportEndDate')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("em", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_LeaveEmptyToRemove')), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    name: "new-import-end-date",
    uicontrol: "text",
    modelValue: _ctx.newImportEndDate,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return _ctx.newImportEndDate = $event;
    }),
    placeholder: "".concat(_ctx.translate('GoogleAnalyticsImporter_EndDate'), " (YYYY-MM-DD)")
  }, null, 8, ["modelValue", "placeholder"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ImportStatusvue_type_template_id_985a7fca_hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    class: "modal-action modal-close btn",
    onClick: _cache[5] || (_cache[5] = function ($event) {
      return _ctx.changeImportEndDateModal();
    }),
    style: {
      "margin-right": "3.5px"
    }
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Change')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    href: "",
    class: "modal-action modal-close modal-no",
    onClick: _cache[6] || (_cache[6] = function ($event) {
      return _ctx.cancelEditImportEndDateModal();
    })
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Cancel')), 1)])])], 512)), [[_directive_tooltips, {
    content: _ctx.tooltipContent,
    delay: 500,
    duration: 200
  }]]);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatus.vue?vue&type=template&id=985a7fca

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatusRow.vue?vue&type=template&id=7ef1732e

var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_1 = ["data-idsite"];
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_2 = {
  class: "sitename"
};
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_3 = ["href"];
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_4 = {
  key: 1,
  style: {
    "text-transform": "uppercase"
  }
};

var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_5 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_6 = ["innerHTML"];
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_7 = {
  class: "status"
};
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_8 = ["title"];
var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_9 = {
  key: 1,
  style: {
    "word-wrap": "break-word"
  }
};

var ImportStatusRowvue_type_template_id_7ef1732e_hoisted_10 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_11 = {
  key: 0
};
var _hoisted_12 = {
  class: "last-date-imported"
};

var _hoisted_13 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_14 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_15 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_16 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_17 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_18 = {
  key: 0
};
var _hoisted_19 = {
  class: "scheduled-reimports"
};
var _hoisted_20 = {
  key: 0
};
var _hoisted_21 = {
  key: 1
};
var _hoisted_22 = {
  class: "import-start-finish-times"
};

var _hoisted_23 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_24 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("br", null, null, -1);

var _hoisted_25 = {
  key: 0
};
var _hoisted_26 = {
  key: 1
};
var _hoisted_27 = {
  key: 0
};
var _hoisted_28 = {
  key: 1
};
var _hoisted_29 = {
  key: 2
};
var _hoisted_30 = {
  key: 3
};
var _hoisted_31 = {
  class: "actions"
};
var _hoisted_32 = ["title"];
var _hoisted_33 = ["title"];
function ImportStatusRowvue_type_template_id_7ef1732e_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _ctx$status$reimport_;

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("tr", {
    "data-idsite": _ctx.status.idSite
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ImportStatusRowvue_type_template_id_7ef1732e_hoisted_2, [_ctx.status.site ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    target: "_blank",
    href: _ctx.siteUrl
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.siteName), 9, ImportStatusRowvue_type_template_id_7ef1732e_hoisted_3)) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ImportStatusRowvue_type_template_id_7ef1732e_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_SiteDeleted')), 1)), ImportStatusRowvue_type_template_id_7ef1732e_hoisted_5, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_SiteID')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.idSite), 1)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", {
    class: "ga-info",
    innerHTML: _ctx.$sanitize(_ctx.gaInfoPretty)
  }, null, 8, ImportStatusRowvue_type_template_id_7ef1732e_hoisted_6), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", ImportStatusRowvue_type_template_id_7ef1732e_hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.statusName) + " ", 1), _ctx.status.statusDescription ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
    key: 0,
    class: "icon icon-help",
    title: _ctx.status.statusDescription
  }, null, 8, ImportStatusRowvue_type_template_id_7ef1732e_hoisted_8)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.status.errorDescription ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", ImportStatusRowvue_type_template_id_7ef1732e_hoisted_9, [ImportStatusRowvue_type_template_id_7ef1732e_hoisted_10, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_StatusErroredName')), 1), _ctx.status.errorCode ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_11, " " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.errorCode), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.errorDescription), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_LastDayImported')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.last_date_imported || _ctx.noneText), 1), _hoisted_13, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_LastDayArchived')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.last_day_archived || _ctx.noneText), 1), _hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ImportStartDate')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.import_range_start || _ctx.websiteCreationTime) + " ", 1), _hoisted_15, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ImportEndDate')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.import_range_end || _ctx.noneText) + " ", 1), _hoisted_16, _hoisted_17]), _ctx.status.status !== 'finished' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_18, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: "edit-import-end-link table-command-link",
    href: "",
    onClick: _cache[0] || (_cache[0] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.$emit('end-import');
    }, ["prevent"]))
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_EditEndDate')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [_ctx.status.isGA4 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    id: "reimport-date-range",
    class: "table-command-link",
    href: "",
    onClick: _cache[1] || (_cache[1] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.$emit('reimport');
    }, ["prevent"]))
  }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ReimportDate')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", _hoisted_19, [(_ctx$status$reimport_ = _ctx.status.reimport_ranges) !== null && _ctx$status$reimport_ !== void 0 && _ctx$status$reimport_.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("ul", _hoisted_20, [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.status.reimport_ranges, function (entry, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
      key: index
    }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(entry[0]) + "," + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(entry[1]), 1);
  }), 128))])) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_21, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_None')), 1))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", _hoisted_22, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ImportStartTime')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.import_start_time || _ctx.noneText), 1), _hoisted_23, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_LastResumeTime')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.last_job_start_time || _ctx.noneText), 1), _hoisted_24, _ctx.status.status === 'finished' ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_25, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_TimeFinished')) + ": " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.status.import_end_time || _ctx.noneText), 1)) : _ctx.status.estimated_days_left_to_finish ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_26, [_ctx.thisJobShouldFinishToday ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_27, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ThisJobShouldFinishToday')), 1)) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_28, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_EstimatedFinishIn', _ctx.status.estimated_days_left_to_finish)), 1))])) : _ctx.status.import_range_end ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_29, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_JobWillRunUntilManuallyCancelled')), 1)) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", _hoisted_30, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Unknown')), 1))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("td", _hoisted_31, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
    class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(["table-action", {
      'icon-delete': _ctx.isDone,
      'icon-close': !_ctx.isDone
    }]),
    onClick: _cache[2] || (_cache[2] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.$emit('delete', {
        isDone: _ctx.isDone
      });
    }, ["prevent"])),
    title: _ctx.isDone ? _ctx.translate('General_Remove') : _ctx.translate('General_Cancel')
  }, null, 10, _hoisted_32), ['finished', 'ongoing', 'started'].indexOf(_ctx.status.status) === -1 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("a", {
    key: 0,
    class: "table-action icon-play",
    onClick: _cache[3] || (_cache[3] = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withModifiers"])(function ($event) {
      return _ctx.$emit('manuallyResume');
    }, ["prevent"])),
    title: _ctx.translate('GoogleAnalyticsImporter_ResumeDesc')
  }, null, 8, _hoisted_33)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)])], 8, ImportStatusRowvue_type_template_id_7ef1732e_hoisted_1);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatusRow.vue?vue&type=template&id=7ef1732e

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatusRow.vue?vue&type=script&lang=ts


/* harmony default export */ var ImportStatusRowvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    status: {
      type: Object,
      required: true
    }
  },
  emits: ['end-import', 'reimport', 'delete', 'manuallyResume'],
  computed: {
    isDone: function isDone() {
      return this.status.status === 'finished';
    },
    siteUrl: function siteUrl() {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify(Object.assign(Object.assign({
        period: 'day',
        date: 'today'
      }, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
        idSite: this.status.idSite,
        module: 'CoreHome',
        action: 'index'
      })));
    },
    gaInfoPretty: function gaInfoPretty() {
      return (this.status.gaInfoPretty || '').replace(/\n/g, '<br/>');
    },
    errorMessageBugReportRequest: function errorMessageBugReportRequest() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ErrorMessageBugReportRequest', Object(external_CoreHome_["externalLink"])('https://forum.matomo.org/'), '</a>');
    },
    thisJobShouldFinishToday: function thisJobShouldFinishToday() {
      return this.status.estimated_days_left_to_finish === 0 || this.status.estimated_days_left_to_finish === '0';
    },
    siteName: function siteName() {
      var _this$status$site;

      return external_CoreHome_["Matomo"].helper.htmlDecode((_this$status$site = this.status.site) === null || _this$status$site === void 0 ? void 0 : _this$status$site.name);
    },
    noneText: function noneText() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_None');
    },
    websiteCreationTime: function websiteCreationTime() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_CreationDate');
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatusRow.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatusRow.vue



ImportStatusRowvue_type_script_lang_ts.render = ImportStatusRowvue_type_template_id_7ef1732e_render

/* harmony default export */ var ImportStatusRow = (ImportStatusRowvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatus.vue?vue&type=script&lang=ts




var ImportStatusvue_type_script_lang_ts_window = window,
    ImportStatusvue_type_script_lang_ts_$ = ImportStatusvue_type_script_lang_ts_window.$;
/* harmony default export */ var ImportStatusvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    statuses: {
      type: Array,
      required: true
    },
    stopImportNonce: {
      type: String,
      required: true
    },
    changeImportEndDateNonce: {
      type: String,
      required: true
    },
    resumeImportNonce: {
      type: String,
      required: true
    },
    scheduleReImportNonce: {
      type: String,
      required: true
    }
  },
  components: {
    Field: external_CorePluginsAdmin_["Field"],
    ImportStatusRow: ImportStatusRow
  },
  directives: {
    Tooltips: external_CoreHome_["Tooltips"]
  },
  data: function data() {
    return {
      editImportEndDateIdSite: null,
      reimportDateRangeIdSite: null,
      reimportStartDate: '',
      reimportEndDate: '',
      newImportEndDate: '',
      isGA4: false
    };
  },
  methods: {
    showEditImportEndDateModal: function showEditImportEndDateModal(idSite, isGA4) {
      this.editImportEndDateIdSite = idSite;
      this.isGA4 = isGA4;
      ImportStatusvue_type_script_lang_ts_$('#editImportEndDate').modal({
        dismissible: false
      }).modal('open');
    },
    cancelEditImportEndDateModal: function cancelEditImportEndDateModal() {
      this.editImportEndDateIdSite = null;
      this.isGA4 = false;
    },
    manuallyResume: function manuallyResume(idSite, isGA4) {
      return external_CoreHome_["AjaxHelper"].post({
        module: 'GoogleAnalyticsImporter',
        action: 'resumeImport',
        idSite: idSite,
        isGA4: isGA4 ? 1 : 0,
        nonce: this.resumeImportNonce
      }, {}, {
        withTokenInUrl: true
      }).finally(function () {
        window.location.reload();
      });
    },
    deleteImportStatus: function deleteImportStatus(idSite, isDoneOrForce) {
      var _this = this;

      if (!isDoneOrForce) {
        external_CoreHome_["Matomo"].helper.modalConfirm('#confirmCancelJob', {
          yes: function yes() {
            _this.deleteImportStatus(idSite, true);
          }
        });
        return undefined;
      }

      return external_CoreHome_["AjaxHelper"].post({
        module: 'GoogleAnalyticsImporter',
        action: 'deleteImportStatus',
        idSite: idSite,
        nonce: this.stopImportNonce
      }, {}, {
        withTokenInUrl: true
      }).finally(function () {
        window.location.reload();
      });
    },
    openScheduleReimportModal: function openScheduleReimportModal(idSite, isGA4) {
      this.reimportDateRangeIdSite = idSite;
      this.isGA4 = isGA4;
      ImportStatusvue_type_script_lang_ts_$('#openScheduleReimportModal').modal({
        dismissible: false
      }).modal('open');
    },
    changeImportEndDateModal: function changeImportEndDateModal() {
      return external_CoreHome_["AjaxHelper"].post({
        module: 'GoogleAnalyticsImporter',
        action: 'changeImportEndDate',
        idSite: this.editImportEndDateIdSite,
        nonce: this.changeImportEndDateNonce,
        endDate: this.newImportEndDate
      }, {}, {
        withTokenInUrl: true
      }).finally(function () {
        window.location.reload();
      });
    },
    scheduleReimport: function scheduleReimport() {
      return external_CoreHome_["AjaxHelper"].post({
        module: 'GoogleAnalyticsImporter',
        action: 'scheduleReImport',
        idSite: this.reimportDateRangeIdSite,
        startDate: this.reimportStartDate,
        endDate: this.reimportEndDate,
        nonce: this.scheduleReImportNonce,
        isGA4: this.isGA4 ? 1 : 0
      }, {}, {
        withTokenInUrl: true
      }).finally(function () {
        window.location.reload();
      });
    }
  },
  computed: {
    tooltipContent: function tooltipContent() {
      return function tooltipContent() {
        var title = ImportStatusvue_type_script_lang_ts_$(this).attr('title') || '';
        return window.vueSanitize(title.replace(/\n/g, '<br />'));
      };
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatus.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ImportStatus/ImportStatus.vue



ImportStatusvue_type_script_lang_ts.render = ImportStatusvue_type_template_id_985a7fca_render

/* harmony default export */ var ImportStatus = (ImportStatusvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/Configure/ConfigureConnection.vue?vue&type=template&id=7a9a48f2

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_1 = {
  key: 0,
  class: "form-group row"
};
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_2 = {
  class: "col s12 m12"
};
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_3 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_4 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_5 = ["textContent"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_6 = {
  class: "form-group row"
};
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_7 = ["action"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_8 = {
  key: 0,
  type: "hidden",
  name: "isNoDataPage",
  value: "1"
};
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_9 = ["value"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_10 = ["disabled"];

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_11 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-upload"
}, null, -1);

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_12 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-upload"
}, null, -1);

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_13 = {
  key: 1,
  class: "system-success connected-message-successful"
};

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_14 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-ok"
}, null, -1);

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_15 = {
  key: 2
};
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_16 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_17 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_18 = ["action"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_19 = ["value"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_20 = ["disabled", "textContent"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_21 = {
  key: 0,
  class: "system-success connected-message-successful"
};

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_22 = /*#__PURE__*/Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
  class: "icon-ok"
}, null, -1);

var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_23 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_24 = ["textContent"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_25 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_26 = ["innerHTML"];
var ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_27 = ["textContent"];
function ConfigureConnectionvue_type_template_id_7a9a48f2_render(_ctx, _cache, $props, $setup, $data, $options) {
  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, [!_ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ConfigureTheImporterLabel1')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ConfigureTheImporterLabel2')) + "  ", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.setupGoogleAnalyticsImportFaq)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_3)])])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 1,
    innerHTML: _ctx.$sanitize(_ctx.getAdvanceConnectStep01Text)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_4)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDynamicComponent"])(_ctx.isNoDataPage ? 'li' : 'div'), null, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [_ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
        key: 0,
        textContent: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep02'))
      }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_5)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
        class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])(_ctx.getClass)
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
        id: "configFileUploadForm",
        action: _ctx.manualActionUrl,
        method: "POST",
        enctype: "multipart/form-data"
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        type: "file",
        id: "clientfile",
        name: "clientfile",
        accept: ".json",
        onChange: _cache[0] || (_cache[0] = function () {
          return _ctx.processFileChange && _ctx.processFileChange.apply(_ctx, arguments);
        }),
        style: {
          "display": "none"
        }
      }, null, 32), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("input", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_8)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        type: "hidden",
        name: "config_nonce",
        value: _ctx.manualConfigNonce
      }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_9), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
        type: "button",
        class: "btn advance-upload-button",
        onClick: _cache[1] || (_cache[1] = function ($event) {
          return _ctx.selectConfigFile();
        }),
        disabled: _ctx.isUploadButtonDisabled
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, [ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_11, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Upload')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], !_ctx.isUploadButtonDisabled]]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, [ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_12, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Uploading')), 1)], 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], _ctx.isUploadButtonDisabled]])], 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_10), _ctx.isNoDataPage && _ctx.hasClientConfiguration ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_13, [ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_14, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_UploadSuccessful')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_7)], 2)])];
    }),
    _: 1
  })), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", {
    innerHTML: _ctx.$sanitize(_ctx.getAdvanceConnectStep03Text)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_16), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", {
    class: "complete-note-warning",
    innerHTML: _ctx.$sanitize(_ctx.getOauthCompleteWarningMessage)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_17), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
    target: "_blank",
    method: "post",
    action: _ctx.authorizeUrl
  }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    type: "hidden",
    name: "auth_nonce",
    value: _ctx.forwardToAuthNonce
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_19), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", {
    disabled: _ctx.hasClientConfiguration === false,
    textContent: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.getAuthorizeText),
    type: "submit",
    class: "btn btn-forward-to-Oauth"
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_20), _ctx.isNoDataPage && _ctx.hasClientConfiguration && _ctx.isConfigured ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_21, [ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_22, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(" " + Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_AccountsConnectedSuccessfully')), 1)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_18)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 3,
    innerHTML: _ctx.$sanitize(_ctx.getAdvanceConnectStep04Text)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_23)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 4,
    textContent: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep06GA4'))
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_24)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 5,
    innerHTML: _ctx.$sanitize(_ctx.getAdvanceConnectStep07Text)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_25)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 6,
    innerHTML: _ctx.$sanitize(_ctx.getAdvanceConnectStep08Text)
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_26)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("li", {
    key: 7,
    textContent: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep09'))
  }, null, 8, ConfigureConnectionvue_type_template_id_7a9a48f2_hoisted_27)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)], 64);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/Configure/ConfigureConnection.vue?vue&type=template&id=7a9a48f2

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/Configure/ConfigureConnection.vue?vue&type=script&lang=ts


/* harmony default export */ var ConfigureConnectionvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  data: function data() {
    return {
      isSelectingFile: false,
      isUploading: false
    };
  },
  props: {
    manualConfigNonce: {
      type: String,
      required: true
    },
    manualActionUrl: {
      type: String,
      required: true
    },
    isNoDataPage: Boolean,
    hasClientConfiguration: Boolean,
    indexActionUrl: {
      type: String,
      required: true
    },
    authorizeUrl: String,
    forwardToAuthNonce: String,
    isConfigured: Boolean
  },
  methods: {
    selectConfigFile: function selectConfigFile() {
      this.isSelectingFile = true;
      var fileInput = document.getElementById('clientfile');

      if (fileInput) {
        fileInput.click();
      }
    },
    processFileChange: function processFileChange() {
      var fileInput = document.getElementById('clientfile');
      var configFileUploadForm = document.getElementById('configFileUploadForm');

      if (fileInput && fileInput.value && configFileUploadForm) {
        this.isUploading = true;
        configFileUploadForm.submit();
      }
    },
    checkForCancel: function checkForCancel() {
      // If we're not in currently selecting a file or if we're uploading, there's no point checking
      if (!this.isSelectingFile || this.isUploading) {
        return;
      } // Check if the file is empty and change back from selecting status


      var fileInput = document.getElementById('clientfile');

      if (fileInput && !fileInput.value) {
        this.isSelectingFile = false;
      }
    }
  },
  computed: {
    setupGoogleAnalyticsImportFaq: function setupGoogleAnalyticsImportFaq() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ConfigureTheImporterLabel3', Object(external_CoreHome_["externalLink"])('https://matomo.org/faq/general/set-up-google-analytics-import/'), '</a>');
    },
    isUploadButtonDisabled: function isUploadButtonDisabled() {
      return this.isSelectingFile || this.isUploading;
    },
    getAdvanceConnectStep01Text: function getAdvanceConnectStep01Text() {
      return this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep01', Object(external_CoreHome_["externalLink"])('https://matomo.org/faq/general/set-up-google-analytics-import/'), '</a>');
    },
    getAdvanceConnectStep03Text: function getAdvanceConnectStep03Text() {
      return this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep03', this.translate('GoogleAnalyticsImporter_Authorize'));
    },
    getAdvanceConnectStep04Text: function getAdvanceConnectStep04Text() {
      return this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep04', "<a href=\"".concat(this.indexActionUrl, "\" target=\"_blank\" rel=\"noreferrer noopener\">"), '</a>', Object(external_CoreHome_["externalLink"])('https://matomo.org/faq/general/running-the-google-analytics-import/'), '</a>');
    },
    getAdvanceConnectStep05Text: function getAdvanceConnectStep05Text() {
      return this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep05', Object(external_CoreHome_["externalLink"])(this.indexActionUrl), '</a>');
    },
    getAdvanceConnectStep07Text: function getAdvanceConnectStep07Text() {
      return "".concat(this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep07', this.translate('GoogleAnalyticsImporter_Start')), "<br><div >").concat(this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep07Note', '<strong>', '</strong>', this.translate('GoogleAnalyticsImporter_Start')), "</div>");
    },
    getAdvanceConnectStep08Text: function getAdvanceConnectStep08Text() {
      return this.translate('GoogleAnalyticsImporter_GAImportNoDataScreenStep08', "<a href=\"".concat(this.indexActionUrl, "\" target=\"_blank\" rel=\"noreferrer noopener\">"), '</a>');
    },
    getOauthCompleteWarningMessage: function getOauthCompleteWarningMessage() {
      return this.translate('GoogleAnalyticsImporter_GoogleOauthCompleteWarning', '<strong>', '</strong>');
    },
    getClass: function getClass() {
      var classes = 'col s12';

      if (this.isNoDataPage) {
        classes += ' p-half-point';
      } else {
        classes += ' m6';
      }

      return classes;
    },
    getAuthorizeText: function getAuthorizeText() {
      if (this.isConfigured) {
        return this.translate('GoogleAnalyticsImporter_ReAuthorize');
      }

      return this.translate('GoogleAnalyticsImporter_Authorize');
    }
  },
  mounted: function mounted() {
    document.body.onfocus = this.checkForCancel;
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/Configure/ConfigureConnection.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/Configure/ConfigureConnection.vue



ConfigureConnectionvue_type_script_lang_ts.render = ConfigureConnectionvue_type_template_id_7a9a48f2_render

/* harmony default export */ var ConfigureConnection = (ConfigureConnectionvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ClientConfig/ClientConfig.vue?vue&type=template&id=3d935500

var ClientConfigvue_type_template_id_3d935500_hoisted_1 = ["action"];
var ClientConfigvue_type_template_id_3d935500_hoisted_2 = ["value"];
var ClientConfigvue_type_template_id_3d935500_hoisted_3 = {
  key: 0
};
var ClientConfigvue_type_template_id_3d935500_hoisted_4 = {
  type: "submit",
  class: "btn"
};
var ClientConfigvue_type_template_id_3d935500_hoisted_5 = {
  key: 1
};
var ClientConfigvue_type_template_id_3d935500_hoisted_6 = {
  type: "submit",
  class: "btn"
};
var ClientConfigvue_type_template_id_3d935500_hoisted_7 = ["action"];
var ClientConfigvue_type_template_id_3d935500_hoisted_8 = ["value"];
var ClientConfigvue_type_template_id_3d935500_hoisted_9 = {
  type: "submit",
  class: "btn"
};
function ClientConfigvue_type_template_id_3d935500_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [_ctx.hasClientConfiguration ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    key: 0,
    "content-title": _ctx.translate('GoogleAnalyticsImporter_ConfigureTheImporter')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
        method: "post",
        action: _ctx.forwardToAuthUrl,
        id: "clientauthform"
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        type: "hidden",
        name: "auth_nonce",
        value: _ctx.authNonce
      }, null, 8, ClientConfigvue_type_template_id_3d935500_hoisted_2), _ctx.isConfigured ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ClientConfigvue_type_template_id_3d935500_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ImporterIsConfigured')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", ClientConfigvue_type_template_id_3d935500_hoisted_4, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ReAuthorize')), 1)])) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", ClientConfigvue_type_template_id_3d935500_hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ClientConfigSuccessfullyUpdated')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", ClientConfigvue_type_template_id_3d935500_hoisted_6, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_Authorize')), 1)]))], 8, ClientConfigvue_type_template_id_3d935500_hoisted_1)];
    }),
    _: 1
  }, 8, ["content-title"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.hasClientConfiguration ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    key: 1,
    "content-title": _ctx.translate('GoogleAnalyticsImporter_RemoveClientConfiguration')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("form", {
        action: _ctx.deleteClientCredentialsLink,
        method: "POST",
        enctype: "multipart/form-data",
        id: "removeConfigForm"
      }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_DeleteUploadedClientConfig')) + ":", 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
        type: "hidden",
        name: "config_nonce",
        value: _ctx.configNonce
      }, null, 8, ClientConfigvue_type_template_id_3d935500_hoisted_8), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("button", ClientConfigvue_type_template_id_3d935500_hoisted_9, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_Remove')), 1)], 8, ClientConfigvue_type_template_id_3d935500_hoisted_7)];
    }),
    _: 1
  }, 8, ["content-title"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ClientConfig/ClientConfig.vue?vue&type=template&id=3d935500

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/ClientConfig/ClientConfig.vue?vue&type=script&lang=ts


/* harmony default export */ var ClientConfigvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    hasClientConfiguration: Boolean,
    isConfigured: Boolean,
    authNonce: String,
    configNonce: String
  },
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"]
  },
  data: function data() {
    return {
      clientFileToSet: null,
      clientConfigTextToSet: ''
    };
  },
  computed: {
    forwardToAuthUrl: function forwardToAuthUrl() {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
        action: 'forwardToAuth'
      })));
    },
    configureClientLink: function configureClientLink() {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
        action: 'configureClient'
      })));
    },
    configureClientDesc2: function configureClientDesc2() {
      var link = 'https://matomo.org/docs/google-analytics-importer/';
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ConfigureClientDesc2', "<a href=\"".concat(link, "\" target=\"_blank\" rel=\"noopener noreferrer\">"), '</a>');
    },
    deleteClientCredentialsLink: function deleteClientCredentialsLink() {
      return "?".concat(external_CoreHome_["MatomoUrl"].stringify(Object.assign(Object.assign({}, external_CoreHome_["MatomoUrl"].urlParsed.value), {}, {
        action: 'deleteClientCredentials'
      })));
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ClientConfig/ClientConfig.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/ClientConfig/ClientConfig.vue



ClientConfigvue_type_script_lang_ts.render = ClientConfigvue_type_template_id_3d935500_render

/* harmony default export */ var ClientConfig = (ClientConfigvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/AdminPage.vue?vue&type=template&id=89ec9138

var AdminPagevue_type_template_id_89ec9138_hoisted_1 = {
  class: "hide-import-main-div ga-import-main-div ga4-main-div"
};
var AdminPagevue_type_template_id_89ec9138_hoisted_2 = {
  key: 0
};
var AdminPagevue_type_template_id_89ec9138_hoisted_3 = {
  key: 3,
  class: "ui-confirm",
  id: "confirmCancelJob"
};
var AdminPagevue_type_template_id_89ec9138_hoisted_4 = ["value"];
var AdminPagevue_type_template_id_89ec9138_hoisted_5 = ["value"];
function AdminPagevue_type_template_id_89ec9138_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_CommonConnect = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("CommonConnect");

  var _component_ClientConfig = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ClientConfig");

  var _component_ImportSchedulerGA4 = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ImportSchedulerGA4");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  var _component_ImportStatus = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ImportStatus");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_CommonConnect, {
    extensions: _ctx.extensions,
    "configure-connection-props": _ctx.configureConnectionProps
  }, null, 8, ["extensions", "configure-connection-props"]), _ctx.isClientConfigurable ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ClientConfig, {
    key: 0,
    "has-client-configuration": _ctx.hasClientConfiguration,
    "is-configured": _ctx.isConfigured,
    "auth-nonce": _ctx.authNonce,
    "config-nonce": _ctx.configNonce
  }, null, 8, ["has-client-configuration", "is-configured", "auth-nonce", "config-nonce"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.hasClientConfiguration && _ctx.isConfigured ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    key: 1
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", AdminPagevue_type_template_id_89ec9138_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ScheduleAnImportGA4')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ImportSchedulerGA4, {
        "start-import-nonce": _ctx.startImportNonce,
        "max-end-date-desc": _ctx.maxEndDateDesc,
        "extra-custom-dimensions-field": _ctx.extraCustomDimensionsFieldGa4,
        "stream-ids-field": _ctx.streamIdsFieldGa4
      }, null, 8, ["start-import-nonce", "max-end-date-desc", "extra-custom-dimensions-field", "stream-ids-field"])])];
    }),
    _: 1
  })) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.hasClientConfiguration && _ctx.isConfigured ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
    key: 2,
    id: "importStatusContainer",
    "content-title": _ctx.translate('GoogleAnalyticsImporter_ImportJobs')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      var _ctx$statuses, _ctx$statuses2;

      return [!((_ctx$statuses = _ctx.statuses) !== null && _ctx$statuses !== void 0 && _ctx$statuses.length) ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("p", AdminPagevue_type_template_id_89ec9138_hoisted_2, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_ThereAreNoImportJobs')), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), (_ctx$statuses2 = _ctx.statuses) !== null && _ctx$statuses2 !== void 0 && _ctx$statuses2.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ImportStatus, {
        key: 1,
        statuses: _ctx.statuses,
        "stop-import-nonce": _ctx.stopImportNonce,
        "change-import-end-date-nonce": _ctx.changeImportEndDateNonce,
        "resume-import-nonce": _ctx.resumeImportNonce,
        "schedule-re-import-nonce": _ctx.scheduleReImportNonce
      }, null, 8, ["statuses", "stop-import-nonce", "change-import-end-date-nonce", "resume-import-nonce", "schedule-re-import-nonce"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)];
    }),
    _: 1
  }, 8, ["content-title"])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.hasClientConfiguration && _ctx.isConfigured ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", AdminPagevue_type_template_id_89ec9138_hoisted_3, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h2", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('GoogleAnalyticsImporter_CancelJobConfirm')), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "yes",
    type: "button",
    value: _ctx.translate('General_Yes')
  }, null, 8, AdminPagevue_type_template_id_89ec9138_hoisted_4), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("input", {
    role: "no",
    type: "button",
    value: _ctx.translate('General_No')
  }, null, 8, AdminPagevue_type_template_id_89ec9138_hoisted_5)])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/AdminPage.vue?vue&type=template&id=89ec9138

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/CommonConnect.vue?vue&type=template&id=a5479d76

function CommonConnectvue_type_template_id_a5479d76_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.componentExtensions, function (refComponent, index) {
    return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], {
      key: index
    }, [!_ctx.isNoDataPage ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(_component_ContentBlock, {
      key: 0,
      "content-title": _ctx.isNoDataPage ? '' : _ctx.translate('GoogleAnalyticsImporter_AdminMenuTitle')
    }, {
      default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
        return [(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDynamicComponent"])(refComponent), {
          "manual-config-nonce": _ctx.configConnectProps.manualConfigNonce,
          "base-domain": _ctx.configConnectProps.baseDomain,
          "base-url": _ctx.configConnectProps.baseUrl,
          "manual-action-url": _ctx.configConnectProps.manualActionUrl,
          "primary-text": _ctx.configConnectProps.primaryText,
          "radio-options": _ctx.configConnectProps.radioOptions,
          "manual-config-text": _ctx.configConnectProps.manualConfigText,
          "connect-accounts-url": _ctx.configConnectProps.connectAccountsUrl,
          "connect-accounts-btn-text": _ctx.configConnectProps.connectAccountsBtnText,
          "auth-url": _ctx.configConnectProps.authUrl,
          "unlink-url": _ctx.configConnectProps.unlinkUrl,
          strategy: _ctx.configConnectProps.strategy,
          "connected-with": _ctx.configConnectProps.connectedWith,
          "is-no-data-page": _ctx.isNoDataPage,
          "has-client-configuration": _ctx.hasClientConfiguration,
          "index-action-url": _ctx.indexActionUrl,
          "authorize-url": _ctx.authorizeUrl,
          "forward-to-auth-nonce": _ctx.forwardToAuthNonce,
          "is-configured": _ctx.isConfigured,
          "strategy-to-use": _ctx.strategyToUse,
          "additional-help-text": _ctx.configConnectProps.additionalHelpText
        }, null, 8, ["manual-config-nonce", "base-domain", "base-url", "manual-action-url", "primary-text", "radio-options", "manual-config-text", "connect-accounts-url", "connect-accounts-btn-text", "auth-url", "unlink-url", "strategy", "connected-with", "is-no-data-page", "has-client-configuration", "index-action-url", "authorize-url", "forward-to-auth-nonce", "is-configured", "strategy-to-use", "additional-help-text"]))];
      }),
      _: 2
    }, 1032, ["content-title"])) : (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createBlock"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveDynamicComponent"])(refComponent), {
      key: 1,
      "manual-config-nonce": _ctx.configConnectProps.manualConfigNonce,
      "base-domain": _ctx.configConnectProps.baseDomain,
      "base-url": _ctx.configConnectProps.baseUrl,
      "manual-action-url": _ctx.configConnectProps.manualActionUrl,
      "primary-text": _ctx.configConnectProps.primaryText,
      "radio-options": _ctx.configConnectProps.radioOptions,
      "manual-config-text": _ctx.configConnectProps.manualConfigText,
      "connect-accounts-url": _ctx.configConnectProps.connectAccountsUrl,
      "connect-accounts-btn-text": _ctx.configConnectProps.connectAccountsBtnText,
      "auth-url": _ctx.configConnectProps.authUrl,
      "unlink-url": _ctx.configConnectProps.unlinkUrl,
      strategy: _ctx.configConnectProps.strategy,
      "connected-with": _ctx.configConnectProps.connectedWith,
      "is-no-data-page": _ctx.isNoDataPage,
      "has-client-configuration": _ctx.hasClientConfiguration,
      "index-action-url": _ctx.indexActionUrl,
      "authorize-url": _ctx.authorizeUrl,
      "forward-to-auth-nonce": _ctx.forwardToAuthNonce,
      "is-configured": _ctx.isConfigured,
      "strategy-to-use": _ctx.strategyToUse,
      "additional-help-text": _ctx.configConnectProps.additionalHelpText
    }, null, 8, ["manual-config-nonce", "base-domain", "base-url", "manual-action-url", "primary-text", "radio-options", "manual-config-text", "connect-accounts-url", "connect-accounts-btn-text", "auth-url", "unlink-url", "strategy", "connected-with", "is-no-data-page", "has-client-configuration", "index-action-url", "authorize-url", "forward-to-auth-nonce", "is-configured", "strategy-to-use", "additional-help-text"]))], 64);
  }), 128);
}
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/CommonConnect.vue?vue&type=template&id=a5479d76

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/CommonConnect.vue?vue&type=script&lang=ts


/* harmony default export */ var CommonConnectvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    extensions: Array,
    configureConnectionProps: {
      type: Object,
      required: true
    },
    isNoDataPage: Boolean,
    hasClientConfiguration: Boolean,
    indexActionUrl: String,
    authorizeUrl: String,
    forwardToAuthNonce: String,
    strategyToUse: String,
    isConfigured: Boolean
  },
  components: {
    Notification: external_CoreHome_["Notification"],
    ContentBlock: external_CoreHome_["ContentBlock"]
  },
  computed: {
    componentExtensions: function componentExtensions() {
      var entries = this.extensions;
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["markRaw"])(entries.map(function (ref) {
        return Object(external_CoreHome_["useExternalPluginComponent"])(ref.plugin, ref.component);
      }));
    },
    configConnectProps: function configConnectProps() {
      return this.configureConnectionProps;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/CommonConnect.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/CommonConnect.vue



CommonConnectvue_type_script_lang_ts.render = CommonConnectvue_type_template_id_a5479d76_render

/* harmony default export */ var CommonConnect = (CommonConnectvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/AdminPage.vue?vue&type=script&lang=ts






/* harmony default export */ var AdminPagevue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    hasClientConfiguration: Boolean,
    isConfigured: Boolean,
    isClientConfigurable: Boolean,
    authNonce: String,
    configNonce: String,
    startImportNonce: {
      type: String,
      required: true
    },
    maxEndDateDesc: String,
    extraCustomDimensionsField: {
      type: Object,
      required: true
    },
    extraCustomDimensionsFieldGa4: {
      type: Object,
      required: true
    },
    streamIdsFieldGa4: {
      type: Object,
      required: true
    },
    statuses: {
      type: Array,
      required: true
    },
    stopImportNonce: {
      type: String,
      required: true
    },
    changeImportEndDateNonce: {
      type: String,
      required: true
    },
    resumeImportNonce: {
      type: String,
      required: true
    },
    scheduleReImportNonce: {
      type: String,
      required: true
    },
    importOptionsUa: {
      type: Object,
      required: true
    },
    importOptionsGa4: {
      type: Object,
      required: true
    },
    extensions: Array,
    configureConnectionProps: {
      type: Object,
      required: true
    }
  },
  components: {
    CommonConnect: CommonConnect,
    ImportSchedulerGA4: ImportSchedulerGA4,
    ContentBlock: external_CoreHome_["ContentBlock"],
    ClientConfig: ClientConfig,
    ImportStatus: ImportStatus
  },
  data: function data() {
    return {
      selectedImporter: ''
    };
  },
  computed: {
    importerHelp2Text: function importerHelp2Text() {
      var link = 'https://matomo.org/docs/google-analytics-importer/';
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ImporterHelp2', "<a href=\"".concat(link, "\" target=\"_blank\" rel=\"noreferrer noopener\">"), '</a>');
    },
    importerHelp3Text: function importerHelp3Text() {
      return Object(external_CoreHome_["translate"])('GoogleAnalyticsImporter_ImporterHelp3', '<br><br><strong>', '</strong>');
    },
    componentExtensions: function componentExtensions() {
      var entries = this.extensions;
      return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["markRaw"])(entries.map(function (ref) {
        return Object(external_CoreHome_["useExternalPluginComponent"])(ref.plugin, ref.component);
      }));
    },
    configConnectProps: function configConnectProps() {
      return this.configureConnectionProps;
    }
  }
}));
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/AdminPage.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/AdminPage/AdminPage.vue



AdminPagevue_type_script_lang_ts.render = AdminPagevue_type_template_id_89ec9138_render

/* harmony default export */ var AdminPage = (AdminPagevue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/GoogleAnalyticsImporter/vue/src/index.ts
/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */







// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib-no-default.js




/***/ })

/******/ });
});
//# sourceMappingURL=GoogleAnalyticsImporter.umd.js.map