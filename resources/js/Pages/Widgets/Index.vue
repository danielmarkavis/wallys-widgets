<template>
    <GuestLayout title="Packing">
        <div class="container mx-auto">
            <div
                v-if="$page.props.flash.message"
                class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg"
                role="alert"
            >
                <span class="font-medium">
                    {{ $page.props.flash.message }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template v-for="(widget, index) in widgets" :key="index">
                    <a :href="route('widgets.edit', widget.id)">
                        <div class="bg-gray-200 hover:bg-gray-400 flex flex-col py-5 rounded-md">
                            <div class="text-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 uppercase">{{ widget.size }}</h5>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            <div class="mt-5">
                <BaseButton
                    color="blue"
                    tag="link"
                    :href="route('widgets.create')"
                >Create
                </BaseButton>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import BaseButton from "@/Components/Buttons/BaseButton.vue";

interface Widget {
    id: string,
    size: string
}

const props = defineProps<{
    widgets: Array<Widget>
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
    form.post(route('widgets.index'), {
        onSuccess: (res) => {
            order.value = res.props.order;
        },
    });
}
</script>