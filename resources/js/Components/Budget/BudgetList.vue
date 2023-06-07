<script setup>
import { ref } from 'vue';
import Client from '@/Components/Client/Client.vue';
import { PlusIcon, SparklesIcon } from '@heroicons/vue/24/solid';
import ModalCreateBudget from '@/Components/Budget/Modals/ModalCreateBudget.vue';
import { router } from '@inertiajs/core';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    client: Object,
    budgets_list: Object,
    budget_selects_options: Object,
});

const modal_budget_create_open = ref(false);

const formatDate = (date) => {
    date = date.split(/\-|\ |\:|\T|\./);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

const goToBudget = (budget_id) => {
    router.get(route('budgets.show', budget_id));
}
</script>
<template>
    <Client :client="client">
        <div v-if="budgets_list" class="mt-10 overflow-auto">
            <!-- Orçamentos do cliente -->
            <table class="w-full m-auto table-auto truncate">
                <thead class="lg:border-b-2 lg:border-gray-500">
                    <th>Status</th>
                    <th>Evento</th>
                    <th>Qtd. Convidados</th>
                    <th>Preço total</th>
                    <th>Data Evento</th>
                    <th>Data Cadastro</th>
                </thead>
                <tbody>
                    <tr v-for="(budget, index) in budgets_list" :key="budget.id"
                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center cursor-pointer"
                        :class="{ 'bg-gray-100': (index % 2 != 0) }" @click="goToBudget(budget.id)">
                        <td class="py-3 px-5">
                            <div class="w-3 h-3 rounded-full" :class="{
                                'bg-gray-700': budget.status == 0,
                                'bg-green-700': budget.status == 1,
                                'bg-yellow-700': budget.status == 2,
                                'bg-red-700': budget.status == 3,
                                'bg-blue-700': budget.status == 4,
                            }">
                            </div>
                        </td>
                        <td class="py-3 px-5 truncate">
                            {{ budget.event_name }}
                        </td>
                        <td class="py-3 px-5 truncate">{{ budget.guests_quantity }} convidados</td>
                        <td class="py-3 px-5 truncate">{{ toMonetary(budget.budget_total_value) }} </td>
                        <td class="py-3 px-5 truncate">{{ formatDate(budget.event_date + ' ' + budget.event_time) }}</td>
                        <td class="py-3 px-5 truncate">{{ formatDate(budget.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="w-full text-center my-5">{{ client.name }} não possui(em) orçamentos cadastrados!</div>
        <div class="w-full py-3 mb-10 text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle select-none"
            @click="modal_budget_create_open = true">
            <PlusIcon class="w-5 h-5" />
            <span>Cadastrar novo orçamento</span>
        </div>

        <ModalCreateBudget v-if="modal_budget_create_open" :client_id="client.id"
            :budget_selects_options="budget_selects_options" @modal_open="(open) => modal_budget_create_open = open" />
    </Client>
</template>