<template>
    <GuestLayout title="Widgets">
        <div class="container mx-auto max-w-xl">
            <FormSection @submitted="submit">
                <template #form>
                    <div class="grid gap-x-4">
                        <section>
                            <FormGroup
                                label="Size"
                                name="size"
                                required
                                single-column
                            >
                                {{form.size}}
                                <FormTextInput
                                    id="size"
                                    v-model="form.size"
                                    type="number"
                                    class="block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                            </FormGroup>
                        </section>
                    </div>
                </template>
                <template #actions>
                    <BaseButton
                        color="red"
                        tag="button"
                        type="button"
                        v-if="editing"
                        :disabled="disabled"
                        @click="router.delete(route('widgets.destroy', record), { preserveState: false })"
                    >
                        <slot>Delete</slot>
                    </BaseButton>

                    <BaseButton
                        color="blue"
                        tag="button"
                        :disabled="disabled"
                        :processing="form.processing"
                        type="submit"
                    >
                        <slot>Save</slot>
                    </BaseButton>
                </template>
            </FormSection>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import {router, useForm} from '@inertiajs/vue3'

import FormSection from "@/Components/Form/FormSection.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import CreateEdit from "@/Consumables/CreateEdit"
import GuestLayout from "@/Layouts/GuestLayout.vue";
import BaseButton from "@/Components/Buttons/BaseButton.vue";

const props = defineProps<{
    record?: object,
}>();

const form = useForm<{
    size: number,
}>({
    size: props?.record?.size ?? ""
});

const {editing, disabled, submit} = CreateEdit(props, form, {
    store_route: 'widgets.store',
    update_route: 'widgets.update'
})
</script>
