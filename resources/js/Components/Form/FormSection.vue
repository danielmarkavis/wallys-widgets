<template>
    <SectionTitle v-if="slots.label">
        <template #label>
            <slot name="title"/>
        </template>
        <template #description>
            <slot name="description"/>
        </template>
    </SectionTitle>

    <form @submit.prevent="emit('submitted')">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <slot name="form" />

                <div
                    v-if="hasActions"
                    class="bg-white text-white px-5"
                >
                    <div class="flex flex-col md:flex-row gap-2 py-2 justify-end w-full">
                        <slot
                            name="actions"
                            v-bind="{buttonClasses}"
                        />
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import {ref, computed, useSlots} from 'vue'
import SectionTitle from '@/Components/SectionTitle.vue'

const emit = defineEmits(['submitted'])

const buttonClasses = ref('mx-3 hover:border-b-2 border-white')

const slots = useSlots()

const hasActions = computed(() => {
    return !!slots.actions
})
</script>
