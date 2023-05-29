<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

const props = defineProps({
    client_id: Number,
    budget_selects_options: Object,
});

const emit = defineEmits(['modal_open']);
const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
let budget_event_date = new Date(Date.now() + 2592000000);
const min_date = ref(new Date());
min_date.value = min_date.value.getFullYear() + '-' + dateZeroFiller(min_date.value.getMonth() + 1) + '-' + dateZeroFiller(min_date.value.getDate()) + 'T' + dateZeroFiller(min_date.value.getHours()) + ':' + dateZeroFiller(min_date.value.getMinutes());
budget_event_date = budget_event_date.getFullYear() + '-' + dateZeroFiller(budget_event_date.getMonth() + 1) + '-' + dateZeroFiller(budget_event_date.getDate()) + 'T' + dateZeroFiller(budget_event_date.getHours()) + ':' + dateZeroFiller(budget_event_date.getMinutes());

const form = useForm({
    client_id: props.client_id,

    event_id: 1,
    decoration_id: 1,
    buffet_entry_id: 6,
    buffet_id: 1,

    beer: true,
    bar: true,
    dj: true,
    advisory: true,

    additional_meat: false,
    ravioli: false,
    additional_drinks: false,
    other_beers: false,

    guests_quantity: 0,
    event_date: budget_event_date,
    budget_total_value: 0.0,
    status: 0,

    budget_comment: null,
    budget_token: null,
    budget_link: null,
});

const calcBudgetTotal = () => {
    let total = 2900;
    let buffet = 59;
    let option = {
        bar: 15 * form.guests_quantity,
        dj: 1200,
        decoration: form.decoration_id == 1 ? 1400 : 0,
        advisory: 900,

        additional_meat: 7 * form.guests_quantity,
        ravioli: 5 * form.guests_quantity,
        additional_drinks: 5 * form.guests_quantity,
        other_beers: 5 * form.guests_quantity,
    }

    if (form.buffet_id == 1) buffet += 20;
    if (form.beer) buffet += 15;

    total += buffet * form.guests_quantity;
    total += option.decoration;

    if (form.bar) total += option.bar;
    if (form.dj) total += option.dj;
    if (form.advisory) total += option.advisory;

    if (form.additional_meat) total += option.additional_meat;
    if (form.ravioli) total += option.ravioli;
    if (form.additional_drinks) total += option.additional_drinks;
    if (form.other_beers) total += option.other_beers;

    form.budget_total_value = total;
}
calcBudgetTotal();

