<script setup>
import Client from '@/Components/Client/Client.vue';
defineProps({
    client: Object,
    client_budgets: Object,
    budget_selects_options: Object,

    budget: Object,
    budget_selects_options: Object
})
</script>
<template>
    <Client :client="client" :client_budgets="client_budgets" :budget_selects_options="budget_selects_options"
        :budget_id="budget.id">
        Testando 123
    </Client>
</template>