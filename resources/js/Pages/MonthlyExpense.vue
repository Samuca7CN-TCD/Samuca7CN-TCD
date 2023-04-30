<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MonthlyExpenses from '@/Components/MonthlyExpense/MonthlyExpenses.vue';
import ExpenseRecord from '@/Components/MonthlyExpense/ExpenseRecords.vue';
import { ref } from 'vue';
defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,
    monthly_expenses: Object,
    expense_record: Object,
})

const months = ref([
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
])

</script>
<template>
    <AppLayout title="Clientes" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gastos Mensais {{ expense_record ? ' - ' + months[expense_record.month - 1] + ' / ' + expense_record.year :
                    '' }}
            </h2>
        </template>
        <MonthlyExpenses v-if="monthly_expenses" :monthly_expenses="monthly_expenses" />
        <ExpenseRecord v-if="expense_record" :expense_record="expense_record" />
    </AppLayout>
</template>