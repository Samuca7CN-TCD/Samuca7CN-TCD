<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ClientsList from '@/Components/Client/ClientsList.vue';
import Client from '@/Components/Client/Client.vue';
defineProps({
    activated_page: Number,
    page_url_base: String,
    submenu: Object,
    clients_list: Object,
    selected_client: Object,
    client_budgets: Object,
    budget_selects_options: Object,
})
</script>
<template>
    <AppLayout title="Dashboard" :submenu='submenu' :activated_page='activated_page' :page_url_base="page_url_base">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes -
                <span class="inline" v-if="selected_client">{{ selected_client.name }}</span>
                <span class="inline" v-else>Lista de Clientes</span>
            </h2>
        </template>
        <ClientsList v-if="!selected_client" :clients_list="clients_list" />
        <Client v-else :client="selected_client" :client_budgets="client_budgets"
            :budget_selects_options="budget_selects_options" />
    </AppLayout>
</template>