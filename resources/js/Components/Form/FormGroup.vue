<template>
  <div
    :class="{'lg:flex-row':!singleColumn}"
    class="flex flex-col mb-5"
  >
    <label
      v-if="!noLabel"
      :class="{'lg:w-1/3 lg:text-right':!singleColumn}"
      :for="name"
      class="mr-5 mt-1 mb-1"
      @click.prevent
    >
      <span class="font-medium text-gray-700">
        <slot name="label">{{ label }}</slot>
        <span
          v-if="required"
          class="ml-1 text-red-600 font-normal"
        >*</span>
      </span>
    </label>
    <div :class="{'lg:w-2/3':!singleColumn}">
      <slot
        :required="required"
      />

      <div
        v-if="page.props.errors[props.name]"
        class="text-left"
      >
        <span
          :class="{'lg:w-2/3':!singleColumn}"
          class="w-full text-red-600 text-sm"
        >{{ page.props.errors[props.name] }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {usePage} from "@inertiajs/vue3";

const props = defineProps<{
  name: string,
  label?: string,
  help?: string,
  required?: boolean,
  loading?: boolean,
  singleColumn?: boolean,
  noLabel?: boolean,
}>()

const page = usePage();
</script>
