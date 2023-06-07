<script setup>
import { ref } from 'vue';
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/solid';
import { router, useForm } from '@inertiajs/vue3';
import Ceremony from '@/Components/Ceremony/Ceremony.vue';
import { toMonetary, formatDate } from '/resources/js/shared_functions.js';
import BudgetStatusButton from '@/Components/BudgetStatusButton.vue';
import calcBudgetTotal from './Modals/calcBudgetTotal.js';
import axios from 'axios';

const props = defineProps({
    budget: Object,
    ceremony: Object,
    budget_selects_options: Object,
    has_installment: Boolean,
});

const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
const min_date = ref(new Date());
min_date.value = min_date.value.getFullYear() + '-' + dateZeroFiller(min_date.value.getMonth() + 1) + '-' + dateZeroFiller(min_date.value.getDate()) + 'T' + dateZeroFiller(min_date.value.getHours()) + ':' + dateZeroFiller(min_date.value.getMinutes());

const show_financial = ref(0);

const obs = ref(null);
const obs_rows = ref(null);

if (props.ceremony) {
    obs.value = props.ceremony.observations || "";
    obs_rows.value = obs.value.split('\n').length || 1;
}

const form = useForm({
    id: props.budget.id,
    client_id: props.budget.client_id,

    event_id: props.budget.event_id,
    decoration_id: props.budget.decoration_id,
    buffet_entry_id: props.budget.buffet_entry_id,
    buffet_id: props.budget.buffet_id,

    beer: props.budget.beer ? true : false,
    bar: props.budget.bar ? true : false,
    dj: props.budget.dj ? true : false,
    advisory: props.budget.advisory ? true : false,

    additional_meat: props.budget.additional_meat ? true : false,
    ravioli: props.budget.ravioli ? true : false,
    additional_drinks: props.budget.additional_drinks ? true : false,
    other_beers: props.budget.other_beers ? true : false,

    guests_quantity: props.budget.guests_quantity,

    event_date: props.budget.event_date,
    event_time: props.budget.event_time,

    budget_total_value: props.budget.budget_total_value,

    budget_comment: props.budget.budget_comment,
    budget_token: props.budget.budget_token,
    budget_link: props.budget.budget_link,
});

const budget_event_datetime = ref(form.event_date + 'T' + form.event_time);

const setBudgetFormDateTime = () => {
    let event_date_time = budget_event_datetime.value.split('T');
    form.event_date = event_date_time[0];
    form.event_time = event_date_time[1];
    console.log(event_date_time);
}

const budgetTotal = () => {
    setBudgetFormDateTime();
    form.budget_total_value = calcBudgetTotal(form);
    submit();
}

const saveObs = () => {
    obs_rows.value = obs.value.split('\n').length || 1;
    router.put(route('ceremonies.updade.obs', props.ceremony.id), { obs: obs.value }, {
        preserveScroll: true,
    });
}

const submit = () => {
    form.put(route('budgets.update', form.id), {
        preserveScroll: true,
    });
}

