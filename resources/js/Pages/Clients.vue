<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ClientsList from '@/Components/Client/ClientsList.vue';
import BudgetList from '@/Components/Budget/BudgetList.vue';
import Budget from '@/Components/Budget/Budget.vue';

const props = defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,

    clients_list: Object,

    selected_client: Object,
    client_budgets: Object,
    budget_selects_options: Object,
    budget: Object,
    ceremony: Object,
});

const event_name = () => {
    return props.budget_selects_options.events.filter((el) => el.id == props.budget.event_id)[0].name;
}

const formatDate = (date) => {
    date = date.split(/\-|\T|\:|\ /);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

</script>
<template>
    <AppLayout title="Clientes" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 v-if="!budget" class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes -
                <span class="inline" v-if="selected_client">{{ selected_client.name }}</span>
                <span class="inline" v-else>Lista de Clientes</span>
            </h2>
            <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">
                Orçamento - {{ event_name() + ' (' + formatDate(budget.event_date) + ')' }}
            </h2>
        </template>
        <ClientsList v-if="!selected_client && !budget" :clients_list="clients_list" />
        <BudgetList v-if="selected_client && !budget" :client="selected_client" :budgets_list="client_budgets"
            :budget_selects_options="budget_selects_options" />
        <Budget v-if="budget" :budget="budget" :ceremony="ceremony" :budget_selects_options="budget_selects_options" />
    </AppLayout>
</template>