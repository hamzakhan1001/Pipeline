<template>
  <div v-show="visible" ref="tooltipRef" class="tooltip" :style="tooltipStyle">
    <div class="tooltip-item title">{{ title }}</div>
    <div class="tooltip-item subtitle">{{ subtitle }}</div>
    <div class="tooltip-item" :class="{ selected: type === 'exits' }">
      <span class="tooltip-label">{{ translate('Funnels_DropOff') }}</span>
      <span class="tooltip-value">{{ formatNumber(exits) }}</span>
    </div>
    <div class="tooltip-item" :class="{ selected: type === 'skipped' }">
      <span class="tooltip-label">{{ translate('Funnels_Skips') }}</span>
      <span class="tooltip-value">{{ formatNumber(skipped) }}</span>
    </div>
    <div class="tooltip-item" :class="{ selected: type === 'entries' }">
      <span class="tooltip-label">{{ translate('Funnels_Entries') }}</span>
      <span class="tooltip-value">{{ formatNumber(entries) }}</span>
    </div>
    <div class="tooltip-item" :class="{ selected: type === 'proceeded' }">
      <span class="tooltip-label">{{ translate('Funnels_Progressions') }}</span>
      <span class="tooltip-value">{{ formatNumber(proceeded) }}</span>
    </div>
  </div>
</template>

<script lang="ts">
import {
  defineComponent, reactive, toRefs, computed, CSSProperties, nextTick, ref,
} from 'vue';
import { translate } from 'CoreHome';
import { formatNumber } from '../../../javascripts/numberFormatter';

export default defineComponent({
  props: {
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      required: true,
    },
    exits: {
      type: Number,
      required: true,
    },
    skipped: {
      type: Number,
      required: true,
    },
    entries: {
      type: Number,
      required: true,
    },
    proceeded: {
      type: Number,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
  },
  setup() {
    const state = reactive({
      visible: false,
      position: { top: 0, left: 0 },
    });

    const tooltipRef = ref<HTMLElement | null>(null);

    const tooltipStyle = computed<CSSProperties>(() => ({
      top: `${state.position.top}px`,
      left: `${state.position.left}px`,
      position: 'absolute',
      zIndex: 1000,
    }));

    function show(event: MouseEvent) {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const scrollLeft = window.scrollX || document.documentElement.scrollLeft;
      state.position.top = event.clientY + scrollTop + 10;
      state.position.left = event.clientX + scrollLeft + 10;
      state.visible = true;

      nextTick(() => {
        const tooltipElement = tooltipRef.value;
        if (tooltipElement) {
          const { innerWidth, innerHeight } = window;
          const tooltipRect = tooltipElement.getBoundingClientRect();

          if (tooltipRect.right > innerWidth) {
            state.position.left = event.clientX + scrollLeft - tooltipRect.width - 10;
          }
          if (tooltipRect.bottom > innerHeight) {
            state.position.top = event.clientY + scrollTop - tooltipRect.height - 10;
          }

          const adjustedTooltipRect = tooltipElement.getBoundingClientRect();
          if (adjustedTooltipRect.left < 0) {
            state.position.left = scrollLeft + 10;
          }
          if (adjustedTooltipRect.top < 0) {
            state.position.top = scrollTop + 10;
          }
        }
      });
    }

    function hide() {
      state.visible = false;
    }

    return {
      ...toRefs(state),
      tooltipRef,
      show,
      hide,
      tooltipStyle,
      translate,
      formatNumber,
    };
  },
});
</script>
