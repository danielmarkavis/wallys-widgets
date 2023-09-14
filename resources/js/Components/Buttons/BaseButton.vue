<template>
    <component
        :is="tagTypes[tag ?? 'button']"
        :disabled="(disabled || processing)"
        :class="classes"
        class="inline-flex items-center p-2 border rounded-md uppercase tracking-widest focus:outline-none transition ease-in-out duration-150"
        v-bind="$attrs"
    >
        <div
            v-if="$slots.icon || processing"
            :class="[iconClass, $slots.default ? (compact?'mr-2':'mr-3') : '']"
        >
            <ICircle
                v-if="processing"
            />

            <slot
                v-if="!processing"
                name="icon"
                v-bind="iconClass"
            />
        </div>

        <span
            v-if="$slots.default"
            :class="fontSize"
        >
            <slot/>
        </span>
    </component>
</template>

<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import {computed} from "vue";
import ICircle from "@/Components/Icons/ICircle.vue";

type BaseButtonType = 'a' | 'button' | 'link';
type ButtonColors = 'blue' | 'gray' | 'green' | 'red' | 'yellow';

const props = defineProps<{
    color: ButtonColors,
    tag?: BaseButtonType,
    info?: string,
    disabled?: boolean,
    compact?: boolean,
    processing?: boolean,
    borderOnly?: boolean,
    dashed?: boolean
}>()

const tagTypes = {
    'a': 'a',
    'link': Link,
    'button': 'button',
}

const iconClass = computed(() => {
    return !props.compact ? 'w-4 h-4' : 'w-3 h-3'
})

const fontSize = computed(() => {
    return !props.compact ? 'text-md leading-4' : 'text-xs leading-3'
})

const colors = computed(() => {
    if (!props.borderOnly) {
        return colorBackgroundClass.value
    } else {
        return colorBorderClass.value
    }
})

/**
 *
 */
const colorBackgroundClass = computed(() => {
    let additions = '';

    if (props.disabled || props.processing) {
        additions += 'bg-opacity-25 text-gray-500 '
    } else {
        additions += 'text-white '
    }

    if (!props.compact) {
        additions += 'sm:px-4 lg:py-3 '
    }
    const disabled = props.disabled || props.processing;

    const baseColor = {
        'blue': 'bg-blue-500 border-none ' + (!disabled ? ' hover:bg-blue-600 active:bg-blue-700' : ''),
        'green': 'bg-green-500 border-none ' + (!disabled ? ' hover:bg-green-600 active:bg-green-700' : ''),
        'gray': 'bg-gray-500 border-none ' + (!disabled ? ' hover:bg-gray-600 active:bg-gray-700' : ''),
        'red': 'bg-red-500 border-none ' + (!disabled ? ' hover:bg-red-600 active:bg-red-700' : ''),
        'yellow': 'bg-yellow-500 border-none ' + (!disabled ? ' hover:bg-yellow-600 active:bg-yellow-700' : ''),
    }[props.color]

    return additions + baseColor;
})

/**
 *
 */
const colorBorderClass = computed(() => {
    let additions = 'border ';

    if (props.disabled || props.processing) {
        additions += 'bg-opacity-50'
    }

    if (!props.compact) {
        additions += 'sm:px-4 lg:py-3 '
    }

    if (props.dashed) {
        additions += 'border-dashed '
    }

    const baseColor = {
        'blue': 'border-blue-500 hover:bg-blue-600 active:bg-blue-700',
        'green': 'border-green-500 hover:bg-green-600 active:bg-green-700',
        'gray': 'border-gray-500 hover:bg-gray-600 active:bg-gray-700',
        'red': 'border-red-500 hover:bg-red-600 active:bg-red-700',
        'yellow': 'border-yellow-500 hover:bg-yellow-200 active:bg-yellow-700',
    }[props.color]

    return additions + baseColor
})

/**
 *
 */
const classes = computed(() => {
    return [
        colors.value,
        (!props.disabled && !props.processing) && !props.borderOnly ? ' shadow-md' : '',
        !props.borderOnly ? 'border-transparent' : ''
    ]
})
</script>
