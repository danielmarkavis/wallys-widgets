<script setup lang="ts">
import {onMounted, ref} from 'vue';

defineProps<{
    modelValue: string | number | null;
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({focus: () => input.value?.focus()});
</script>

<template>
    <input
        ref="input"
        class="bg-level-2 border-0 text-gray-700 rounded-md shadow focus:ring-accent"
        :value="modelValue"
        v-bind="$attrs"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >
</template>