const show_status = () => {
    return {
        0: 'Inativo',
        1: 'Ativos',
        2: 'Pendente',
        3: 'Cancelado',
        4: 'Concluído',
    }[props.budget.status]
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full min-h-[10px] bg-gray-900">
            <Ceremony v-if="ceremony" :ceremony="ceremony" :budget="budget" :button_type="0" />
        </div>
        <form v-if="!show_financial" id="create_task" @submit.prevent="budget_submit"
            class="w-full px-0 md:py-5 md:px-14 xl:px-24">
            <div class="overflow-hidden md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-10">
                    <div class="flex flex-row items-center space-x-5">
                        <span class=" py-2 px-5 rounded-full text-white" :class="{
                            'bg-gray-700': budget.status == 0,
                            'bg-green-700': budget.status == 1,
                            'bg-yellow-700': budget.status == 2,
                            'bg-red-700': budget.status == 3,
                            'bg-blue-700': budget.status == 4,
                        }
                            ">
                            {{ show_status() }}
                        </span>
                        <span>
                            <a :href="route('clients.show', budget.client_id)"
                                class="text-gray-700 hover:text-gray-900 active:text-gray-800 flex flex-row items-center align-middle space-x-2">
                                <ArrowUturnLeftIcon class="w-4 h-4" />
                                <span>Voltar para Cliente</span>
                            </a>
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 my-5">
                        <!--Evento-->
                        <div class="min-w-fit">
                            <label for="budget_event" class="text-xs text-slate-400">Evento</label>
                            <select id="budget_event" class="w-full border-slate-300 outline-0 sm:text-md"
                                :disabled="budget.status != 2" v-model="form.event_id" @change="budgetTotal">
                                <option :value="null">Escolha um eventos</option>
                                <option v-for="   event    in    budget_selects_options.events   " :key="event.id"
                                    :value="event.id" :selected="form.event_id == event.id">{{ event.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.event_id" class="text-xs text-red-600 ml-3">{{
                                form.errors.event_id }}
                            </div>
                        </div>

                        <!--Decoração-->
                        <div class="min-w-fit">
                            <label for="budget_decoration" class="text-xs text-slate-400">Decoração</label>
                            <select id="budget_decoration" class="w-full border-slate-300 sm:text-md"
                                :disabled="budget.status != 2" v-model="form.decoration_id" @change="budgetTotal">
                                <option :value="null">Escolha uma decoração</option>
                                <option v-for="   decoration    in    budget_selects_options.decorations   "
                                    :key="decoration.id" :value="decoration.id"
                                    :selected="form.decoration_id == decoration.id">{{
                                        decoration.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.decoration_id" class="text-xs text-red-600 ml-3">{{
                                form.errors.decoration_id
                            }}
                            </div>
                        </div>

                        <!--Entrada Buffet-->
                        <div class="min-w-fit">
                            <label for="budget_buffet_entry" class="text-xs text-slate-400">Entrada de Buffet</label>
                            <select id="budget_buffet_entry" class="w-full border-slate-300 sm:text-md"
                                :disabled="budget.status != 2" v-model="form.buffet_entry_id" @change="budgetTotal">
                                <option :value="null">Escolha uma entrada de buffet</option>
                                <option v-for="   buffet_entry    in    budget_selects_options.buffet_entries   "
                                    :key="buffet_entry.id" :value="buffet_entry.id"
                                    :selected="form.buffet_entry_id == buffet_entry.id">{{
                                        buffet_entry.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.buffet_entry_id" class="text-xs text-red-600 ml-3">{{
                                form.errors.buffet_entry_id }}
                            </div>
                        </div>

                        <!--Buffet-->
                        <div class="min-w-fit">
                            <label for="budget_buffet" class="text-xs text-slate-400">Buffet</label>
                            <select id="budget_buffet" class="w-full border-slate-300 sm:text-md"
                                :disabled="budget.status != 2" v-model="form.buffet_id" @change="budgetTotal">
                                <option :value="null">Escolha um buffet</option>
                                <option v-for="   buffet    in    budget_selects_options.buffets   " :key="buffet.id"
                                    :value="buffet.id" :selected="form.buffet_id == buffet.id">{{ buffet.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.buffet_id" class="text-xs text-red-600 ml-3">{{
                                form.errors.buffet_id }}
                            </div>
                        </div>
                    </div>

                    <!--Checkboxes-->
                    <div>
                        <span class="text-slate-400 text-sm">Opções</span>
                        <div class="py-2 flex flex-col lg:flex-row lg:space-x-10">
                            <!--Bar-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-bar"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.bar" v-model="form.bar" @change="budgetTotal"
                                        :disabled="budget.status != 2" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-bar">Bar</label>
                                </div>
                                <div v-if="form.errors.bar" class="text-xs text-red-600 ml-3">{{
                                    form.errors.bar
                                }}
                                </div>
                            </div>

                            <!--Cerveja-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-beer"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.beer" v-model="form.beer"
                                        :disabled="budget.status != 2" @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-beer">Cerveja</label>
                                </div>
                                <div v-if="form.errors.beer" class="text-xs text-red-600 ml-3">{{
                                    form.errors.beer
                                }}
                                </div>
                            </div>

                            <!--DJ-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-dj"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.dj" v-model="form.dj" :disabled="budget.status != 2"
                                        @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-dj">Dj</label>
                                </div>
                                <div v-if="form.errors.dj" class="text-xs text-red-600 ml-3">{{ form.errors.dj
                                }}
                                </div>
                            </div>

                            <!--Acessoria-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-advisory"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.advisory" v-model="form.advisory"
                                        :disabled="budget.status != 2" @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-advisory">Cerimonialista</label>
                                </div>
                                <div v-if="form.errors.advisory" class="text-xs text-red-600 ml-3">{{
                                    form.errors.advisory }}
                                </div>
                            </div>
                        </div>

                        <span class="text-slate-400 text-sm">Adicionais</span>
                        <div class="py-2 flex flex-col">
                            <!--Carne adicional-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-additional-meat"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.additional_meat" v-model="form.additional_meat"
                                        @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-additional-meat">Adicional de carne</label>
                                </div>
                                <div v-if="form.errors.additional_meat" class="text-xs text-red-600 ml-3">{{
                                    form.errors.additional_meat }}
                                </div>
                            </div>

                            <!--Raviole-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-raviolli"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.ravioli" v-model="form.ravioli"
                                        @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-raviolli">Raviolli
                                        de
                                        carne ou quatro queijos</label>
                                </div>
                                <div v-if="form.errors.ravioli" class="text-xs text-red-600 ml-3">{{ form.errors.ravioli }}
                                </div>
                            </div>

                            <!--Bebida adicional-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-additional-drinks"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.additional_drinks" v-model="form.additional_drinks"
                                        @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-additional-drinks">Drinks
                                        adicionais</label>
                                </div>
                                <div v-if="form.errors.additional_drinks" class="text-xs text-red-600 ml-3">{{
                                    form.errors.additional_drinks }}
                                </div>
                            </div>

                            <!--Cerveja de outras marcas-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input id="checkbox-other-beers"
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.other_beers" v-model="form.other_beers"
                                        @change="budgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkbox-other-beers">Cervejas
                                        outras marcas</label>
                                </div>
                                <div v-if="form.errors.other_beers" class="text-xs text-red-600 ml-3">{{
                                    form.errors.other_beers
                                }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-row-config space-x-2 pt-2 pb-5">
                        <!-- Data -->
                        <div class="w-3/4">
                            <label for="budget_date" class="text-xs text-slate-700">Data da cerimônia</label>
                            <input type="datetime-local" id="budget_date" placeholder="Data da cerimônia" :min="min_date"
                                class="w-full border-slate-300 sm:text-md" v-model="budget_event_datetime"
                                :disabled="budget.status != 2" @input="budgetTotal" />
                            <div v-if="form.errors.event_date" class="text-xs text-red-600 ml-3">{{ form.errors.event_date
                            }}</div>
                            <div v-if="form.errors.event_time" class="text-xs text-red-600 ml-3">{{ form.errors.event_time
                            }}</div>
                        </div>

                        <!-- Quantidade de convidados -->
                        <div class="w-1/4">
                            <label for="budget_guests_quantity" class="text-xs text-slate-700">Qtd. Convidados</label>
                            <input type="number" id="budget_guests_quantity" step="1" min="1" max="150"
                                placeholder="Quantidade de convidados" class="w-full border-slate-300 sm:text-md"
                                v-model="form.guests_quantity" :disabled="budget.status != 2" @input="budgetTotal"
                                minlength="8" maxlength="20" />
                            <div v-if="form.errors.guests_quantity" class="text-xs text-red-600 ml-3">{{
                                form.errors.guests_quantity }}
                            </div>
                        </div>
                    </div>

                    <ul>
                        <li v-if="budget.budget_token"><span class="font-bold">Token: </span>{{ budget.budget_token }}
                        </li>
                        <li v-if="budget.budget_link"><span class="font-bold">Ver PDF do orçamento: </span><a
                                href="https://google.com/" target="_blank" class="text-sky-600">{{
                                    budget.budget_link }}</a></li>
                        <li v-if="budget.budget_comment"><span class="font-bold">Comentário do cliente: </span>"{{
                            budget.budget_comment }}"</li>
                    </ul>
                    <h1 class="text-gray-900 text-xl">Valor do orçamento: {{ toMonetary(budget.budget_total_value) }}
                    </h1>
                    <BudgetStatusButton :budget="budget" :ceremony="ceremony" :has_installment="has_installment" />
                </div>
            </div>

            <div v-if="ceremony" class="mx-10">
                <label for="obs" class="text-xs text-slate-700">Observações</label>
                <textarea id="obs" :rows="obs_rows" v-model="obs" placeholder="Observações sobre a Cerimônia"
                    class="w-full border-slate-300 sm:text-md" @input="saveObs" autofocus="true"></textarea>
            </div>
        </form>
    </section>
</template>