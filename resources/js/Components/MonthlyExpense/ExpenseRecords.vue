<script setup>
import { ref } from 'vue';
import { PlusIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import ModalCreateExpense from '@/Components/MonthlyExpense/Modals/ModalCreateExpense.vue';
import { router } from '@inertiajs/core';

const props = defineProps({
    expense_record: Object,
});

const modal_create_open = ref(false);

const toMonetary = (value) => {
    if (value !== null) return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

const getTotal = () => {
    let total = 0;
    JSON.parse(props.expense_record.last_record).forEach(me => {
        total += me.amount;
    });
    return total;
}

const deleteExpenseRecord = (expense_record_id) => {
    props.expense_record.last_record = JSON.stringify(JSON.parse(props.expense_record.last_record).filter(ex => ex.id != expense_record_id));
    router.put(route('monthly_expenses.update_record', props.expense_record.id), props.expense_record, { preserveScroll: true })
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full p-5 bg-gray-900">
            <p class="text-xl text-gray-300">Total de despesas mensais: <span
                    class="text-xl font-weight-bolder text-white">{{
                        toMonetary(getTotal()) }}</span></p>
        </div>
        <div v-if="expense_record.last_record.length" class="w-full overflow-auto">
            <table class="w-full m-auto table-fixed overflow-auto mt-2">
                <thead class="lg:border-b-2 lg:border-gray-500">
                    <!--<th>Status</th>-->
                    <th>Nome</th>
                    <th>Valor Padrão</th>
                    <th>Excluir</th>
                    <!--<th>Duplicar</th>-->
                </thead>
                <tbody>
                    <tr v-for="(expense, index) in JSON.parse(expense_record.last_record)" :key="expense.id"
                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                        :class="{ 'bg-gray-100': (index % 2 != 0) }">
                        <!--<td @click="toggleBuffetStatus(buffet)"><div v-if="buffet.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="buffet_table_status" id="buffet-table-status" :checked="buffet.status" /></div><span v-else class="text-orange-600">Pendente</span></td>-->

                        <td class="py-3 px-5 truncate">{{ expense.name }}
                        </td>
                        <td class="py-3 px-5 truncate">{{ toMonetary(expense.amount) }}</td>
                        <td class="py-3 px-5 truncate cursor-pointer flex-col-config" title="Excluir despesa mensal"
                            @click="deleteExpenseRecord(expense.id)">
                            <XMarkIcon class="w-6 h-6" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="w-full text-center my-10">Não há gastos mensais registrados!</div>
    </section>

    <button type="buttom"
        class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
        @click="modal_create_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>

    <ModalCreateExpense v-if="modal_create_open" :expense_record="expense_record"
        @modal_open="(open) => modal_create_open = open" />
</template>