(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("Goals"), require("vue"), require("CorePluginsAdmin"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", "Goals", , "CorePluginsAdmin"], factory);
	else if(typeof exports === 'object')
		exports["MultiChannelConversionAttribution"] = factory(require("CoreHome"), require("Goals"), require("vue"), require("CorePluginsAdmin"));
	else
		root["MultiChannelConversionAttribution"] = factory(root["CoreHome"], root["Goals"], root["Vue"], root["CorePluginsAdmin"]);
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE__19dc__, __WEBPACK_EXTERNAL_MODULE__76d2__, __WEBPACK_EXTERNAL_MODULE__8bbf__, __WEBPACK_EXTERNAL_MODULE_a5a2__) {
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
/******/ 	__webpack_require__.p = "plugins/MultiChannelConversionAttribution/vue/dist/";
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

/***/ "76d2":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE__76d2__;

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
__webpack_require__.d(__webpack_exports__, "ManageMultiattribution", function() { return /* reexport */ ManageMultiattribution; });
__webpack_require__.d(__webpack_exports__, "ReportAttribution", function() { return /* reexport */ ReportAttribution; });

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

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.vue?vue&type=template&id=7b8b3a38

var _hoisted_1 = {
  class: "manageMultiAttribution"
};
var _hoisted_2 = {
  name: "isEnabled"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "checkbox",
    name: "isEnabled",
    title: _ctx.translate('MultiChannelConversionAttribution_Enabled'),
    modelValue: _ctx.isEnabled,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.isEnabled = $event;
    }),
    introduction: _ctx.translate('MultiChannelConversionAttribution_MultiChannelConversionAttribution'),
    "inline-help": _ctx.translate('MultiChannelConversionAttribution_Introduction')
  }, null, 8, ["title", "modelValue", "introduction", "inline-help"])])]);
}
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.vue?vue&type=template&id=7b8b3a38

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// EXTERNAL MODULE: external "Goals"
var external_Goals_ = __webpack_require__("76d2");

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.vue?vue&type=script&lang=ts




/* harmony default export */ var ManageMultiattributionvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {},
  components: {
    Field: external_CorePluginsAdmin_["Field"]
  },
  data: function data() {
    return {
      isLoading: false,
      isEnabled: null
    };
  },
  created: function created() {
    var _this = this;

    var idGoal = external_Goals_["ManageGoalsStore"].idGoal.value;

    if (typeof idGoal === 'number') {
      this.initGoalForm('Goals.updateGoal', idGoal);
    }

    this.isLoading = false;
    this.reset();
    external_CoreHome_["Matomo"].on('Goals.cancelForm', function () {
      return _this.resetForm();
    });
    external_CoreHome_["Matomo"].on('Goals.beforeInitGoalForm', this.initGoalForm.bind(this));
    external_CoreHome_["Matomo"].on('Goals.beforeAddGoal', this.onSetAttribution.bind(this));
    external_CoreHome_["Matomo"].on('Goals.beforeUpdateGoal', this.onSetAttribution.bind(this));
  },
  methods: {
    reset: function reset() {
      this.isEnabled = true;
    },
    resetForm: function resetForm() {
      this.reset();
      this.isLoading = false;
    },
    getGoalAttribution: external_CoreHome_["AjaxHelper"].oneAtATime('MultiChannelConversionAttribution.getGoalAttribution'),
    initGoalForm: function initGoalForm(goalMethodAPI, goalId) {
      var _this2 = this;

      this.resetForm();

      if (!goalId || goalMethodAPI === 'Goals.addGoal') {
        return;
      }

      this.isLoading = true;
      this.getGoalAttribution({
        idGoal: goalId
      }).then(function (response) {
        _this2.isEnabled = !!response.isEnabled && response.isEnabled !== '0';
      }).finally(function () {
        _this2.isLoading = false;
      });
    },
    onSetAttribution: function onSetAttribution(_ref) {
      var options = _ref.options;

      if (this.isEnabled === null) {
        return; // not loaded yet
      }

      options.postParams = Object.assign(Object.assign({}, options.postParams), {}, {
        multiAttributionEnabled: this.isEnabled ? 1 : 0
      });
    }
  }
}));
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.vue



ManageMultiattributionvue_type_script_lang_ts.render = render

