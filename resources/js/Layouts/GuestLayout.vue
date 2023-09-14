<script setup lang="ts">
import {Head as Heading} from "@inertiajs/vue3";
import NavBar from "@/Components/App/NavBar.vue";
defineProps<{
    title: string
}>()
</script>

<template>
    <Heading :title="title"/>

    <div class="min-h-screen flex flex-col">
        <NavBar/>

        <div class="w-full bg-white overflow-hidden pt-12">
            <slot/>
        </div>
    </div>
</template>
