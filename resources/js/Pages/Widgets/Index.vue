<template>
    <GuestLayout title="Packing">
        <div class="max-w-xl mx-auto">
            <div class="flex flex-row">
                <template v-for="widget in widgets">
                    <div class="bg-gray-200 px-2 py-1 rounded-lg mr-1">
                        {{ widget.size }}
                    </div>
                </template>
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
                <div class="flex flex-row pt-5">
                    <button type="submit" class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-12 py-2.5 ml-2 mb-2 focus:outline-none">Purchase</button>
                </div>
            </form>

            <div class="flex flex-row mt-5">
                <template v-for="(item, index) in order">
                    <div class="bg-gray-200 px-2 py-1 rounded-lg mr-1">
                        {{ index }}: {{ item }}
                    </div>
                </template>
            </div>
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
}>({
    redirect: false,
    quantity: 251
});

const order = ref([]);

const handleSubmit = (): void => {
    //  const lastPack = props.widgets[props.widgets.length-1].size;
    //  let packIndex = 0;
    //  let quantity = form.quantity;
    //  const packs = props.widgets;
    //  let rollout = 1000;
    //  while(quantity > 0) {
    //      let packSize = packs[packIndex].size;
    //      console.log(packSize);
    //      if ((quantity - packSize) >= 0 || (quantity - lastPack <= 0 && packSize === lastPack)) {
    //          quantity = quantity - packSize;
    //          console.log(order.value[packSize]['quantity'])
    //          if (order.value[packSize]['quantity']) {
    //              order.value[packSize]['quantity']++;
    //          } else
    //              order.value[packSize]['quantity'] = 1;
    //      } else {
    //          packIndex++;
    //      }
    //      rollout -= 1;
    //      if (rollout <= 0) break;
    // }
    //  console.log(order.value);

    form.post(route('widgets.index'), {
        onSuccess: (res) => {
            order.value = res.props.order;
            // console.log(res.props.order);
        },
    });
}
</script>