/* harmony default export */ var ManageMultiattribution = (ManageMultiattributionvue_type_script_lang_ts);
// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.vue?vue&type=template&id=c9efd062

var ReportAttributionvue_type_template_id_c9efd062_hoisted_1 = {
  class: "MultiChannelConversionAttributionWidget"
};
var ReportAttributionvue_type_template_id_c9efd062_hoisted_2 = {
  key: 0
};
var _hoisted_3 = {
  key: 1,
  class: "alert alert-info"
};
var _hoisted_4 = {
  key: 2,
  class: "row goalAndDaysPrior"
};
var _hoisted_5 = {
  class: "col s12 m3"
};
var _hoisted_6 = {
  name: "idgoal"
};
var _hoisted_7 = {
  class: "col s12 m6"
};
var _hoisted_8 = {
  name: "campaignDimensionCombination"
};
var _hoisted_9 = {
  key: 3,
  class: "row modelSelection"
};
var _hoisted_10 = {
  class: "col s12 m3"
};
var _hoisted_11 = {
  name: "model1"
};
var _hoisted_12 = {
  class: "col s12 m3"
};
var _hoisted_13 = {
  name: "model2"
};
var _hoisted_14 = {
  class: "col s12 m3"
};
var _hoisted_15 = {
  name: "model3"
};
var _hoisted_16 = {
  class: "attributionReport",
  ref: "attributionReport"
};
function ReportAttributionvue_type_template_id_c9efd062_render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_EnrichedHeadline = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("EnrichedHeadline");

  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", ReportAttributionvue_type_template_id_c9efd062_hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [!_ctx.isWidgetized ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("h2", ReportAttributionvue_type_template_id_c9efd062_hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_EnrichedHeadline, {
    "inline-help": _ctx.reportHelp
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('MultiChannelConversionAttribution_MultiChannelConversionAttribution')), 1)];
    }),
    _: 1
  }, 8, ["inline-help"])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.goals.length === 0 ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_3, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate(_ctx.noGoalEnabledMessageKey)), 1)) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.goals.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_4, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_5, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_6, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "idgoal",
    disabled: _ctx.goals.length <= 1,
    "model-value": _ctx.idGoal,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      _ctx.idGoal = $event;

      _ctx.onReportChange();
    }),
    "full-width": true,
    title: _ctx.translate('General_Goal'),
    options: _ctx.goals
  }, null, 8, ["disabled", "model-value", "title", "options"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_7, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_8, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "campaignDimensionCombination",
    "model-value": _ctx.campaignDimensionCombination,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      _ctx.campaignDimensionCombination = $event;

      _ctx.onReportChange();
    }),
    "full-width": true,
    title: _ctx.translate('MultiChannelConversionAttribution_CampaignDimensionCombinationTitleNew') + _ctx.$sanitize(_ctx.getEditURL),
    options: _ctx.campaignDimensionCombinationOptions
  }, null, 8, ["model-value", "title", "options"])])])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true), _ctx.goals.length ? (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_9, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_10, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_11, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "model1",
    "model-value": _ctx.model1,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      _ctx.model1 = $event;

      _ctx.onReportChange();

      _ctx.modelChanged();
    }),
    "full-width": true,
    title: _ctx.translate('MultiChannelConversionAttribution_AttributionModelX', 1),
    options: _ctx.attributionModels
  }, null, 8, ["model-value", "title", "options"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_12, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_13, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "model2",
    "model-value": _ctx.model2,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      _ctx.model2 = $event;

      _ctx.onReportChange();

      _ctx.modelChanged();
    }),
    "full-width": true,
    title: _ctx.translate('MultiChannelConversionAttribution_AttributionModelX', 2),
    options: _ctx.attributionModelsCancelable
  }, null, 8, ["model-value", "title", "options"])])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_14, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_15, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
    uicontrol: "select",
    name: "model3",
    "model-value": _ctx.model3,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      _ctx.model3 = $event;

      _ctx.onReportChange();

      _ctx.modelChanged();
    }),
    "full-width": true,
    title: _ctx.translate('MultiChannelConversionAttribution_AttributionModelX', 3),
    options: _ctx.attributionModelsCancelable
  }, null, 8, ["model-value", "title", "options"])])])])) : Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createCommentVNode"])("", true)]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_16, null, 512)]);
}
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.vue?vue&type=template&id=c9efd062

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.vue?vue&type=script&lang=ts



