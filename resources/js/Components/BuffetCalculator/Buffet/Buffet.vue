<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/solid';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    buffet: Object,
})

/*
const form_buffet = useForm({
    id: props.buffet.id,
    status: props.buffet.status,
    name: props.buffet.name,
    description: props.buffet.description,
    price: props.buffet.price,
    plates: props.buffet.plates,
    type: props.buffet.type,
});

const resizeDescriptionTextarea = () => {
    return form_buffet.description.split('\n').length + 1
}
const submit = () => {
    form_buffet.put(route('buffets.update', form_buffet.id), {
        preserveScroll: true,
    })
}
*/
</script>
<template>
    <section class="w-11/12 m-auto md:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white overflow-hidden">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <a :href="route('buffets.index', buffet.type)"
                    class="text-gray-700 hover:text-gray-900 active:text-gray-800 flex flex-row items-center align-middle space-x-2">
                    <ArrowUturnLeftIcon class="w-4 h-4" />
                    <span>{{ buffet.type == 1 ? 'Buffet' : 'Entrada' }}</span>
                </a>
                <div class="w-32 h-1 bg-gray-700"></div>
                <h1 class="w-full text-4xl border-none px-0 pt-5">{{ buffet.name }}</h1>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Preço no orçamento</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ toMonetary(buffet.price) }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Custo (Buffet para 10 pessoas)</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ toMonetary(buffet.cost) }}</dd>
                    </div>
                    <div class="bg-gray-50 gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Excedente</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ toMonetary(buffet.price -
                                                    buffet.cost) }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Descrição</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{
                                                    buffet.description }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <main>
            <slot />
        </main>
    </section>
</template>