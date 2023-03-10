<script setup>
import Client from '@/Components/Client/Client.vue';
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

const props = defineProps({
    client: Object,
    client_budgets: Object,
    budget_selects_options: Object,

    budget: Object,
    ceremony: Object,
    budget_selects_options: Object
});

const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
const min_date = ref(new Date());
min_date.value = min_date.value.getFullYear() + '-' + dateZeroFiller(min_date.value.getMonth() + 1) + '-' + dateZeroFiller(min_date.value.getDate()) + 'T' + dateZeroFiller(min_date.value.getHours()) + ':' + dateZeroFiller(min_date.value.getMinutes());

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

    guests_quantity: props.budget.guests_quantity,

    event_date: props.budget.event_date.replace(' ', 'T').substring(0, 16),

    budget_total_value: props.budget.budget_total_value,

    budget_comment: props.budget.budget_comment,
    budget_token: props.budget.budget_token,
    budget_link: props.budget.budget_link,
});

const ceremony_form = useForm({
    id: props.ceremony.id,
    budget_id: props.ceremony.budget_id,
    ceremony_status_id: props.ceremony.ceremony_status_id,
    total_negotiated_amount: props.ceremony.total_negotiated_amount,
    entry_amount: props.ceremony.entry_amount,
    remaining_amount: props.ceremony.remaining_amount,
});

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

const progress = (total, remaining) => {
    let paid = total - remaining;
    if (total == 0) return 0;
    return paid / total;
}

const submit = () => {
    console.log(form.event_date);
    form.put(route('budgets.update', form.id), {
        preserveScroll: true,
    });
}

const ceremonyStatus = (new_status) => {
    ceremony_form.ceremony_status_id = new_status;
    ceremony_form.put(route('ceremonies.update', ceremony_form.id), {
        preserveScroll: true,
    })
}

