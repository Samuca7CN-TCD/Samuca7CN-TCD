<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BudgetsList from '@/Components/Budget/BudgetList.vue';
import Budget from '@/Components/Budget/Budget.vue';
defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,

    selected_client: Object,
    budget_list: Object,

    budget_selects_options: Object,
    budget: Object,
    ceremony: Object,
})
</script>
<template>
    <AppLayout title="Clientes" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orçamentos
            </h2>
        </template>
        <BudgetsList v-if="budget_list" :client="selected_client" :budgets_list="budgets_list" />
        <Budget v-if="budget" :client="selected_client" :budget="budget" :ceremony="ceremony"
            :budget_selects_options="budget_selects_options" />
    </AppLayout>
</template>