var _window = window,
    $ = _window.$;
/* harmony default export */ var ReportAttributionvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {
    isWidgetized: Boolean,
    settingsUrl: String,
    reportHtml: {
      type: String,
      required: true
    },
    reportHelp: {
      type: String,
      required: true
    },
    noGoalEnabledMessageKey: {
      type: String,
      required: true
    },
    goals: {
      type: Array,
      required: true
    },
    campaignDimensionCombinationOptions: {
      type: Array,
      required: true
    },
    attributionModels: {
      type: Array,
      required: true
    },
    attributionModelsCancelable: {
      type: Array,
      required: true
    },
    firstGoal: [String, Number],
    defaultCampaignDimensionCombination: {
      type: String,
      required: true
    },
    selectedModels: {
      type: Array,
      required: true
    }
  },
  components: {
    EnrichedHeadline: external_CoreHome_["EnrichedHeadline"],
    Field: external_CorePluginsAdmin_["Field"]
  },
  data: function data() {
    return {
      idGoal: this.firstGoal,
      campaignDimensionCombination: this.defaultCampaignDimensionCombination,
      model1: this.selectedModels[0],
      model2: this.selectedModels[1],
      model3: this.selectedModels[2]
    };
  },
  mounted: function mounted() {
    $(this.$refs.attributionReport).html(this.reportHtml);
    var dataTableEl = $(this.$refs.attributionReport).find('.dataTable:first');

    if (dataTableEl.length) {
      var reportId = dataTableEl.data('report');

      window.require('piwik/UI/DataTable').initNewDataTables(reportId);

      var dataTable = dataTableEl.data('uiControlObject');
      dataTable.dataTableLoaded(this.reportHtml, dataTable.workingDivId);
      this.modelChanged();
      this.updateHash();
    }
  },
  methods: {
    onReportChange: function onReportChange() {
      var dataTable = $(this.$refs.attributionReport).find('.dataTable:first').data('uiControlObject');

      if (dataTable !== null && dataTable !== void 0 && dataTable.param) {
        this.updateHash();
        dataTable.param.idGoal = this.idGoal;
        dataTable.param.idCampaignDimensionCombination = this.campaignDimensionCombination;
        dataTable.param.attributionModels = "".concat(this.model1, ",").concat(this.model2, ",").concat(this.model3);
        dataTable.reloadAjaxDataTable();
      }
    },
    modelChanged: function modelChanged() {
      var element = document.getElementById('inconsistentDataAlert');

      if (!element) {
        return;
      }

      if (this.model1 === 'lastNonDirect' || this.model2 === 'lastNonDirect' || this.model3 === 'lastNonDirect') {
        element.classList.remove('hide');
      } else {
        element.classList.add('hide');
      }
    },
    updateHash: function updateHash() {
      // Update the hash to remember the selection on refresh
      var newParams = Object.assign({}, external_CoreHome_["MatomoUrl"].hashParsed.value);
      delete newParams.idGoal;
      delete newParams.idCampaignDimensionCombination;
      delete newParams.attributionModel1;
      delete newParams.attributionModel2;
      delete newParams.attributionModel3;
      newParams.idGoal = this.idGoal;
      newParams.idCampaignDimensionCombination = this.campaignDimensionCombination;
      newParams.attributionModel1 = this.model1;
      newParams.attributionModel2 = this.model2;
      newParams.attributionModel3 = this.model3;
      external_CoreHome_["MatomoUrl"].updateHash(newParams);
    }
  },
  computed: {
    getEditURL: function getEditURL() {
      if (this.settingsUrl) {
        return Object(external_CoreHome_["translate"])('MultiChannelConversionAttribution_CampaignCombinationEdit', "<a href=\"".concat(this.settingsUrl, "\" rel=\"noreferrer noopener\" target=\"_blank\" id=\"multi-channel-conversion-attribution-settings-edit-link\">"), '</a>');
      }

      return '';
    }
  }
}));
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.vue?vue&type=script&lang=ts
 
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.vue



ReportAttributionvue_type_script_lang_ts.render = ReportAttributionvue_type_template_id_c9efd062_render

/* harmony default export */ var ReportAttribution = (ReportAttributionvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/MultiChannelConversionAttribution/vue/src/index.ts
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
//# sourceMappingURL=MultiChannelConversionAttribution.umd.js.map