const calcBudgetTotal = () => {
    let total = 2900;
    let buffet = 49;
    let option = {
        bar: 15 * form.guests_quantity,
        dj: 1200,
        decoration: form.decoration_id == 1 ? 1900 : 1500,
        advisory: 900
    }

    if (form.buffet_id == 1) buffet += 18;
    if (form.beer) buffet += 12;

    total += buffet * form.guests_quantity;
    total += option.decoration;

    if (form.bar) total += option.bar;
    if (form.dj) total += option.dj;
    if (form.advisory) total += option.advisory;

    form.budget_total_value = total;
    submit();
}
calcBudgetTotal();
</script>
<template>
    <Client :client="client" :client_budgets="client_budgets" :budget_selects_options="budget_selects_options"
        :budget_id="budget.id">
        <div
            class="border-collapse md:border-2 md:border-indigo-100 rounded-xl md:m-5 md:shadow-xl md:hover:shadow-2xl overflow-hidden">
            <div
                class="w-full bg-indigo-900 flex-col-config space-y-5 lg:space-y-0 lg:flex-row-config text-white py-5 px-5 lg:px-10">
                <div class="w-full lg:w-1/2 flex-col-config space-y-5">
                    <p class="text-5xl font-bold">{{ toMonetary(ceremony.total_negotiated_amount) }}</p>
                    <a v-if="ceremony.ceremony_status_id == 1"
                        class="rounded-xl px-3 py-1 bg-indigo-700 hover:bg-indigo-800 active:bg-indigo-700 cursor-pointer select-none">Fazer
                        pagamento</a>
                </div>
                <div class="w-full lg:w-1/2 flex flex-col">
                    <div class="space-y-3 text-lg font-mono">
                        <p>
                            <span v-if="ceremony.entry_amount">Entrada paga: {{ toMonetary(ceremony.entry_amount) }}</span>
                            <span v-else class="text-slate-200">Pagamento de entrada não realizado</span>
                        <p class="text-xs text-indigo-200">Entrada mínima: {{ toMonetary(ceremony.total_negotiated_amount *
                            0.1)
                        }}</p>
                        </p>
                        <p>Restante: {{ toMonetary(ceremony.remaining_amount) }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700"
                            :title="progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) + '%'">
                            <div class="bg-indigo-600 h-1.5 rounded-full dark:bg-indigo-500" :class="{
                                'w-0': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.0,
                                'w-1/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.1,
                                'w-2/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.2,
                                'w-3/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.3,
                                'w-4/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.4,
                                'w-5/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.5,
                                'w-6/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.6,
                                'w-7/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.7,
                                'w-8/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.8,
                                'w-9/10': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 0.9,
                                'w-full': progress(ceremony.total_negotiated_amount, ceremony.remaining_amount) >= 1.0,
                            }"></div>
                        </div>
                    </div>
                </div>
            </div>
            <form id="create_task" @submit.prevent="budget_submit" class="w-full px-0 md:py-5 md:px-14 xl:px-24">

                <div class="overflow-hidden md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                    <div class="w-full m-0 p-0 space-y-2">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-5">
                            <!--Evento-->
                            <div class="min-w-fit">
                                <label for="budget_event" class="text-xs text-slate-400">Evento</label>
                                <select id="budget_event" class="w-full border-slate-300 outline-0 sm:text-md"
                                    v-model="form.event_id" @change="calcBudgetTotal">
                                    <option :value="null">Escolha um eventos</option>
                                    <option v-for="event in budget_selects_options.events" :key="event.id" :value="event.id"
                                        :selected="form.event_id == event.id">{{ event.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.event_id" class="text-xs text-red-600 ml-3">{{
                                    form.errors.event_id }}
                                </div>
                            </div>

                            <!--Decoração-->
                            <div class="min-w-fit">
                                <label for="budget_edecoration" class="text-xs text-slate-400">Decoração</label>
                                <select ID="budget_decoration" class="w-full border-slate-300 sm:text-md"
                                    v-model="form.decoration_id" @change="calcBudgetTotal">
                                    <option :value="null">Escolha uma decoração</option>
                                    <option v-for="decoration in budget_selects_options.decorations" :key="decoration.id"
                                        :value="decoration.id" :selected="form.decoration_id == decoration.id">{{
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
                                    v-model="form.buffet_entry_id" @change="calcBudgetTotal">
                                    <option :value="null">Escolha uma entrada de buffet</option>
                                    <option v-for="buffet_entry in budget_selects_options.buffet_entries"
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
                                    v-model="form.buffet_id" @change="calcBudgetTotal">
                                    <option :value="null">Escolha um buffet</option>
                                    <option v-for="buffet in budget_selects_options.buffets" :key="buffet.id"
                                        :value="buffet.id" :selected="form.buffet_id == buffet.id">{{ buffet.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.buffet_id" class="text-xs text-red-600 ml-3">{{
                                    form.errors.buffet_id }}
                                </div>
                            </div>
                        </div>

                        <!--Checkboxes-->
                        <span class="text-slate-400 text-sm">Opções</span>
                        <div class="py-2 flex flex-col lg:flex-row lg:space-x-10">
                            <!--Bar-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.bar" v-model="form.bar" @change="calcBudgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkboxChecked">Bar</label>
                                </div>
                                <div v-if="form.errors.bar" class="text-xs text-red-600 ml-3">{{
                                    form.errors.bar
                                }}
                                </div>
                            </div>

                            <!--Cerveja-->
                            <div>
                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                    <input
                                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-indigo-700 dark:checked:border-indigo-700 checked:bg-indigo-700 dark:checked:bg-indigo-700 checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                        type="checkbox" :checked="form.beer" v-model="form.beer"
                                        @change="calcBudgetTotal" />
                                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="checkboxChecked">Cerveja</label>
                                </div>
                                <div v-if="form.errors.beer" class="text-xs text-red-600 ml-3">{{
                                    form.errors.beer
                                }}
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
                                <div v-if="form.errors.dj" class="text-xs text-red-600 ml-3">{{ form.errors.dj
                                }}
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
                                <div v-if="form.errors.advisory" class="text-xs text-red-600 ml-3">{{
                                    form.errors.advisory }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-row-config space-x-2 pt-2 pb-5">
                            <!-- Data -->
                            <div class="w-3/4">
                                <label for="budget_date" class="text-xs text-slate-700">Data da cerimônia</label>
                                <input type="datetime-local" id="budget_date" placeholder="Data da cerimônia"
                                    :min="min_date" class="w-full border-slate-300 sm:text-md" v-model="form.event_date"
                                    @input="calcBudgetTotal" />
                                <div v-if="form.errors.event_date" class="text-xs text-red-600 ml-3">{{
                                    form.errors.event_date
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
                </div>
            </form>
            <div
                class="flex-col-config space-y-5 md:flex-row-config md:space-y-0 md:space-x-5 border-t-2 border-slate-200 p-10">
                <p class="w-full text-left text-xl" :class="{ 'md:w-1/2': ceremony.ceremony_status_id != 2 }">Valor do
                    Orçamento: {{ toMonetary(budget.budget_total_value)
                    }}</p>
                <div v-if="ceremony.ceremony_status_id != 2"
                    class="w-full md:w-1/2 flex-col-config space-y-3 lg:flex-row-config lg:space-y-0 lg:space-x-5">
                    <button v-if="ceremony.ceremony_status_id == 3"
                        class="rounded-xl px-3 py-2 text-white bg-sky-700 hover:bg-sky-800 active:bg-sky-700 cursor-pointer select-none"
                        @click="ceremonyStatus(1)">Ativar
                        Cerimônia</button>
                    <button v-if="ceremony.ceremony_status_id == 1"
                        class="rounded-xl px-3 py-2 text-white bg-sky-700 hover:bg-sky-800 active:bg-sky-700 cursor-pointer select-none"
                        @click="ceremonyStatus(2)">Concluir
                        Cerimônia</button>
                    <button v-if="ceremony.ceremony_status_id == 1"
                        class="rounded-xl px-3 py-2 text-white bg-red-700 hover:bg-red-800 active:bg-red-700 cursor-pointer select-none"
                        @click="ceremonyStatus(3)">Cancelar
                        Cerimônia</button>
                </div>
            </div>
        </div>
    </Client>
</template>