<script setup>
import { ref } from 'vue';
import ModalManageExpenses from './Modals/ModalManageExpenses.vue';
import { PencilIcon, XMarkIcon, PlusIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    expenses: Object,
});

const open_modal = ref(false);

const expense = ref({});

const openModal = (exp = null) => {
    expense.value = exp;
    open_modal.value = true;
}

const delete_expense = (exp_id) => {
    router.delete(route('ceremonies.delete.expense', exp_id), {
        preserveScroll: true,
    });
}
</script>
<template>
    <!--Despesas-->
    <div class="flex-col-config mb-5 bg-stone-100 py-5 font-mono text-red-700">
        <p class="text-4xl">Despesas</p>
        <p class="text-xl">{{ toMonetary(ceremony.total_expenses) }}</p>
    </div>
    <div v-if="expenses.length" class="mt-10 overflow-auto">
        <!-- Orçamentos do cliente -->
        <table class="w-full m-auto table-auto truncate">
            <thead class="lg:border-b-2 lg:border-gray-500">
                <th>Nome</th>
                <th>Valor</th>
                <th v-if="budget.status == 1 || budget.status == 2">Editar</th>
                <th v-if="budget.status == 1 || budget.status == 2">Excluir</th>
            </thead>
            <tbody>
                <tr v-for="(exp, i = 0) in expenses" :key="exp.id"
                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                    :class="{ 'bg-gray-100': (i++) % 2 == 0 }">
                    <td class="py-3 px-5 truncate" :title="exp.name">{{ exp.name }}</td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(exp.amount) }} </td>
                    <td v-if="budget.status == 1 || budget.status == 2" class="py-3 px-5 cursor-pointer"
                        :title="'Editar ' + exp.name" @click="openModal(exp)">
                        <PencilIcon class=" w-full h-6 text-stone-500" />
                    </td>
                    <td v-if="budget.status == 1 || budget.status == 2" class="py-3 px-5 cursor-pointer"
                        :title="'Excluir ' + exp.name" @click="delete_expense(exp.id)">
                        <XMarkIcon class=" w-full h-6 text-stone-500" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="w-full text-center">
        <p>Não há despesas cadastradas no momento!</p>
    </div>
    <p v-if="budget.status == 1 || budget.status == 2"
        class="text-blue-400 hover:text-blue-600 active:text-blue-800 cursor-pointer flex-row-config space-x-1 py-5"
        @click="openModal(null)">
        <PlusIcon class="w-4 h-4" />
        <span>Cadastrar despesa</span>
    </p>
    <ModalManageExpenses v-if="open_modal" :ceremony="ceremony" :expense="expense"
        @modal_open="(open) => open_modal = open" />
</template>