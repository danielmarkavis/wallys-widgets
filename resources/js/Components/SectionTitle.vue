<template>
  <div class="md:col-span-1 flex justify-between mb-4 md:mb-8">
    <div class="px-4 sm:px-0">
      <h1 class="font-bold text-3xl sm:text-4xl">
        <slot name="label" />
      </h1>

      <p class="mt-1 text-sm">
        <slot name="description" /> 
      </p>
    </div>

    <div class="px-4 sm:px-0">
      <slot name="aside" />
    </div>
  </div>
</template>
