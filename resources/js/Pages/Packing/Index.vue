<template>
    <GuestLayout title="Packing">
        <div class="max-w-xl mx-auto">
            <h3>Packs</h3>
            <div class="flex flex-row">
                <template v-for="widget in widgets">
                    <div class="bg-gray-200 px-2 py-1 rounded-lg mr-1">
                        {{ widget }}
                    </div>
                </template>
            </div>
            <hr class="my-2"/>
            <h3>Tests</h3>
            <div class="flex flex-row gap-2">
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 1"
                >1</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 250"
                >250</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 251"
                >251</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 501"
                >501</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 12001"
                >12001</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = 14800"
                >14800</BaseButton>
                <BaseButton
                    tag="button"
                    type="button"
                    color="green"
                    @click="form.quantity = Math.floor(Math.random() * 25000)"
                >?????</BaseButton>
            </div>

            <hr class="my-12">

            <form @submit.prevent="handleSubmit" method="post">
                <FormGroup
                    label="Quantity"
                    name="quantity"
                    required
                    single-column
                >
                    <input v-model="form.quantity" type="text" id="quantity" name="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </FormGroup>


                <div class="flex flex-row items-center">
                    <input
                        v-model="form.optimize"
                        type="checkbox"
                        class="rounded bg-white border-gray-300 text-gray-700 shadow focus:ring-0 mr-3"
                        id="form_optimize"
                        name="form_optimize"
                    >
                    <label for="form_optimize">
                        Optimize
                    </label>
                </div>
                <div class="flex flex-row pt-5">
                    <BaseButton
                        tag="button"
                        type="submit"
                        color="green"
                    >Purchase</BaseButton>
                </div>
            </form>

            <template v-if="order">
                <div class="mt-5">
                    <h3 class="text-xl">Order:</h3>
                    <div class="text-gray-700 mb-5">
                        Total packed widgets: <span class="bg-blue-300 rounded-md px-3 py-1">{{actualQuantity}}</span>
                    </div>
                    <h3 class="text-xl">Packs:</h3>
                    <div class="flex flex-row mt-2">
                        <template v-for="(item, index) in order">
                            <div class="rounded-lg mr-5 flex flex-row items-center">
                                <div class="bg-gray-300 rounded-l-md px-3 py-1">{{ index }}</div>
                                <div class="bg-blue-500 text-white px-3 py-1 rounded-r-md">x{{ item }}</div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import FormGroup from "@/Components/Form/FormGroup.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import BaseButton from "@/Components/Buttons/BaseButton.vue";

interface Widget {
    id: string,
    size: string
}

const props = withDefaults(defineProps<{
    actualQuantity?: number|null
    order?: object
    widgets?: Array<Widget>
}>(),
    {
        actualQuantity: null,
        order: null
    }
)

const form = useForm<{
    redirect: boolean,
    quantity: string,
    optimize: bool
}>({
    redirect: false,
    quantity: 251,
    optimize: true
});

const handleSubmit = (): void => {
    form.post(route('packing.store'), {
        onSuccess: () => {},
    });
}
</script>