const closeModal = () => {
    form.reset();
    form.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    calcBudgetTotal();
    form.post(route('budgets.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
}
</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-blue-100 p-2 rounded-full text-blue-400">
                    <PlusIcon class="w-5 h-5" />
                </span>
                <h2 class="text-2xl bold">Cadastrar Orçamento</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro de um novo orçamento</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">

            <div class="overflow-hidden m-5 md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-2">

                    <!--Evento-->
                    <div class="border-2 min-w-fit">
                        <select class="w-full border-none sm:text-xs" v-model="form.event_id" @change="calcBudgetTotal">
                            <option :value="null">Escolha um eventos</option>
                            <option v-for="event in budget_selects_options.events" :key="event.id" :value="event.id"
                                :selected="form.event_id == event.id">{{ event.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.event_id" class="text-xs text-red-600 ml-3">{{ form.errors.event_id }}
                        </div>
                    </div>

                    <!--Decoração-->
                    <div class="border-2 min-w-fit">
                        <select class="w-full border-none sm:text-xs" v-model="form.decoration_id"
                            @change="calcBudgetTotal">
                            <option :value="null">Escolha uma decoração</option>
                            <option v-for="decoration in budget_selects_options.decorations" :key="decoration.id"
                                :value="decoration.id" :selected="form.decoration_id == decoration.id">{{ decoration.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.decoration_id" class="text-xs text-red-600 ml-3">{{ form.errors.decoration_id
                        }}
                        </div>
                    </div>

                    <!--Entrada Buffet-->
                    <div class="border-2 min-w-fit">
                        <select class="w-full border-none sm:text-xs" v-model="form.buffet_entry_id">
                            <option :value="null">Escolha uma entrada de buffet</option>
                            <option v-for="buffet_entry in budget_selects_options.buffet_entries" :key="buffet_entry.id"
                                :value="buffet_entry.id" :selected="form.buffet_entry_id == buffet_entry.id">{{
                                    buffet_entry.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.buffet_entry_id" class="text-xs text-red-600 ml-3">{{
                            form.errors.buffet_entry_id }}
                        </div>
                    </div>

                    <!--Buffet-->
                    <div class="border-2 min-w-fit">
                        <select class="w-full border-none sm:text-xs" v-model="form.buffet_id" @change="calcBudgetTotal">
                            <option :value="null">Escolha um buffet</option>
                            <option v-for="buffet in budget_selects_options.buffets" :key="buffet.id" :value="buffet.id"
                                :selected="form.buffet_id == buffet.id">{{ buffet.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.buffet_id" class="text-xs text-red-600 ml-3">{{ form.errors.buffet_id }}
                        </div>
                    </div>

                    <!--Checkboxes-->
                    <div class="py-2 mx-10">
                        <!--Bar-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.bar" v-model="form.bar" @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                    for="checkboxChecked">Bar</label>
                            </div>
                            <div v-if="form.errors.bar" class="text-xs text-red-600 ml-3">{{ form.errors.bar }}
                            </div>
                        </div>

                        <!--Cerveja-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.beer" v-model="form.beer" @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                    for="checkboxChecked">Cerveja</label>
                            </div>
                            <div v-if="form.errors.beer" class="text-xs text-red-600 ml-3">{{ form.errors.beer }}
                            </div>
                        </div>

                        <!--DJ-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.dj" v-model="form.dj" @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                    for="checkboxChecked">Dj</label>
                            </div>
                            <div v-if="form.errors.dj" class="text-xs text-red-600 ml-3">{{ form.errors.dj }}
                            </div>
                        </div>

                        <!--Acessoria-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.advisory" v-model="form.advisory"
                                    @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                    for="checkboxChecked">Acessoria</label>
                            </div>
                            <div v-if="form.errors.advisory" class="text-xs text-red-600 ml-3">{{ form.errors.advisory }}
                            </div>
                        </div>

                        <p class="pt-3 font-mono text-lg text-indigo-900">Adicionais</p>

                        <!--Carne adicional-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.additional_meat" v-model="form.additional_meat"
                                    @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                    for="checkboxChecked">Adicional de carne</label>
                            </div>
                            <div v-if="form.errors.additional_meat" class="text-xs text-red-600 ml-3">{{
                                form.errors.additional_meat }}
                            </div>
                        </div>

                        <!--Raviole-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.ravioli" v-model="form.ravioli"
                                    @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxChecked">Raviolli
                                    de
                                    carne ou quatro queijos</label>
                            </div>
                            <div v-if="form.errors.ravioli" class="text-xs text-red-600 ml-3">{{ form.errors.ravioli }}
                            </div>
                        </div>

                        <!--Bebida adicional-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.additional_drinks" v-model="form.additional_drinks"
                                    @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxChecked">Drinks
                                    adicionais</label>
                            </div>
                            <div v-if="form.errors.additional_drinks" class="text-xs text-red-600 ml-3">{{
                                form.errors.additional_drinks }}
                            </div>
                        </div>

                        <!--Cerveja de outras marcas-->
                        <div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                    type="checkbox" :checked="form.other_beers" v-model="form.other_beers"
                                    @change="calcBudgetTotal" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxChecked">Cervejas
                                    outras marcas</label>
                            </div>
                            <div v-if="form.errors.other_beers" class="text-xs text-red-600 ml-3">{{ form.errors.other_beers
                            }}
                            </div>
                        </div>
                    </div>
                    <div class="flex-row-config space-x-2">
                        <!-- Data -->
                        <div class="w-3/4">
                            <label for="budget_date" class="text-xs text-slate-700">Data da cerimônia</label>
                            <input type="datetime-local" id="budget_date" placeholder="Data da cerimônia" :min="min_date"
                                class="w-full border-slate-300 sm:text-md" v-model="form.event_date" />
                            <div v-if="form.errors.event_date" class="text-xs text-red-600 ml-3">{{ form.errors.event_date
                            }}
                            </div>
                        </div>
                        <!-- Quantidade de convidados -->
                        <div class="w-1/4">
                            <label for="budget_guests_quantity" class="text-xs text-slate-700">Qtd. Convidados</label>
                            <input type="number" id="budget_guests_quantity" step="1" min="1" max="150"
                                placeholder="Quantidade de convidados" class="w-full border-slate-300 sm:text-md"
                                v-model="form.guests_quantity" @input="calcBudgetTotal" minlength="8" maxlength="20" />
                            <div v-if="form.errors.guests_quantity" class="text-xs text-red-600 ml-3">{{
                                form.errors.guests_quantity }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 flex-col-config space-y-8 sm:flex-row-config sm:space-y-0">
                    <div class="w-full sm:w-1/2 text-center sm:text-left text-md sm:text-sm">Valor do Orçamento: {{
                        form.budget_total_value.toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }) }}</div>
                    <div class="w-full sm:w-1/2 flex-row-config space-x-2 text-right">
                        <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" @click="closeModal">
                            Cancelar
                        </SecondaryButton>

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Cadastrar
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </form>
    </Modal>
</template>