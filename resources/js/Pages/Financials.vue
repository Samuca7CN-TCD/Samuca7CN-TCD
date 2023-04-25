<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Financial from '@/Components/Ceremony/Financial.vue';
defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,

    selected_client: Object,
    budget_list: Object,

    budget_selects_options: Object,
    budget: Object,
    ceremony: Object,
});
</script>
<template>
    <AppLayout title="Clientes" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orçamentos
            </h2>
        </template>
        <Financial :budget="budget" :ceremony="ceremony" :installments="JSON.parse(ceremony.installments)"
            :additions="JSON.parse(ceremony.additions)" :expenses="JSON.parse(ceremony.expenses)" />
    </AppLayout>
</template>