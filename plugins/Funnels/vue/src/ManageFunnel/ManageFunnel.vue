<!--
  Copyright (C) InnoCraft Ltd - All rights reserved.

  NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
  The intellectual and technical concepts contained herein are protected by trade secret
  or copyright law. Redistribution of this information or reproduction of this material is
  strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.

  You shall use this code only in accordance with the license agreement obtained from
  InnoCraft Ltd.

  @link https://www.innocraft.com/
  @license For license details see https://www.innocraft.com/license
-->

<template>
  <div
    class="alert alert-info"
    v-show="isLocked"
  >
    {{ translate('Funnels_WarningFunnelIsActivatedRequiredUnlock') }}
    <br />
    <input
      type="button"
      class="btn unlockFunnel"
      @click="unlockFunnel()"
      :value="translate('Funnels_Unlock')"
    />
  </div>
  <div class="activateFunnel">
    <Field
      uicontrol="checkbox"
      name="activateFunnel"
      :model-value="funnel.activated"
      @update:model-value="toggleFunnelActivated($event)"
      :model-modifiers="{abortable: true}"
      :title="translate('Funnels_EnableFunnel')"
      :inline-help="getEnableFunnelHelpText"
      v-if="!isHideEnable"
      :disabled="isLocked"
    >
    </Field>
  </div>
  <ActivityIndicator :loading="isLoading"/>
  <div class="manageFunnel" v-show="funnel.activated">
    <div
      class="alert alert-warning"
      v-show="isUnlocked"
    >
      {{ translate('Funnels_WarningOnUpdateReportNeedsArchiving') }}
    </div>
    <h3 class="stepHeading">{{ translate('Funnels_Steps') }}</h3>
    <table
      class="funnelsTable"
      ref="funnelsTable"
      v-show="!isLoading"
      v-content-table
    >
      <thead>
        <tr>
          <th>{{ translate('Funnels_Step') }}</th>
          <th>{{ translate('General_Name') }}</th>
          <th>{{ translate('Funnels_ComparisonColumnTitle') }}</th>
          <th>{{ translate('Funnels_Condition') }}</th>
          <th>{{ translate('Goals_Pattern') }}
            <span
              class="icon-info header-help"
              :title="translate('Funnels_PatternHelpText')"
            ></span></th>
          <th>{{ translate('Funnels_RequiredColumnTitle') }}
            <span
              class="icon-info header-help required-help-icon"
              :title="getRequiredHelpText"
            ></span></th>
          <th>{{ translate('General_Help') }}</th>
          <th>{{ translate('General_Remove') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(step, index) in funnel.steps"
          :class="`step step${index + 1} ${matches[index]} ${isLocked ? 'inactive' : ''}`"
          :key="index"
        >
          <td>{{ index + 1 }}</td>
          <td>
            <div class="stepName">
              <Field
                uicontrol="text"
                :placeholder="translate('Funnels_StepName')"
                :name="`stepName${index + 1}`"
                v-model="step.name"
                :maxlength="150"
                :full-width="true"
                :disabled="isLocked"
              />
            </div>
          </td>
          <td>
            <div>
              <Field
                uicontrol="select"
                name="patternComparison"
                :model-value="step.patternComparison"
                @update:model-value="updatePatternType(step.patternComparison, $event, index);
                    step.patternComparison = $event; validateSteps()"
                :disabled="isLocked"
                :full-width="true"
                :options="patterns"
              >
              </Field>
            </div>
          </td>
          <td>
            <div>
              <Field
                uicontrol="select"
                name="pattern_type"
                :model-value="step.pattern_type"
                @update:model-value="step.pattern_type = $event; validateSteps()"
                :disabled="isLocked"
                :full-width="true"
                :options="patternConditions(step.patternComparison)"
              >
              </Field>
            </div>
          </td>
          <td>
            <div class="stepPattern">
              <Field
                uicontrol="text"
                :model-value="step.pattern"
                @update:model-value="step.pattern = $event; validateSteps()"
                :name="`stepPattern${index}${1}`"
                :maxlength="1000"
                :full-width="true"
                :disabled="isLocked"
                :placeholder="patternExamples[step.pattern_type]"
                :hidden="step.patternComparison === 'goal'"
              />
              <Field
                uicontrol="select"
                :name="`stepPattern${index}${1}`"
                :options="goals"
                :model-value="step.pattern"
                @update:model-value="step.pattern = $event; validateSteps()"
                :disabled="isLocked"
                :hidden="step.patternComparison !== 'goal'"
                :full-width="true"
              />
            </div>
          </td>
          <td>
            <div class="stepRequired">
              <Field
                uicontrol="checkbox"
                :name="`stepRequired${index}${1}`"
                v-model="step.required"
                :disabled="isLocked"
              />
            </div>
          </td>
          <td><span
              class="icon-info table-action"
              :title="translate('Funnels_HelpStepTooltip')"
              @click="showHelpForStep(index)"
            /></td>
          <td><span
              class="icon-minus table-action"
              :title="translate('Funnels_RemoveStepTooltip')"
              v-show="funnel.steps.length > 1"
              @click="removeStep(index)"
            /></td>
        </tr>
        <tr class="step inactive" v-if="!isNonGoalFunnel || isSalesFunnel">
          <td>{{ funnel.steps.length + 1 }}</td>
          <td>
            <div class="stepName">
              <Field
                uicontrol="text"
                v-model="getGoalName"
                :full-width="true"
                :disabled="true"
              />
            </div>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <div class="stepRequired">
              <Field
                uicontrol="checkbox"
                v-model="isGoalRequired"
                :disabled="true"
              />
            </div>
          </td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <div id="funnelValidationError" />
    <div
      class="tableActionBar"
      v-show="!isLoading"
    >
      <button
        class="addNewStep"
        @click="addStep()"
      >
        <span class="icon-add" />
        {{ translate('Funnels_AddStep') }}
      </button>
    </div>
    <div class="targetValidator">
      <div class="urlField">
        <Field
          uicontrol="text"
          name="urlField"
          :title="translate('Funnels_ValidateStepsOptional')"
          placeholder="https://www.example.com"
          :model-value="validateUrl"
          @update:model-value="validateUrl = $event; validateSteps()"
          @click="prefillValidateUrl()"
          :inline-help="getTestUrlHelpText"
        />
      </div>
      <span
        class="loadingPiwik loadingMatchingSteps"
        v-show="isLoadingMatchingSteps"
      >
        <img
          src="plugins/Morpheus/images/loading-blue.gif"
          alt
        />{{ translate('General_LoadingData') }}
      </span>
    </div>
    <div
      class="alert alert-warning"
      v-show="isUnlocked"
    >
      {{ translate('Funnels_WarningOnUpdateReportNeedsArchiving') }}
    </div>
    <div
      class="ui-confirm"
      ref="infoFunnelIsLocked"
    >
      <h2>{{ translate('Funnels_InfoFunnelIsLocked') }}</h2>
      <input
        role="unlock"
        type="button"
        :value="translate('Funnels_Unlock')"
      />
      <input
        role="ok"
        type="button"
        :value="translate('General_Cancel')"
      />
    </div>
    <div
      class="ui-confirm"
      ref="cannotActivateIncompleteSteps"
    >
      <h2>{{ translate('Funnels_InfoCannotActivateFunnelIncomplete') }}</h2>
      <input
        role="ok"
        type="button"
        :value="translate('General_Ok')"
      />
    </div>
    <div
      class="ui-confirm"
      ref="confirmUnlockFunnel"
    >
      <h2>{{ translate('Funnels_ConfirmUnlockFunnel') }}</h2>
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
    </div>
    <div
      class="ui-confirm"
      ref="confirmDeactivateFunnel"
    >
      <h2>{{ translate('Funnels_ConfirmDeactivateFunnel') }}</h2>
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  Matomo,
  AjaxHelper,
  ContentTable,
  MatomoUrl,
  debounce,
  AjaxOptions,
  ActivityIndicator,
} from 'CoreHome';
import { Field, AbortableEvent } from 'CorePluginsAdmin';
import { ManageGoalsStore } from 'Goals';
import { Funnel, FunnelStep } from '../types';

interface PatterConditions {
  key: string;
  value: string;
  example: string;
}
interface PatternMatchOption {
  comparisonName: string;
  conditions: PatterConditions[];
  example: string;
}

interface ManageFunnelState {
  funnel: Funnel;
  isLoading: boolean;
  patternMatchOptions: PatternMatchOption[];
  isLocked: boolean;
  isUnlocked: boolean;
  matches: Record<number, string>;
  validateUrl: string;
  isLoadingMatchingSteps: boolean;
  isGoalRequired: boolean;
}

interface TestUrlMatchesTest {
  matches: boolean;
  pattern_type: string;
  pattern: string;
}

interface TestUrlMatchesResponse {
  url: string;
  tests: TestUrlMatchesTest[];
}

export default defineComponent({
  props: {
    showGoal: Number,
    isHideEnable: {
      type: Boolean,
      default: false,
    },
    isSalesFunnel: {
      type: Boolean,
      default: false,
    },
    isNonGoalFunnel: {
      type: Boolean,
      default: false,
    },
    goals: {
      type: Array,
      required: true,
    },
  },
  components: {
    ActivityIndicator,
    Field,
  },
  directives: {
    ContentTable,
  },
  data(): ManageFunnelState {
    return {
      funnel: {} as unknown as Funnel,
      isLoading: false,
      patternMatchOptions: [],
      isLocked: false,
      isUnlocked: false,
      matches: {},
      validateUrl: '',
      isLoadingMatchingSteps: false,
      isGoalRequired: true,
    };
  },
  created() {
    // we wait for 200ms before actually sending a request as user might be still typing
    this.fetchMatchingSteps = debounce(this.fetchMatchingSteps, 200);

    const idGoal = ManageGoalsStore.idGoal.value || this.showGoal;
    if ((!this.isNonGoalFunnel || this.isSalesFunnel) && typeof idGoal === 'number') {
      this.initGoalForm('Goals.updateGoal', idGoal, '');
    }

    AjaxHelper.fetch<PatternMatchOption[]>({
      method: 'Funnels.getAvailablePatternMatches',
    }).then((response) => {
      this.patternMatchOptions = response;
    });

    this.reset();

    // Only listen for the events related to the parent view in order to avoid confusion
    if (this.isSalesFunnel) {
      Matomo.on('Funnels.beforeUpdateSalesFunnel', this.onSetFunnel);
    }

    if (this.isNonGoalFunnel && !this.isSalesFunnel) {
      Matomo.on('Funnels.resetForm', () => this.resetForm());
      Matomo.on('Funnels.initFunnelForm', this.initFunnelForm.bind(this));
      Matomo.on('Funnels.beforeUpdateFunnel', this.onSetFunnel);
    }

    if (!this.isNonGoalFunnel) {
      Matomo.on('Goals.beforeInitGoalForm', this.initGoalForm.bind(this));
      Matomo.on('Goals.beforeAddGoal', this.onSetFunnel.bind(this));
      Matomo.on('Goals.beforeUpdateGoal', this.onSetFunnel.bind(this));
      Matomo.on('Goals.cancelForm', () => this.resetForm());
      Matomo.on('Goals.goalNameChanged', this.updateGoalName.bind(this));
    }
  },
  updated() {
    this.$nextTick(() => {
      if (!this.isSalesFunnel) {
        this.scrollToFunnelsTable();
        return;
      }

      // If it's a sales funnel, give the other reports a second to load before scrolling
      setTimeout(() => {
        this.scrollToFunnelsTable();
      }, 1000);
    });
  },
  unmounted(): void {
    // Remove the onSetFunnel listeners otherwise they might accidentally double up
    if (this.isSalesFunnel) {
      Matomo.off('Funnels.beforeUpdateSalesFunnel', this.onSetFunnel);
    }

    if (this.isNonGoalFunnel && !this.isSalesFunnel) {
      Matomo.off('Funnels.beforeUpdateFunnel', this.onSetFunnel);
    }
  },
  methods: {
    testUrlMatchesSteps: AjaxHelper.oneAtATime<TestUrlMatchesResponse>(
      'Funnels.testUrlMatchesSteps',
      {
        errorElement: '#funnelValidationError',
      },
    ),
    getGoalFunnel: AjaxHelper.oneAtATime<Funnel>('Funnels.getGoalFunnel'),
    getFunnel: AjaxHelper.oneAtATime<Funnel>('Funnels.getFunnel'),
    doUnlock() {
      this.isLocked = false;
      this.isUnlocked = true;
    },
    confirmFunnelIsLocked() {
      return new Promise<void>((resolve) => {
        Matomo.helper.modalConfirm(this.$refs.infoFunnelIsLocked as HTMLElement, {
          unlock: () => {
            this.doUnlock();

            resolve();
          },
        });
      });
    },
    addStep() {
      if (!this.funnel) {
        return;
      }

      if (this.isLocked) {
        this.confirmFunnelIsLocked().then(() => {
          this.addStep();
        });
        return;
      }

      if (!this.funnel.steps?.length) {
        this.funnel.steps = [];
      }

      this.funnel.steps = [
        ...this.funnel.steps,
        {
          name: '',
          pattern: '',
          pattern_type: 'path_equals',
          patternComparison: 'path',
          required: true,
        },
      ];
    },
    removeStep(index: number) {
      if (!this.funnel) {
        return;
      }

      if (this.isLocked) {
        this.confirmFunnelIsLocked().then(() => {
          this.removeStep(index);
        });
        return;
      }

      if (index > -1 && this.funnel?.steps) {
        this.removeTooltipForStep(index + 1);
        const newSteps = [...this.funnel.steps];
        newSteps.splice(index, 1);
        this.funnel.steps = newSteps;
      }

      this.validateSteps();
    },
    removeTooltipForStep(stepNumber: number) {
      const selector = `table.funnelsTable tr.step${stepNumber} span.icon-minus`;
      const removeStepIcon = document.querySelectorAll(selector)[0];
      const tooltipId = removeStepIcon.getAttribute('aria-describedby');
      if (!tooltipId) {
        return;
      }
      const tooltipElement = document.getElementById(tooltipId);
      if (!tooltipElement) {
        return;
      }
      tooltipElement.remove();
    },
    prefillValidateUrl() {
      if (!this.validateUrl) {
        this.validateUrl = 'https://www.';
      }
    },
    fetchMatchingSteps() {
      const url = this.validateUrl;

      if (!url || !this.funnel?.steps?.length || !this.stepsWithPattern.length) {
        return;
      }

      this.isLoadingMatchingSteps = true;

      this.testUrlMatchesSteps(
        {
          url,
        },
        {
          steps: this.stepsWithPattern,
        },
      ).then((response) => {
        if (!this.funnel?.steps) {
          return;
        }

        if (!response?.url || !response?.tests || response.url !== this.validateUrl) {
          return;
        }

        this.funnel.steps.forEach((step, i) => {
          response.tests.forEach((test) => {
            // we do not test for step positions as the patterns might have changed and this way
            // we always show a correct result whether something matches even if value changed
            // since sending the request
            if (test
              && step.pattern === test.pattern
              && step.pattern_type === test.pattern_type
            ) {
              this.matches[i] = test.matches ? 'validateMatch' : 'validateMismatch';
            }
          });
        });
      }).finally(() => {
        this.isLoadingMatchingSteps = false;
      });
    },
    cannotActivateIncompleteSteps() {
      Matomo.helper.modalConfirm(this.$refs.cannotActivateIncompleteSteps as HTMLElement, {});
    },
    validateSteps() {
      this.matches = { 1: '' };
      if (!this.funnel.steps?.length) {
        return;
      }

      this.matches = this.funnel.steps.map(() => 'noValidation');
      if (!this.validateUrl) {
        return;
      }

      this.fetchMatchingSteps();
    },
    updatePatternType(oldPatternComparison: string, newPatternComparison: string, index: number) {
      const patternConditions = this.patternConditions(newPatternComparison);
      const patternConditionFirstKey = Object.keys(patternConditions)[0];
      this.funnel.steps[index].pattern_type = patternConditionFirstKey;

      if (newPatternComparison === 'goal' && this.funnel.steps[index].patternComparison === oldPatternComparison) {
        const goal = this.goals[0] as Record<string, string>;
        this.funnel.steps[index].pattern = goal.key;
      } else {
        this.funnel.steps[index].pattern = '';
      }
    },
    unlockFunnel() {
      if (!this.funnel) {
        return;
      }

      if (this.isLocked) {
        Matomo.helper.modalConfirm(this.$refs.confirmUnlockFunnel as HTMLElement, {
          yes: () => {
            this.doUnlock();
          },
        });
      }
    },
    toggleFunnelActivated(event: AbortableEvent<boolean>) {
      if (!this.funnel) {
        return;
      }

      if (this.isLocked && event) {
        event.abort();

        // undo toggle change from checkbox
        this.confirmFunnelIsLocked().then(() => {
          this.toggleFunnelActivated(event);
        });
        return;
      }

      if (this.funnel.activated) {
        Matomo.helper.modalConfirm(this.$refs.confirmDeactivateFunnel as HTMLElement, {
          yes: () => {
            this.funnel.activated = false;
          },
          no: () => {
            event.abort();
            this.funnel.activated = true;
          },
        });
      } else {
        this.funnel.activated = true;
      }
    },
    showHelpForStep(index: number) {
      const step = this.funnel?.steps?.[index];
      const hasPatternAndType = step?.pattern && step?.pattern_type;

      const url = MatomoUrl.stringify({
        module: 'Funnels',
        action: 'stepHelp',
        pattern: hasPatternAndType ? step.pattern : undefined,
        pattern_type: hasPatternAndType ? step.pattern_type : undefined,
      });

      const help = translate('General_Help');
      Piwik_Popover.createPopupAndLoadUrl(url, help, 'funnelStepHelp');
    },
    reset(skipAddStep = false) {
      // we need isActivated for the view handling, and activated for the funnel itself. Because
      // we listen to ng-change / ng-click it would be confusing otherwise. we try to remove
      // isActivated later
      this.funnel = {
        activated: this.isNonGoalFunnel,
        steps: [],
      } as unknown as Funnel;
      this.isLocked = false;
      this.isUnlocked = false;
      this.matches = { 1: '' };
      this.validateUrl = '';
      if (!skipAddStep) {
        this.addStep();
      }
    },
    resetForm(skipAddStep = false) {
      this.reset(skipAddStep);
      this.isLoading = false;
    },
    initGoalForm(goalMethodAPI: string, goalId: string|number, goalName: string) {
      this.resetForm();

      if (goalId === '' || goalMethodAPI === 'Goals.addGoal') {
        return;
      }

      this.isLoading = true;
      this.getGoalFunnel({ idGoal: goalId }).then((response) => {
        if (!response) {
          return;
        }

        this.funnel = response;

        this.funnel.name = this.funnel.name ? this.funnel.name : goalName;

        if (!this.funnel.steps) {
          this.funnel.steps = [];
          this.addStep();
        }

        if (this.funnel.activated) {
          // we only allow save once user has confirmed to deactivate the funnel
          this.isLocked = true;
        } else {
          this.isLocked = false;
        }

        // If it's a sales funnel and the funnel doesn't exist yet, enable by default
        if (this.isNonGoalFunnel && typeof this.funnel.idfunnel === 'undefined') {
          this.funnel.activated = true;
        }

        this.validateSteps();
      }).finally(() => {
        this.isLoading = false;
      });
    },
    initFunnelForm(idSite: number, idFunnel: number) {
      this.resetForm(idFunnel > 0);

      if (idFunnel === 0) {
        return;
      }

      this.isLoading = true;

      // Have a slight delay to avoid potential race condition
      setTimeout(() => {
        this.getFunnel({ idSite, idFunnel }).then((response) => {
          if (!response) {
            return;
          }

          this.funnel = response;

          if (!this.funnel.steps) {
            this.funnel.steps = [];
            this.addStep();
          }

          if (this.funnel.activated) {
            // we only allow save once user has confirmed to deactivate the funnel
            this.isLocked = true;
          } else {
            this.isLocked = false;
          }

          this.validateSteps();
        }).finally(() => {
          this.isLoading = false;
        });
      }, 500);
    },
    onSetFunnel({ parameters, options }: { parameters: QueryParameters, options: AjaxOptions }) {
      if (!this.funnel || (this.isLocked && (this.isSalesFunnel || this.isNonGoalFunnel))) {
        parameters.isLocked = this.isLocked;
        parameters.cancelRequest = true;

        return;
      }

      if (this.funnel.activated && !this.funnel.steps?.length) {
        this.cannotActivateIncompleteSteps();

        parameters.cancelRequest = true;

        return;
      }

      const isAStepMissingNameOrPattern = this.funnel.steps.some((s) => this.isStepIncomplete(s));
      if (this.funnel.activated && isAStepMissingNameOrPattern) {
        this.cannotActivateIncompleteSteps();

        parameters.cancelRequest = true;

        return;
      }

      options.postParams = {
        ...options.postParams,
        funnelSteps: this.stepsWithNameAndPattern,
        funnelActivated: this.funnel.activated ? '1' : '0',
      };

      if (this.isNonGoalFunnel) {
        options.postParams = {
          ...options.postParams,
          steps: this.stepsWithNameAndPattern,
          isActivated: this.funnel.activated ? '1' : '0',
        };

        if (!this.isSalesFunnel && options.postParams.steps.length) {
          options.postParams.steps[options.postParams.steps.length - 1].required = 1;
        }
      }
    },
    isStepIncomplete(step: FunnelStep) {
      return !step.name || !step.name.trim() || !step.pattern || !step.pattern.trim();
    },
    updateGoalName(goalName: string) {
      this.funnel.name = goalName;
    },
    scrollToFunnelsTable() {
      const element = this.$refs.funnelsTable as HTMLElement;
      const params = { ...MatomoUrl.hashParsed.value };
      if (params.scrollToFunnel && element) {
        delete params.scrollToFunnel;
        element.scrollIntoView();
      }
    },
    patternConditions(patternCondition: string) {
      const result: Record<string, string> = {};
      Object.entries(this.patternMatchOptions).forEach(([index, patternMatchOption]) => {
        if (index === patternCondition) {
          Object.values(patternMatchOption.conditions).forEach((condition) => {
            result[condition.key] = condition.value;
          });
        }
      });
      return result;
    },
  },
  computed: {
    patternExamples() {
      const result: Record<string, string> = {};
      Object.values(this.patternMatchOptions).forEach((patternMatchOption) => {
        Object.values(patternMatchOption.conditions).forEach((condition) => {
          result[condition.key] = condition.example;
        });
      });
      return result;
    },
    patterns() {
      const result: Record<string, string> = {};
      Object.entries(this.patternMatchOptions).forEach(([index, patternMatchOption]) => {
        result[index] = patternMatchOption.comparisonName;
      });
      return result;
    },
    stepsWithPattern() {
      if (!this.funnel.steps?.length) {
        return [];
      }

      return this.funnel.steps
        .filter((step) => step && step.pattern && step.pattern_type)
        .map((s) => ({ ...s, required: s.required ? 1 : 0 }));
    },
    stepsWithNameAndPattern() {
      let steps = this.stepsWithPattern;
      steps = steps.filter((s) => s.name);
      return steps;
    },
    getEnableFunnelHelpText() {
      const helpLink = '<a target="_blank" rel="noreferrer noopener" href="https://matomo.org/faq/funnels/faq_22793/">';
      return translate('Funnels_EnableFunnelHelpText', helpLink, '</a>');
    },
    getGoalName() {
      if (this.isSalesFunnel) {
        return translate('Ecommerce_Sales');
      }

      return this.funnel.name ? this.funnel.name : translate('Goals_GoalName');
    },
    getTestUrlHelpText() {
      const testUrlHelpText = translate('Funnels_TestUrlHelpText');
      const testUrlHelpTextGoalComparison = translate('Funnels_TestUrlHelpTextGoalComparison', '<i>', '</i>');
      return `${testUrlHelpText} ${testUrlHelpTextGoalComparison}`;
    },
    getRequiredHelpText() {
      const note = translate(
        'Funnels_RequiredStepsHelpTextNote',
        '<br><br><strong>',
        '</strong>',
      );
      return translate('Funnels_RequiredStepsHelpTextNew') + note;
    },
  },
});
</script>
