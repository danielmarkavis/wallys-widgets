<template>
    <GuestLayout title="Packing">
        <div class="max-w-xl mx-auto">
            <h3>Packs</h3>
            <div class="flex flex-row">
                <template v-for="widget in widgets">
                    <div class="bg-gray-200 px-2 py-1 rounded-lg mr-1">
                        {{ widget.size }}
                    </div>
                </template>
            </div>
            <hr class="my-2"/>
            <h3>Tests</h3>
            <div class="flex flex-row">
                <button @click="form.quantity = 1" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    1
                </button>
                <button @click="form.quantity = 250" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    250
                </button>
                <button @click="form.quantity = 251" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    251
                </button>
                <button @click="form.quantity = 501" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    501
                </button>
                <button @click="form.quantity = 12001" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    12001
                </button>
                <button @click="form.quantity = 14800" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    14800
                </button>
                <button @click="form.quantity = Math.floor(Math.random() * 25000)" class="bg-green-200 px-2 py-1 rounded-lg mr-1">
                    ????
                </button>
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
                    <button type="submit" class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-12 py-2.5 ml-2 mb-2 focus:outline-none">Purchase</button>
                </div>
            </form>

            <template v-if="order">
                <div class="mt-5">
                    <h3>Order:</h3>
                    <div class="flex flex-row mt-2">
                        <template v-for="(item, index) in order">
                            <div class="rounded-lg mr-5 flex flex-row items-center">
                                <div class="bg-gray-300 rounded-l-xl px-3 py-1">{{ index }}</div><div class="bg-blue-500 text-white px-3 py-1 rounded-r-full">x{{ item }}</div>
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
import {ref} from "vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

interface Widget {
    id: string,
    size: string
}

const props = defineProps<{
    widgets?: Array<Widget>
}>();

const form = useForm<{
    redirect: boolean,
    quantity: string,
    optimize: bool
}>({
    redirect: false,
    quantity: 251,
    optimize: true
});

const order = ref(null);

const handleSubmit = (): void => {
    form.post(route('packing.store'), {
        onSuccess: (res) => {
            order.value = res.props.order;
        },
    });
}
</script>