<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/solid';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    plate: Object,
})

/*
const form_plate = useForm({
    id: props.plate.id,
    status: props.plate.status,
    name: props.plate.name,
    description: props.plate.description,
    price: props.plate.price,
    plates: props.plate.plates,
    type: props.plate.type,
});

const resizeDescriptionTextarea = () => {
    return form_plate.description.split('\n').length + 1
}

const submit = () => {
    form_plate.put(route('plates.update', form_plate.id), {
        preserveScroll: true,
    })
}
*/
</script>
<template>
    <section class="w-11/12 m-auto md:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white overflow-hidden">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <a :href="route('plates.index', plate.buffet_id)"
                    class="text-gray-700 hover:text-gray-900 active:text-gray-800 flex flex-row items-center align-middle space-x-2">
                    <ArrowUturnLeftIcon class="w-4 h-4" />
                    <span>Pratos</span>
                </a>
                <div class="w-32 h-1 bg-gray-700"></div>
                <h1 class="w-full text-4xl border-none px-0 pt-5">{{ plate.name }}</h1>
                <p class="w-full text-md text-gray-500">{{ toMonetary(plate.cost) }} / Buffet de 10 pessoas</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div v-if="plate.description" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Descrição</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{
                            plate.description }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <main>
            <slot />
        </main>
    </section>
</template>